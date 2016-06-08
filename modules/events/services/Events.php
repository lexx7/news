<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 07.06.2016
 * Time: 20:13
 */

namespace app\modules\events\services;

use Yii;
use yii\base\Component;
use yii\base\Event;

class Events extends Component
{
    const CREATE_NEWS = 'events-create-news';

    /**
     * @param Event $event
     */
    static public function createNews($event)
    {
        $eventManager = new EventManager();
        $eventManager->sendEvents($event);
    }
}