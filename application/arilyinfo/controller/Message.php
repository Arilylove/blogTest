<?php
/**
 * Created by PhpStorm.
 * User: HXL
 * Date: 2017/7/21
 * Time: 16:32
 */
namespace app\arilyinfo\controller;

use think\Controller;
use think\Db;
use app\arily\controller\Base;

class Message extends Controller{
    private $tableMessage = 'blog_leamessage';
    public function base(){
        $b = new Base();
        return $b;
    }
    public function index()
    {
        $tableName1 = $this->tableMessage;
        $tableName2 = '';
        $param = '';
        $html = 'message';
        $field = 'lea_id,lea_content,lea_editor,lea_status,lea_time';
        $where = '';
        $destination = 'message/index';
        $listLine = $this->base()->search($tableName1, $tableName2, $param, $html, $field, $where, $destination);
        return $listLine;
    }
    public function addMessage(){

        return $this->fetch('message/addmessage');
    }

    public function addMessageOut(){
        $lea_id = input('param.lea_id');
        $lea_content = input('param.lea_content');
        $lea_editor = input('param.lea_editor');
        $lea_status = input('param.lea_status');
        $lea_time = date('Y-m-d H:i:s',time());
        $leaMessage = array(
            'lea_id'=>$lea_id,
            'lea_content'=>$lea_content,
            'lea_editor'=>$lea_editor,
            'lea_status'=>$lea_status,
            'lea_time'=>$lea_time,
        );
        //var_dump($leaMessage);exit();
        if(empty($lea_editor) || empty($lea_content)){
            return $this->error('请添加留言');
        }
        $result = Db::table($this->tableMessage)->insert($leaMessage);
        if(!$result){
            return $this->error("留言失败");
        }
        return $this->success("留言成功", 'message/index');

    }
}