<?php

namespace app\modules\user\models;

use app\modules\user\models\User as UserModel;
use Yii;

/**
 * This is the model class for table "event_users".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $event_type
 * @property integer $value
 *
 * @property User $user
 */
class EventUsers extends \yii\db\ActiveRecord
{
    static protected $listEventsType = null;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'event_type'], 'required'],
            [['user_id', 'value'], 'integer'],
            [['event_type'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserModel::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'event_type' => 'Event Type',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(UserModel::className(), ['id' => 'user_id']);
    }

    /**
     * @description Возвращает все типы событий выбранного пользователя
     * @param $userId
     * @return array
     */
    static public function getListEventsType($userId)
    {
        if (self::$listEventsType) return self::$listEventsType;

        $eventsType = self::findAll(['user_id' => $userId]);

        $array = [];

        foreach ($eventsType as $item) {
            $array[] = $item->event_type;
        }

        self::$listEventsType = $array;

        return $array;
    }
}
