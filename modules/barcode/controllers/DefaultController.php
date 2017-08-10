<?php

namespace app\modules\barcode\controllers;

use app\modules\barcode\models\Barcode;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Response;

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

        \Yii::$app->response->format = Response::FORMAT_JSON;

        if ($model->save()) {
            return ['status' => 1];
        }

        return ['status' => 0];
    }
}
