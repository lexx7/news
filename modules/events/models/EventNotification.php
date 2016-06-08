<?php

namespace app\modules\events\models;

use budyaga\users\models\User;
use Yii;

/**
 * This is the model class for table "event_notification".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $event_type
 * @property string $title
 * @property string $content
 * @property integer $send
 *
 * @property User $user
 */
class EventNotification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event_notification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'event_type', 'title', 'content'], 'required'],
            [['id', 'user_id', 'send'], 'integer'],
            [['content'], 'string'],
            [['event_type', 'title'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'title' => 'Title',
            'content' => 'Content',
            'send' => 'Send',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
