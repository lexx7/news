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
        This is the About page. You may modify the following file to customize its content:
    </p>

    <canvas id="videoCanvas" width="320" height="240">
    </canvas>
    <button id="decode" style="position:absolute;top:225px;left:330px" onclick="Decode()">Start decoding</button>
    <button id="stopDecode" style="position:absolute;top:225px;left:450px" onclick="StopDecode()">Stop decoding</button>
    <p id="Result" style="position:absolute;top:275px;"></p>
    <div >
        <select id="barcodes" multiple="true">
            <?php foreach ($codes as $code) {?>
                <option value="<?php echo $code->code ?>"><?php echo $code->code ?></option>
            <?php } ?>
        </select>
    </div>
</div>
