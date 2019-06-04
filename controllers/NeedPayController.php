<?php

namespace app\controllers;

use app\models\Supplier;
use Yii;

/**
 * 应付管理
 * Class NeedPayController
 * @package app\controllers
 */
class NeedPayController extends BaseController
{
    public function actionAdd(){
        $company_type = Yii::$app->request->get('company_type', '');
        $company_name = Yii::$app->request->get('company_name', '');
        $company_owner = Yii::$app->request->get('company_owner', '');
        $industry = Yii::$app->request->get('industry', '');
        $email = Yii::$app->request->get('email', '');
        $address = Yii::$app->request->get('address', '');
        $position = Yii::$app->request->get('position', '');
        $tel = Yii::$app->request->get('tel', '');
        $phone = Yii::$app->request->get('phone', '');
        $contract_num = Yii::$app->request->get('contract_num', '');
        $source = Yii::$app->request->get('source', '');
        $maker = Yii::$app->request->get('maker', '');
        $make_time = time();

        if(!empty($_FILES['data'])){
            //保存文件
            $company_pic = '';
        }else{
            $company_pic = '';
        }

        $model = new Supplier();
        $model->company_type = $company_type;
        $model->company_name = $company_name;
        $model->company_owner = $company_owner;
        $model->industry = $industry;
        $model->email = $email;
        $model->address = $address;
        $model->position = $position;
        $model->tel = $tel;
        $model->phone = $phone;
        $model->contract_num = $contract_num;
        $model->source = $source;
        $model->maker = $maker;
        $model->make_time = $make_time;
        $model->company_pic = $company_pic;
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
     * 查询
     */
    public function actionSearch(){
        $company_owner = Yii::$app->request->get('company_owner', '');
        $company_name = Yii::$app->request->get('company_name', '');
        $contract_num = Yii::$app->request->get('contract_num', '');
        $tel = Yii::$app->request->get('tel', '');
        $maker = Yii::$app->request->get('maker', '');


        $params = [];
        if(!empty($company_owner)){
            $params['company_owner'] = $company_owner;
        }

        if(!empty($company_name)){
            $params['company_name'] = $company_name;
        }

        if(!empty($contract_num)){
            $params['contract_num'] = $contract_num;
        }

        if(!empty($tel)){
            $params['tel'] = $tel;
        }

        if(!empty($maker)){
            $params['maker'] = $maker;
        }

        if(!empty($params)){
            $all = Supplier::find()->where($params)->asArray()->all();
            if(!empty($all)){
                $this->success(['supplier' => $all]);
            }else{
                $this->success(['supplier' => []]);
            }
        }else{
            $all = Supplier::find()->asArray()->all();
            $this->success(['supplier' => $all]);
        }
    }

    /**
     *  全部
     */
    public function actionAll(){
        //todo 分页
        $all = Supplier::find()->asArray()->all();
        $this->success(['supplier' => $all]);
    }

    /**
     *  查看单个
     */
    public function actionOne(){
        $id = Yii::$app->request->get('id', '');
        $one = Supplier::find()->where(['id'=> $id])->asArray()->one();
        $this->success(['supplier' => $one]);
    }

    public function actionUpdate(){
        $id = Yii::$app->request->get('id', '');
        $params['company_type'] = Yii::$app->request->get('company_type', '');
        $params['company_name'] = Yii::$app->request->get('company_name', '');
        $params['company_owner'] = Yii::$app->request->get('company_owner', '');
        $params['industry'] = Yii::$app->request->get('industry', '');
        $params['email'] = Yii::$app->request->get('email', '');
        $params['address'] = Yii::$app->request->get('address', '');
        $params['position'] = Yii::$app->request->get('position', '');
        $params['tel'] = Yii::$app->request->get('tel', '');
        $params['phone'] = Yii::$app->request->get('phone', '');
        $params['contract_num'] = Yii::$app->request->get('contract_num', '');
        $params['source'] = Yii::$app->request->get('source', '');
        $params['maker'] = Yii::$app->request->get('maker', '');
        $one = Supplier::find()->where(['id'=> $id])->one();
        if(empty($one)){
            $this->error();
        }
        foreach ($params as $key => $val){
            if(!empty($val)){
                $one->$key = $val;
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
    }

}
