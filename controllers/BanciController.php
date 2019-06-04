<?php

namespace app\controllers;

use app\models\Banci;
use app\models\CustomerData;
use app\models\PublicMoney;
use Yii;

/**
 * 考勤管理--班次管理 -- 班次管理
 */
class BanciController extends BaseController
{
    public function actionAdd()
    {
        $params['name'] = Yii::$app->request->post('name', '');//客户名称
        $params['start_time'] = Yii::$app->request->post('start_time', '');//客户公司名称
        $params['end_time'] = Yii::$app->request->post('end_time', '');//回款产品

        $model = new Banci();
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
        $all = Banci::find()->asArray()->all();
        $count = Banci::find()->count();

        $this->success(['data' => $all, 'count' => $count]);
    }
    public function actionDelete()
    {
        $id = Yii::$app->request->post('id', '');
        $one = Banci::find()->where(['id'=> $id])->one();
        if(!empty($one)){
            $one->delete();
        }
        $this->success();
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
            $all = Banci::find()->where($data)->asArray()->all();
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
        $one = Banci::find()->where(['id' => $id])->asArray()->one();
        $this->success(['supplier' => $one]);
    }

    /**
     *  查看单个
     */
    public function actionUpdate(){
        $id = Yii::$app->request->post('id', '');
        $update_json = Yii::$app->request->post('update_json', '');
        $update = json_decode($update_json,true);
        $one = Banci::find()->where(['id'=> $id])->one();

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
        $this->success();
    }

}
