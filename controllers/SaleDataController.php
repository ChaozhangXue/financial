<?php

namespace app\controllers;

use app\models\SaleData;
use Yii;

/**
 * 数据管理--销售数据    第六列 前两个
 * Class BaoxiaoController
 * @package app\controllers
 */
class SaleDataController extends BaseController
{

    public function actionExport()
    {
        $search_json = Yii::$app->request->post('search_json', '');
        $search = json_decode($search_json, true);
        $data = [];
        foreach ($search as $key => $val) {
	                if($val === '0'){
                $data[$key] = $val;

        }

            if ($val) {
                $data[$key] = $val;
            }
        }
        if (!empty($data)) {
            $all = SaleData::find()->where($data)->asArray()->all();
        } else {
            $all = SaleData::find()->asArray()->all();
        }


        $title = [
            '编号',
            '销售员',
            '当前排名',
            '考核月份',
            '月度指标',
            '月度回款金额(元)',
            '提成金额(元)',
            '所属部门',
            '入职时间',
        ];
        $excel_data = [];
        $month_target = [0 => '未达成', 1 => '已达成'];

        foreach ($all as $val) {
            $excel_data[] = [
                $val['id'],
                $val['sales_name'],
                $val['rank'],
                $val['date'],
                $month_target[$val['month_target']],
                $val['month_repay'],
                $val['reback_money'],
                $val['department'],
                $val['employee_time'],
            ];
        }

        $this->export($title, $excel_data, '销售数据');
    }

    public function actionAdd()
    {
        $params['sales_name'] = Yii::$app->request->post('sales_name', '');//销售名称
        $params['rank'] = Yii::$app->request->post('rank', '');//当前排名
        $params['date'] = Yii::$app->request->post('date', '');//考核月份
        $params['month_repay'] = Yii::$app->request->post('month_repay', '');//月度回款金额
        $params['month_target'] = Yii::$app->request->post('month_target', '');//发票状态 0:未达成 1:已达成

        $params['reback_money'] = Yii::$app->request->post('reback_money', '');//提成金额

        $params['department'] = Yii::$app->request->post('department', '');//部门
        $params['employee_time'] = Yii::$app->request->post('employee_time', '');//入职时间

        $model = new SaleData();
        foreach ($params as $key => $val) {
            if ($val) {
                $model->$key = $val;
            }
        }

        try {
            if ($model->save()) {
                $this->success();
            } else {
                $this->error();
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
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

        $all = SaleData::find()->offset($pageNum * $pageSize)->limit($pageSize)->asArray()->all();
        $count = SaleData::find()->asArray()->count();

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
		if($val === '0'){
                $data[$key] = $val;

	}
            if ($val) {
                $data[$key] = $val;
            }
        }
        if (!empty($data)) {
            $all = SaleData::find()->where($data)->asArray()->all();
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
        $one = SaleData::find()->where(['id' => $id])->asArray()->one();
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
        $one = SaleData::find()->where(['id' => $id])->one();

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
