<?php

namespace App\Http\Controllers\Admin;



use App\Http\Factorys\Admin\ControllerFactory;

use Guzzle\Common\Exception\ExceptionCollection;
use Illuminate\Support\Facades\Cache;

class NewsController extends ControllerFactory
{
    //protected $AuthGroupModel;
    private $ClassModel;
    public function __construct()
    {
        parent::__construct();

        $this->ClassModel = $this->newObject(1,'News');
    }

    public function index()
    {
        if($this->Request->isMethod('post')){

            $data = $this->Request->post();

            $where = '1 = 1';
            if(!empty($data['key'])){
                $where .= " and concat(`title`) like '%".$data['key']."%'";
            }
            if(intval($data['status'] ?? -2) > -1){
                $where .= " and status = ".$data['status'];
            }
            $list = $this->ClassModel->getList($where);

            foreach ($list['data'] as $k => $v) {
                //$list['data'][$k]['topic_name'] = '';
                $list['data'][$k]['create_time'] = date('Y-m-d H:i:s', $v['create_time']);
                $list['data'][$k]['username'] = $v['user_info']['username'];
                $list['data'][$k]['headImg'] = $v['user_info']['headImg'];
//                if(!empty($v['news_topic'])){
//                    foreach($list['data'][$k]['news_topic'] as $news_topic_k => $news_topic_v){
//                        if(!empty($news_topic_v['news']['news_topic_name'])){
//                            $list['data'][$k]['topic_name'] .= $news_topic_v['news']['news_topic_name'];
//                            $list['data'][$k]['topic_name'] .= ((count($list['data'][$k]['news_topic']) - 1) == $news_topic_k) ? '' : ',';
//                        }
//                    }
//                }
                unset($list['data'][$k]['news_topic']);
            }
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total']];
        }else{

            return view('admin.news.index');
        }
    }
    public function del()
    {
        $data = $this->Request->post();

        if(($data['id'] ?? 0)){
            $res = $this->ClassModel->del('id = '.$data['id']);
            if($res){
                $news_info_model = $this->newObject(1,'NewsInfo');
                $news_info_model->del('news_id = '.$data['id']);
                $news_topic_model = $this->newObject(1,'NewsTopic');
                $news_topic_model->del('news_id = '.$data['id'].' and type = 1');
                return r_result();
            }
        }
        return r_result(0);
    }
    public function add()
    {
        if($this->Request->isMethod('post')){
            $data = $this->Request->post();

//            if(!isset($data['cover_url']) || empty($data['cover_url'])){
//                return r_result(0,'封面必须上传！');
//            }
            $news_data = [
                'title' => $data['title'],
                'content' => $data['content'],
                'is_admin' => 1,
                'create_time' => time(),
                'cover_url' => $data['cover_url'] ?? '',
                'publisher_id' => $data['publisher_id'],//session()->get('aid')
                'status' => 1
            ];

            $topic = [];
            $topic_type = [];
            $topic_title = [];
//            if($data['n_topic']){
//                $data['n_topic'] = explode(',',$data['n_topic']);
//                foreach($data['n_topic'] as $n_topic_v){
//                    if($n_topic_v){
//                        $n_topic_v_1 = explode('#',$n_topic_v);
//                        $topic[] = $n_topic_v_1[0];
//                        $topic_type[] = $n_topic_v_1[1];
//                        $topic_title = $n_topic_v_1[2];
//                    }
//                }
//            }
//            if($data['o_topic']){
//                $data['o_topic'] = explode(',',$data['o_topic']);
//                foreach($data['o_topic'] as $o_topic_v){
//                    if($o_topic_v){
//                        $o_topic_v_1 = explode('#',$o_topic_v);
//                        $topic[] = $o_topic_v_1[0];
//                        $topic_type[] = $o_topic_v_1[1];
//                        $topic_title[] = $o_topic_v_1[2];
//                    }
//                }
//            }
            if($data['topic']){
                $data['topic'] = explode(',',$data['topic']);
                foreach($data['topic'] as $topic_v){
                    if($topic_v){
                        $topic_v_1 = explode('#',$topic_v);

                        $topic_type[] = $topic_v_1[1];
                        $topic_title[] = $topic_v_1[2];
                        if(!$topic_v_1[0]){
                            $topic_model = $this->newObject(1,'Topic');
                            try{
                                $topic_data['create_time'] = time();
                                $topic_data['is_admin'] = 1;
                                $topic_data['create_user_id'] = 0;
                                $topic_data['type'] = 1;
                                $topic_data['title'] = $topic_v_1[2];
                                $topic[] = $topic_model->getInsertId($topic_data);
                            }catch (\Exception $e) {
                                $topic[] = $topic_model->getValue('title = \''.$topic_v_1[2].'\'','id');
                            }

                        }else{
                            $topic[] = $topic_v_1[0];
                        }
                    }
                }
            }


            //$news_data['topic'] = implode(',',$topic);
            $news_id = $this->ClassModel->getInsertId($news_data);

            $new_topic_data = [];
            if(!empty($topic)){
                foreach($topic as $topic_k => $topic_v){
                    $new_topic_data[] = [
                        'main_id' => $topic_v,
                        'news_id' => $news_id ?? 0,
                        'create_time' => time(),
                        'type' => $topic_type[$topic_k],
                        'title' => $topic_title[$topic_k],
                        'topic_use_count' => 1
                    ];
                }

                if(!empty($new_topic_data)){
                    $news_topic_model = $this->newObject(1,'NewsTopic');
                    $news_topic_model->add($new_topic_data);
                }

            }


            $news_info_data = [];
            $sort = 0;

            if($data['num'] > 0){
                for($i = 0;$i < $data['num'];$i++){
                    if(($data['type_'.$i] ?? 0)){
                        $news_info_data[] = [
                            'news_id' => $news_id,
                            'type' => $data['type_'.$i],
                            'url' => $data['url_'.$i] ?? '',
                            'video_cloud_id' => $data['video_cloud_id_'.$i] ?? '',
                            'desc' => $data['desc_'.$i] ?? '',
                            'sort' => $sort + 1
                        ];
                    }
                }
            }

            if($news_info_data){
                $news_info_model = $this->newObject(1,'NewsInfo');
                $news_info_model->add($news_info_data);
            }
            if($news_id){
                return r_result(1,'',url('admin/News/index'));
            }else{
                return r_result();
            }
        }else{
            $user_list = $this->getUserList();
            $info = 'null';
            $signature = $this->getSignature();
            return view('admin.news.form',['title' => '添加信息','info' => $info,'user_list' => $user_list,'signature' => $signature]);
        }
    }
//    public function edit()
//    {
//        if($this->Request->isMethod('post')){
//            $data = $this->Request->post();
//            $where = 'id = '.$data['id'];
//            unset($data['file']);
//            $res = $this->ClassModel->edit($where,$data);
//
//            return r_result(1,'',url('admin/News/index'));
//        }else{
//            $id = $this->Request->get('id');
//
//            $info = $this->ClassModel->queryOne(['id' => $id]);
//            $p_list = $this->getP0();
//            return view('admin.news.form',['title' => '修改信息','info' => json_encode($info),'info1' => $info,'p_list' => $p_list]);
//        }
//    }
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
    public function isDraft()
    {
        $id = $this->Request->post('id');
        $is_draft = $this->Request->post('is_draft');
        $res = $this->ClassModel->editStatus(['id' => $id],['is_draft' => $is_draft]);
        if ($res) {
            return r_result();
        } else {
            return r_result(0);
        }
    }
    //设置
    public function status()
    {
        $id = $this->Request->post('id');
        $status = $this->Request->post('status');
        $res = $this->ClassModel->editStatus(['id' => $id],['status' => $status]);
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
        $news = $this->ClassModel->queryOne('id = '.$id);
        //dd($news);die;
        $news['topic_name'] = '';
        if(!empty($news['news_topic'])){
            foreach($news['news_topic'] as $news_topic_k => $news_topic_v){
                $news['topic_name'] .= '#'.$news_topic_v['title'];
                $news['topic_name'] .= ((count($news['news_topic']) - 1) == $news_topic_k) ? '' : ' ';
            }
        }
        unset($news['news_topic']);
        return view('admin.news.detail',['title' => '详细信息','info' => $news]);
    }
    //获取可以发帖的用户
    public function getUserList()
    {
        $user_model = $this->newObject(1,'User');

        $list = $user_model->getAll('level = 1 and updated_at > 0');
        return $list;
    }

    //获取api签名
    public function getSignature()
    {
        // 确定 App 的云 API 密钥
        $secret_id = "AKIDqZ6TggMzPRM5eX6i4FDzfDTc6Ree7CvY";
        $secret_key = "fWGpDPOCnCOOCrKemkWv9B4mMp6Bbsxq";

// 确定签名的当前时间和失效时间
        $current = time();
        $expired = $current + 86400;  // 签名有效期：3天

// 向参数列表填入参数
        $arg_list = array(
            "secretId" => $secret_id,
            "currentTimeStamp" => $current,
            "expireTime" => $expired,
            "random" => rand());

// 计算签名
        $original = http_build_query($arg_list);
        $signature = base64_encode(hash_hmac('SHA1', $original, $secret_key, true).$original);
        return $signature;
    }
}