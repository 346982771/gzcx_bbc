<?php

namespace App\Http\Controllers\Admin;

use App\Http\Factorys\Admin\ControllerFactory;
class AdminController extends ControllerFactory
{
    private $ClassModel;
    public function __construct()
    {
        parent::__construct();
        $this->ClassModel = $this->newObject(1,'Admin');
    }

    public function index()
    {
        if($this->Request->isMethod('post')){
            $data = $this->Request->post();
            $where = '1 = 1';
            if(!empty($data['group_id']) && ($data['group_id'] > 0)){
                $where .= ' and group_id = '.$data['group_id'];
            }
            if(!empty($data['key'])){
                $where .= " and concat(`loginname`,`username`) like '%".$data['key']."%'";
            }
            $list = $this->ClassModel->getList($where);
            foreach ($list['data'] as $k => $v) {
                $list['data'][$k]['create_time'] = date('Y-m-d H:i:s', $v['create_time']);
                $list['data'][$k]['group_title'] = $v['auth_group']['title'];
            }
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total']];
        }else{
            $auth_group = $this->getAuthGroup();
            return view('admin.admin.index',['auth_group' => $auth_group]);
        }
    }
    public function del()
    {
        $data = $this->Request->post();
        $result = r_result(0);
        if($data['id'] != 1 && $data['id']){
            $res = $this->ClassModel->del('admin_id = '.$data['id']);
            if($res){
                $result = r_result();
            }
        }
        return $result;
    }
    public function add()
    {
        if($this->Request->isMethod('post')){
            $data = $this->Request->post();
            if(!$data['password']){
                return r_result(0,'密码不能为空！');
            }
            $data['password'] = md5($data['password']);
            unset($data['file']);
            $data['create_time'] = time();
            $loginname_res = $this->ClassModel->queryOne(['loginname' => $data['loginname']]);
            if($loginname_res){
                return r_result(0,'用户名已存在！');
            }
            try{
                $res = $this->ClassModel->add($data);
            }catch(\Exception $e){
                return r_result(0,'操作失败！');
            }

            if($res){
                return r_result(1,'',url('admin/admin/index'));
            }else{
                return r_result();
            }
        }else{
            $auth_group = $this->getAuthGroup();
            $info = 'null';
            $shops = get_curl(config('common.mocar_url').'/api/common/getshop');
            $shops = $shops['code'] ? $shops['data'] : [];
            return view('admin.admin.form',['auth_group' => $auth_group,'title' => '添加用户','info' => $info,'shops' => $shops]);
        }
    }
    public function edit()
    {
        if($this->Request->isMethod('post')){
            $data = $this->Request->post();

            if(!$data['password']){
                unset($data['password']);
            }else{
                $data['password'] = md5($data['password']);
            }
            unset($data['file']);
            dd($data);die;
            $where = 'admin_id = '.$data['admin_id'];
            $res = $this->ClassModel->edit($where,$data);
            return r_result(1,'',url('admin/admin/index'));
        }else{
            $auth_group = $this->getAuthGroup();
            $id = $this->Request->get('id');
            $info = $this->ClassModel->queryOne(['admin_id' => $id]);

            return view('admin.admin.form',['auth_group' => $auth_group,'title' => '修改用户','info' => json_encode($info),'info1' => $info]);
        }
    }
    private function getAuthGroup()
    {
        $AuthGroupModel = $this->newObject(1,'AuthGroup');
        $auth_group = $AuthGroupModel->getAll();
        return $auth_group;
    }

}