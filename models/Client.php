<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client".
 *
 * @property int $id
 * @property int $client_number
 * @property string $name
 * @property string $order_id
 * @property int $resource_type
 * @property string $principal_name
 * @property string $mobile
 * @property string $address
 * @property string $email
 * @property int $client_from 0:展会1:广告杂志2:客户转介绍
 * @property string $follower
 * @property string $follow_date
 * @property int $flat_account_type 0:未平账  1: 已平账
 * @property string $update_time
 */
class Client extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client';
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
            'client_number' => 'Client Number',
            'name' => 'Name',
            'order_id' => 'Order ID',
            'resource_type' => 'Resource Type',
            'principal_name' => 'Principal Name',
            'mobile' => 'Mobile',
            'address' => 'Address',
            'email' => 'Email',
            'client_from' => 'Client From',
            'follower' => 'Follower',
            'follow_date' => 'Follow Date',
            'flat_account_type' => 'Flat Account Type',
            'update_time' => 'Update Time',
        ];
    }
}
