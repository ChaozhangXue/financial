<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customer_data".
 *
 * @property int $id
 * @property string $customer_name 客户名称
 * @property string $customer_company 客户公司名称
 * @property string $repay_product_name 回款产品
 * @property int $num 产品数量
 * @property int $price 产品单价
 * @property int $total 产品总价
 * @property int $repay_money 回款金额
 * @property string $repay_date 回款日期
 */
class CustomerData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer_data';
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
            'customer_name' => 'Customer Name',
            'customer_company' => 'Customer Company',
            'repay_product_name' => 'Repay Product Name',
            'num' => 'Num',
            'price' => 'Price',
            'total' => 'Total',
            'repay_money' => 'Repay Money',
            'repay_date' => 'Repay Date',
        ];
    }
}
