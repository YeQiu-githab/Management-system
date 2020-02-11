<?php
namespace app\admin\controller;
use think\Cache;
use think\Controller;
use think\Db;
use think\Loader;
use think\Request;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Cell;
use think\Session;

class User  extends Base
{


    public function index(){

        return $this->fetch();
    }

    public function  userList()
    {
        $admin=Db::table("ck_admin")->where('username',Session::get('username'))->find();

        $post=1;  //
        $user=Db::table('ck_user');

        if(request()->isPost()){
            $post=2;
            $ck= Db::table('ck_user');
            $uinfo=input();
            $start=trim($uinfo['start']);
            $end=trim($uinfo['end']);
            $user_id=trim($uinfo['username']);
            if($admin['id'] == 1){
                if(!empty($start) && empty($end) && empty($user_id)){
                    $data=[
                        'create_time'=>['gt',strtotime($start)],
                    ];
                }else if(empty($start) && !empty($end) && empty($user_id)){
                    $data=[
                        'create_time'=>['lt',strtotime($end)],
                    ];
                }
                else if(!empty($start) && !empty($end) && empty($user_id)){
                    $data=[
                        'create_time'=>['between',[strtotime($start),strtotime($end)]],
                    ];
                }else if(empty($start) && empty($end) && !empty($user_id)){
                    $data=[
                        'user_id'=>$user_id,
                    ];
                }else{
                    $data=[
                        'id'=> ['gt',0],
                    ];
                }
            }else{
                if(!empty($start) && empty($end) && empty($user_id)){
                    $data=[
                        'parent_id'=> Session::get('u_id'),
                        'create_time'=>['gt',strtotime($start)],
                    ];
                }else if(empty($start) && !empty($end) && empty($user_id)){
                    $data=[
                        'parent_id'=> Session::get('u_id'),
                        'create_time'=>['lt',strtotime($end)],
                    ];
                }else if(!empty($start) && !empty($end) && empty($user_id)){
                    $data=[
                        'parent_id'=> Session::get('u_id'),
                        'create_time'=>['between',[strtotime($start),strtotime($end)]],
                    ];
                }else if(empty($start) && empty($end) && !empty($user_id)){
                    echo "'fsdafas'";
                    $data=[
                        'user_id'=>$user_id,
                        'parent_id'=>  Session::get('u_id'),
                    ];
                }else if(!empty($start) && !empty($end) && !empty($user_id)){
                    $data=[
                        'user_id'=>$user_id,
                        'parent_id'=>  Session::get('u_id'),
                        'create_time'=>['between',[strtotime($start),strtotime($end)]],
                    ];
                }else{

                    $data=[
                        'parent_id'=>  Session::get('u_id'),
                    ];
                }
            }
            $page=$ck->where($data)->select();

            echo $ck->getLastSql();
            $list_length =  count($page);

            $datas=[];
            foreach ($page as $k=>$v) {
                $admins=Db::table('ck_admin')->where('id',$v['parent_id'])->find();

                $new=time();
                $num=round(($new-$v['create_time'])/86400);
                $datas[$k]['id']=$v['id'];
                $datas[$k]['user_id']=$v['user_id'];
                $datas[$k]['grade']=$v['grade'];
                $datas[$k]['username']=$v['username'];
                $datas[$k]['phone']=base64_decode($v['phone']);
                $datas[$k]['money']=$v['money'];
                $datas[$k]['note']=$v['note'];
                $datas[$k]['create_time']=date('Y-m-d',$v['create_time']);
                $datas[$k]['day']=$num;
                $datas[$k]['own']=$admins['username'];
            }

            $this->assign('post',$post);   // 对比参数
            $this->assign('page',$page);  // 分页
            $this->assign('fcount',$list_length);  //总计条数
            $this->assign('datas',$datas); //  数据



        }


        if($admin['id'] == 1){
            $info= $user->paginate(20);
        }else{
            $data=[
                'parent_id'=>$admin['id'],   //  登录的用户
            ];
            $info= $user->where($data)->paginate(20);
        }
        $list_length = $info->total();
//        dump($info);
//        echo $user->getLastSql();
        $data=[];
        foreach ($info as $k=>$v) {
            $admins=Db::table('ck_admin')->where('id',$v['parent_id'])->find();

            $new=time();
            $num=round(($new-$v['create_time'])/86400);
            $data[$k]['id']=$v['id'];
            $data[$k]['user_id']=$v['user_id'];
            $data[$k]['grade']=$v['grade'];
            $data[$k]['username']=$v['username'];
            $data[$k]['phone']=base64_decode($v['phone']);
            $data[$k]['money']=$v['money'];
            $data[$k]['note']=$v['note'];
            $data[$k]['create_time']=date('Y-m-d',$v['create_time']);
            $data[$k]['day']=$num;
            $data[$k]['own']=$admins['username'];
        }
        $this->assign('userinfo',$data);
        $this->assign('list',$info);
        $this->assign('post',$post);
        $this->assign('count',$list_length);  // 总计条数
        return $this->fetch();
    }




    public function userEdit(){
        $user=model('User');
        $info=input();
        $id=$info['id'];
        $info=$user->getNote($id);
        $this->assign('note',$info['note']);
        $this->assign('id',$info['id']);
        return $this->fetch();
    }
    public  function userUpdate(){
        $user=model('User');
        $info=input();
        $id=$info['id'];
        $note=$info['note'];
        $info=$user->oneUpdate($id,$note);

        if($info){
             $data=[
                 'code'=>1,
                 'msg'=>'修改成功',
             ];
            return  json($data);
        }else{
            $data=[
                'code'=>0,
                'msg'=>'修改失败',
            ];
            return json($data);
        }
    }
    public function userAdd(){
        return $this->fetch();
    }

    // 导入  Excel 数据
    public function excelIn(){
        $file = request()->file('file');

        $type = substr(strrchr($_FILES["file"]["name"], '.'), 1);
//        echo $type;
        if($type != "xlsx" && $type!= "xls" ){
          $json['code']=-1;
          $json['msg']="文件格式不支持!";
          return json($json);
        }
        $admin=Db::table("ck_admin")->where('username',Session::get('username'))->find();
        Loader::import('PHPExcel.PHPExcel');
        Loader::import('PHPExcel.PHPExcel.PHPExcel_IOFactory');
        Loader::import('PHPExcel.PHPExcel.PHPExcel_Cell');
        //实例化PHPExcel
        $objPHPExcel = new \PHPExcel();

//        //获取表单上传文件
        $info = $file->validate(['size'=>1053696,'ext'=>'xlsx,xls'])->move(ROOT_PATH . 'public' . DS . 'excel');

        if($info){
            //获取文件名
            $exclePath = $info->getSaveName();
            //上传文件的地址
            $file_name = ROOT_PATH . 'public' . DS . 'excel' . DS . $exclePath;
            $extension = substr(strrchr($file_name, '.'), 1);
            if ($extension =='xlsx') {
                $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
            }else if($extension =='xls'){
                $objReader = \PHPExcel_IOFactory::createReader('Excel5');
            }
//            加载文件内容,编码utf-8

            $obj_PHPExcel = $objReader->load($file_name, $encode = 'utf-8');


            $excel_array = $obj_PHPExcel->getsheet(0)->toArray();   //转换为数组格式
            array_shift($excel_array);  //删除第一个数组(标题);
            $data = [];
//            dump($excel_array);

            foreach (array_filter($excel_array) as $k => $v) {
                $n=$k+2;
                if(empty($v)) {
                    continue;
                }else{
                    if(empty($v[0]) || empty($v[1]) || empty($v[2]) || !isset($v[3]) || empty($v[4]) ||empty($v[5]) || empty($v[6])){
//                        echo $n;
//                        echo $v[3];
                        $json['code']=-6;
                        $json['msg']="请核对excel表 表中有遗漏数据，或者表后不要出现多余空行";
                        return json($json);
                    }

                    if(preg_match("/([\x81-\xfe][\x40-\xfe])/", $v['1'])){

                        $json['code']=-3;

                        $json['msg']="excel 表第".$n."行会员ID 含有中文字!";
                        return json($json);
                    }
                    if(strtotime($v['4'])>time()){
                        $json['code']=-4;
                        $json['msg']="excel 表第".$n."行时间有问题!";
                        return json($json);
                    }
                    if(trim($v[5]) != '无'){
                        if(!preg_match("/^1[345678]{1}\d{9}$/",$v[5])){
                            $json['code']=-5;
                            $json['msg']="excel 表第".$n ."行手机号码有问题!";
                            return json($json);
                        }
                    }

                    $data[$k]['grade'] = $v['0'];
                    $data[$k]['user_id'] = $v['1'];
                    $data[$k]['username'] = $v['2'];
                    $data[$k]['money'] = $v['3'];
                    $data[$k]['create_time'] = strtotime($v['4']);
                    $data[$k]['phone'] = base64_encode(trim($v['5']));
                    $data[$k]['note'] = $v['6'];
                    $data[$k]['update_time'] = time();
                    $data[$k]['last_time'] = time();
                    $data[$k]['parent_id'] = $admin['id'];
                }

            }
            //批量插入数据

//            dump($data);
            $userinfo = Db::table('ck_user');
            $updata=[];
//            dump($data);
            $i=0;
            $j=0;
            foreach ($data as $n=> $vo) {

                $one= Db::table("ck_user")->where('user_id',$vo['user_id'])->find();
//                dump($one);
                if($one){
                    $where=[
                        'user_id'=>$one['user_id'],
                        'create_time'=>$vo['create_time'],
                    ];
                    $two= Db::table("ck_user")->where($where)->find();
//                    dump( $two);
                    if(!$two){
                        ++$i;
                        $updata['id'] =$one['id'];
                        $updata['money'] = $one['money']+$vo['money'];
                        $updata['note'] = $vo['note'];
                        $updata['create_time'] = $vo['create_time'];
                        $updata['phone'] = $vo['phone'];
                        $updata['update_time'] = time();
                        $updata['last_time'] = time();
                        $result=Db::table("ck_user")->where('user_id',$vo['user_id'])->update($updata);
//                        dump($result);
                    }
                }else{
                    ++$j;
                    $result=Db::table("ck_user")->where('user_id',$vo['user_id'])->insert($vo);

                }
            }
            if(isset($result)){
                $json['code']=1;
                $json['msg']="新增".$j."个会员,更新".$i."个会员数据";
                return json($json);
            }else{
                $json['code']=0;
                $json['msg']="没有新数据插入和更新";
                return json($json);
            }
        }else{
            // 上传失败获取错误信息
            $json['code']=-1;
            $json['msg']=$file->getError()."请导入小于1M文件";
            return json($json);

        }
    }


}