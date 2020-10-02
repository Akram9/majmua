<?php
namespace app\assets;

use yii\web\AssetBundle;

class FooterAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/footer.css',
    ];
    public $js = [
        'js/mobile.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
