<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 09.06.2016
 * Time: 19:52
 */

namespace app\modules\events\models;


use app\modules\events\services\EventManager;
use yii\base\Behavior;

class EventBehavior extends Behavior
{
    public function events()
    {
        return Event::getListEvents();
    }

    public function create($event)
    {
        $eventManager = new EventManager();
        $eventManager->sendEvents($event);
    }
}