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
    <h1 id="heading">Report</h1>
    <form name="report-details" method="POST" action="/registered" id="report-details">
        <input id='form-token' type='hidden' name='_csrf' value=<?= Yii::$app->request->getCsrfToken() ?> />
        <input type="hidden" name="link" value="<?= $link ?>" />
        <h4>Result link:</h4>
        <p><?= $link ?></p>
        <h4>What issue did you find with this result? (select most relevant one)</h4>
        <input type="radio" name="issue" value="1" required /> Goes against Quran or Hadith or both<br>
        <input type="radio" name="issue" value="2" /> Includes doubtful claims (plase mention below)<br>
        <input type="radio" name="issue" value="3" /> Anti-Islamic<br>
        <input type="radio" name="issue" value="4" /> Non-Islamic / Irrelevant<br>
        <input type="radio" name="issue" value="5" /> Other (please mention below)<br>
        <h4>Details:</h4>
        <textarea id="details" name="details" rows="7" cols="50"></textarea>
        <h4>Email (optional)</h4>
        <input type="text" name="email" value="Email" id="email">
        <input type="submit" name="submit" value="Submit" id="submit">
    </form>
</body>
<?php $this->endBody() ?>

</html>
<?php $this->endPage() ?>