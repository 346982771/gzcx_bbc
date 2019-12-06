<?php

namespace App\Http\Controllers\Admin;



use App\Http\Factorys\Admin\ControllerFactory;

use Illuminate\Support\Facades\Cache;


class CarParamOptionController extends ControllerFactory
{
    //protected $AuthGroupModel;
    private $ClassModel;
    public function __construct()
    {
        parent::__construct();
        $this->ClassModel = $this->newObject(1,'CarParamOption');
    }

    public function index()
    {
        if($this->Request->isMethod('post')){

            $data = $this->Request->post();

            $where = 'param_id = '.$data['param_id'];
            if(!empty($data['key'])){
                $where .= " and `title` like '%".$data['key']."%'";
            }
            $list = $this->ClassModel->getAll($where);
            $list = menu($list);
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list];
        }else{
            $param_id = $this->Request->get('param_id');

            return view('admin.car_param_option.index',['param_id' => $param_id]);
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

            $res = $this->ClassModel->add($data);
            if($res){
                return r_result(1,'',url('admin/CarParamOption/index').'?param_id='.$data['param_id']);
            }else{
                return r_result();
            }
        }else{

            $param_id = $this->Request->get('param_id');
            $where  = ' and param_id = '.$param_id;
            $param_type = $this->getParamType($param_id);
            $p_list = $this->getP0($where);

            $info = 'null';
            return view('admin.car_param_option.form',['title' => '添加信息','info' => $info,'p_list' => $p_list,'param_id' => $param_id,'param_type' => $param_type]);
        }
    }
    public function edit()
    {
        if($this->Request->isMethod('post')){
            $data = $this->Request->post();
            $where = 'id = '.$data['id'];
            unset($data['file']);
            $res = $this->ClassModel->edit($where,$data);

            return r_result(1,'',(url('admin/CarParamOption/index')).'?param_id='.$data['param_id']);
        }else{

            $id = $this->Request->get('id');
            $info = $this->ClassModel->queryOne(['id' => $id]);

            $param_type = $this->getParamType($info['param_id']);
            return view('admin.car_param_option.form',['title' => '修改信息','info' => json_encode($info),'info1' => $info,'param_type' => $param_type]);
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
    public function getP0($where = '')
    {
        $p_list = $this->ClassModel->getAll('pid = 0'.$where);
        return $p_list;
    }
    public function getParamType($param_id)
    {
        $car_param = $this->newObject(1,'CarParam');

        $param_type = $car_param->getValue(['id' => $param_id],'type');
        return $param_type;
    }
}