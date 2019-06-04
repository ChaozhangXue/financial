<?php

namespace app\controllers;

use app\models\Supplier;
use Yii;

/**
 * 供应商管理
 * Class SupplierController
 * @package app\controllers
 */
class SupplierController extends BaseController
{
    public function actionExport()
    {
        $company_owner = Yii::$app->request->post('company_owner', '');
        $company_name = Yii::$app->request->post('company_name', '');
        $contract_num = Yii::$app->request->post('contract_num', '');
        $tel = Yii::$app->request->post('tel', '');
        $maker = Yii::$app->request->post('maker', '');


        $params = [];
        if (!empty($company_owner)) {
            $params['company_owner'] = $company_owner;
        }

        if (!empty($company_name)) {
            $params['company_name'] = $company_name;
        }

        if (!empty($contract_num)) {
            $params['contract_num'] = $contract_num;
        }

        if (!empty($tel)) {
            $params['tel'] = $tel;
        }

        if (!empty($maker)) {
            $params['maker'] = $maker;
        }

        if (!empty($params)) {
            $all = Supplier::find()->where($params)->asArray()->all();

        } else {
            $all = Supplier::find()->asArray()->all();
        }


        $title = [
            '编号',
            '公司类型',
            '公司名称',
            '负责人',
            '手机号码',
            '所属行业',
            '地址',
            '来源',
            '合同编号',
            '建档人',
            '最后跟进时间',
        ];
        $company_type = [1 => '运营商', 2 => '同行公司'];
        $industry = [1 => '金融业', 2 => '游戏业'];
        $source = [1 => '展会', 2 => '广告杂志', 3 => '客户转介绍'];
        $data = [];
        foreach ($all as $val) {
            $data[] = [
                $val['id'],
                $company_type[$val['company_type']],
                $val['company_name'],
                $val['company_owner'],
                $val['phone'],
                $industry[$val['industry']],
                $val['address'],
                $source[$val['source']],
                $val['contract_num'],
                $val['maker'],
                $val['last_follow'],
            ];
        }
	$this->success($this->export($title, $data, '供应商'));
    }

    public function actionAdd()
    {
        $company_type = Yii::$app->request->post('company_type', '');
        $company_name = Yii::$app->request->post('company_name', '');
        $company_owner = Yii::$app->request->post('company_owner', '');
        $company_pic = Yii::$app->request->post('company_pic', '');
        $industry = Yii::$app->request->post('industry', '');
        $email = Yii::$app->request->post('email', '');
        $address = Yii::$app->request->post('address', '');
        $position = Yii::$app->request->post('position', '');
        $tel = Yii::$app->request->post('tel', '');
        $phone = Yii::$app->request->post('phone', '');
        $contract_num = Yii::$app->request->post('contract_num', '');
        $source = Yii::$app->request->post('source', '');
        $make_time = time();


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
        $model->maker = isset($this->user_info['username']) ? $this->user_info['username'] : '';
        $model->make_time = $make_time;
        $model->company_pic = !empty($company_pic)? implode(',', $company_pic):'';
        $model->last_follow = time();
        $model->created_at = time();
        $model->updated_at = time();
        try {

            if ($model->save() != False) {
                $this->success();
            } else {
                $this->error();
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

        $this->success();
    }

    /**
     * 查询
     */
    public function actionSearch()
    {
        $company_owner = Yii::$app->request->post('company_owner', '');
        $company_name = Yii::$app->request->post('company_name', '');
        $contract_num = Yii::$app->request->post('contract_num', '');
        $tel = Yii::$app->request->post('tel', '');
        $maker = Yii::$app->request->post('maker', '');


        $params = [];
        if (!empty($company_owner)) {
            $params['company_owner'] = $company_owner;
        }

        if (!empty($company_name)) {
            $params['company_name'] = $company_name;
        }

        if (!empty($contract_num)) {
            $params['contract_num'] = $contract_num;
        }

        if (!empty($tel)) {
            $params['phone'] = trim($tel);
        }

        if (!empty($maker)) {
            $params['maker'] = $maker;
        }

        if (!empty($params)) {
            $all = Supplier::find()->where($params)->asArray()->all();
            if (!empty($all)) {
                $this->success(['supplier' => $all,'count'=> count($all)]);
            } else {
                $this->success(['supplier' => [],'count'=> 0]);
            }
        } else {
            $this->error();
        }
    }




    /**
     *  全部
     */
    public function actionAll()
    {
        $pageNum = Yii::$app->request->post('pageNum', '0');
        $pageSize = Yii::$app->request->post('pageSize', '5');
        $all = Supplier::find()->offset($pageNum * $pageSize)->limit($pageSize)->asArray()->all();
        $count = Supplier::find()->count();

        $this->success(['data' => $all, 'count' => $count]);
    }

    /**
     *  查看单个
     */
    public function actionOne()
    {
        $id = Yii::$app->request->post('id', '');
        $one = Supplier::find()->where(['id' => $id])->asArray()->one();
        $one['company_pic'] = !empty($one['company_pic'])? explode(',', $one['company_pic']):'';

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
        $one = Supplier::find()->where(['id' => $id])->one();

        if (!empty($one) && !empty($update)) {
            foreach ($update as $key => $value) {
                if(in_array($key, ['company_pic'])){
                    $one->$key = !empty($value)? implode(',', $value):'';
                }else{
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
        $this->success();
    }
    public function actionGetData(){
        $data = Supplier::find()->asArray()->all();
        $this->success($data);
    }
}

