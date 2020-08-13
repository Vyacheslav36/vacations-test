<?php


namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\YiiAsset;

class UserAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $basePath = '@webroot';
    /**
     * @var string
     */
    public $baseUrl = '@web';

    /**
     * @var array
     */
    public $css = [
        'css/user/style.css'
    ];
    /**
     * @var array
     */
    public $js = [
    ];

    /**
     * @var array
     */
    public $depends = [
        YiiAsset::class,
    ];
}