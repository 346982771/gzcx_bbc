<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
class CommonController extends BaseController
{

    public function __construct()
    {
        parent::__construct();

    }
    public function getUserInfo()
    {
        if($this->wxLogin() > 0){
            return api_success('操作成功！',$this->user);
        }
    }
    //换取openid
    public function actionGetOpenid()
    {
        $data = $this->Request->post();
        $appid = config('common.appid');
        $app_secret = config('common.appSecret');
        $js_code = is_empty($data['code']);
        if (!$js_code) {
            return api_error('code不能为空');
        }
        $opts = array('http' => array('method' => "GET", 'timeout' => 10,));
        $context = stream_context_create($opts);
        $html = file_get_contents('https://api.weixin.qq.com/sns/jscode2session?appid=' . $appid . '&secret=' . $app_secret . '&js_code=' . $js_code . '&grant_type=authorization_code', false, $context);
        return json_decode($html, true);
    }
    public function common()
    {
//        $res = get_curl('http://testapi.che300.com/service/getCarBrandList?token=318fe0b7bf890749ec0e4d54907535da');
//        $res = $res['brand_list'];
//        $data = [];
//        $car_brand_model = $this->newObject(1,'CarBrand');
//        foreach($res as $res_k => $res_v){
//            $data[$res_k]['brand_id'] = $res_v['brand_id'];
//            $data[$res_k]['brand_name'] = $res_v['brand_name'];
//            $data[$res_k]['initial'] = $res_v['initial'];
//            $data[$res_k]['update_time'] = $res_v['update_time'];
//        }
//        $car_brand_model->add($data);
//        echo '品牌添加成功！';die;

        echo 123;die
        $res = get_curl('http://testapi.che300.com/service/getCarBrandList?token=318fe0b7bf890749ec0e4d54907535da');
        dd($res);die;
        $res = $res['brand_list'];
        $car_series_model = $this->newObject(1,'CarSeries');
        $data = [];

        foreach($res as $res_k => $res_v){
            $res1 = get_curl('http://testapi.che300.com/service/getCarSeriesList?token=318fe0b7bf890749ec0e4d54907535da&brandId='.$res_v['brand_id']);

            if(isset($res1['series_list']) && !empty($res1['series_list']) && is_array($res1['series_list'])){
                foreach($res1['series_list'] as $series_k => $series_v){
                    $data[$res_k]['series_id'] = $series_v['series_id'];
                    $data[$res_k]['brand_id'] = $res_v['series_id'];
                    $data[$res_k]['update_time'] = $series_v['update_time'];
                    $data[$res_k]['maker_type'] = $series_v['maker_type'];
                    $data[$res_k]['series_group_name'] = $series_v['series_group_name'];
                    $data[$res_k]['series_name'] = $series_v['series_name'];
                }
            }
        }
        $car_series_model->add($data);
        echo '车型添加成功！';die;


    }
}