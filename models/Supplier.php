<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "supplier".
 *
 * @property int $id 编号
 * @property int $company_type 1: 运营商 2同行公司
 * @property string $company_name 公司名称
 * @property string $company_owner 负责人
 * @property string $position 职位
 * @property string $industry 所属行业  1.金融业 2游戏业
 * @property string $email 邮箱
 * @property string $address 省市区详细地址
 * @property string $tel 座机
 * @property string $phone 手机号码
 * @property string $company_pic 公司照片
 * @property string $contract_num 合同编号
 * @property string $source 来源  1展会 2广告杂志 3客户转介绍
 * @property string $maker 建档人
 * @property string $make_time 建档时间
 * @property string $last_follow 最后跟进时间
 * @property string $created_at
 * @property string $updated_at
 */
class Supplier extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'supplier';
    }

    /**
     * {@inheritdoc}
     */
	public function rule(){
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
            'company_type' => 'Company Type',
            'company_name' => 'Company Name',
            'company_owner' => 'Company Owner',
            'position' => 'Position',
            'industry' => 'Industry',
            'email' => 'Email',
            'address' => 'Address',
            'tel' => 'Tel',
            'phone' => 'Phone',
            'company_pic' => 'Company Pic',
            'contract_num' => 'Contract Num',
            'source' => 'Source',
            'maker' => 'Maker',
            'make_time' => 'Make Time',
            'last_follow' => 'Last Follow',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
