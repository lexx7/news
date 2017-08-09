<?php

namespace app\modules\barcode\controllers;

use app\modules\barcode\models\Barcode;
use yii\helpers\Json;
use yii\web\Controller;

/**
 * Default controller for the `Barcode` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $model = new Barcode();

        return $this->render('index', [
            'codes' => $model->getCodes(10)
        ]);
    }

    public function actionSave()
    {
        $model = new Barcode();

        if ($model->save()) {
            return Json::encode(['status' => 1]);
        }

        return Json::encode(['status' => 0]);
    }
}
