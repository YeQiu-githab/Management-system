<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Session;
use  think\Cache;
use  think\Request;

class Login extends Controller
{

    public function  index(){
        return $this->fetch();
    }

    public function checkLogin(){
        $info=input();

        $username= trim($info['username']);
        $pwd=trim($info['pwd']);


        $user=Db::table('ck_admin');
        if(!empty($username) && isset($username)){
            $info=$user->where('username',$username)->find();
            if($info){
                Session::set('username',$username);
                Session::set('u_id',$info['id']);
                Cache::set('username',Session::get('username',$username),3600);
//                echo Session::get('username');
                if($info['pwd'] == md5($pwd)){
                    $data['code']=1;
                    $data['msg']='登录成功';
                    return json($data);
                }else{
                    $data['code']=0;
                    $data['msg']='登陆失败';
                    return json($data);
                }
            }else{
                $data['code']=-1;
                $data['msg']='用户账号密码错误！';
                return json($data);
            }

        }
    }
    public function logout(){
        Session::clear();
        $this->success('退出成功','login/index');
    }

}