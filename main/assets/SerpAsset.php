<?php

namespace app\assets;

use yii\web\AssetBundle;

class SerpAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/serp.css',
    ];
    public $js = [
        'js/dates.js',
        'js/mobile.js'
    ];
    public $depends = [
    ];
}