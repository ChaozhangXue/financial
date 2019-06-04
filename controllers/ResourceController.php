<?php

namespace app\controllers;

use app\models\Client;
use app\models\Resource;
use Yii;

/**
 * 应收管理---客户管理
 */
class ResourceController extends BaseController
{
    public function actionAdd()
    {
        $params['pay_record_id'] = Yii::$app->request->post('pay_record_id', '');
        $params['pay_record_type'] = Yii::$app->request->post('pay_record_type', '');
        $params['resource_attribute'] = Yii::$app->request->post('resource_attribute', '');
        $params['pay_method'] = Yii::$app->request->post('pay_method', '');
        $params['yd_count'] = Yii::$app->request->post('yd_count', '');
        $params['lt1_count'] = Yii::$app->request->post('lt1_count', '');
        $params['lt2_count'] = Yii::$app->request->post('lt2_count', '');
        $params['dx_count'] = Yii::$app->request->post('dx_count', '');
        $params['yd_money'] = Yii::$app->request->post('yd_money', '');
        $params['lt1_money'] = Yii::$app->request->post('lt1_money', '');
        $params['lt2_money'] = Yii::$app->request->post('lt2_money', '');
        $params['dx_money'] = Yii::$app->request->post('dx_money', '');
        $params['yd_cost'] = Yii::$app->request->post('yd_cost', '');
        $params['lt1_cost'] = Yii::$app->request->post('lt1_cost', '');
        $params['lt2_cost'] = Yii::$app->request->post('lt2_cost', '');
        $params['dx_cost'] = Yii::$app->request->post('dx_cost', '');
        $params['total'] = Yii::$app->request->post('total', '');

        $model = new Resource();
        foreach ($params as $key => $val) {
            if ($val) {
                $model->$key = $val;
            }
        }

        try{
            if($model->save()){
                $this->success(['id'=>$model->id]);

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

        $all = Resource::find()->offset($pageNum * $pageSize)->limit($pageSize)->asArray()->all();
        $count = Resource::find()->asArray()->count();

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
            $all = Resource::find()->where($data)->asArray()->all();
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
        $one = Resource::find()->where(['id'=> $id])->one();

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
