<?php
/* This crawler will not be updated any more. No features will be added.
 * This was a trial crawler.
 * 
 * This crawler does not obey robots.txt restrictions but obeys robots meta tag.
 * This is mainly due to the complexity of handling robots.txt files since I am not good with regex.
 * On the other side, this crawler crawls at avery slow rate of <2000 urls/hour.
 * Also, this crawler does not download files of types mentioned in the IGNORED_EXTENSIONS array.
 * 
 * Nevertheless, the next version of this crawler will probably be written in python
 * using the scrapy library. That should be able to handle all sorts of quirks that this one can't.
*/


// define some error settings for DOMDocument - I don't understand but solves a problem
libxml_use_internal_errors(TRUE);

// define extensions to not download
define("IGNORED_EXTENSIONS", [
    '.mng', '.pct', '.bmp', '.gif', '.jpg', '.jpeg', '.png', '.pst', '.psp', '.tif',
    '.tiff', '.ai', '.drw', '.dxf', '.eps', '.ps', '.svg',

    '.mp3', '.wma', '.ogg', '.wav', '.ra', '.aac', '.mid', '.au', '.aiff',

    '.3gp', '.asf', '.asx', '.avi', '.mov', '.mp4', '.mpg', '.qt', '.rm', '.swf', '.wmv',
    '.m4a', '.flv',

    '.css', '.pdf', '.doc', '.exe', '.bin', '.rss', '.zip', '.rar', '.epub', '.docx',
    '.torrent', '.xlsx', '.odt', '.zip', '.ppt', '.xml', '.js'
]);

$db = [
    'host' => 'host',
    'user' => 'user',
    'password' => 'password',
    'database' => 'database'
];

if (!file_exists('./log')) {
    mkdir('log', 0777, true);
}

// open a logfile for sites-not-visited.
$sites_log_file = "log/sites_" . date('d-m-y') . ".log";
if (!file_exists($sites_log_file)) {
    touch($sites_log_file);
}

$sites_log_handle = fopen($sites_log_file, "a");

// open logfile for errors
$error_log_file = "log/errors_" . date('d-m-y') . ".log";
if (!file_exists($error_log_file)) {
    touch($error_log_file);
}

$error_log_handle = fopen($error_log_file, "a");

// connect to database
$dbconn = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);

if (!$dbconn) {
    // log error to file
    fwrite($error_log_handle, "MySQL connection failed: " . mysqli_connect_errno() . "\n");
    die("Connection failed: " . mysqli_connect_errno() . "\nQuitting...");
}

// set UTF-8 encoding
$dbconn->set_charset('utf8mb4');

// prepare insert statement
$insert_link = mysqli_prepare($dbconn, 
               "INSERT IGNORE INTO links(domain_id, link, types, title, description, keywords, body, lang)
               VALUES(?, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE 
               title=?, description=?, keywords=?, body=?, updated_on=CURRENT_TIMESTAMP;");

$insert_link->bind_param('ssssssssssss', $domain_id, $url, $types, $title, $desc,
                        $keywords, $contents, $lang, $title, $desc, $keywords, $contents);

// prepare pre-redirect insert statement
$pre_redirect = mysqli_prepare($dbconn, "INSERT INTO links(domain_id, link, types, flag)
                               VALUES(?, ?, ?, ?) ON DUPLICATE KEY UPDATE updated_on=CURRENT_TIMESTAMP;");
$pre_redirect->bind_param('ssss', $domain_id, $url, $types, $flag);
                        
// prepare checking statement
$check_link = mysqli_prepare($dbconn, "SELECT updated_on FROM links WHERE link=?;");
$check_link->bind_param('s', $extracted_url);

// initialise curl
$curl = curl_init();

// set default curl options
$curl_options = [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_CONNECTTIMEOUT => 15,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_ENCODING => 'UTF-8',
    CURLOPT_FOLLOWLOCATION => TRUE,
];
curl_setopt_array($curl, $curl_options);

// initialize DOMDocument
$dom = new DOMDocument();

// take all domains that need to be crawled
$domains_to_visit = mysqli_query($dbconn, "SELECT id, domain, types, flag, crawling FROM domains
                                 WHERE crawling='ongoing' OR crawling='scheduled' ORDER BY id;");

if (!$domains_to_visit) {
    mysqli_query($dbconn, "UPDATE domains SET crawling='scheduled';");
    $domains_to_visit = mysqli_query($dbconn, "SELECT id, domain, types, flag, FROM domains
                                                ORDER BY id;");
}

// check for domains ongoing crawling
$ongoing = mysqli_query($dbconn, "SELECT id FROM domains WHERE crawling='ongoing';");
if ($ongoing && $ongoing->num_rows>0) {
    $ongoing_id = mysqli_fetch_array($ongoing)['id'];
    // get last crawled domain
    $query_crawled_domain = mysqli_query($dbconn, "SELECT domain_id, link FROM links ORDER BY updated_on DESC LIMIT 1;");
    $row = mysqli_fetch_array($query_crawled_domain);
    $last_crawled_domain = $row['domain_id'];
    if ($ongoing_id === $last_crawled_domain) {
        // start from the last crawled webpage
        $links_to_visit = [$row['link']];
    } else {
        $links_to_visit = [];
    }
} else {$links_to_visit = [];}

// loop through every domain in domains table
while($row = mysqli_fetch_array($domains_to_visit)) {

    // empty the arrays after every domain
    $links_extracted = [];
    $links_visited = [];
    $links_out_of_domain = 0;
    
    // get domain_id from domains table
    $domain_id = $row['id'];

    // change the crawling status of domain
    mysqli_query($dbconn, "UPDATE domains SET crawling='ongoing' WHERE id={$domain_id};");

    // get types from domains table
    $types = $row['types'];

    // start from exact domain - may be redirected
    $domain = explode('/', $row['domain'])[2];
    array_push($links_to_visit, $row['domain']);

    // loop through links in every domain
    while ($links_to_visit !== []) {

        $follow = true;
        $index = true;
        $desc = null;
        $keywords = null;
        $contents = null;

        $url = array_shift($links_to_visit);
        echo "Trying url: {$url}\n";

        // get html using curl
        curl_setopt($curl, CURLOPT_URL, $url);
        $html_page = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // handle curl errors
        if (curl_errno($curl) !== 0) {
            $error = "Failed to execute curl with error: " . curl_error($curl) . "\n";
            echo $error;
            fwrite($error_log_handle, $error);
            continue;
        }

        // handle http errors
        if ($http_code < 200 || $http_code > 299) {
            echo "HTTP {$http_code} error for {$url}\n";
            $error = "Failed to load {$url} with http error: {$http_code}\n";
            fwrite($error_log_handle, $error);
            continue;
        }

        // get redirect url if redirected
        $redirect_url = curl_getinfo($curl, CURLINFO_EFFECTIVE_URL);

        // clean redirect url of ending slash - '/'
        if (strrpos($redirect_url, '/') === strlen($redirect_url) - 1) {
            $redirect_url = implode('/', array_slice(explode('/', $redirect_url), 0, -1));
        }

        // handle redirects
        if ($url !== $redirect_url) {

            // handle redirects to different domains
            if (!is_int(strpos(explode('/', $redirect_url)[2], $domain))) {
                fwrite($sites_log_handle, "{$redirect_url}\n");
                continue;
            } else {
                $flag = 5;
                $pre_redirect->execute();
                $url = $redirect_url;
            }
            echo "Redirected to: {$url}\n";
        }

        // add the link to visited links array
        array_push($links_visited, $url);

        // load html page to parse
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html_page);

        // get html element for language of page
        // default language is English
        $html_tag = $dom->getElementsByTagName('html');
        if ($html_tag->length > 0) {
            $lang = $html_tag[0]->getAttribute('lang');
            $lang = ($lang == '' ? 'en' : $lang);
        } else {
            $lang = 'zz';
        }

        // get title from webpage
        $titles = $dom->getElementsByTagName('title');
        if ($titles->length > 0) {
            $title = $titles->item(0)->textContent;
        }
        echo $title . "\n";

        // get meta elements for description and keywords
        $metas = $dom->getElementsByTagName('meta');

        foreach ($metas as $meta) {
            if ($meta->getAttribute('name') === 'robots') {
                if (is_int(strpos(strtolower($meta->getAttribute('contents')), 'nofollow'))) {
                    $follow = false;
                }
                if (is_int(strpos(strtolower($meta->getAttribute('contents')), 'noindex'))) {
                    $index = false;
                }
            }
            if ($meta->getAttribute('name') === 'description') {
                $desc = $meta->getAttribute('content');
            }
            if ($meta->getAttribute('name') === 'keywords') {
                $keywords = $meta->getAttribute('content');
            }

            if ($desc !== NULL && $keywords !== NULL) {
                break;
            }
        }

        // insert the data to mysql database
        if ($index) {
            // extract all the p-tag contents
            $paras = $dom->getElementsByTagName('p');

            foreach ($paras as $para) {
                $contents = $contents . "\n" . $para->nodeValue;
                if (strlen($contents) > 1000) {
                    break;
                }
            }
            $insert_link->execute();
            echo "Added to database.\n";
        } else {
            echo "Skipped adding to database.\n";
        }
        
        // delete the following if-else block
        if ($dbconn->ping()) {
            echo "Connected...\n";
        }
        else {
            echo "Disconnected\n";
        }


        // follow if allowed
        if (!$follow) {
            continue;
        }

        // get all links from html page
        echo "Extracting links from webpage...\n";
        $links = $dom->getElementsByTagName('a');

        foreach ($links as $link) {
            
            $extracted_url = $link->getAttribute('href');
            
            // following only for islamhouse.com to respect its robots.txt
            if (strpos($extracted_url, 'download-excel')) {
                continue;
            }
            
            // skip 'mailto:' links
            if (is_int(strpos($extracted_url, 'mailto:'))) {
                continue;
            }

            // skip links that have ignored extensions
            foreach (IGNORED_EXTENSIONS as $extension) {
                if (strpos(strtolower($extracted_url), $extension)) {
                    continue 2;
                }
            }
            
            // trim the url of whitespaces and ending slash
            $extracted_url = rtrim(trim($extracted_url), '/');

            //  remove queries from url
            $extracted_url = explode('?', $extracted_url)[0];
            
            // remove anchors from links
            $extracted_url = explode('#', $extracted_url)[0];
            
            // remove javascript scripts from links
            $extracted_url = explode('javascript', strtolower($extracted_url))[0];

            // include account pages only once
            if (strpos($extracted_url, 'account')) {
                $extracted_url = explode('account', $extracted_url)[0] . "account";
            }

            // add relative links
            if (explode('/', $extracted_url)[0] === ''){

                if (strpos($extracted_url, '//') === 0) {
                    // exclude links which are out of domain
                    if (is_int(strpos(explode('/', $extracted_url)[2], $domain))) {

                        // get the http form of the current page
                        $url_protocol = explode('/', $url)[0];
                        $extracted_url = $url_protocol . $extracted_url;
                    } else {
                        continue;
                    }
                } else {
                    // get current page domain
                    $current_page = implode('/', array_slice(explode('/', $url), 0, 3));
                    $extracted_url = $current_page . $extracted_url;
                    $extracted_url = rtrim($extracted_url, '/');
                }
                
                // check link already present in to_visit list
                if (in_array($extracted_url, $links_to_visit)) {
                    continue;
                }
                
                // check link if exists in database
                $check_link->execute();
                $last_updated = $check_link->get_result()->fetch_assoc();
                
                if ($last_updated === null) {
                    array_push($links_to_visit, $extracted_url);
                }
                
                /*
                if (!in_array($extracted_url, $links_extracted)) {
                    array_push($links_extracted, $extracted_url);
                    array_push($links_to_visit, $extracted_url);
                }*/
                
            } elseif (strpos($extracted_url, 'http') !== 0) {
                // handle links appending to current link

                if (strpos($url, '.asp') || strpos($url, '.html') || 
                    strpos($url, '.htm') || strpos($url, '.php')) {
                    // check if webpage has .asp, .html, .htm or .php extensions

                    // get the directory of the webpage on the server
                    $current_dir = implode('/', array_slice(explode('/', $url), 0, -1));

                    // get complete url of the specified link
                    $extracted_url = $current_dir . "/" . $extracted_url;
                    $extracted_url = rtrim($extracted_url, '/');

                } else {
                    // get complete url of the specified link
                    $extracted_url = $url . "/" . $extracted_url;
                    $extracted_url = rtrim($extracted_url, '/');
                }
                
                // check link already present in to_visit list
                if (in_array($extracted_url, $links_to_visit)) {
                    continue;
                }
                
                // check link if exists in database
                $check_link->execute();
                $last_updated = $check_link->get_result()->fetch_assoc();
                
                if ($last_updated === null) {
                    array_push($links_to_visit, $extracted_url);
                }
                
                /*
                if (!in_array($extracted_url, $links_extracted)) {
                    array_push($links_extracted, $extracted_url);
                    array_push($links_to_visit, $extracted_url);
                }*/
                
            } elseif (is_int(strpos(explode('/', $extracted_url)[2], $domain))) {
                
                // check link already present in to_visit list
                if (in_array($extracted_url, $links_to_visit)) {
                    continue;
                }
                
                // check link if exists in database
                $check_link->execute();
                $last_updated = $check_link->get_result()->fetch_assoc();
                
                if ($last_updated === null) {
                    array_push($links_to_visit, $extracted_url);
                }
                /*
                array_push($links_extracted, $extracted_url);
                array_push($links_to_visit, $extracted_url);*/

            } else {
                if (!is_int(strpos(explode('/', $extracted_url)[2], $domain))) {
                    $links_out_of_domain += 1;
                    fwrite($sites_log_handle, "{$extracted_url}\n");
                }
            }
        }
        echo "Done." . count($links_to_visit) . "\n";
    }
    echo "\nFor domain {$domain} -\n";
    echo "Links visited: " . count($links_visited) . "\n";
    echo "Links extracted: " . count($links_extracted) . "\n";
    echo "Links out of domain: " . $links_out_of_domain . "\n\n";

    // update crawling status to 'done'
    mysqli_query($dbconn, "UPDATE domains SET crawling='done' WHERE id={$domain_id};");
}

$dbconn->close();

fclose($sites_log_handle);
fclose($error_log_handle);

libxml_clear_errors();

?>