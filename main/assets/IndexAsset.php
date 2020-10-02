<?php

namespace app\assets;

use yii\web\AssetBundle;

class IndexAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/index.css',
    ];
    public $js = [
        'js/dates.js',
        'js/mobile.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
