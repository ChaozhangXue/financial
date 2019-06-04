<?php

namespace app\controllers;

use app\models\Userinfo;
use Yii;

/**
 * 账户管理-用户管理  账户管理  账户管理-新增用户  倒数第一列
 * Class UserController
 * @package app\controllers
 */
class FileController extends BaseController
{

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionUpload()
    {
        $url = 'http://backend.delcache.com/upload/';
        if (empty($_FILES)) {
            return true;
        } else {
            if ($_FILES["file"]["error"] > 0) {
                $this->error();
            } else {
                $name = time() . rand(0,9999);

                if (file_exists("upload/" . $name)) {
                    $this->success($url . $name);
                } else {
                    move_uploaded_file($_FILES["file"]["tmp_name"],
                        '/var/www/html/financial/web/upload/' . $name);
                    $this->success($url . $name);
                }
            }
        }

    }

}

