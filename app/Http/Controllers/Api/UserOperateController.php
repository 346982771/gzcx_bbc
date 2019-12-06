<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
//use Illuminate\Support\Facades\Cache;
//use Illuminate\Support\Facades\Storage;
class UserOperateController extends BaseController
{
    private $ClassModel;
    public function __construct()
    {
        parent::__construct();
        $this->ClassModel = $this->newObject(1,'UserOperate');
    }
    //用户操作  点赞收藏
    public function praise()
    {
        $login_code = $this->wxLogin();
        if($login_code == 403 || $login_code == 402) {
            return api_error($login_code);
        }
        $data = $this->Request->all();
        $news_model = $this->newObject(1,'News');
        $news_model->fieldIncrement('id = '.$data['info_id'],'praise_num',1);
        $this->ClassModel->add(['info_id' => $data['info_id'],'info_type' => $data['info_type'],'type' => $data['type'],'user_id' => $this->user['id'],'create_time' => time()]);
        return api_success();
    }
    //用户操作  取消点赞、取消收藏
    public function cancelPraise()
    {
        $login_code = $this->wxLogin();
        if($login_code == 403 || $login_code == 402) {
            return api_error($login_code);
        }
        $data = $this->Request->all();
        $news_model = $this->newObject(1,'News');
        $news_model->fieldDecrement('id = '.$data['info_id'],'praise_num',1);
        $this->ClassModel->del(['info_id' => $data['info_id'],'info_type' => $data['info_type'],'type' => $data['type'],'user_id' => $this->user['id']]);
        return api_success();
    }
}