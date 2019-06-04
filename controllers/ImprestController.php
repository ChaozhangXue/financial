<?php

namespace app\controllers;

use app\models\CustomerData;
use app\models\Imprest;
use Yii;

/**
 * 出纳管理备用金管理  第五行 第1,2,3,4个
 */
class ImprestController extends BaseController
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
            $all = Imprest::find()->where($data)->asArray()->all();
        } else {
//            $all = Imprest::find()->where(['type' => 1])->asArray()->all();
            $all = Imprest::find()->where()->asArray()->all();
        }

        $title = [
            '编号',
            '备用金总额(元)',
            '入账人',
            '入账时间',
            '入账方式',
        ];

        $excel_data = [];
        foreach ($all as $val) {
            $excel_data[] = [
                $val['id'],
                $val['money'],
                $val['name'],
                $val['time'],
                $val['method'],
            ];
        }
        $this->success($this->export($title, $excel_data, '备用金'));
    }

    public function actionAdd()
    {
        $params['name'] = Yii::$app->request->post('name', '');//入账或出账人姓名
        $params['money'] = Yii::$app->request->post('money', '');//金额数  入账或出账的金额
        $params['time'] = Yii::$app->request->post('time', '');//时间 入账或出账的时间
        $params['method'] = Yii::$app->request->post('method', '');//方式 入账或出账方式
        $params['type'] = Yii::$app->request->post('type', '');//1:入账 2:出账
        $params['reason'] = Yii::$app->request->post('reason', '');//1:入账 2:出账


        $model = new Imprest();
        foreach ($params as $key => $val) {
            if ($val) {
                $model->$key = $val;
            }
        }
        $one = Imprest::find()->orderBy('id desc')->asArray()->all();
        $now_total = isset($one[0]['now_total'])?$one[0]['now_total']:0;
        $now_last = isset($one[0]['now_last'])?$one[0]['now_last']:0;
        if($params['type'] == 1){
            //入账
//            备用金增加 结余增加

            $model->now_total = $now_total+$params['money'];
            $model->now_last = $now_last + $params['money'];

        }else{
            //出账
            //            备用金不变 结余减少
            $model->now_total = $now_total;
            $model->now_last = $now_last - $params['money'];
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
        $type = Yii::$app->request->post('type');
        $all = Imprest::find()->where(['type' => $type])->offset($pageNum * $pageSize)->limit($pageSize)->asArray()->all();
        $count = Imprest::find()->count();

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
            $all = Imprest::find()->where($data)->asArray()->all();
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
        $one = Imprest::find()->where(['id' => $id])->asArray()->one();
        $this->success(['supplier' => $one]);
    }

    /**
     *  查看单个
     */
    public function actionUpdate(){
        $id = Yii::$app->request->post('id', '');
        $update_json = Yii::$app->request->post('update_json', '');
        $update = json_decode($update_json,true);
        $one = Imprest::find()->where(['id'=> $id])->one();

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

    public function actionGetMoney(){
        $one = Imprest::find()->orderBy('id desc')->asArray()->one();

        $now_total = isset($one['now_total'])?$one['now_total']:0;
        $now_last = isset($one['now_last'])?$one['now_last']:0;
//        SELECT SUM(money) FROM imprest WHERE TYPE = 2;
//        $out_money = Imprest::find()->select('SUM(money)')->where(['type'=>2])->all();

        $this->success(['now_total' => $now_total, 'last' => $now_last]);
    }

}

