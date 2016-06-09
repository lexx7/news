<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 07.06.2016
 * Time: 21:03
 */

namespace app\modules\events\services;

use app\modules\events\models\Event;
use app\modules\events\types\TypeInterface;
use app\modules\user\models\EventUsers;
use budyaga\users\models\User;
use Yii;
use yii\helpers\Json;

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
     * @param \yii\base\Event $event
     */
    public function sendEvents($event)
    {
        $events = Event::findOne(['name' => $event->name]);
        if (!$events) return;
        $eventsType = $events->event_type;

        foreach ($eventsType as $type) {
            $className = self::CLASS_NAME_EVENT_TYPES . ucfirst($type);
            /** @var TypeInterface $eventType */
            $eventType = new $className();

            $template = $this->renderTemplate($events->template, $event->sender);
            $recipients = $this->getRecipient($type);
            foreach ($recipients as $recipient) {
                $user = $recipient->getUser()->one();

                if (!$user->checkRoles($events->auth_item) || Yii::$app->user->id === $user->id ||
                    $user->status != User::STATUS_ACTIVE) continue;
                $eventMessage = new EventMessage();
                $eventMessage->user = $user;
                $eventMessage->title = $events->title;
                $eventMessage->template = $template;
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

    /**
     * @description Подстановка в шаблон переменных
     * @param string $template
     * @param Object $sender
     * @return string
     */
    private function renderTemplate($template, $sender)
    {
        $matches = [];
        if (preg_match_all('/\[[A-Za-z0-9_]+\]/', $template, $matches)) {
            $variables = [];

            foreach (current($matches) as $match) {
                $item = preg_replace('/\[|\]/', '', $match);
                $variables[$match] = $sender->$item;
            }
        }

        return strtr($template, $variables);
    }
}