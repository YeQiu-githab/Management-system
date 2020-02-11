<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;


class Admin extends Base
{


    public function index(){

        return $this->fetch();
    }

    /**
     * @return mixed
     * 用户 信息 列表页
     */
    public function adminList(){
        $admin=Db::table('ck_admin');
        $result=$admin->paginate(20);
        $num=$result->total();
        $data=[];
//        dump($result);
        foreach ($result as$k=> $v){


            $datas[$k]['id']=$v['id'];
            $datas[$k]['grade']=$v['grade'];
            $datas[$k]['username']=$v['username'];
            $datas[$k]['money']=$v['money'];
            $datas[$k]['create_time']=date('Y-m-d',$v['create_time']);
        }
        $this->assign('admininfo',$datas);
        $this->assign('num',$num);
        $this->assign('list',$result);
        return $this->fetch();
    }

    /**
     * @return mixed
     * 用户信息 编辑页面
     */
    public function adminEdit(){
        $info=input();
        $admin_id=$info['id'];
        $admin=Db::table("ck_admin");
        $admiminfo=$admin->where('id',$admin_id)->find();

        $this->assign('admininfo',$admiminfo);
        return $this->fetch();
    }
    public function adminSave(){
            $info=input();
            dump($info);
            $id=$info['adminid'];
            $pwd=$info['pass'];
//            $prade=$info['permissions'];
            $data=[
                'pwd'=>md5($pwd),
//                'grade'=>$prade,
                'update_time'=>time(),
                'last_time'=>time(),

            ];
            $admin=Db::table("ck_admin");
            $result=$admin->where('id',$id)->update($data);
            if($result){
                $json['code']=1;
                $json['msg']="修改成功";
                return json($json);
            }else{
                $json['code']=0;
                $json['msg']="修改失败";
                return json($json);
            }


    }


    public function  userinfo(){

    }
    public function adminAdd(){
        return $this->fetch();
    }


    public  function adminInsert(){
        $info=input();
        $username=trim($info['username']);
        $pwd=trim($info['pass']);
        $permissions=trim($info['permissions']);

        if($permissions == 'admin'){
            $grade=1;
            $note="超级管理员";
        }else{
            $grade=2;
            $note="管理员";
        }
        $user=Db::table("ck_admin");
        $id=$user->where('username',$username)->find();
        if($id){
            $data['code']=-1;
            $data['msg']="用户已存在!";
            return json($data);
        }else{
            $data=[
                'username'=>$username,
                'pwd'=>md5($pwd),
                'grade'=>$grade,
                'create_time'=>time(),
                'update_time'=>time(),
                'last_time'=>time(),
                'note'=>$note,
            ];
            if(Db::table("ck_admin")->insert($data)){
                $json['code']=1;
                $json['msg']="添加管理员成功!";
                return json($json);
            }else{
                $json['code']=-1;
                $json['msg']="添加管理失败!";
                return json($json);
            }
        }
    }
    public function  adminDel(){

       $info=input();
       $id=$info['id'];
       if(isset($id)){
           $user=Db::table("ck_admin");
          if( $user->where('id',$id)->delete()){
              $data['code']=1;
              $data['msg']="删除成功!";
              return json($data);
          }else{
              $data['code']=-1;
              $data['msg']="删除失败!";
              return json($data);
          }
       }else{
           $data['code']=-1;
           $data['msg']="添加管理失败!";
           return json($data);
       }

    }

}