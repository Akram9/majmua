<?php

namespace app\assets;

use yii\web\AssetBundle;

class SearchAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/search.css',
    ];
    public $js = [
        'js/dates.js',
    ];
    public $depends = [
    ];
}