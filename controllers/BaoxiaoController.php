<?php

namespace app\controllers;

use app\models\Baoxiao;
use app\models\Supplier;
use Yii;

/**
 * 报销管理
 * Class BaoxiaoController
 * @package app\controllers
 */
class BaoxiaoController extends BaseController
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
            $all = Baoxiao::find()->where($data)->asArray()->all();
        } else {
            $all = Baoxiao::find()->asArray()->all();
        }


        $title = [
            '编号',
            '报销人',
            '报销时间',
            '报销金额(元)',
            '报销项目',
            '报销方式',
            '审核人',
            '复核人',
        ];

        $excel_data = [];
        foreach ($all as $val) {
            $excel_data[] = [
                $val['id'],
                $val['people'],
                $val['time'],
                $val['account'],
                $val['project'],
                $val['method'],
                $val['check_people'],
                $val['recheck_people'],
            ];
        }

        $this->export($title, $excel_data, '报销管理');
    }

    public function actionAdd()
    {
        $params['people'] = Yii::$app->request->post('people', '');//报销人
        $params['time'] = Yii::$app->request->post('time', '');//报销时间
        $params['account'] = Yii::$app->request->post('account', '');//报销金额
        $params['method'] = Yii::$app->request->post('method', '');//报销方式
        $params['project'] = Yii::$app->request->post('project', '');//报销项目
        $params['check_people'] = Yii::$app->request->post('check_people', '');//审核人
        $params['recheck_people'] = Yii::$app->request->post('recheck_people', '');//复核人
        $params['make_people'] = Yii::$app->request->post('make_people', '');//出账人

        if(empty($params['make_people'] )){
            $params['make_people']  = isset($this->user_info['username']) ? $this->user_info['username'] : '';

        }
        $model = new Baoxiao();
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
            $all = Baoxiao::find()->where($data)->asArray()->all();
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
     *  全部
     */
    public function actionAll()
    {
        //todo 分页
        $pageNum = Yii::$app->request->get('pageNum', '0');
        $pageSize = Yii::$app->request->get('pageSize', '5');

        $all = Baoxiao::find()->offset($pageNum * $pageSize)->limit($pageSize)->asArray()->all();

        $count = Baoxiao::find()->asArray()->count();

        $this->success(['data' => $all, 'count' => $count]);
    }

    /**
     *  查看单个
     */
    public function actionOne()
    {
        $id = Yii::$app->request->post('id', '');
        $one = Baoxiao::find()->where(['id' => $id])->asArray()->one();
        $this->success($one);
    }

 public function actionUpdate(){
        $id = Yii::$app->request->post('id', '');
        $update_json = Yii::$app->request->post('update_json', '');
        $update = json_decode($update_json,true);
        $one = Baoxiao::find()->where(['id'=> $id])->one();

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

