<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banci_order".
 *
 * @property int $id
 * @property int $banci_id 班次表的id
 * @property int $user_id 用户id
 */
class BanciOrder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banci_order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'banci_id' => 'Banci ID',
            'user_id' => 'User ID',
        ];
    }
}
