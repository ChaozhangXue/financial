<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "imprest".
 *
 * @property int $id id
 * @property string $name 入账或出账人姓名
 * @property int $money 金额数  入账或出账的金额
 * @property int $time 时间 入账或出账的时间
 * @property int $method 方式 入账或出账方式
 * @property int $type 1:入账 2:出账
 */
class Imprest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'imprest';
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
            'name' => 'Name',
            'money' => 'Money',
            'time' => 'Time',
            'method' => 'Method',
            'type' => 'Type',
        ];
    }
}
