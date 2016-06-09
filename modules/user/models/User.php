<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 09.06.2016
 * Time: 20:59
 */

namespace app\modules\user\models;

use Yii;

class User extends \budyaga\users\models\User
{
    static private $listRulesCurrentUser = null;

    /**
     * @description Получает все роли текущего пользователя
     * @return array
     */
    static public function getListRulesCurrentUser()
    {
        if (self::$listRulesCurrentUser) return self::$listRulesCurrentUser;

        $user = self::findOne(Yii::$app->user->id);
        $assignments = $user->getAssignments()->all();

        $userRoles = ["''"];
        foreach ($assignments as $item) {
            $userRoles[] = "'" . $item->item_name . "'";
        }

        self::$listRulesCurrentUser = $userRoles;

        return $userRoles;
    }

    public function checkRoles($role)
    {
        if ($role === "") return true;
        
        foreach ($this->getAssignments()->all() as $item) {
            if ($item->item_name == $role) return true;
        }

        return false;
    }
}