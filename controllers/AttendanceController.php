<?php

namespace app\controllers;

use app\models\Attendance;
use app\models\AttendanceRecord;
use app\models\Userinfo;
use Yii;

/**
 * 考勤管理--- 考勤记录
 * Class AttendanceController
 * @package app\controllers
 */
class AttendanceController extends BaseController
{
    //0: 正常 1:迟到 2 早退 3 事假 4病假 5 丧假 6旷工
    public $attendance_reflect = [
        '0' => 'on_days',
        '1' => 'late_days',
        '2' => 'early_leave_days',
        '3' => 'shi_jia_days',
        '4' => 'ill_days',
        '5' => 'absence_days',
        '6' => 'miss_days',
    ];

    //todo 涉及两张表
    public function actionExport()
    {
        $search_json = Yii::$app->request->post('search_json', '');
        $search = json_decode($search_json, true);
        $data = [];

        foreach ($search as $key => $val) {
            if ($val) {
                $data[$key] = $val;
            }
        }
        if (!empty($data)) {
            $all = Attendance::find()->where($data)->asArray()->all();
        } else {
            $all = Attendance::find()->asArray()->all();
        }

        $title = [
            '编号',
            '员工姓名',
            '岗位',
            '部门',
            '入职时间',
            '考勤日期',
            '出勤天数',
            '旷工天数',
            '迟到天数',
            '早退天数',
            '事假天数',
            '病假天数',
            '缺勤天数',
        ];
        $excel_data = [];
        foreach ($all as $val) {
            $excel_data[] = [
                $val['id'],
                $val['name'],
                $val['position'],
                $val['join_date'],
                $val['attendance_date'],
                $val['on_days'],
                $val['miss_days'],
                $val['late_days'],
                $val['early_leave_days'],
                $val['shi_jia_days'],
                $val['ill_days'],
                $val['absence_days'],
            ];
        }

        $this->export($title, $excel_data, '考勤记录');
    }

    public function actionGetUsername()
    {
        $all = Userinfo::find()->where(['enabled' => 1])->asArray()->all();
        $this->success(['users' => $all]);
    }

    public function actionAdd()
    {
        $params['user_id'] = Yii::$app->request->post('user_id', '');//用户名
        $params['name'] = Yii::$app->request->post('name', '');//用户名
        $params['position'] = Yii::$app->request->post('position', '');//岗位
        $params['department'] = Yii::$app->request->post('department', '');//部门
        $params['join_time'] = Yii::$app->request->post('join_time', '');//入职时间
        $params['date'] = Yii::$app->request->post('date', '');//考勤日期
        $params['type'] = Yii::$app->request->post('type', '');//0: 正常 1:迟到 2 早退 3 事假 4病假 5 丧假 6旷工
        $params['day'] = Yii::$app->request->post('day', 1);//天数
        //$params['join_date'] = Yii::$app->request->post('join_date', 1);//天数

        $model = new AttendanceRecord();
        foreach ($params as $key => $val) {
            if ($val) {
                $model->$key = $val;
            }
        }

        try {
            $model->save();
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

        //去attendance 表里面找到这个用户,然后给对应的假期加上日子  如果不存在 就插入一条
        $attendance_people = Attendance::find()->where(['user_id' => $params['user_id']])->one();
        $attribute_name = $this->attendance_reflect[$params['type']];
        if ($attendance_people) {
            //存在
            $attendance_people->$attribute_name = $attendance_people->$attribute_name + $params['day'];
            $attendance_people->save();
        } else {
            //不存在
            $attendance_model = new Attendance();
            $attendance_model->name = $params['name'];
            $attendance_model->position = $params['position'];
            $attendance_model->department = $params['department'];
            $attendance_model->user_id =$params['user_id'];
            $attendance_model->$attribute_name = $params['day'];
            $attendance_model->join_date = $params['join_time'];
            $attendance_model->attendance_date = $params['date'];
            $attendance_model->save();
        }

        $this->success();
    }

    /**
     *  全部
     */
    public function actionAll()
    {
        //todo 分页
        $pageNum = Yii::$app->request->post('pageNum', '0');
        $pageSize = Yii::$app->request->post('pageSize', '5');

        $all = Attendance::find()->offset($pageNum * $pageSize)->limit($pageSize)->asArray()->all();
        $count = Attendance::find()->count();

        $this->success(['data' => $all, 'count' => $count]);
    }


    /**
     * 查询
     */
    public function actionSearch()
    {
        $search_json = Yii::$app->request->post('search_json', '');
        $search = json_decode($search_json, true);
        $data = [];
        if(empty($search)){
            $this->error();
        }
        foreach ($search as $key => $val) {
            if ($val) {
                $data[$key] = $val;
            }
        }
        if (!empty($data)) {
            $all = Attendance::find()->where($data)->asArray()->all();
            if (!empty($all)) {
                $this->success(['data'=>$all, 'count'=> count($all)]);
            } else {
                $this->success(['data'=>[], 'count'=> 0]);
            }
        } else{
			$this->error();
		}
    }


    /**
     *  查看单个
     */
    public function actionOne()
    {
        $id = Yii::$app->request->post('id', '');
        $one = Attendance::find()->where(['id' => $id])->asArray()->one();
        $this->success(['supplier' => $one]);
    }

    /**
     *  查看单个
     */
    public function actionUpdate()
    {
        $id = Yii::$app->request->post('id', '');
        $update_json = Yii::$app->request->post('update_json', '');
        $update = json_decode($update_json, true);
        $one = Attendance::find()->where(['id' => $id])->one();

        if (!empty($one) && !empty($update)) {
            foreach ($update as $key => $value) {
                $one->$key = $value;
            }
            try {
                if ($one->save()) {
                    $this->success();
                } else {
                    $this->error();
                }
            } catch (\Exception $e) {
                $this->error($e->getMessage());
            }
        } else {
            $this->error();
        }
        $this->success();
    }

}
