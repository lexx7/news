<?php

namespace app\modules\events\models;

use budyaga\users\models\AuthItem;
use Yii;

/**
 * This is the model class for table "event".
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property string $description
 * @property string $template
 * @property string $event_type
 * @property string $auth_item
 */
class Event extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'event_type', 'auth_item'], 'required'],
            [['description', 'template'], 'string'],
            [['name', 'title', 'event_type'], 'string', 'max' => 255],
            [['auth_item'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'title' => 'Title',
            'description' => 'Description',
            'template' => 'Template',
            'event_type' => 'Event Type',
            'auth_item' => 'Auth Item',
        ];
    }
    /**
     * @return array
     */
    public function getEventType()
    {
        $eventType = [];
        foreach (Yii::$app->params['eventsType'] as $item) {
            $eventType[current($item)] = $item['label'];
        }

        return $eventType;
    }

    public function getAuthItem()
    {
        $rules = AuthItem::find()->where('type=1')->all();

        $authItems = [];
        foreach ($rules as $item) {
            $authItems[$item->name] = $item->description;
        }

        return $authItems;
    }
}
