<?php
namespace app\backend\rbac;
use yii\rbac\Rule;
use Yii;
class IsAuthorRule extends Rule
{
    public $name = 'isAuthorRule';
    public function execute($user, $item, $params)
    {
        if (!isset($params['news'])) {
            return false;
        }
        return ($params['news']->create_user_id == $user);
    }
}