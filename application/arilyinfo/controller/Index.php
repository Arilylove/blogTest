<?php
/**
 * Created by PhpStorm.
 * User: HXL
 * Date: 2017/7/21
 * Time: 16:14
 */
namespace app\arilyinfo\controller;

use think\Controller;
use think\Db;
use app\arily\controller\Base;

class Index extends Controller{
    private $tableIndex = "blog_listlink";
    private $tableList = "blog_list";
    public function base(){
        $b = new Base();
        return $b;
    }
    public function index(){
        /*
         * 有首页列表，图文推荐，还有点击排行，涉及多个表？？？？？？？？？？？？？？
         */
        $tableName1 = $this->tableIndex;
        $tableName2 = $this->tableList;
        $param = 'list_linkId';
        $html = 'listlink';
        $field = 'link_id,link_title,link_content,link_img,list_linkId,link_time,list_name';
        $where = '';
        $destination = 'index/index';
        $listLine = $this->base()->search($tableName1, $tableName2, $param, $html, $field, $where, $destination);
        return $listLine;
    }
    


}