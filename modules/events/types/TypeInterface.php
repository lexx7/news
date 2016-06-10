<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 07.06.2016
 * Time: 21:16
 */

namespace app\modules\events\types;


use app\modules\events\models\EventMessage;

interface TypeInterface
{
    public function send(EventMessage $eventMessage);
}