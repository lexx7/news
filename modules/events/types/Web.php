<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 07.06.2016
 * Time: 22:06
 */

namespace app\modules\events\types;

use Yii;
use app\modules\events\models\EventNotification;
use app\modules\events\models\EventMessage;
use yii\base\Object;
use yii\bootstrap\Alert;

class Web extends Object implements TypeInterface
{
    public function send(EventMessage $eventMessage)
    {
        $user = $eventMessage->user;

        $eventNotification = new EventNotification();
        $eventNotification->user_id = $user->id;
        $eventNotification->title = $eventMessage->title;
        $eventNotification->content = $eventMessage->template;
        $eventNotification->send = 0;
        $eventNotification->event_type = 'web';

        $eventNotification->save();
    }

    static public function view()
    {
        $user = Yii::$app->user;

        $eventNotification = EventNotification::find();
        $notification = $eventNotification->where('user_id = :userId', ['userId' => $user->id])
            ->andWhere('send = 0')->one();

        if (!$notification) return;
        $notification->send = 1;
        $notification->save();

        Alert::begin([
            'options' => [
                'class' => 'alert-info'
            ],
        ]);

        echo "<strong>{$notification->title}</strong> {$notification->content}";

        Alert::end();
    }
}