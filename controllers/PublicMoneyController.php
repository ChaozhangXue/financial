<?php

namespace app\controllers;

use app\models\CustomerData;
use app\models\PublicMoney;
use Yii;

/**
 * 数据管理--客户数据  第六行后两个
 */
class PublicMoneyController extends BaseController
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
            $all = PublicMoney::find()->where($data)->asArray()->all();
        } else {
            $all = PublicMoney::find()->asArray()->all();
        }


        $title = [
            '编号',
            '请款人',
            '对象类别',
            '申请日期',
            '费用类型',
            '请款用途',
            '申请金额(元)',
            '审核人',
            '复核人',
        ];
        $excel_data = [];
        foreach ($all as $val) {
            $excel_data[] = [
                $val['id'],
                $val['ask_name'],
                $val['type'],
                $val['date'],
                $val['type'],
                $val['reason'],
                $val['count'],
                $val['check_people'],
                $val['recheck_people'],
            ];
        }

        $this->export($title, $excel_data, '公费管理');
    }

    public function actionAdd()
    {
        $params['ask_name'] = Yii::$app->request->post('ask_name', '');//客户名称
        $params['department'] = Yii::$app->request->post('department', '');//客户公司名称
        $params['date'] = Yii::$app->request->post('date', '');//回款产品
        $params['count'] = Yii::$app->request->post('count', '');//产品数量
        $params['type'] = Yii::$app->request->post('type', '');//产品单价
        $params['reason'] = Yii::$app->request->post('reason', '');//产品总价
        $params['check_people'] = Yii::$app->request->post('check_people', '');//回款金额
        $params['recheck_people'] = Yii::$app->request->post('recheck_people', '');//回款日期

        $model = new PublicMoney();
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
     *  全部
     */
    public function actionAll()
    {
        //todo 分页
        $pageNum = Yii::$app->request->post('pageNum', '1');
        $pageSize = Yii::$app->request->post('pageSize', '5');

        $all = PublicMoney::find()->offset($pageNum * $pageSize)->limit($pageSize)->asArray()->all();
        $count = PublicMoney::find()->asArray()->count();

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
	    if($val === '0'){
	                $data[$key] = $val;

	}
            if ($val) {
                $data[$key] = $val;
        }
}
        if (!empty($data)) {
            $all = PublicMoney::find()->where($data)->asArray()->all();
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
        $one = PublicMoney::find()->where(['id' => $id])->asArray()->one();
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
        $one = PublicMoney::find()->where(['id' => $id])->one();

        if (!empty($one) && !empty($update)) {
            foreach ($update as $key => $value) {
                $one->$key = $value;
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

}
