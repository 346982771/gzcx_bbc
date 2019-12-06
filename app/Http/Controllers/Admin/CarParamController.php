<?php

namespace App\Http\Controllers\Admin;



use App\Http\Factorys\Admin\ControllerFactory;

use Illuminate\Support\Facades\Cache;


class CarParamController extends ControllerFactory
{
    //protected $AuthGroupModel;
    private $ClassModel;
    public function __construct()
    {
        parent::__construct();
        $this->ClassModel = $this->newObject(1,'CarParam');
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

            return view('admin.car_param.index');
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

            if($data['sort']){
                $res = $this->ClassModel->add($data);
            }else{
                $id = $this->ClassModel->getInsertId($data);
                $where = 'id = '.$id;
                $res = $this->ClassModel->edit($where,['sort' => $id * 10]);

            }

            if($res){
                return r_result(1,'',url('admin/CarParam/index'));
            }else{
                return r_result();
            }
        }else{
            $p_list = $this->getP0();
            $info = 'null';
            return view('admin.car_param.form',['title' => '添加信息','info' => $info,'p_list' => $p_list]);
        }
    }
    public function edit()
    {
        if($this->Request->isMethod('post')){
            $data = $this->Request->post();
            $where = 'id = '.$data['id'];

            $res = $this->ClassModel->edit($where,$data);

            return r_result(1,'',url('admin/CarParam/index'));
        }else{
            $id = $this->Request->get('id');

            $info = $this->ClassModel->queryOne(['id' => $id]);
            $p_list = $this->getP0();
            return view('admin.car_param.form',['title' => '修改信息','info' => json_encode($info),'info1' => $info,'p_list' => $p_list]);
        }
    }
    //设置
    public function isShow()
    {
        $id = $this->Request->post('id');
        $is_show = $this->Request->post('is_show');
        $res = $this->ClassModel->editStatus(['id' => $id],['is_show' => $is_show]);
        if ($res) {
            return r_result();
        } else {
            return r_result(0);
        }
    }
    //设置
    public function isBasis()
    {
        $id = $this->Request->post('id');
        $is_basis = $this->Request->post('is_basis');
        $res = $this->ClassModel->editStatus(['id' => $id],['is_basis' => $is_basis]);
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
}