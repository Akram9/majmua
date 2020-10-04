<?php

use app\assets\SearchAsset;

SearchAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->head() ?>
    <title>Search Results demo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, minimum-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="HandheldFriendly" content="true">
    <meta name="theme-color" content="rgb(255, 255, 255)">
</head>

<body>
    <?php $this->beginBody() ?>
    <div id="div0">
        <div id="div0l" class="div0-elements">
            <p><a href="/" id="name">Majmua</a></p>
            <form name="searchform" action="/search" method="GET" id="searchform">
                <input type="text" id="text-box" name="q" value="demo"><input type="submit" id="search-button" value="Search">
            </form>
        </div>
        <div id="div0r" class="div0-elements">
            <p id="date"></p>
        </div>
    </div>
    <div id="results-div">
        <?php
        for ($i = 0; $i < 10; $i++) {
            $title = "This is how the title of the search result looks";
            if (strlen($title) > 60) {
                $title = substr($title, 0, 59) . "...";
            }
            $description = "This is the description part of the search result.
                            It is limited to 300 character.";
            if (strlen($description) > 300) {
                $description = substr($description, 0, 300) . "...";
            }
            $link = "https://majmua.org";
            if (strlen($link) > 100) {
                $link = substr($link, 0, 98) . "...";
            }
            echo "<div class='result-parent'>
                    <div class='results'>
                        <p class='title'><a href='/' class='title' target='_blank'>{$title}</a></p>
                        <p class='link'><a href='/' class='link' target='_blank'>{$link}</a></p>
                        <p class='description'>{$description}</p>
                    </div>
                    <div class='report'>
                        <form name='report' action='/report' method='POST' target='_blank'>
                            <input id='form-token' type='hidden' name='_csrf' value=" . Yii::$app->request->getCsrfToken() . " />
                            <button type='submit' id='report-button' value='/' name='r'>Report</button>
                        </form>
                    </div>
                </div>";
        }
        ?>
    </div>
    <div id="page-numbers-div">
        <h3>Page</h3>
            <?php
            for ($i = 1; $i <= 10; $i++) {
                if ($i === 1) {
                    echo "<button type='submit' id='page-button-current' class='page-buttons' value='{$i}' name='p'>{$i}</button>";
                } else {
                    echo "<button type='submit' id='page-button' class='page-buttons' value='{$i}' name='p'>{$i}</button>";
                }
            }
            ?>
        </form>
    </div>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>