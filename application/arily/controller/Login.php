<?php
/**
 * Created by PhpStorm.
 * User: HXL
 * Date: 2017/7/21
 * Time: 10:29
 */
namespace app\arily\controller;

use think\Controller;
use org\Verify;
use app\arily\crypt\AesCrypt;

class Login extends Controller
{

    public function index()
    {
        return $this->fetch('login/log');
    }

    //后台登录
    public function login()
    {
        $admin['user_username'] = input('param.user_username');
        $admin['user_password'] = input('param.user_password');
        $hex = new AesCrypt();
        $admin['user_password'] = $hex->encrypt($admin['user_password']);
        //var_dump($admin['password']);exit();
        $code = input("param.code");
        //var_dump($username);exit;
        $verify = new Verify();
        $check = $verify->check($code);
        if (!$check) {
            return $this->error('验证码错误', $_SERVER['HTTP_REFERER']);
        }
        $hasAdmin = Db::table('user')->where('user_username', $admin['user_username'])->find();
        //var_dump($hasAdmin['password']);exit();
        if (empty($hasAdmin)) {
            return $this->error('用户不存在', $_SERVER['HTTP_REFERER']);
        }

        if ($admin['user_password'] != $hasAdmin['user_password']) {
            return $this->error('密码错误', $_SERVER['HTTP_REFERER']);
        }
        session('user_username', $admin['user_username']); //保存到session中判断是否登录

        return $this->success('登录成功', 'user/listStates');

    }

    //验证码
    public function verify()
    {
        $verify = new Verify();
        $verify->imageH = 36;
        $verify->imageW = 140;
        $verify->length = 4;
        $verify->useNoise = false;
        $verify->fontSize = 18;
        return $verify->entry();
    }

    public function out()
    {
        if (true) {
            session('username', null);
            return $this->fetch('login/log');
        }
        return false;
    }
}