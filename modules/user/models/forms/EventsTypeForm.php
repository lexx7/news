<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 08.06.2016
 * Time: 19:56
 */

namespace app\modules\user\models\forms;

use app\modules\user\models\EventUsers;
use Yii;
use yii\base\Model;


class EventsTypeForm extends Model
{
    const ERROR_EVENTS_TYPE = 'Данный тип события не существует';
    const PRE_NAME = 'event_type_';

    public $events_type = [];

    public $items = [];

    public function __construct(array $config = [])
    {
        $this->events_type = Yii::$app->params['eventsType'];

        // Динамическое добавление элементов формы
        foreach ($this->events_type as $item) {
            $nameItem = self::PRE_NAME . current($item);
            $this->$nameItem = 0;
        }

        if (array_key_exists('model', $config)) {
            $this->loadData($config['model']);
        }

        parent::__construct($config);
    }

    public function __set($name, $value)
    {
        $this->items[$name] = $value;

        return $this;
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->items)) {
            return $this->items[$name];
        }

        return null;
    }

    public function load($data, $formName = null)
    {
        if (array_key_exists('EventsTypeForm', $data) && is_array($data['EventsTypeForm'])) {
            foreach ($data['EventsTypeForm'] as $index => $item) {
                $this->__set($index, $item);
            }
        }

        return true;
    }

    /**
     * @description Подгрузка данных в форму
     * @param $model
     */
    private function loadData($model)
    {
        $query = EventUsers::find();

        $elements = $query->where('user_id = :userId', ['userId' => $model->id])->all();

        /** @var EventUsers $element */
        foreach ($elements as $element) {
            if (array_key_exists(self::PRE_NAME . $element->event_type, $this->items))
                $this->__set(self::PRE_NAME . $element->event_type, $element->value);
        }
    }

    public function save()
    {   
        $data = $this->items;

        $query = EventUsers::find();

        $elements = $query->where('user_id = :userId', ['userId' => $data['model']->id])->all();

        /** @var EventUsers $item */
        foreach ($elements as $item)
        {
            $nameItem = self::PRE_NAME . $item->event_type;
            if (!isset($data[$nameItem])) { // удаляем несуществующий тип из базы
                $item->delete();
                continue;
            }
            if ($data[$nameItem]) {
                $item->value = 1;
            } else {
                $item->value = 0;
            }
            $item->save();

            unset($data[$nameItem]);
        }

        // Проверяем события отсутствующие в базе
        foreach ($this->events_type as $type) {
            $nameItem = self::PRE_NAME . current($type);
            if (array_key_exists($nameItem, $data) && $data[$nameItem]) {
                $eventUsers = new EventUsers();
                $eventUsers->user_id = $data['model']->id;
                $eventUsers->event_type = current($type);
                $eventUsers->value = 1;
                $eventUsers->save();
            }
        }
    }
}