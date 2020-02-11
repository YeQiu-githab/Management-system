<?php
namespace app\index\controller;

use think\Controller;

class Index extends  Controller
{
    public function index()
    {
        $url =url('admin/login/index');
        echo "<script> window.location.href='$url'</script>";
    }
}
