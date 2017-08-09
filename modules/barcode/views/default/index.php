<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use app\modules\barcode\assets\BarcodeAsset;

BarcodeAsset::register($this);

$this->title = 'Barcode';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-barcode">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Show the barcode to the camera:
    </p>

    <div id="barcode">
        <video id="barcodevideo" autoplay></video>
        <canvas id="barcodecanvasg" ></canvas>
    </div>
    <canvas id="barcodecanvas" ></canvas>

    <div >
        <select id="barcodes" multiple="true">
            <?php foreach ($codes as $code) {?>
                <option value="<?php echo $code->code ?>"><?php echo $code->code ?></option>
            <?php } ?>
        </select>
    </div>
</div>
