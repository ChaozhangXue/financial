<?php

namespace app\controllers;

use app\models\Client;
use app\models\ClientPayRecord;
use app\models\ClientResource;

use Yii;

/**
 * 应收管理---客户管理 -客户应收
 */
class ClientPayRecordController extends BaseController
{
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
            $all = ClientPayRecord::find()->where($data)->asArray()->all();
        } else {
            $all = ClientPayRecord::find()->asArray()->all();
        }


        $title = [
            '客户订单编号',
            '客户合同编号',
            '合计金额(元)',
            '结算方式',
            '收款状态',
            '收款方式',
            '收款日期',
            '开票状态',
            '开票日期',
        ];
        $invoice_status = [1 => '已开票', 2 => '未开票'];
        $pay_method = [1 => '月结', 2 => '预付'];
        $receivables_status = [1 => '已收款', 2 => '未收款'];
        $receivables_type = [1 => '对公收款', 2 => '对私收款'];
        $excel_data = [];
        foreach ($all as $val) {
            $excel_data[] = [
                $val['id'],
                $val['id'],
                $val['total_count'],
                $pay_method[$val['pay_method']],
                $receivables_status[$val['receivables_status']],
                $receivables_type[$val['receivables_type']],
                $val['receivables_date'],
                $invoice_status[$val['invoice_status']],
                $val['invoice_date'],
            ];
        }

        $this->export($title, $excel_data, '应收管理-应收录入');
    }


    public function actionAdd()
    {
        $params['client_id'] = Yii::$app->request->post('client_id', '');
        $params['client_name'] = Yii::$app->request->post('client_name', '');
        $params['pay_method'] = Yii::$app->request->post('pay_method', '');
        $params['orderId'] = Yii::$app->request->post('orderId', '');
        $params['resource_id'] = Yii::$app->request->post('resource_id', '');
        $params['total_count'] = Yii::$app->request->post('total_count', '');
        $params['receivables_entity'] = Yii::$app->request->post('receivables_entity', '');
        $params['receivables_account'] = Yii::$app->request->post('receivables_account', '');
        $params['receivables_status'] = Yii::$app->request->post('receivables_status', '');
        $params['receivables_date'] = Yii::$app->request->post('receivables_date', '');
        $params['receivables_type'] = Yii::$app->request->post('receivables_type', '');
        $params['invoice_status'] = Yii::$app->request->post('invoice_status', '');
        $params['invoice_head'] = Yii::$app->request->post('invoice_head', '');
        $params['org_code'] = Yii::$app->request->post('org_code', '');
        $params['invoice_content'] = Yii::$app->request->post('invoice_content', '');
        $params['open_bank'] = Yii::$app->request->post('open_bank', '');
        $params['invoice_type'] = Yii::$app->request->post('invoice_type', '');
        $params['mail_addr'] = Yii::$app->request->post('mail_addr', '');
        $params['invoice_date'] = Yii::$app->request->post('invoice_date', '');
        $model = new ClientPayRecord();
        foreach ($params as $key => $val) {
            if($key == 'resource_id'){
                if(!empty($val)){
                    $model->$key = implode(',', $val);
                }
            }else{
                if ($val) {
                    $model->$key = $val;
                }
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

        $all = ClientPayRecord::find()->offset($pageNum * $pageSize)->limit($pageSize)->asArray()->all();
        $count = ClientPayRecord::find()->asArray()->count();

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
            $all = ClientPayRecord::find()->where($data)->asArray()->all();
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
        $one = ClientPayRecord::find()->where(['id' => $id])->asArray()->one();
        if(!empty($one)){
            if(!empty($one['resource_id'])){
                $resource_id = $one['resource_id'];
                $one['resource'] = ClientResource::find()->where('id in (' . $resource_id . ')')->asArray()->all();
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
    public function actionUpdate()
    {
        $id = Yii::$app->request->post('id', '');
        $update_json = Yii::$app->request->post('update_json', '');
        $update = json_decode($update_json, true);
        $one = ClientPayRecord::find()->where(['id' => $id])->one();

        if (!empty($one) && !empty($update)) {
            foreach ($update as $key => $value) {
                if($key == 'resource_id'){
                    if(!empty($value)){
                        $one->$key = implode(',', $value);
                    }
                }else {
                    $one->$key = $value;
                }
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
    }

}


