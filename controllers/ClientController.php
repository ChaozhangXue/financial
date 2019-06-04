<?php

namespace app\controllers;

use app\models\Client;
use Yii;

/**
 * 应收管理---客户管理
 */
class ClientController extends BaseController
{
    public function actionExport()
    {
        $search_json = Yii::$app->request->post('search_json', '');
        $search = json_decode($search_json,true);
        $data = [];
        foreach ($search as $key => $val) {
            if ($val) {
                $data[$key] = $val;
            }
        }
        if (!empty($data)) {
            $all = Client::find()->where($data)->asArray()->all();
        } else {
            $all = Client::find()->asArray()->all();
        }



        $title = [
            '客户编号',
            '客户名称',
            '订单编号',
            '资源属性',
            '负责人',
            '联系电话',
            '所在地址',
            '客户来源',
            '跟进人员',
            '跟进时间',
            '平帐状态',
        ];
        $client_from = [0 => '展会1', 1 => '广告杂志2',2=>'客户转介绍'];
        $flat_account_type = [1 => '已平账', 0 => '未平账'];
        $excel_data = [];
        foreach ($all as $val) {
            $excel_data[] = [
                $val['client_number'],
                $val['name'],
                $val['order_id'],
                $val['resource_type'],
                $val['principal_name'],
                $val['mobile'],
                $val['address'],
                $client_from[$val['client_from']],
                $val['follower'],
                $val['follow_date'],
                $flat_account_type[$val['flat_account_type']],
            ];
        }

        $this->export($title, $excel_data, '客户档案');
    }

    public function actionAdd()
    {
        $params['client_number'] = Yii::$app->request->post('client_number', '');//客户名称
        $params['name'] = Yii::$app->request->post('name', '');//客户公司名称
        $params['order_id'] = Yii::$app->request->post('order_id', '');//回款产品
        $params['resource_type'] = Yii::$app->request->post('resource_type', '');//产品数量
        $params['principal_name'] = Yii::$app->request->post('principal_name', '');//产品单价
        $params['mobile'] = Yii::$app->request->post('mobile', '');//产品总价
        $params['address'] = Yii::$app->request->post('address', '');//回款金额
        $params['client_from'] = Yii::$app->request->post('client_from', '');//回款日期
        $params['follower'] = Yii::$app->request->post('follower', '');//回款日期
        $params['follow_date'] = Yii::$app->request->post('follow_date', '');//回款日期
        $params['flat_account_type'] = Yii::$app->request->post('flat_account_type', '');//回款日期
        $model = new Client();
        foreach ($params as $key => $val) {
            if ($val) {
                $model->$key = $val;
            }
        }

        try{
            if($model->save()){
                $this->success();
            }else{
                $this->error();
            }
        }catch (\Exception $e){
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

        $all = Client::find()->offset($pageNum * $pageSize)->limit($pageSize)->asArray()->all();
        $count = Client::find()->asArray()->count();

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
            $all = Client::find()->where($data)->asArray()->all();
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
        $one = Client::find()->where(['id' => $id])->asArray()->one();
        $this->success(['supplier' => $one]);
    }

    /**
     *  查看单个
     */
    public function actionUpdate(){
        $id = Yii::$app->request->post('id', '');
        $update_json = Yii::$app->request->post('update_json', '');
        $update = json_decode($update_json,true);
        $one = Client::find()->where(['id'=> $id])->one();

        if(!empty($one) &&!empty($update)){
            foreach ($update as $key => $value){
                $one->$key=$value;
            }
            try{
                if($one->save()){
                    $this->success();
                }else{
                    $this->error();
                }
            }catch (\Exception $e){
                $this->error($e->getMessage());
            }
        }else{
            $this->error();
        }
    }
    public function actionGetData(){
        $client = Client::find()->asArray()->all();
        $this->success($client);
    }
}
