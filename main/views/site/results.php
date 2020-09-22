<?php

use app\assets\SerpAsset;

SerpAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->head() ?>
    <title>Search - <?= $query ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, minimum-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="HandheldFriendly" content="true">
</head>

<?php $this->beginBody() ?>

<body>
    <div id="div0">
        <div id="div0l" class="div0-elements">
            <p><a href="/site/search" id="name">Search</a></p>
            <form name="searchform" action="/site/results" method="GET" id="searchform">
                <input type="text" id="text-box" name="q" value="<?= $query ?>"><input type="submit" id="search-button" value="Search">
            </form>
        </div>
        <div id="div0r" class="div0-elements">
            <p id="date"></p>
        </div>
    </div>
    <div id="results-div">
        <!--
        <div class="results">
            <p class='title'><a href="https://quran.com/search?q=<?= $query ?>&ref=opensearch" class='title'>
                    Check in the Quran</a></p>
            <p class='link'><a href="https://quran.com/search?q=<?= $query ?>&ref=opensearch" class="link">
                    https://quran.com/search?q=<?= $query ?>&ref=opensearch</a></p>
            <p class="description">The Quran translated into many languages in a simple and easy interface.</p>
        </div>
        <div class="results">
            <p class='title'><a href="https://sunnah.com/search?q=<?= $query ?>" class='title'>
                    Check in the Shahih Hadeeth</a></p>
            <p class='link'><a href="https://sunnah.com/search?q=<?= $query ?>" class="link">
                    https://sunnah.com/search?q=<?= $query ?></a></p>
            <p class="description">Hadith of the Prophet Muhammad (saws) in several languages.</p>
        </div>-->
        <?php
        foreach ($results as $result) {
            $title = $result['title'];
            if (strlen($title) > 60) {
                $title = substr($title, 0, 59) . "...";
            }
            $description = $result['description'];
            if (strlen($description) > 300) {
                $description = substr($description, 0, 300) . "...";
            }
            $link = $result['link'];
            if (strlen($link) > 100) {
                $link = substr($link, 0, 98) . "...";
            }
            echo "<div class='result-parent'>
                    <div class='results'>
                        <p class='title'><a href='{$result['link']}' class='title'>{$title}</a></p>
                        <p class='link'><a href='{$result['link']}' class='link'>{$link}</a></p>
                        <p class='description'>{$description}</p>
                    </div>
                    <div class='report'>
                        <form name='report' action='/site/report' method='POST' class='report' target='_blank'>
                            <button type='submit' id='report-button' value='{$result['link']}' name='r'>Report</button>
                        </form>
                    </div>
                </div>";
        }
        ?>
    </div>

    <div id="page-numbers-div">
        <h3>Page</h3>
        <form name="pages" action="/site/results" method="GET" id="pages">
            <input type="hidden" name="q" value="<?= $query ?>">
            <?php
            for ($i = 1; $i <= $maxpages; $i++) {
                if ($i === $page) {
                    echo "<button type='submit' id='page-button-current' class='page-buttons' value='{$i}' name='p'>{$i}</button>";
                } else {
                    echo "<button type='submit' id='page-button' class='page-buttons' value='{$i}' name='p'>{$i}</button>";
                }
            }
            ?>
        </form>
    </div>
    <div id="bottom-search" class="hidden">
        <h2><a href="/site/search" id="name">Search</a></h2>
        <form name="searchform" action="/site/results" method="GET" id="searchform">
            <input type="text" id="text-box" name="q" value="<?= $query ?>">
            <input type="submit" id="search-button" value="Search">
        </form>
    </div>
</body>
<?php $this->endBody() ?>

</html>
<?php $this->endPage() ?>