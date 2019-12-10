<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
//use Illuminate\Support\Facades\Cache;
//use Illuminate\Support\Facades\Storage;
class NewsController extends BaseController
{
    private $ClassModel;
    public function __construct()
    {
        parent::__construct();
        $this->ClassModel = $this->newObject(1,'News');
    }
    //发布信息
    public function add()
    {

        $login_code = $this->wxLogin();
        if($login_code == 403 || $login_code == 402) {
            return api_error($login_code);
        }
        if($this->user['level'] != 1){
            return api_error(404);
        }
        $data = $this->Request->post();
//            if(empty($data['title'])){
//                return api_error('缺少参数!');
//            }
        $news_data = [
            'title' => $data['title'] ?? '',
            'content' => $data['content'] ?? '',
            'cover_url' => $data['cover_url'] ?? '',
            'create_time' => time(),
            'is_draft' => is_one($data['is_draft'] ?? 0),
            'publisher_id' => $this->user['id']
        ];
        $draft_news_id = is_empty(isset($data['draft_news_id']) ? $data['draft_news_id'] : '');
        $news_info = $this->newObject(1,'NewsInfo');

        if($draft_news_id){
            $this->ClassModel->edit('id = '.$draft_news_id,$news_data);
            $news_info->del('news_id = '.$draft_news_id);
            $news_id = $draft_news_id;
        }else{
            $news_id = $this->ClassModel->getInsertId($news_data);
        }
        if(is_empty(isset($data['data']) ? $data['data'] : '')){
            $data['data'] = json_decode($data['data'],true);
            $news_info_data = [];
            foreach($data['data'] as $k => $v){
                $news_info_data[$k] = [
                    'news_id' => $news_id,
                    'type' => $v['type'],
                ];
                if($v['type'] == 1){
                    $news_info_data[$k]['url'] = $v['img_url'];
                    $news_info_data[$k]['desc'] = $v['remark'];
                }elseif($v['type'] == 2){
                    $news_info_data[$k]['desc'] = $v['text'];

                }else{
                    $news_info_data[$k]['video_cloud_id'] = $v['fileId'];
                    $news_info_data[$k]['url'] = $v['videoUrl'];
                    $news_info_data[$k]['desc'] = $v['remark'];
                }
                $news_info->add($news_info_data[$k]);
            }
        }
        return api_success('操作成功！');

    }
    //获取个人发布信息列表
    public function getNewsList()
    {
        $login_code = $this->wxLogin();
        if($login_code == 403 || $login_code == 402) {
            return api_error($login_code);
        }
        $data = $this->Request->post();
        $where = 'publisher_id = ' . $this->user['id'] . ' and is_admin = 0 and hide = 0';
        if(is_one($data['is_draft'] ?? 0)){
            $where .= ' and is_draft = 1';
        }
        $news = $this->ClassModel->getList($where);


        return api_success('操作成功！',$news);
    }
    //获取单条信息
    public function getNewsInfo()
    {

        $data = $this->Request->all();
        if(!isset($data['id'])){
            return api_error(400,'参数不足！');
        }
        $this->ClassModel->fieldIncrement('id = '.$data['id'],'visited_num',rand(5, 15));
        $where = 'id = '.$data['id'].' and hide = 0';
        if(is_one($data['is_draft'] ?? 0)){
            $where .= ' and is_draft = 1';
        }

        $news = $this->ClassModel->queryOne($where);
        if($news){
            $news['create_time'] = date('Y-m-d I:h:s',$news['create_time']);
        }
        return api_success('操作成功！',$news);

    }
    //删除信息
    public function delNews()
    {
        $login_code = $this->wxLogin();
        if($login_code == 403 || $login_code == 402) {
            return api_error($login_code);
        }
        $data = $this->Request->post();
        $where = 'publisher_id = ' . $this->user['id'] . ' and is_admin = 0 and id = '.$data['id'];
        if(is_one($data['is_draft'] ?? 0)){
            $where .= ' and is_draft = 1';
        }
        $news_res = $this->ClassModel->edit($where,['hide' => 1]);
//            $news_info_res = $this->newObject(1,'NewsInfo');
//            $news_info_model = $news_info_res->del('news_id = '.$data['id']);
        return api_success('操作成功！');

    }
    //获取所有信息
    public function getNewsListAll()
    {

        $data = $this->Request->all();
        $where = 'hide = 0';
        $news = $this->ClassModel->getList($where);

        return api_success('操作成功！',$news);
    }

    //测试
    public function test()
    {
        echo rand(5, 15);
        $data = $this->Request->all();
    }
}