<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Session;
use  think\Request;

class Index extends Base {

    public function index()
    {

        $admin= Session::get('u_id');

        $this->assign('admin',$admin);
        return $this->fetch();
    }
    public function welcome(){

        if(Session::get('u_id') == '1' ){
            $info=Db::table("ck_user")->select();
        }else{
            $info=Db::table("ck_user")->where('parent_id',Session::get('u_id'))->select();
        }


        $data=[
            'count'=>count($info),
            'system'=>PHP_OS
        ];
        $admin= Session::get('root_grade');
        echo $admin;
        $this->assign('admin',$admin);
        $this->assign('data',$data);
        return $this->fetch();
    }

}
