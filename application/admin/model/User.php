<?php
namespace app\admin\model;
use  think\Model;
use  think\Paginator;

class User extends  Model
{
    /**
     * 用户信息查询
     */
    public function userList(){
        $user=new  User();
        $data=[
            'id'=>1,
        ];
       $result= $user->where($data)
            ->select()->paginate(10);
        return $result;
    }

    /**
     * @param $id
     * 获取单条数据
     */
    public  function getNote($id){
        $user=new  User();
        $data=[
            'id'=>$id,
        ];
        $result= $user->where($data)
            ->find();
        return $result;
    }
    public function oneUpdate($id,$note){
        $user=new  User();
        $data=[
            'note'=>$note,
        ];
        $save=$user->save($data,['id'=>$id]);
        if($save !== false){
            return 'true';
        }else{
            return  'false';
        }
    }


}