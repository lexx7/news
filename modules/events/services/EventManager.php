<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 07.06.2016
 * Time: 21:03
 */

namespace app\modules\events\services;

use app\modules\events\types\TypeInterface;
use app\modules\user\models\EventUsers;
use budyaga\users\models\User;
use Yii;

/**
 * Class EventManager
 * @package app\modules\events\services
 * @description Управление событиями по типам
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
                $user = $recipient->getUser()->one();
                if (Yii::$app->user->id === $user->id && $user->status = User::STATUS_ACTIVE) continue;
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
        $eventUsers = EventUsers::find();

        return $eventUsers->where('event_type = :type', ['type' => $type])
            ->andWhere('value = 1')->all();
    }
}