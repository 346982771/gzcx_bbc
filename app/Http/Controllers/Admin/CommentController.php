<?php

namespace App\Http\Controllers\Admin;



use App\Http\Factorys\Admin\ControllerFactory;

use Illuminate\Support\Facades\Cache;


class CommentController extends ControllerFactory
{
    private $ClassModel;
    public function __construct()
    {
        parent::__construct();

        $this->ClassModel = $this->newObject(1,'Comment');
    }

    public function index()
    {
        if($this->Request->isMethod('post')){

            $data = $this->Request->post();

            $where = '1 = 1';
            if(!empty($data['key'])){
                $where .= " and concat(`content`) like '%".$data['key']."%'";
            }
            $list = $this->ClassModel->getList($where);
            foreach ($list['data'] as $k => $v) {
                $list['data'][$k]['create_time'] = date('Y-m-d H:i:s', $v['create_time']);
                $list['data'][$k]['username'] = $v['user_info']['username'];
                $list['data'][$k]['headImg'] = $v['user_info']['headImg'];
            }

            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total']];
        }else{

            return view('admin.comment.index');
        }
    }
    public function del()
    {
        $data = $this->Request->post();
        if(($data['id'] ?? 0)){
            $res = $this->ClassModel->del('id = '.$data['id'].' or top_id = '.$data['id']);
            return r_result();
        }
        return r_result(0);
    }
    public function edit()
    {
        if($this->Request->isMethod('post')){
            $data = $this->Request->post();
            $where = 'id = '.$data['id'];
            unset($data['file']);
            $res = $this->ClassModel->edit($where,$data);

            return r_result(1,'',url('admin/News/index'));
        }else{
            $id = $this->Request->get('id');

            $info = $this->ClassModel->queryOne(['id' => $id]);
            $p_list = $this->getP0();
            return view('admin.news.form',['title' => '修改信息','info' => json_encode($info),'info1' => $info,'p_list' => $p_list]);
        }
    }
    //设置隐藏
    public function hide()
    {
        $id = $this->Request->post('id');
        $hide = $this->Request->post('hide');
        //$res = $this->ClassModel->editStatus('id = '.$id.' or pid = '.$id,['hide' => $hide]);
        $res = $this->ClassModel->editStatus('id = '.$id,['hide' => $hide]);
        if ($res) {
            return r_result();
        } else {
            return r_result(0);
        }
    }


    //置顶
    public function topping()
    {
        $id = $this->Request->post('id');
        $max_topping = $this->ClassModel->getMaxValue('','topping','topping desc');
        $res = $this->ClassModel->editStatus(['id' => $id],['topping' => $max_topping + 1]);
        if ($res) {
            return r_result();
        } else {
            return r_result(0);
        }
    }
    //详细
    public function detail()
    {
        $id = $this->Request->get('id');
        $info = $this->ClassModel->queryOne('id = '.$id);
        return view('admin.comment.detail',['title' => '详细信息','info' => $info]);
    }
    //获取可以发帖的用户
    public function getUserList()
    {
        $user_model = $this->newObject(1,'User');

        $list = $user_model->getAll('level = 1');
        return $list;
    }
}