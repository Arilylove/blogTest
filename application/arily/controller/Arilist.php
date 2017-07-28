<?php
/**
 * Created by PhpStorm.
 * User: HXL
 * Date: 2017/7/21
 * Time: 11:05
 */
namespace app\arily\controller;

use think\Controller;
use think\Db;
use app\arily\controller\Base;

class Arilist extends Controller
{
     private $tableList = "blog_list";
     private $tableLink = "blog_listlink";
     public function base(){
         $ba = new Base();
         return $ba;
     }
     /*
      * 分类列表菜单
      * */
     public function listLine(){
         $tableName1 = $this->tableList;
         $tableName2 = '';
         $param = '';
         $html = 'listlink';
         $field = 'list_id,list_name,list_status,list_linkId';
         $where = '';
         $destination = 'arilist/listline';
         $listLine = $this->base()->search($tableName1, $tableName2, $param, $html, $field, $where, $destination);
         return $listLine;
     }

     /*
      * 添加列表
      * */
    public function addList(){
        $listName = Db::table($this->tableList)->field('list_id,list_name,list_status')->where('list_status','1')->select();
        $this->assign('listName', $listName);
        return $this->fetch('arilist/addlist');
    }
     public function addListOut(){
          $list_id = input("param.list_id");
          $list_name = input('param.list_name');
          $list_status = input('param.list_status');
          $list_linkId = input('param.list_linkId');
          $list = array(
              'list_id'=>$list_id,
              'list_name'=>$list_name,
              'list_status'=>$list_status,
              'list_linkId'=>$list_linkId
          );
         //var_dump($list);exit();
         //验证不重复性
         if(!$list){
             return $this->error('请填入需要添加的列表信息');
         }
         $result = Db::table($this->tableList)->insert($list);
         if(!$result){
             return $this->error('添加失败');
         }
         return $this->success('添加成功','arilist/listline');
     }
    /*
    * 列表修改
    * */
    public function updateList(){
        return $this->fetch('arilist/udpatelist');
    }
    public function updateListOut()
    {
        $list_id = input("param.list_id");
        $list_name = input('param.list_name');
        $list_status = input('param.list_status');
        $list_linkId = input('param.list_linkId');
        $list = array(
            'list_id'=>$list_id,
            'list_name'=>$list_name,
            'list_status'=>$list_status,
            'list_linkId'=>$list_linkId
        );
        var_dump($list);exit();
        $this->assign('list_blog', $list);
        $result = Db::table($this->tableList)->where('list_id',$list_id)->update($list);
        if(!$result){
            return $this->error('修改失败');
        }
        return $this->success('修改成功');


    }


     /*
      * 列表删除
      * */
    public function delList(){
        $list_id = input("param.list_id");
        $result = Db::table($this->tableList)->where('list_id', $list_id)->delete();
        if(!$result){
            return $this->error('删除失败');
        }
        return $this->success("删除成功");


    }

    /*
    * 首页列表菜单
    * */
    public function listLink(){
        $tableName1 = $this->tableLink;
        $tableName2 = $this->tableList;
        $param = 'list_linkId';
        $html = 'link';
        $field = 'link_id,list_name,link_title,list_linkId,link_content,link_time,link_img';
        $where = '';
        $destination = 'arilist/listlink';
        $listLine = $this->base()->search($tableName1, $tableName2, $param, $html, $field, $where, $destination);
        return $listLine;
    }

    /*
     * 添加首页列表
     * */
    public function addLink(){
        $listName = Db::table($this->tableList)->field('list_name,list_linkId')->select();
        $this->assign('listName', $listName);
        return $this->fetch('arilist/addlink');
    }
    public function addLinkOut(){
        $link_id = input("param.link_id");
        $link_title = input('param.link_title');
        $link_content = input('param.link_content');
        $link_time = date('Y-m-d H:i:s', time());
        $link_img = input('param.link_img');
        $list_linkId = input('param.list_linkId');
        //var_dump($list_linkId);exit();
        //$list_linkId = Db::table($this->tableList)->field('list_name,list_linkId')->where('list_name',$list_name)->find();
        $link = array(
            'link_id'=>$link_id,
            'link_title'=>$link_title,
            'link_content'=>$link_content,
            'link_time'=>$link_time,
            'link_img'=>$link_img,
            'list_linkId'=>$list_linkId
        );
        //var_dump($link);exit();
        //验证不重复性
        if(!$link){
            return $this->error('请填入需要添加的列表信息');
        }
        $result = Db::table($this->tableLink)->insert($link);
        if(!$result){
            return $this->error('添加失败');
        }
        return $this->success('添加成功','arilist/listlink');
    }
    /*
       * 首页列表修改
       * */
    public function updateLink(){
        return $this->fetch('arilist/udpatelink');
    }
    public function updateLinkOut()
    {
        $link_id = input("param.link_id");
        $link_title = input('param.link_title');
        $link_content = input('param.link_content');
        $link_time = input('param.link_time');
        $link_img = input('param.link_img');
        $list_linkId = input('param.list_linkId');
        //$list_linkId = Db::table($this->tableList)->field('list_name,list_linkId')->where('list_name',$list_name)->find();
        $link = array(
            'link_id'=>$link_id,
            'link_title'=>$link_title,
            'link_content'=>$link_content,
            'link_time'=>$link_time,
            'link_img'=>$link_img,
            'link_linkId'=>$list_linkId
        );
        var_dump($link);exit();
        $this->assign('link', $link);
        $result = Db::table($this->tableLink)->where('link_id',$link_id)->update($link);
        if(!$result){
            return $this->error('修改失败');
        }
        return $this->success('修改成功');


    }

    /*
     * 首页列表删除
     * */
    public function delLink(){
        $link_id = input("param.link_id");
        $result = Db::table($this->tableLink)->where('link_id', $link_id)->delete();
        if(!$result){
            return $this->error('删除失败');
        }
        return $this->success("删除成功");


    }


}