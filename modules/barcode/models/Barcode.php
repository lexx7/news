<?php

namespace app\modules\barcode\models;

use Yii;

/**
 * This is the model class for table "barcode".
 *
 * @property integer $id
 * @property string $code
 * @property string $create_date_time
 */
class Barcode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'barcode';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_date_time'], 'safe'],
            [['code'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'create_date_time' => 'Create Date Time',
        ];
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        $post = Yii::$app->request->post();

        $code = !empty($post['code']) ? $post['code'] : null;
        if (!$code) return false;

        $this->code = $code;
        $this->create_date_time = new \DateTime();

        return parent::save($runValidation, $attributeNames);
    }

    /**
     * @param int $limit
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getCodes($limit)
    {
        $query = $this->find();

        $news = $query->orderBy('id desc')
            ->limit($limit)
            ->all();

        return $news;
    }
}
