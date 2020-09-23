<?php

use app\assets\IndexAsset;

IndexAsset::register($this);
?>

<?php $this->beginPage()?>
<DOCTYPE html>
<html lang="en">

<head>
    <?php $this->head() 
    ?>
    <title>Search Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, minimum-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="HandheldFriendly" content="true">
</head>
<?php $this->beginBody() 
?>

<body>
<div id="div0">
    <p id="date"><strong>Date</strong></p>
</div>
<div id="div-main">
    <div id="search">
        <p id="name">Majmua</p>
        <form name="searchform" action="/search" method="GET" id="searchform">
            <input type="text" id="text-box" name="q" placeholder="Type here" value="" autofocus><input id="search-button" type="submit" value="Search">
        </form>
    </div>
</div>
</body>
<?php $this->endBody() 
?>

</html>
<?php $this->endPage() 
?>