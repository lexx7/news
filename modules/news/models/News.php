<?php

namespace app\modules\news\models;

use app\modules\events\models\EventBehavior;
use app\modules\events\services\Events;
use budyaga\users\models\User;
use Yii;
use yii\data\Pagination;

/**
 * This is the model class for table "news".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $create_user_id
 * @property integer $edit_user_id
 * @property string $create_date_time
 * @property string $edit_date_time
 * @property integer $actual
 *
 * @property User $createUser
 * @property User $editUser
 */
class News extends \yii\db\ActiveRecord
{
    /** @var Pagination */
    private $pagination = null;

    public function behaviors()
    {
        return [
            EventBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            [['id', 'create_user_id', 'edit_user_id', 'actual'], 'integer'],
            [['content'], 'string'],
            [['create_date_time', 'edit_date_time'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['create_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['create_user_id' => 'id']],
            [['edit_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['edit_user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'create_user_id' => 'Create User ID',
            'edit_user_id' => 'Edit User ID',
            'create_date_time' => 'Create Date Time',
            'edit_date_time' => 'Edit Date Time',
            'actual' => 'Actual',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreateUser()
    {
        return $this->hasOne(User::className(), ['id' => 'create_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEditUser()
    {
        return $this->hasOne(User::className(), ['id' => 'edit_user_id']);
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        $new = false;
        if ($this->id) {
            $this->edit_date_time = (new \DateTime())->format('Y-m-d H:i:s');
            $this->edit_user_id = Yii::$app->user->id;
        } else {
            $this->create_date_time = (new \DateTime())->format('Y-m-d H:i:s');
            $this->create_user_id = Yii::$app->user->id;
            $this->actual = 1;
            $new = true;
        }

        $result = parent::save($runValidation, $attributeNames);
        if ($new) $this::trigger('events-create-news');
        return $result;
    }

    /**
     * @param int $limit
     * @return Pagination
     */
    public function getPagination($limit)
    {
        if (is_null($this->pagination)) {

            $query = $this->find();

            $pagination = new Pagination([
                'defaultPageSize' => intval($limit),
                'totalCount' => $query->count(),
            ]);

            $this->pagination = $pagination;
        }

        return $this->pagination;
    }

    /**
     * @param int $limit
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getNews($limit)
    {
        $query = $this->find();
        $pagination = $this->getPagination($limit);

        $news = $query->orderBy(['id' => 'desc'])
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $news;
    }
}
