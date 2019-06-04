<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sale_data".
 *
 * @property int $id 销售名称
 * @property string $sales_name 销售名称
 * @property int $rank 当前排名
 * @property string $date 考核月份
 * @property int $month_repay 月度回款金额
 * @property int $invoice_status 发票状态 0:未达成 1:已达成
 * @property string $department 部门
 * @property int $employee_time 入职时间
 */
class SaleData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sale_data';
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
            'sales_name' => 'Sales Name',
            'rank' => 'Rank',
            'date' => 'Date',
            'month_repay' => 'Month Repay',
            'invoice_status' => 'Invoice Status',
            'department' => 'Department',
            'employee_time' => 'Employee Time',
        ];
    }
}
