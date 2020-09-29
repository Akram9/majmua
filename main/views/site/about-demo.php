<?php

use app\assets\DefaultAsset;

DefaultAsset::register($this);

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1>About</h1>

    <p class="about-para">
        &emsp;
        This is the about page for the project.
        <br>
        Edit the following file to change this page:
    </p>
    <code><?= __FILE__ ?></code>
    <br>
</div>