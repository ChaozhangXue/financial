<?php

namespace app\controllers;

use app\models\Client;
use app\models\SupplierPayRecord;
use app\models\Resource;
use Yii;

/**
 * 应收管理---客户管理
 */
class SupplierPayRecordController extends BaseController
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
            $all = SupplierPayRecord::find()->where($data)->asArray()->all();
        } else {
            $all = SupplierPayRecord::find()->asArray()->all();
        }


        $title = [
            '编号',
            '订单合同编号',
            '合计金额(元)',
            '付款主体',
            '付款方式',
            '付款账号',
            '付款日期',
            '付款状态',
            '开票状态',
            '平帐状态',
        ];
        $pay_type = [0 => '对公', 1 => '对私'];
        $status = [0 => '已付款', 1 => '未付款'];
        $receipt_status = [1 => '已开票', 0 => '未开票'];
        $flat_account_type = [1 => '已平账', 0 => '未平账'];
        $excel_data = [];
        foreach ($all as $val) {
            $excel_data[] = [
                $val['id'],
                $val['order_num'],
                $val['total_price'],
                $val['pay_entity'],
                isset($val['pay_type'])?$pay_type[$val['pay_type']]:'',
                $val['pay_account'],
                $val['pay_time'],
                isset($val['status'])?$status[$val['status']]:'',
                isset($val['receipt_status'])?$receipt_status[$val['receipt_status']]:'',
                isset($val['flat_account_type'])?$flat_account_type[$val['flat_account_type']]:'',
            ];
        }

        $this->export($title, $excel_data, '应付录入');
    }

    public function actionAdd()
    {
        $params['supplier_id'] = Yii::$app->request->post('supplier_id', '');
        $params['supplier_name'] = Yii::$app->request->post('supplier_name', '');
        $params['order_num'] = Yii::$app->request->post('order_num', '');
        $params['total_price'] = Yii::$app->request->post('total_price', '');
        $params['pay_type'] = Yii::$app->request->post('pay_type', '');
        $params['status'] = Yii::$app->request->post('status', '');
        $params['pay_time'] = Yii::$app->request->post('pay_time', '');
        $params['pay_entity'] = Yii::$app->request->post('pay_entity', '');
        $params['pay_account'] = Yii::$app->request->post('pay_account', '');
        $params['receipt_status'] = Yii::$app->request->post('receipt_status', '');
        $params['receipt_head'] = Yii::$app->request->post('receipt_head', '');
        $params['org_code'] = Yii::$app->request->post('org_code', '');
        $params['receipt_content'] = Yii::$app->request->post('receipt_content', '');
        $params['deposit_bank'] = Yii::$app->request->post('deposit_bank', '');
        $params['receipt_type'] = Yii::$app->request->post('receipt_type', '');
        $params['address'] = Yii::$app->request->post('address', '');
        $params['receipt_date'] = Yii::$app->request->post('receipt_date', '');
        $params['address'] = Yii::$app->request->post('address', '');
        $params['flat_account_type'] = Yii::$app->request->post('flat_account_type', '');
        $params['backup'] = Yii::$app->request->post('backup', '');
        $params['resource_id'] = Yii::$app->request->post('resource_id', '');
        $model = new SupplierPayRecord();
        foreach ($params as $key => $val) {
            if($key == 'resource_id'){
                if(!empty($val)){
                    $model->$key = implode(',', $val);
                }
            }else{
		 if($val == "0"){
                    $model->$key = $val;       
                }else{
                    if ($val) {
                        $model->$key = $val;
                    }
                }
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


        $all = SupplierPayRecord::find()->offset($pageNum * $pageSize)->limit($pageSize)->asArray()->all();
        $count = SupplierPayRecord::find()->count();

        $this->success(['data' => $all, 'count' => $count]);
    }


    /**
     * 查询
     */
    public function actionSearch()
    {
        $search_json = Yii::$app->request->post('search_json', '');
        $search = json_decode($search_json, true);
        if(empty($search)){
            $this->error();
        }
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
            $all = SupplierPayRecord::find()->where($data)->asArray()->all();
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
        $one = SupplierPayRecord::find()->where(['id' => $id])->asArray()->one();
        if(!empty($one)){
            if(!empty($one['resource_id'])){
                $resource_id = $one['resource_id'];
                $one['resource'] = Resource::find()->where('id in (' . $resource_id . ')')->asArray()->all();
                $one['resource_id'] = explode(',',$one['resource_id']);
            }
            $this->success(['supplier' => $one]);
        }else{
            $this->success(['supplier' => []]);
        }
    }

    /**
     *  查看单个
     */
    public function actionUpdate(){
        $id = Yii::$app->request->post('id', '');
        $update_json = Yii::$app->request->post('update_json', '');
        $update = json_decode($update_json,true);
        $one = SupplierPayRecord::find()->where(['id'=> $id])->one();

        if(!empty($one) &&!empty($update)){


            foreach ($update as $key => $value){
                if($key == 'resource_id'){
                    if(!empty($value)){
                        $one->$key = implode(',', $value);
                    }
                }else {
                    if($value == "0"){
                        $one->$key = $value;
                    }else{
                        if ($value) {
                            $one->$key = $value;
                        }
                    }
                }
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

}


