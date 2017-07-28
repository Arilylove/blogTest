<?php
/**
 * Created by PhpStorm.
 * User: HXL
 * Date: 2017/7/21
 * Time: 11:02
 */
namespace app\arily\controller;

use think\Controller;
use think\Db;
use app\arily\controller\Base;

class Arily extends Controller
{
    private $tableUser = 'blog_user';
    public function base(){
        $b = new Base();
        return $b;
    }

    public function user(){
        $tableName1 = $this->tableUser;
        $tableName2 = '';
        $param = '';
        $html = 'user';
        $field = 'user_id,user_username,user_password';
        $where = '';
        $destination = 'arily/user';
        $listLine = $this->base()->search($tableName1, $tableName2, $param, $html, $field, $where, $destination);
        return $listLine;
    }
}