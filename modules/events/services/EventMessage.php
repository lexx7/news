<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 07.06.2016
 * Time: 20:49
 */

namespace app\modules\events\services;


use yii\base\Event;

class EventMessage extends Event
{
    public $model;

    public $user;

    public $template;

    public $title;
}