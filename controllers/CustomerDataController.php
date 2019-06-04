<?php

namespace app\controllers;

use app\models\CustomerData;
use Yii;

/**
 * 数据管理--客户数据  第六行后两个
 */
class CustomerDataController extends BaseController
{
    public function actionExport()
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
            $all = CustomerData::find()->where($data)->asArray()->all();
        } else {
            $all = CustomerData::find()->asArray()->all();
        }


        $title = [
            '编号',
            '客户姓名',
            '客户公司名称',
            '回款产品',
            '产品数量',
            '产品单价(元)',
            '产品总价(元)',
            '回款(元)',
            '回款日期',
        ];

        $data = [];
        foreach ($all as $val) {
            $data[] = [
                $val['id'],
                $val['customer_name'],
                $val['customer_company'],
                $val['repay_product_name'],
                $val['num'],
                $val['price'],
                $val['total'],
                $val['repay_money'],
                $val['repay_date'],
            ];
        }

        $this->export($title, $data, '客户数据');
    }

    public function actionAdd()
    {
        $params['customer_name'] = Yii::$app->request->post('customer_name', '');//客户名称
        $params['customer_company'] = Yii::$app->request->post('customer_company', '');//客户公司名称
        $params['repay_product_name'] = Yii::$app->request->post('repay_product_name', '');//回款产品
        $params['num'] = Yii::$app->request->post('num', '');//产品数量
        $params['price'] = Yii::$app->request->post('price', '');//产品单价
        $params['total'] = Yii::$app->request->post('total', '');//产品总价
        $params['repay_money'] = Yii::$app->request->post('repay_money', '');//回款金额
        $params['repay_date'] = Yii::$app->request->post('repay_date', '');//回款日期

        $model = new CustomerData();
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
    }

    /**
     *  全部
     */
    public function actionAll()
    {
        //todo 分页
        $pageNum = Yii::$app->request->post('pageNum', '0');
        $pageSize = Yii::$app->request->post('pageSize', '5');

        $all = CustomerData::find()->offset($pageNum * $pageSize)->limit($pageSize)->asArray()->all();
        $count = CustomerData::find()->asArray()->count();

        $this->success(['data' => $all, 'count' => $count]);
    }


    /**
     * 查询
     */


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
            $all = CustomerData::find()->where($data)->asArray()->all();
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
        $one = CustomerData::find()->where(['id' => $id])->asArray()->one();
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
        $one = CustomerData::find()->where(['id' => $id])->one();

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
