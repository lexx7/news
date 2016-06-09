<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 07.06.2016
 * Time: 21:15
 */

namespace app\modules\events\types;

use Yii;
use app\modules\events\services\EventMessage;

class Mail implements TypeInterface
{
    public function send(EventMessage $eventMessage)
    {
        $user = $eventMessage->user;

        $params = Yii::$app->params;

        Yii::$app->mailer->compose()
            ->setFrom($params['supportEmail'])
            ->setTo($user->email)
            ->setSubject($eventMessage->title)
            ->setTextBody($eventMessage->template)
            ->setHtmlBody($eventMessage->template)
            ->send();
    }
}