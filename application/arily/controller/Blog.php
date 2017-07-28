<?php
/**
 * Created by PhpStorm.
 * User: HXL
 * Date: 2017/7/27
 * Time: 10:39
 */
namespace app\arily\controller;

use think\Controller;
use think\Db;
use app\arily\controller\Base;

class Blog extends Controller{
    private $tableBlog = 'blog_blog';

    public function base(){
        $b = new Base();
        return $b;
    }
    public function blogList(){
        $tableName1 = $this->tableBlog;
        $tableName2 = '';
        $param = '';
        $html = 'blog';
        $field = 'blog_id,blog_title,blog_content,blog_img,blog_editor,blog_link,blog_status,blog_time';
        $where = '';
        $destination = 'blog/bloglist';
        $listLine = $this->base()->search($tableName1, $tableName2, $param, $html, $field, $where, $destination);
        return $listLine;
    }
    /*
     * 添加
     */
    public function addBlog(){
        return $this->fetch('blog/addblog');
    }

    public function addBlogOut(){

        $blog_id = input('param.blog_id');
        $blog_title = input('param.blog_title');
        $blog_content = input('param.blog_content');
        $blog_editor = input('param.blog_editor');
        $blog_link = input('param.blog_link');
        $blog_status = input('param.blog_status');
        $blog_img = input('param.blog_img');
        $blog_time = date("Y-m-d H:i:s", time());
        $blog = array(
            'blog_id'=>$blog_id,
            'blog_title'=>$blog_title,
            'blog_content'=>$blog_content,
            'blog_editor'=>$blog_editor,
            'blog_link'=>$blog_link,
            'blog_status'=>$blog_status,
            'blog_img'=>$blog_img,
            'blog_time'=>$blog_time
        );
        //var_dump($blog);exit();
        if(empty($blog)){
            return $this->error('输入要添加的内容');
        }
        $result = Db::table($this->tableBlog)->insert($blog);
        if(!$result){
            return $this->error('添加失败');
        }
        return $this->success('添加成功','blog/bloglist');
    }
    /*
     * 修改
     */

    public function updateBlog(){

        $blog_id = input('param.blog_id');
        $blog_title = input('param.blog_title');
        $blog_content = input('param.blog_content');
        $blog_editor = input('param.blog_editor');
        $blog_link = input('param.blog_link');
        $blog_status = input('param.blog_status');
        $blog_img = input('param.blog_img');
        $blog_time = input('param.blog_time');
        $blog = array(
            'blog_id'=>$blog_id,
            'blog_title'=>$blog_title,
            'blog_content'=>$blog_content,
            'blog_editor'=>$blog_editor,
            'blog_link'=>$blog_link,
            'blog_status'=>$blog_status,
            'blog_img'=>$blog_img,
            'blog_time'=>$blog_time
        );
        $this->assign("blog", $blog);
        $result = Db::table($this->tableBlog)->where('blog_id', $blog_id)->update($blog);
        if(!$result){
            return $this->error('修改失败');
        }
        return $this->success('修改成功');
    }

         /*
          * 删除博客
          * */
    public function delBlog(){
        $blog_id = input("param.blog_id");
        $result = Db::table($this->tableBlog)->where('blog_id', $blog_id)->delete();
        if(!$result){
            return $this->error('删除失败');
        }
        return $this->success("删除成功");


    }

}