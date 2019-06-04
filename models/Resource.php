<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "resource".
 *
 * @property int $id
 * @property int $pay_record_id 对应的供应商和客户的应付表的id
 * @property int $pay_record_type 1:供应商 2:客户
 * @property string $resource_attribute 资源属性
 * @property string $pay_method 付款方式
 * @property int $yd_count 移动消耗条数
 * @property int $lt1_count 联调1消耗条数
 * @property int $lt2_count 联调2消耗条数
 * @property int $dx_count 电信消耗条数
 * @property int $yd_money 移动报价
 * @property int $lt1_money 联调1报价
 * @property int $lt2_money 联通2报价
 * @property int $dx_money 电信报价
 * @property int $yd_cost 移动成本
 * @property int $lt1_cost 联通1成本
 * @property int $lt2_cost 联通2成本
 * @property int $dx_cost 电信成本
 * @property int $total 总金额
 */
class Resource extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'resource';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pay_record_id' => 'Pay Record ID',
            'pay_record_type' => 'Pay Record Type',
            'resource_attribute' => 'Resource Attribute',
            'pay_method' => 'Pay Method',
            'yd_count' => 'Yd Count',
            'lt1_count' => 'Lt1 Count',
            'lt2_count' => 'Lt2 Count',
            'dx_count' => 'Dx Count',
            'yd_money' => 'Yd Money',
            'lt1_money' => 'Lt1 Money',
            'lt2_money' => 'Lt2 Money',
            'dx_money' => 'Dx Money',
            'yd_cost' => 'Yd Cost',
            'lt1_cost' => 'Lt1 Cost',
            'lt2_cost' => 'Lt2 Cost',
            'dx_cost' => 'Dx Cost',
            'total' => 'Total',
        ];
    }
}
