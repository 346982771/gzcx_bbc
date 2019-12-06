<?php

namespace App\Http\Controllers\Admin;



use App\Http\Factorys\Admin\ControllerFactory;

use Illuminate\Support\Facades\Cache;


class CarSeriesController extends ControllerFactory
{
    //protected $AuthGroupModel;
    private $ClassModel;
    public function __construct()
    {
        parent::__construct();
        $this->ClassModel = $this->newObject(1,'CarSeries');
    }

    public function index()
    {
//        $file_path = base_path().'/json.json';
//        if(file_exists($file_path)){
//            $str = file_get_contents($file_path);//将整个文件内容读入到一个字符串中
//            $str = json_decode($str,true);
//            $arr = [];
//            foreach($str as $k => $v){
//                echo "<img src=\"".($v['img'] ? 'https:'.$v['img'] : '')."\"  style=\"max-width: 30px;max-height: 30px;\">";
//                $arr[$k]['icon'] = $v['img'] ? 'http:'.$v['img'] : '';
//                $arr[$k]['title'] = $v['brand_name'];
//                $arr[$k]['firstletter'] = $v['firstletter'];
//                $arr[$k]['sort'] = 50;
//            }
//            $res = $this->ClassModel->add($arr);
//            dd($res);die;
//        }
//        echo 1;die;
        if($this->Request->isMethod('post')){
            $data = $this->Request->post();
            $where = '1 = 1';
            if(!empty($data['key'])){
                $where .= " and concat(`series_name`) like '%".$data['key']."%'";
            }
            $list = $this->ClassModel->getList($where);

            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total']];
        }else{

            return view('admin.car_series.index');
        }
    }
    public function del()
    {
        $data = $this->Request->post();

        if($data['id']){
            $res = $this->ClassModel->del('series_id = '.$data['id'].' or pid = '.$data['id']);
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
            unset($data['file']);
            $data['update_time'] = date('Y-m-d H:i:s',time());
            $res = $this->ClassModel->add($data);
            if($res){
                return r_result(1,'',url('admin/CarSeries/index'));
            }else{
                return r_result();
            }
        }else{
            $info = 'null';
            return view('admin.car_series.form',['title' => '添加信息','info' => $info]);
        }
    }
    public function edit()
    {
        if($this->Request->isMethod('post')){
            $data = $this->Request->post();
            $where = 'series_id = '.$data['id'];
            unset($data['file']);
            $res = $this->ClassModel->edit($where,$data);

            return r_result(1,'',url('admin/CarSeries/index'));
        }else{
            $id = $this->Request->get('series_id');

            $info = $this->ClassModel->queryOne(['series_id' => $id]);


            return view('admin.car_series.form',['title' => '修改信息','info' => json_encode($info),'info1' => $info]);
        }
    }
    //设置隐藏
    public function hide()
    {
        $id = $this->Request->post('id');
        $hide = $this->Request->post('hide');
        $res = $this->ClassModel->editStatus(['series_id' => $id],['hide' => $hide]);
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
        $res = $this->ClassModel->editStatus(['series_id' => $id],['recommend' => $recommend]);
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
        $res = $this->ClassModel->editStatus(['series_id' => $id],['sort' => $sort]);
        if($res){
            return r_result();
        } else {
            return r_result(0);
        }
    }
    public function getBrandList()
    {
        $p_list = $this->ClassModel->getAll();
        $p_list = menu($p_list);
        return $p_list;
    }

}