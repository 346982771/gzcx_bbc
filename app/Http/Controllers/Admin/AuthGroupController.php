<?php

namespace App\Http\Controllers\Admin;



use App\Http\Factorys\Admin\ControllerFactory;
//use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
//use App\Http\Models\Admin\AuthGroupModel;

use Illuminate\Support\Facades\Cache;


class AuthGroupController extends ControllerFactory
{
    //protected $AuthGroupModel;
    private $ClassModel;
    public function __construct()
    {
        //$this->AuthGroupModel = new AuthGroupModel();
        parent::__construct();
        $this->ClassModel = $this->newObject(1,'AuthGroup');
    }

    public function index()
    {
        if($this->Request->isMethod('post')){

            $data = $this->Request->post();

            $where = '1 = 1';
            if(!empty($data['key'])){
                $where .= " and concat(`title`,`desc`) like '%".$data['key']."%'";
            }
            $list = $this->ClassModel->getList($where);
            foreach ($list['data'] as $k => $v) {
                $list['data'][$k]['addtime'] = date('Y-m-d', $v['addtime']);
            }
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total']];
        }else{

            return view('admin.auth_group.index');
        }
    }
    public function del()
    {
        $data = $this->Request->post();

        if($data['id']){
            $res = $this->ClassModel->del('group_id = '.$data['id']);
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
            $data['addtime'] = time();
            $res = $this->ClassModel->add($data);
            if($res){
                return r_result(1,'',url('admin/AuthGroup/index'));
            }else{
                return r_result();
            }
        }else{
            $info = 'null';
            return view('admin.auth_group.form',['title' => '添加信息','info' => $info]);
        }
    }
    public function edit()
    {
        if($this->Request->isMethod('post')){
            $data = $this->Request->post();
            $where = 'group_id = '.$data['group_id'];

            $res = $this->ClassModel->edit($where,$data);

            return r_result(1,'',url('admin/AuthGroup/index'));
        }else{
            $id = $this->Request->get('id');
            $info = $this->ClassModel->queryOne(['group_id' => $id]);
            return view('admin.auth_group.form',['title' => '修改信息','info' => json_encode($info),'info1' => $info]);
        }
    }
    //配置权限
    public function groupAccess()
    {
        if($this->Request->isMethod('post')){
            $rules = $data = $this->Request->post('rules');

            if (empty($rules)) {
                return r_result(0,'请选择权限!');
            }
            $data = $this->Request->post();
            $where = 'group_id = '.$data['group_id'];
            $res = $this->ClassModel->edit($where,['rules' => $data['rules']]);
            if($res){
                return r_result(1,'权限配置成功!',url('admin/AuthGroup/index'));
            }else{
                return r_result(0);
            }

        }else {
            $data = $this->Request->all();
            $auth_rule = Cache::get('rules');
            $admin_rule = $this->ClassModel->getValue(['group_id' => $data['id']], 'rules');
            $arr = admin_auth($auth_rule, $pid = 0, $admin_rule);
            $arr[] = array(
                "id" => 0,
                "pid" => 0,
                "title" => "全部",
                "open" => true
            );
            return view('admin.auth_group.group_access', ['data' => json_encode($arr, true), 'id' => $data['id']]);
        }
    }


}