<?php

use app\assets\SearchAsset;

SearchAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>

<head>
    <?php $this->head() ?>
    <title>Search - <?= $query ?> - no results</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, minimum-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="HandheldFriendly" content="true">
</head>

<?php $this->beginBody() ?>

<body>
    <div id="div0">
        <div id="div0l" class="div0-elements">
            <p><a href="/search" id="name">Majmua</a></p>
            <form name="searchform" action="/search" method="GET" id="searchform">
                <input type="text" id="text-box" name="q" value="<?= $query ?>"><input type="submit" id="search-button" value="Search">
            </form>
        </div>
        <div id="div0r" class="div0-elements">
            <p id="date">Date</p>
        </div>
    </div>
    <div id="results-div">
        <p>
            Sorry, the term `<?= $query ?>` could not be found. Please search with some different term.
        </p>
    </div>
</body>
<?php $this->endBody() ?>

</html>
<?php $this->endPage() ?>