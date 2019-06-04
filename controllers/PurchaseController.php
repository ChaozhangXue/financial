<?php

namespace app\controllers;

use app\models\Client;
use app\models\Purchase;
use app\models\SupplierPayRecord;
use Yii;

/**
 * 采购记录
 */
class PurchaseController extends BaseController
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
            $all = Purchase::find()->where($data)->asArray()->all();
        } else {
            $all = Purchase::find()->asArray()->all();
        }


        $title = [
            '编号',
            '公司名称',
            '通道',
            '属性',
            '采购价',
            '数量',
            '总金额',
            '采购日期',
        ];
        $excel_data = [];
        foreach ($all as $val) {
            $excel_data[] = [
                $val['id'],
                $val['company_name'],
                $val['way'],
                $val['resource'],
                $val['price'],
                $val['num'],
                $val['total_price'],
                $val['date'],
            ];
        }

        $this->export($title, $excel_data, '采购记录');
    }

    public function actionAdd()
    {
        $params['company_name'] = Yii::$app->request->post('company_name', '');
        $params['way'] = Yii::$app->request->post('way', '');
        $params['resource'] = Yii::$app->request->post('resource', '');
        $params['price'] = Yii::$app->request->post('price', '');
        $params['num'] = Yii::$app->request->post('num', '');
        $params['total_price'] = Yii::$app->request->post('total_price', '');
        $params['date'] = Yii::$app->request->post('date', '');
        $model = new Purchase();
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

        $all = Purchase::find()->offset($pageNum * $pageSize)->limit($pageSize)->asArray()->all();
        $count = Purchase::find()->asArray()->count();

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
            $all = Purchase::find()->where($data)->asArray()->all();
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
        $one = Purchase::find()->where(['id' => $id])->asArray()->one();
        $this->success(['supplier' => $one]);
    }

    /**
     *  查看单个
     */
    public function actionUpdate(){
        $id = Yii::$app->request->post('id', '');
        $update_json = Yii::$app->request->post('update_json', '');
        $update = json_decode($update_json,true);
        $one = Purchase::find()->where(['id'=> $id])->one();

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

}
