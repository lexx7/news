<?php

namespace app\modules\events;
use app\modules\events\services\Events;
use yii\db\ActiveRecord;

/**
 * event module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\events\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        \Yii::configure($this, require(__DIR__ . '/config/config.module.php'));

        \Yii::$app->on(Events::CREATE_NEWS, [Events::className(), 'createNews']);
    }
}
