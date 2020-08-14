<?php


namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\YiiAsset;

class VacationAsset extends AssetBundle
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
        'css/vacation/style.css'
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