<?php

namespace App\Http\Controllers\Admin;
use App\Http\Factorys\Admin\ControllerFactory;

use Illuminate\Support\Facades\Cache;
class UserController extends ControllerFactory
{

    private $ClassModel;
    public function __construct()
    {
        parent::__construct();
        $this->ClassModel = $this->newObject(1,'User');
    }

    public function index()
    {
        if($this->Request->isMethod('post')){
            $data = $this->Request->post();
            $where = '1 = 1';
            if(!empty($data['key'])){
                $where .= " and (`username` like '%".$data['key']."%' or mobile like '%".$data['key']."%')";
            }
            $list = $this->ClassModel->getList($where);
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total']];
        }else{
            return view('admin.user.index');
        }
    }
    public function del()
    {
        $data = $this->Request->post();

        if($data['id']){
            $res = $this->ClassModel->del('id = '.$data['id']);
            if($res){
                return r_result();
            }
        }
        return r_result(0);
    }
    public function add()
    {
        if($this->Request->isMethod('post')){
            $data = $this->Request->post();

            $data['create_time'] = time();
            $data['year'] = substr($data['market_time'],0,4);

            $brand01 = $this->getBrand01($data['brand']);

            $data['brand1'] = $brand01['brand1'];
            $data['brand0'] = $brand01['brand0'];
            $res = $this->ClassModel->add($data);
            if($res){
                return r_result(1,'',url('admin/Car/index'));
            }else{
                return r_result();
            }
        }else{
            $type = $this->getTypeList();
            $brand = $this->getBrandList();
            $info = 'null';
            $color = $this->getColor();
            return view('admin.user.form',['title' => '添加信息','info' => $info,'type' => $type,'brand' => $brand,'color' => $color]);
        }
    }
    public function edit()
    {
        if($this->Request->isMethod('post')){
            $data = $this->Request->post();
            $where = 'id = '.$data['id'];
            $res = $this->ClassModel->edit($where,$data);
            return r_result(1,'',url('admin/Car/index'));
        }else{
            $id = $this->Request->get('id');
            $info = $this->ClassModel->queryOne(['id' => $id]);
            $type = $this->getTypeList();
            $brand = $this->getBrandList();
            $color = $this->getColor();
            return view('admin.user.form',['title' => '修改信息','info' => json_encode($info),'info1' => $info,'type' => $type,'brand' => $brand,'color' => $color]);
        }
    }
    //获取单条信息
    public function getInfo()
    {
        $data = $this->Request->post();
        $where['brand'] = $data['brand'];
        if($data['market_time']){
            $where['year'] = substr($data['market_time'],0,4);
        }
        $info = $this->ClassModel->queryOne($where);
        if($info){
            return r_result(1,'操作成功','',$info);
        }else{
            return r_result(0,'未找到信息');
        }


    }

    //设置
    public function pass()
    {
        $id = $this->Request->post('id');
        $status = $this->Request->post('status');
        $res = $this->ClassModel->editStatus(['id' => $id],['status' => $status]);
        if ($res) {
            return r_result();
        } else {
            return r_result(0);
        }
    }
    //设置
    public function level()
    {
        $id = $this->Request->post('id');
        $level = $this->Request->post('level');
        $res = $this->ClassModel->editStatus(['id' => $id],['level' => $level]);
        if ($res) {
            return r_result();
        } else {
            return r_result(0);
        }
    }

}