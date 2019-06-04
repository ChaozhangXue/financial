<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "public_money".
 *
 * @property int $id
 * @property string $ask_name 请款人
 * @property string $department 部门
 * @property string $date 申请日期
 * @property int $count 申请金额
 * @property int $type 费用类型
 * @property string $reason 请款用途
 * @property string $check_people 审核人
 * @property string $recheck_people 复核人
 */
class PublicMoney extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'public_money';
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
            'ask_name' => 'Ask Name',
            'department' => 'Department',
            'date' => 'Date',
            'count' => 'Count',
            'type' => 'Type',
            'reason' => 'Reason',
            'check_people' => 'Check People',
            'recheck_people' => 'Recheck People',
        ];
    }
}
