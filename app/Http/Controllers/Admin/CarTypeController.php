<?php

namespace App\Http\Controllers\Admin;



use App\Http\Factorys\Admin\ControllerFactory;

use Illuminate\Support\Facades\Cache;


class CarTypeController extends ControllerFactory
{
    //protected $AuthGroupModel;
    private $ClassModel;
    public function __construct()
    {
        parent::__construct();
        $this->ClassModel = $this->newObject(1,'CarType');
    }

    public function index()
    {
        if($this->Request->isMethod('post')){

            $data = $this->Request->post();

            $where = '1 = 1';
            if(!empty($data['key'])){
                $where .= " and concat(`title`) like '%".$data['key']."%'";
            }
            $list = $this->ClassModel->getAll($where);
            $list = menu($list);
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list];
        }else{

            return view('admin.car_type.index');
        }
    }
    public function del()
    {
        $data = $this->Request->post();

        if($data['id']){
            $res = $this->ClassModel->del('id = '.$data['id'].' or pid = '.$data['id']);
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

            if($data['pid']){

                $this->ClassModel->edit('id = '.$data['pid'],['choose' => 0]);
            }

            $data['choose'] = 1;
            unset($data['file']);
            $res = $this->ClassModel->add($data);
            if($res){
                return r_result(1,'',url('admin/CarType/index'));
            }else{
                return r_result();
            }
        }else{

            $p_list = $this->getP0();

            $info = 'null';
            return view('admin.car_type.form',['title' => '添加信息','info' => $info,'p_list' => $p_list]);
        }
    }
    public function edit()
    {
        if($this->Request->isMethod('post')){
            $data = $this->Request->post();
            $where = 'id = '.$data['id'];
            unset($data['file']);
            $res = $this->ClassModel->edit($where,$data);

            return r_result(1,'',url('admin/CarType/index'));
        }else{
            $id = $this->Request->get('id');

            $info = $this->ClassModel->queryOne(['id' => $id]);
            $p_list = $this->getP0();
            return view('admin.car_type.form',['title' => '修改信息','info' => json_encode($info),'info1' => $info,'p_list' => $p_list]);
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
    //设置是否推荐
    public function recommend()
    {
        $id = $this->Request->post('id');
        $recommend = $this->Request->post('recommend');
        $res = $this->ClassModel->editStatus(['id' => $id],['recommend' => $recommend]);
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
    public function getP0()
    {
        $p_list = $this->ClassModel->getAll('pid = 0');
        return $p_list;
    }
    //获取choose列表
    public function getTypeList()
    {
        $carType = $this->newObject(1,'CarType');
        $type = $carType->getAll('choose = 1');
        return $type;
    }
}