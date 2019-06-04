<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "attendance".
 *
 * @property int $id
 * @property string $name 姓名
 * @property string $user_id 用户id
 * @property string $position 岗位
 * @property string $department 部门
 * @property int $on_days 出勤天数
 * @property int $miss_days 旷工天数
 * @property int $late_days 迟到天数
 * @property int $early_leave_days 早退天数
 * @property int $shi_jia_days 事假天数
 * @property int $ill_days 病假天数
 * @property int $absence_days 缺勤天数
 */
class Attendance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attendance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['on_days', 'miss_days', 'late_days', 'early_leave_days', 'shi_jia_days', 'ill_days', 'absence_days'], 'integer'],
            [['name', 'user_id', 'position', 'department'], 'string', 'max' => 50],
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
            'user_id' => 'User ID',
            'position' => 'Position',
            'department' => 'Department',
            'on_days' => 'On Days',
            'miss_days' => 'Miss Days',
            'late_days' => 'Late Days',
            'early_leave_days' => 'Early Leave Days',
            'shi_jia_days' => 'Shi Jia Days',
            'ill_days' => 'Ill Days',
            'absence_days' => 'Absence Days',
        ];
    }
}
