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

    public function __construct(array $config)
    {
        if (array_key_exists('model', $config)) {
            $this->model = $config['model'];
            unset($config['model']);
        }

        if (array_key_exists('user', $config)) {
            $this->user = $config['user'];
            unset($config['user']);
        }

        parent::__construct($config);
    }
}