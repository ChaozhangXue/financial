<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banci".
 *
 * @property int $id
 * @property string $name 班次名称
 * @property string $start_time 开始时间
 * @property string $end_time 结束时间
 */
class Banci extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banci';
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
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
        ];
    }
}
