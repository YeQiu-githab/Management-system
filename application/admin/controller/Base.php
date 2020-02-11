<?php


namespace app\admin\controller;
use think\Controller;
use think\Session;

class Base extends  Controller
{
    public function _initialize()
    {
        $user=Session::get('username');
        if(empty($user) && !isset($user)){

            Session::clear();
            $this->error('未登陆,请登录!',url("login/index"));

        }
    }

}