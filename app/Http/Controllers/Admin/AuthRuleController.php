<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Admin\AuthRuleModel;
use Illuminate\Support\Facades\Cache;
class AuthRuleController extends Controller
{
    protected $AuthRuleModel;
    public function __construct()
    {
        $this->AuthRuleModel = new AuthRuleModel();
    }

    public function index(Request $request)
    {
        if($request->isMethod('post')){

            $data = $request->post();
            //$auth_rule = $this->AuthRuleModel->getAll(['status' => 1]);
            $auth_rule = Cache::get('rules');
            $auth_rule = menu($auth_rule);
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $auth_rule];
        }else{

            return view('admin.auth_rule.index');
        }
    }



    public function del(Request $request)
    {
        $data = $request->post();

        if($data['id']){
            $son = $this->AuthRuleModel->queryOne(['pid' => $data['id']]);
            if($son){
                return r_result(0,'请先删除子级权限！');
            }

            $res = $this->AuthRuleModel->del('id = '.$data['id']);

            if($res){
                $this->updateCache();
                return r_result();
            }
        }
        return r_result(0);
    }
    public function add(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->post();

            $data['addtime'] = time();
            $data['icon'] = '';
            $res = $this->AuthRuleModel->add($data);

            if($res){
                $this->updateCache();
                return r_result(1,'',url('admin/AuthRule/index'));
            }else{
                return r_result();
            }
        }else{

            $auth_rule = $this->AuthRuleModel->getAll(['status' => 1]);

            $auth_rule = menu($auth_rule);
            $info = 'null';
            return view('admin.auth_rule.form',['auth_rule' => $auth_rule,'title' => '添加信息','info' => $info]);
        }
    }
    public function edit(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->post();

            $where = 'id = '.$data['id'];
            $res = $this->AuthRuleModel->edit($where,$data);
            $this->updateCache();
            return r_result(1,'',url('admin/AuthRule/index'));
        }else{


            $id = $request->get('id');

            $info = $this->AuthRuleModel->queryOne(['id' => $id]);

            return view('admin.auth_rule.form',['title' => '修改信息','info' => json_encode($info),'info1' => $info]);
        }
    }
    //设置权限菜单显示或者隐藏
    public function menuStatus(Request $request)
    {
        $id = $request->post('id');
        $menustatus = $request->post('menustatus');
        $res = $this->AuthRuleModel->editStatus(['id' => $id],['menustatus' => $menustatus]);
        if ($res) {
            $this->updateCache();
            return r_result();
        } else {
            return r_result(0);
        }
    }

    //设置权限是否验证
    public function authOpen(Request $request)
    {
        $id = $request->post('id');
        $authopen = $request->post('authopen');
        $res = $this->AuthRuleModel->editStatus(['id' => $id],['authopen' => $authopen]);
        if ($res) {
            $this->updateCache();
            return r_result();
        } else {
            return r_result(0);
        }
    }
    //设置排序
    public function sort(Request $request)
    {
        $id = $request->post('id');
        $sort = $request->post('sort');
        $res = $this->AuthRuleModel->editStatus(['id' => $id],['sort' => $sort]);
        if ($res) {
            $this->updateCache();
            return r_result();
        } else {
            return r_result(0);
        }
    }

    //更新缓存
    private function updateCache()
    {
        $rules = $this->AuthRuleModel->getAll(['status' => 1]);
        Cache::put('rules', $rules, 3600);
    }
}