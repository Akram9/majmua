<?php

use app\assets\DefaultAsset;

DefaultAsset::register($this);
?>

<?php $this->beginPage() ?>
<html>

<head>
    <?php $this->head() ?>
    <title>
        Report
    </title>
</head>
<?php $this->beginBody() ?>

<body>
    <br><br>
    <h3>
        Your report has been registered. We will look into it soon, insha Allah.<br><br>
        If you have provided your email, we may update you about this issue.
    </h3>
    <br>
    <h4>
        <a href="/">Go back to Majmua.</a>
    </h4>
</body>
<?php $this->endBody() ?>

</html>
<?php $this->endPage(); ?>