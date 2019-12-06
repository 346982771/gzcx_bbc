<?php

namespace App\Http\Controllers\Api;

use App\Http\Factorys\Api\ControllerFactory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
class BaseController extends ControllerFactory
{
    protected $user;
    public function __construct()
    {
        parent::__construct();
    }
    //登陆
    public function

    wxLogin()
    {
//        header("Content-type: application/json");
//        header("Access-Control-Allow-Origin:  *" );
//        header("Access-Control-Allow-Methods: GET, OPTIONS, POST");
//        header("Access-Control-Allow-Credentials: true");
//        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding, X-Requested-With, Origin");

        $data = $this->Request->header();

        $data['open_id'] = !empty($data['authorization']) ? (preg_match('/^Bearer\s+(.*?)$/', $data['authorization'][0], $matches) ? str_replace('Bearer ','',$data['authorization'][0]) : '') : '';

        if(empty($data['open_id'])){
            return 402;
        }

        $user_model = $this->newObject(1,'User');
        $user = $user_model->queryOne(['open_id' => $data['open_id']]);

        if(empty($user)){
            $this->register($data);
            $user = $user_model->queryOne(['open_id' => $data['open_id']]);
            unset($user['created_at'],$user['updated_at']);
            $this->user = $user;
        }

        if($user['status'] == 0){
            return 403;
        }
        unset($user['created_at'],$user['updated_at']);
        $this->user = $user;
        return 1;

    }
    //注册
    public function register($data)
    {

        $user_model = $this->newObject(1,'User');
        $res = $user_model->add(['open_id' => $data['open_id'],'created_at' => time()]);
        return $res;
    }
    //绑定手机号
    public function bindingMobile()
    {
        $data = $this->Request->get();
        $user_model = $this->newObject(1,'UserModel');
        $res = $user_model->edit(['openid' => $data['openid'],['mobile' => $data['mobile']]]);
        if($res){
            return api_success();
        }else{
            return api_error();
        }
    }

}