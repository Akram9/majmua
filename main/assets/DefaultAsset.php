<?php

namespace app\assets;

use yii\web\AssetBundle;

class DefaultAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/default.css',
    ];
    public $js = [
        'js/dates.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
