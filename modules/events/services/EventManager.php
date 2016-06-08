<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 07.06.2016
 * Time: 21:03
 */

namespace app\modules\events\services;

use app\modules\events\types\TypeInterface;
use budyaga\users\models\User;
use Yii;

/**
 * Class EventManager
 * @package app\modules\events\services
 * @description Управление отправкой событий по типам
 */
class EventManager
{
    const CLASS_NAME_EVENT_TYPES = 'app\modules\events\types\\';
    
    /**
     * @description Функция отправки событий
     * @param $event
     */
    public function sendEvents($event)
    {
        $params = Yii::$app->params;
        if (!array_key_exists('eventsType', $params)) return;
        $eventsType = $params['eventsType'];

        foreach ($eventsType as $item) {
            $type = current($item);

            $className = self::CLASS_NAME_EVENT_TYPES . ucfirst($type);
            /** @var TypeInterface $eventType */
            $eventType = new $className();

            $recipients = $this->getRecipient($type);
            foreach ($recipients as $recipient) {
                if (Yii::$app->user->id === $recipient->id) continue;
                $eventMessage = new EventMessage(['user' => $recipient]);
                $eventType->send($eventMessage);
            }
        }
    }

    /**
     * @description Получатели сообщений заданного типа события
     * @param $type
     * @return array
     */
    private function getRecipient($type)
    {
        $users = User::find();

        return $users->where('status = 2')->andWhere("email <> ''")->all();
    }
}