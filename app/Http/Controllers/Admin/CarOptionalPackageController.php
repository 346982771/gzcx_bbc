<?php

namespace App\Http\Controllers\Admin;



use App\Http\Factorys\Admin\ControllerFactory;

use Illuminate\Support\Facades\Cache;


class CarOptionalPackageController extends ControllerFactory
{
    //protected $AuthGroupModel;
    private $ClassModel;
    public function __construct()
    {
        parent::__construct();
        $this->ClassModel = $this->newObject(1,'CarOptionalPackage');
    }

    public function index()
    {
        if($this->Request->isMethod('post')){

            $data = $this->Request->post();

            $where = 'car_id = '.$data['car_id'];
            if(!empty($data['key'])){
                $where .= " and `title` like '%".$data['key']."%'";
            }
            $list = $this->ClassModel->getList($where);
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total']];
        }else{
            $car_id = $this->Request->get('car_id');
            return view('admin.car_optional_package.index',['car_id' => $car_id]);
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

            $res = $this->ClassModel->add($data);
            if($res){
                return r_result(1,'',url('admin/CarOptionalPackage/index').'?car_id='.$data['car_id']);
            }else{
                return r_result();
            }
        }else{

            $car_id = $this->Request->get('car_id');
            $info = 'null';
            return view('admin.car_optional_package.form',['title' => '添加信息','info' => $info,'car_id' => $car_id]);
        }
    }
    public function edit()
    {
        if($this->Request->isMethod('post')){
            $data = $this->Request->post();
            $where = 'id = '.$data['id'];
            unset($data['file']);
            $res = $this->ClassModel->edit($where,$data);

            return r_result(1,'',(url('admin/CarOptionalPackage/index')).'?car_id='.$data['car_id']);
        }else{

            $id = $this->Request->get('id');
            $info = $this->ClassModel->queryOne(['id' => $id]);
            return view('admin.car_optional_package.form',['title' => '修改信息','info' => json_encode($info),'info1' => $info]);
        }
    }
    //设置隐藏
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


}