<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 07.06.2016
 * Time: 20:49
 */

namespace app\modules\events\models;


use yii\base\Event as EventModel;

class EventMessage extends EventModel
{
    public $model;

    public $user;

    public $template;

    public $title;
}