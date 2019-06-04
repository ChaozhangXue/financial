<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "attendance_record".
 *
 * @property int $id
 * @property string $name 用户名
 * @property string $position 岗位
 * @property string $department 部门
 * @property string $join_time 入职时间
 * @property string $date 考勤日期
 * @property int $type 0: 正常 1:迟到 2 早退 3 事假 4病假 5 丧假 6旷工
 * @property int $day 天数
 * @property int $user_id 用户id
 */
class AttendanceRecord extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attendance_record';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'required'],
            [['date'], 'safe'],
            [['type', 'day', 'user_id'], 'integer'],
            [['name', 'position', 'department', 'join_time'], 'string', 'max' => 50],
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
            'position' => 'Position',
            'department' => 'Department',
            'join_time' => 'Join Time',
            'date' => 'Date',
            'type' => 'Type',
            'day' => 'Day',
            'user_id' => 'User ID',
        ];
    }
}
