<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client_pay_record".
 *
 * @property int $id
 * @property int $client_id 客户id
 * @property string $client_name 客户名称
 * @property int $total_count 合技金额
 * @property string $receivables_entity 收款主体
 * @property string $receivables_account 收款账户
 * @property int $pay_method 结算方式  1: 月结 2:预付
 * @property int $receivables_status 收款状态 1: 已收款 2:未收款
 * @property string $receivables_date 收款日期
 * @property int $receivables_type 收款方式 1:对公收款 2:对私收款
 * @property int $invoice_status 开票状态  1: 已开票 2:未开票
 * @property string $invoice_head 开票抬头
 * @property string $org_code 组织机构代码
 * @property string $invoice_content 开票内容
 * @property string $open_bank 开票银行
 * @property string $invoice_type 开票种类
 * @property string $mail_addr 邮寄地址
 * @property string $invoice_date 开票日期
 */
class ClientPayRecord extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_pay_record';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'total_count', 'pay_method', 'receivables_status', 'receivables_type', 'invoice_status'], 'integer'],
            [['receivables_date', 'invoice_date'], 'safe'],
            [['invoice_content'], 'string'],
            [['client_name', 'receivables_entity', 'receivables_account', 'invoice_head', 'org_code', 'open_bank', 'invoice_type', 'mail_addr'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Client ID',
            'client_name' => 'Client Name',
            'total_count' => 'Total Count',
            'receivables_entity' => 'Receivables Entity',
            'receivables_account' => 'Receivables Account',
            'pay_method' => 'Pay Method',
            'receivables_status' => 'Receivables Status',
            'receivables_date' => 'Receivables Date',
            'receivables_type' => 'Receivables Type',
            'invoice_status' => 'Invoice Status',
            'invoice_head' => 'Invoice Head',
            'org_code' => 'Org Code',
            'invoice_content' => 'Invoice Content',
            'open_bank' => 'Open Bank',
            'invoice_type' => 'Invoice Type',
            'mail_addr' => 'Mail Addr',
            'invoice_date' => 'Invoice Date',
        ];
    }
}
