<?php
/**
 * Created by PhpStorm.
 * User: HXL
 * Date: 2017/7/20
 * Time: 17:27
 */
namespace app\arily\controller;

use think\Controller;
use think\Db;

class Base extends Controller
{
    /*
     * 搜索
     * */
    public function search($tableName1, $tableName2 = '', $param, $html, $field, $where, $destination){
        $select = input('param.sel');
        $searchText = input('param.search_text');//搜索框中输入的内容
        if (!empty($searchText)) {
            //选择框默认不为空，按条件（搜索内容为对应值）选择
            //需要进行联合查询的
            if ($param != null){
                $multiTableList = $this->multiTable($tableName1, $tableName2, $param, $select, $searchText, $where, $field, $html, $destination);
                return $multiTableList;
            }
            //单表查询
            $single = $this->singleTable($tableName1, $field, $select, $searchText, $where, $html, $destination);
            return $single;
        }
        //搜索内容为空，直接显示列表,联合查询
        if ($tableName2 != ''){
            $multiTableList = $this->multiTable($tableName1, $tableName2, $param, $select, $searchText, $where, $field, $html, $destination);
            return $multiTableList;
        }
        //单表查询
        $single = $this->singleTable($tableName1, $field, $select, $searchText, $where, $html, $destination);
        return $single;
    }

    /*
     * 单表查询
     * */
    public function singleTable($tableName1, $field, $select, $searchText, $where, $html, $destination){
        $count = Db::table($tableName1)->where($select, $searchText)->count();
        $table = Db::table($tableName1)->field($field)
            ->where($select, $searchText)->where($where)->paginate(8, $count);
        //var_dump($table);exit();
        $page = $table->render();
        //$this->assign('list', $list);
        $this->assign('page', $page);     //list 是列表内容
        $this->assign($html, $table);
        return $this->fetch($destination);
    }

    /*
     * 多表查询
     * */
    public function multiTable($tableName1, $tableName2, $param, $select, $searchText, $where, $field, $html, $destination){
        $count = Db::table($tableName1)->join($tableName2, $tableName1.'.'.$param.'='.$tableName2.'.'.$param)
            ->where($select, $searchText)->count();
        if (empty($searchText)){
            //没有field直接显示列表
            $table = Db::table($tableName1)->join($tableName2, $tableName1.'.'.$param.'='.$tableName2.'.'.$param)
                ->where($select,  $searchText)->where($where)->paginate(8, $count);
            $result = $this->pulicList($html, $table, $destination);
            return $result;
        }
        $table = Db::table($tableName1)->join($tableName2, $tableName1.'.'.$param.'='.$tableName2.'.'.$param)
            ->field($field)->where($select,  $searchText)->where($where)->paginate(8, $count);
        //echo Db::table($tableName1)->getLastSql().'<br/>';
        $result = $this->pulicList($html, $table, $destination);
        return $result;
    }

    /*
     * 公用列表-=>多表
     * */
    public function pulicList($html, $table, $destination){
        $page = $table->render();
        //$this->assign('list', $list);
        $this->assign('page', $page);     //list 是列表内容
        $this->assign($html, $table);
        return $this->fetch($destination);
    }
}