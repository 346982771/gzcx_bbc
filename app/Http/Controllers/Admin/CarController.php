<?php

namespace App\Http\Controllers\Admin;



use App\Http\Factorys\Admin\ControllerFactory;

use Illuminate\Support\Facades\Cache;


class CarController extends ControllerFactory
{

    private $ClassModel;
    public function __construct()
    {
        parent::__construct();
        $this->ClassModel = $this->newObject(1,'Car');
    }

    public function index()
    {
        if($this->Request->isMethod('post')){

            $data = $this->Request->post();

            $where = '1 = 1';
            if(!empty($data['key'])){
                $where .= " and cb.`title` = '".$data['key']."'";
            }
            if(!empty($data['brand'])){
                $where .= " and (c.brand = ".$data['brand']." or c.brand0 = ".$data['brand']." or c.brand1 = ".$data['brand'].")";
            }
            $list = $this->ClassModel->getList($where);

            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total']];
        }else{
            $brand = $this->getBrandList();
            return view('admin.car.index',['brand' => $brand]);
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
            return view('admin.car.form',['title' => '添加信息','info' => $info,'type' => $type,'brand' => $brand,'color' => $color]);
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
            return view('admin.car.form',['title' => '修改信息','info' => json_encode($info),'info1' => $info,'type' => $type,'brand' => $brand,'color' => $color]);
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
    //添加参数
    public function addParam()
    {
        if($this->Request->isMethod('post')){
            $data = $this->Request->post();
            return r_result(1,'',url('admin/Car/index'));
        }else{
            $id = $this->Request->get('id');
            $info = $this->ClassModel->queryOne(['id' => $id]);

            return view('admin.car.param_form',['info' => json_encode($info),'info1' => $info]);
        }
    }
    //设置
    public function hide()
    {
        $id = $this->Request->post('id');
        $hide = $this->Request->post('hide');
        $res = $this->ClassModel->editStatus(['id' => $id],['hide' => $hide]);
        if ($res) {
            return r_result();
        } else {
            return r_result(0);
        }
    }
    //设置排序
    public function sort()
    {
        $id = $this->Request->post('id');
        $sort = $this->Request->post('sort');
        $res = $this->ClassModel->editStatus(['id' => $id],['sort' => $sort]);
        if($res){
            return r_result();
        } else {
            return r_result(0);
        }
    }

    //获取车辆类型级别
    public function getTypeList()
    {
        $carType = $this->newObject(0,'CarType');

        $type = $carType->getTypeList();
        return $type;
    }
    //获取车辆平品牌
    public function getBrandList()
    {
        $brand = $this->newObject(0,'CarBrand');
        $list = $brand->getBrandList();
        return $list;
    }
    //获取厂商、品牌
    public function getBrand01($id)
    {
        $brand = $this->newObject(1,'CarBrand');
        $brand1 = $brand->getValue(['id' => $id],'pid');
        $brand0 = 0;
        if($brand1){
            $brand0 = $brand->getValue(['id' => $brand1],'pid');
        }
        return ['brand1' => $brand1,'brand0' => $brand0];

    }
    public function getColor()
    {
        $color = $this->newObject(1,'CarColor');
        $color = $color->getAll('hide = 0');

        return $color;
    }
}