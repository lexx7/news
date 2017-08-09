<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class BarcodeAsset extends AssetBundle
{

//    public $basePath = '@webroot';
//    public $baseUrl = '@web';
    public $sourcePath = '@app/assets/resources';

    public $css = [
        'css/barcode.css',
    ];
    public $js = [
        'js/exif.js',
        'js/barcode-reader.jquery.js',
        'js/DecoderWorker.js',
        'js/BarcodeReader.js',
        'js/barcode.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
