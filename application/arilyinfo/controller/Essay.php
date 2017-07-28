<?php
/**
 * Created by PhpStorm.
 * User: HXL
 * Date: 2017/7/21
 * Time: 16:33
 */
namespace app\arilyinfo\controller;

use think\Controller;

class Essay extends Controller{
    public function newslistpic()
    {
        return $this->fetch('essay/newslistpic');
    }
}