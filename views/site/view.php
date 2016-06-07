<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\news\News */

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'User',
                'value' => empty($model->edit_user_id) ? $model->getCreateUser()->one()->username :
                    $model->getEditUser()->one()->username
            ],
            [
                'label' => 'Date Time',
                'value' => empty($model->edit_date_time) ? $model->create_date_time :
                    $model->edit_date_time
            ],
            'content:ntext',
        ],
    ]) ?>

</div>
