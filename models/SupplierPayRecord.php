<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "supplier_pay_record".
 *
 * @property int $id
 * @property int $supplier_id 供应商id
 * @property string $supplier_name 供应商那么
 * @property int $order_num 订单合同编号
 * @property string $total_price 总金额
 * @property int $pay_type 付款方式 (0:对公 1：对私)  
 * @property int $status 付款状态(0:已付款、1:未付款)
 * @property string $pay_time 付款日期
 * @property string $pay_entity 付款主体
 * @property string $pay_account 付款账号
 * @property int $receipt_status 开票状态1：已开票、0：未开票
 * @property string $receipt_head 开票抬头
 * @property string $org_code 组织机构代码
 * @property string $receipt_content 开票内容
 * @property string $deposit_bank 开户银行
 * @property string $receipt_type 开票种类
 * @property string $address 邮寄地址
 * @property string $receipt_date 开票日期
 * @property int $flat_account_type 平账状态1:已平账、0:未平账
 * @property string $backup 备注信息
 */
class SupplierPayRecord extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'supplier_pay_record';
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
            'supplier_id' => 'Supplier ID',
            'supplier_name' => 'Supplier Name',
            'order_num' => 'Order Num',
            'total_price' => 'Total Price',
            'pay_type' => 'Pay Type',
            'status' => 'Status',
            'pay_time' => 'Pay Time',
            'pay_entity' => 'Pay Entity',
            'pay_account' => 'Pay Account',
            'receipt_status' => 'Receipt Status',
            'receipt_head' => 'Receipt Head',
            'org_code' => 'Org Code',
            'receipt_content' => 'Receipt Content',
            'deposit_bank' => 'Deposit Bank',
            'receipt_type' => 'Receipt Type',
            'address' => 'Address',
            'receipt_date' => 'Receipt Date',
            'flat_account_type' => 'Flat Account Type',
            'backup' => 'Backup',
        ];
    }
}
