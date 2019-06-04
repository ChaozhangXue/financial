<?php

namespace app\controllers;

use app\models\BanciOrder;
use app\models\CustomerData;
use app\models\PublicMoney;
use Yii;
use app\models\Banci;
use app\models\Userinfo;


/**
 * 考勤管理--班次管理 -- 排班表
 */
class BanciOrderController extends BaseController
{
    public function actionAdd()
    {
        $params['banci_id'] = Yii::$app->request->post('banci_id', '');//客户名称
        $params['user_id_list'] = Yii::$app->request->post('user_id_list', '');//客户公司名称

        if(!empty($params['user_id_list'])){
            $user_id_array = implode(',', $params['user_id_list']);
//            foreach ($user_id_array as $user_id){
                $model = new BanciOrder();
                $model->banci_id = $params['banci_id'];
                $model->user_id = $user_id_array;
                $model->save();
//            }
        }
        $this->success();
    }


    public function actionAll()
    {
        //todo 分页
        $pageNum = Yii::$app->request->post('pageNum', '0');
        $pageSize = Yii::$app->request->post('pageSize', '5');

        $all = BanciOrder::find()->offset($pageNum * $pageSize)->limit($pageSize)->asArray()->all();
        $count = BanciOrder::find()->asArray()->count();

        //获取班次信息
        if($count > 0){
            $ret = [];

            foreach ($all as $val){
                $banci = Banci::find()->select(['name','start_time','end_time'])->where(['id'=> $val['banci_id']])->asArray()->one();

                $user = Userinfo::find()->where('id in (' . $val['user_id']  . ')')->asArray()->all();
                $data = array_merge($val,$banci);
                $data['user'] = $user;
                $data['user_id'] = explode(',', $val['user_id']);

                $ret[] = $data;
            }
        }else{
            $ret = [];
        }

        $this->success(['data' => $ret, 'count' => $count]);
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
            $all = BanciOrder::find()->where($data)->asArray()->all();
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
        $val = BanciOrder::find()->where(['id' => $id])->asArray()->one();
        //获取班次信息
        $ret = [];
                $banci = Banci::find()->select(['name','start_time','end_time'])->where(['id'=> $val['banci_id']])->asArray()->one();

        $user = Userinfo::find()->where('id in (' . $val['user_id'] . ')')->asArray()->all();
        $data = array_merge($val, $banci);
        $data['user'] = $user;
        $data['user_id'] = explode(',', $val['user_id']);
        $ret = $data;

        $this->success(['data' => $ret]);
    }

    /**
     *  查看单个
     */
    public function actionUpdate(){
	        $id = Yii::$app->request->post('id', '');
        $update_json = Yii::$app->request->post('update_json', '');
        $update = json_decode($update_json, true);
        $one = BanciOrder::find()->where(['id' => $id])->one();

        if (!empty($one) && !empty($update)) {
            foreach ($update as $key => $value) {
                if($key == 'user_id'){
                    $one->$key = expload(',',$value);

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

    public function actionDelete()
    {
        $id = Yii::$app->request->post('id', '');
        $one = BanciOrder::find()->where(['id'=> $id])->one();
        if(!empty($one)){
            $one->delete();
        }
        $this->success();
    }

}
