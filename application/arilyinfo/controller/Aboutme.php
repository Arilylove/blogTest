<?php
/**
 * Created by PhpStorm.
 * User: HXL
 * Date: 2017/7/21
 * Time: 16:29
 */
namespace app\arilyinfo\controller;

use think\Controller;

class Aboutme extends Controller{
    public function index()
    {
        return $this->fetch('aboutme/index');
    }
    public function listPic()
    {
        return $this->fetch('aboutme/listpic');
    }
}