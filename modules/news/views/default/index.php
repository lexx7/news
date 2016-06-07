<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\news\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'News';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create News', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'title',
            [
                'attribute' => 'content',
                'format' => 'html',
                'value' => function ($model) {
                    return mb_strcut($model->content, 0, 500) . '...';
                }
            ],
            [
                'attribute' => 'user',
                'format' => 'html',
                'value' => function ($model) {
                    return empty($model->edit_user_id) ? $model->getCreateUser()->one()->username:
                        $model->getEditUser()->one()->username;
                },

            ],
            [
                'attribute' => 'date_time',
//                'format' => 'html',
                'value' => function ($model) {
                    return empty($model->edit_date_time) ? $model->create_date_time :
                        $model->edit_date_time;
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
