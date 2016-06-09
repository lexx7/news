<?php

namespace app\modules\events\models;

use app\modules\user\models\EventUsers;
use budyaga\users\models\AuthItem;
use app\modules\user\models\User;
use Yii;
use yii\helpers\Json;

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
    static private $listEvents = null;

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
            [['name', 'event_type'], 'required'],
            [['description', 'template'], 'string'],
            [['name', 'title'], 'string', 'max' => 255],
            [['auth_item'], 'string', 'max' => 64],
            [['name'], 'noCompare'],
        ];
    }

    /**
     * @description Названия событий в базе не должны повторяться
     * @param $attribute
     * @param $params
     */
    public function noCompare($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $event = Event::findOne(['name' => $this->name]);
            if ($event && $event->id != $this->id) {
                $this->addError($attribute, 'Incorrect name event');
            }
        }
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

    static public function findOne($condition)
    {
        $item = parent::findOne($condition); // TODO: Change the autogenerated stub

        if ($item && $item->event_type) {
            $item->event_type = Json::decode($item->event_type);
        }

        return $item;
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if (is_array($this->event_type))
            $this->event_type = Json::encode($this->event_type);

        return parent::save($runValidation, $attributeNames); // TODO: Change the autogenerated stub
    }

    /**
     * @description Список всех типов событий
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

    /**
     * @description Список групп, на которые можно назначать событие
     * @return array
     */
    public function getAuthItem()
    {
        $rules = AuthItem::find()->where('type=1')->all();

        $authItems = [
            '' => 'All',
        ];
        foreach ($rules as $item) {
            $authItems[$item->name] = $item->description;
        }

        return $authItems;
    }

    static public function getListEvents()
    {
        if (self::$listEvents) return self::$listEvents;

        $listEventsType = EventUsers::getListEventsType(Yii::$app->user->id);
        $array = [];

        if ($listEventsType) {
            $list = implode(',', User::getListRulesCurrentUser());
            $events = self::find()->where("auth_item IN ($list)");

            foreach ($listEventsType as $item) {
                $events->orWhere("event_type LIKE '%\"$item\"%'");
            }
            $events = $events->all();

            foreach ($events as $event) {
                $array[$event->name] = 'create';
            }
        }

        self::$listEvents = $array;

        return self::$listEvents;
    }
}
