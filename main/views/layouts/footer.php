<?php

use app\assets\FooterAsset;

FooterAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <?php $this->head() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, minimum-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="HandheldFriendly" content="true">
</head>

<body>
    <?php $this->beginBody() ?>
    <div id="wrap">
        <?= $content ?>
    </div>
    <footer id="footer">
        <div id="footer-left" class="footer-divs">
            <p>
                <a href="/">Majmua</a>
            </p>
        </div>
        <div id="footer-right" class="footer-divs">
            <p>
                <a href="/about">About</a>
            </p>
        </div>
    </footer>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>