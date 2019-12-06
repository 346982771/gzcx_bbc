<?php

namespace App\Http\Controllers\Admin;



use App\Http\Factorys\Admin\ControllerFactory;

use Illuminate\Support\Facades\Cache;


class TopicController extends ControllerFactory
{
    //protected $AuthGroupModel;
    private $ClassModel;
    public function __construct()
    {
        parent::__construct();

        $this->ClassModel = $this->newObject(1,'Topic');
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
            foreach ($list['data'] as $k => $v) {
                $list['data'][$k]['create_time'] = date('Y-m-d H:i:s', $v['create_time']);
            }
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total']];
        }else{

            return view('admin.topic.index');
        }
    }
    public function del()
    {
        $data = $this->Request->post();

        if(($data['id'] ?? 0)){
            $res = $this->ClassModel->del('id = '.$data['id']);
            if($res){
                $news_topic_model = $this->newObject(1,'NewsTopic');
                $news_topic_model->del('main_id = '.$data['id'].' and type = 1');
                return r_result();
            }
        }
        return r_result(0);
    }
    public function add()
    {

        $data = $this->Request->post();
        $data['create_time'] = time();
        $data['is_admin'] = 1;
        $data['create_user_id'] = 0;
        $data['type'] = 1;
        if ($this->Request->isMethod('post')) {
            try {
                $res = $this->ClassModel->add($data);
            } catch (\Exception $e) {
                return r_result(0,'标题已被存在！');
            }
            return r_result(1,'',url('admin/Topic/index'));
        } else {
            $info = 'null';
            return view('admin.topic.form', ['title' => '添加信息','info' => $info]);
        }
    }
    public function edit()
    {
        if($this->Request->isMethod('post')){
            $data = $this->Request->post();
            $where = 'id = '.$data['id'];
            $res = $this->ClassModel->edit($where,$data);
            return r_result(1,'',url('admin/Topic/index'));
        }else{
            $id = $this->Request->get('id');
            $info = $this->ClassModel->queryOne(['id' => $id]);
            return view('admin.topic.form',['title' => '修改信息','info' => json_encode($info),'info1' => $info]);
        }
    }


    //获取话题
    public function getTopicList()
    {
        $data = $this->Request->post();
        if(empty($data['title'])){
            return r_result(0);
        }
        //$Topic = $this->newObject(1,'Topic');
        $where = " concat(`title`) like '%".$data['title']."%'";
        $list1 = $this->ClassModel->getAll($where);
        $car_series_where = " concat(`series_name`) like '%".$data['title']."%'";
        $car_series_model = $this->newObject(1,'CarSeries');
        $series_list = $car_series_model->getAll($car_series_where);
        if(!empty($list1)){
            $list2 = [];
            foreach($list1 as $list1_k => $list1_v){
                $list2[$list1_k] = [
                    'id' => $list1_v['id'],
                    'type' => 1,
                    'title' => $list1_v['title']
                ];
            }
        }
        if(!empty($series_list)){
            $series_list1 = [];
            foreach($series_list as $series_list_k => $series_list_v){
                $series_list1[$series_list_k] = [
                    'id' => $series_list_v['series_id'],
                    'type' => 2,
                    'title' => $series_list_v['series_name']
                ];
            }

        }
        $list = array_merge($list2 ?? [],$series_list1 ?? []);
        if($list){
            return $result = ['code' => 1, 'msg' => '获取成功!', 'data' => $list];
        }else{
            return r_result(0);
        }

    }
    public function newsFormAdd()
    {

        $data = $this->Request->post();
        $data['create_time'] = time();
        if(!empty($data['title'])){
            try{
                $res = $this->ClassModel->add($data);
            }catch(\Exception $e){
                $res = $this->ClassModel->queryOne(['title' => $data['title'],'is_admin' => 1,'create_user_id' => session()->get('aid')]);
                $res = $res['id'];
            }
            return r_result(1,'','',$res);
        }
        return r_result(0,'话题不能为空！');
    }

}