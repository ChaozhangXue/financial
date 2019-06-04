<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "userinfo".
 *
 * @property int $id 用户ID
 * @property string $username 用户名
 * @property int $type 用户类别
 * @property string $phone 手机号码
 * @property int $user_ext 工号
 * @property string $position 职位
 * @property string $employment_date 入职时间
 * @property string $account_name 账号名称
 * @property string $password 密码
 * @property string $user_auth 用户权限 (1 档案管理  2用户管理 3, 数据管理)
 * @property string $function_auth 功能权限 1: 查看权限 2编辑权限 3:保存权限 4新增权限 5 查询权限 6 停用权限
 * @property int $enabled 是否启用
 * @property string $token
 * @property string $created_at
 * @property string $updated_at
 */
class Userinfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'userinfo';
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
            'username' => 'Username',
            'type' => 'Type',
            'phone' => 'Phone',
            'user_ext' => 'User Ext',
            'position' => 'Position',
            'employment_date' => 'Employment Date',
            'account_name' => 'Account Name',
            'password' => 'Password',
            'user_auth' => 'User Auth',
            'function_auth' => 'Function Auth',
            'enabled' => 'Enabled',
            'token' => 'Token',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
