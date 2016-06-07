<?php

use yii\widgets\LinkPager;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $pagination \yii\data\Pagination */
/* @var $news \app\models\news\News */
/* @var $more bool */

$this->title = 'Preview news';
?>
<div class="site-index">

    <div class="content">
        <h1>Preview news</h1>
    </div>

    <div class="body-content">

        <?= LinkPager::widget(['pagination' => $pagination]) ?>

        <?php foreach ($news as $new) : ?>
            <div class="row">
                <h2><?= $new->title ?></h2>
                <p><?= Html::encode(mb_strcut($new->content, 0, 500, 'UTF-8') . '...') ?></p>
                <?php if ($more) {?>
                    <p><?= Html::a('More >>', '/site/view?id=' . $new->id, [
                        'class' => 'btn btn-default'
                    ]) ?></p>
                <?php } ?>
            </div>
        <?php endforeach; ?>

        <?= LinkPager::widget(['pagination' => $pagination]) ?>
        <p>
            Limit news:
            <select id="limit-news">
                <option>5</option>
                <option>10</option>
                <option>15</option>
                <option>20</option>
            </select>
        </p>

    </div>
</div>
