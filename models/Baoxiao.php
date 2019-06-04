<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "baoxiao".
 *
 * @property int $id 编号
 * @property string $people 报销人
 * @property string $account 报销金额
 * @property string $method 报销方式
 * @property string $project 报销项目
 * @property string $check_people 审核人
 * @property string $recheck_people 复审人
 * @property string $make_people
 * @property string $time 报销时间
 */
class Baoxiao extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'baoxiao';
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
            'people' => 'People',
            'account' => 'Account',
            'method' => 'Method',
            'project' => 'Project',
            'check_people' => 'Check People',
            'recheck_people' => 'Recheck People',
            'make_people' => 'Make People',
            'time' => 'Time',
        ];
    }
}
