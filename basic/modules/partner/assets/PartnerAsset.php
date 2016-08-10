<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 08.08.2016
 * Time: 13:18
 */

namespace app\modules\partner\assets;


use yii\web\AssetBundle;

class PartnerAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [];
    public $js = [
        'js/partner.readed.js'
    ];
    public $depends = [
        'app\assets\AppAsset',
    ];
}