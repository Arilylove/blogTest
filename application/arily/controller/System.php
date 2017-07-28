<?php
/**
 * Created by PhpStorm.
 * User: HXL
 * Date: 2017/7/21
 * Time: 11:11
 */
namespace app\arily\controller;

use think\Controller;
use think\Db;
//use app\arily\controller\Base;

class System extends Controller{

    /*
     * 修改密码
     * */
    public function update(){
        $username = session('username');
        $this->assign('username', $username);
        return $this->fetch('Base/updatePassword');
    }
    public function updatePassword(){
        $username = session('username');
        $this->assign('username', $username);
        $find = $this->com()->find('username', array('username'=>$username), 'admin');
        if ($find){
            return $this->error('该用户不存在');
        }
        //var_dump($admin);exit;
        $admin = Db::table('admin')->where('username', $username)->find();
        //var_dump($admin['password']);exit();
        $this->assign('adId', $admin['adId']);
        $string = new AesCrypt();
        //解密
        $password = $string->decrypt($admin['password']);
        //var_dump($password);exit();
        $inputPassword = input('param.password');
        $update = input('param.update');
        $confirm = input('param.confirm');
        if (true){
            if ($update == $password){
                return $this->error('修改密码同原始密码相同');
            }
            if ($update == ''){
                return $this->error('密码不能为空');
            }
            if ($update != $confirm){
                return $this->error('两次输入密码不相同');
            }
            $update = $string->encrypt($update); //再加密后写入数据库
            $result = Db::table('admin')->where('username', $username)->update(['password'=>$update]);
            //var_dump($result);exit();
            if (!$result){
                return $this->error('修改失败');
            }
            if ($admin['status'] == 0){   //管理员
                session('username', null);
                session('status', null);
                return $this->success('修改成功,请重新登录', 'login/index');
                //return $this->success('修改成功');
            }
            session('username', null);
            session('status', null);
            return $this->success('修改成功,请重新登录', 'login/index');
            //return $this->success('修改成功');
        }

    }


}