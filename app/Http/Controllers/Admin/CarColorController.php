<?php

namespace App\Http\Controllers\Admin;



use App\Http\Factorys\Admin\ControllerFactory;

use Illuminate\Support\Facades\Cache;


class CarColorController extends ControllerFactory
{
    //protected $AuthGroupModel;
    private $ClassModel;
    public function __construct()
    {
        parent::__construct();
        $this->ClassModel = $this->newObject(1,'CarColor');
    }

    public function index()
    {
        if($this->Request->isMethod('post')){

            $data = $this->Request->post();

            $where = '1 = 1';
            if(!empty($data['key'])){
                $where .= " and concat(`title`) like '%".$data['key']."%'";
            }
            $list = $this->ClassModel->getList($where);

            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total']];
        }else{

            return view('admin.car_color.index');
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
                return r_result(1,'',url('admin/CarColor/index'));
            }else{
                return r_result();
            }
        }else{

            $info = 'null';
            return view('admin.car_color.form',['title' => '添加信息','info' => $info]);
        }
    }
    public function edit()
    {
        if($this->Request->isMethod('post')){
            $data = $this->Request->post();
            $where = 'id = '.$data['id'];

            $res = $this->ClassModel->edit($where,$data);

            return r_result(1,'',url('admin/CarColor/index'));
        }else{
            $id = $this->Request->get('id');

            $info = $this->ClassModel->queryOne(['id' => $id]);

            return view('admin.car_color.form',['title' => '修改信息','info' => json_encode($info),'info1' => $info]);
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

}