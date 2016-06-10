<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 10.06.2016
 * Time: 20:58
 */

namespace app\modules\events\grid;


use Yii;
use yii\helpers\Html;

class ActionColumn extends \yii\grid\ActionColumn
{
    public $template = '{send} {view} {update} {delete}';

    protected function initDefaultButtons()
    {
        if (!isset($this->buttons['send'])) {
            $this->buttons['send'] = function ($url, $model, $key) {
                $options = array_merge([
                    'title' => 'Send',
                    'aria-label' => 'Send',
                    'data-pjax' => '0',
                ], $this->buttonOptions);
                return Html::a('<span class="glyphicon glyphicon-share"></span>', $url, $options);
            };
        }
        return parent::initDefaultButtons();
    }
}