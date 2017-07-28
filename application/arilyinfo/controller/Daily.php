<?php
/**
 * Created by PhpStorm.
 * User: HXL
 * Date: 2017/7/21
 * Time: 16:31
 */
namespace app\arilyinfo\controller;

use think\Controller;
use think\Db;
use app\arily\controller\Base;

class Daily extends Controller{
    private $tableBlog = "blog_blog";
    public function base(){
        $ba = new Base();
        return $ba;
    }
    public function newslistpic()
    {$tableName1 = $this->tableBlog;
        $tableName2 = '';
        $param = '';
        $html = 'blog';
        $field = 'blog_id,blog_title,blog_content,blog_img,blog_editor,blog_link,blog_time,blog_status';
        $where = '';
        $destination = 'daily/newslistpic';
        $listLine = $this->base()->search($tableName1, $tableName2, $param, $html, $field, $where, $destination);
        return $listLine;
    }

}