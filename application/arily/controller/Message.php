<?php
/**
 * Created by PhpStorm.
 * User: HXL
 * Date: 2017/7/21
 * Time: 11:18
 */
namespace app\arily\controller;

use Symfony\Component\Yaml\Tests\B;
use think\Controller;
use app\arily\controller\Base;

class Message extends Controller{
    private $tableMessage = 'blog_leamessage';
    public function Base(){
        $b = new Base();
        return $b;
    }
    /*
     * 留言板
     * */
    public function messageList()
    {
          //直接显示列表
        $tableName1 = $this->tableMessage;
        $tableName2 = '';
        $param = '';
        $html = 'leamessage';
        $field = 'message_id,message_content,message_editor,message_status';
        $where = '';
        $destination = 'message/messagelist';
        $listLine = $this->base()->search($tableName1, $tableName2, $param, $html, $field, $where, $destination);
        return $listLine;
    }

    /*
     * 后台可以修改使得留言是否要在前端显示,修改lea_status;
     */
    public function update(){
        $lea_id = input('param.lea_id');
        $message = Db::table($this->tableMessage)->where('lea_id', $lea_id)->find();
        $this->assign('message', $message);

    }






    
}