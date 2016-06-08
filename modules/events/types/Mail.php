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
            ->setSubject('Добавлена новая новость')
            ->setTextBody('На новостном портале добавлена новая новость')
            ->setHtmlBody('<b>На новостном портале добавлена новая новость</b>')
            ->send();
    }
}