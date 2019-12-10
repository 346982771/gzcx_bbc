<?php
if(!function_exists('arrayToObject')){
    function arrayToObject($arr) {
        if(is_array($arr)) {
            return (object)array_map(__FUNCTION__, $arr);
        }else {
            return $arr;
        }
    }
}
if(!function_exists('r_result')) {
    function r_result($code = 1, $msg = '操作成功！', $url = '',$data = [])
    {
        $result['code'] = $code;
        if ($msg == '') {
            $msg = '操作成功！';
        }
        if ($code == 0 && $msg == '操作成功！') {
            $result['msg'] = '操作失败！';
        } else {
            $result['msg'] = $msg;
        }
        if ($url) {
            $result['url'] = $url;
        }
        if ($data) {
            $result['data'] = $data;
        }

        return $result;
    }
}
if(!function_exists('menu')) {
    function menu($cate , $lefthtml = '|— ' , $pid=0 , $lvl=0, $leftpin=0 ){
        $arr=array();
        foreach($cate as $v){
            if($v['pid']==$pid){
                $v['lvl']=$lvl + 1;
                $v['leftpin']=$leftpin + 0;
                $v['lefthtml']=str_repeat($lefthtml,$lvl);
                $v['ltitle']=$v['lefthtml'].$v['title'];
                $arr[]=$v;
                $arr= array_merge($arr,menu($cate,$lefthtml,$v['id'], $lvl+1 ,$leftpin+20));
            }
        }

        return $arr;
    }
}

if(!function_exists('admin_auth')) {
    function admin_auth($cate, $pid = 0, $rules)
    {
        $arr = array();
        $rulesArr = explode(',', $rules);
        foreach ($cate as $v) {
            if ($v['pid'] == $pid) {
                if (in_array($v['id'], $rulesArr)) {
                    $v['checked'] = true;
                }
                $v['open'] = true;
                $arr[] = $v;
                $arr = array_merge($arr, admin_auth($cate, $v['id'], $rules));
            }
        }
        return $arr;
    }
}
//curl 封装
if(!function_exists('get_curl')) {
    function get_curl($url)
    {
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        //执行命令
        $result = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        return json_decode($result,true);
    }
}
if(!function_exists('post_curl')) {
    function post_curl($data, $url)
    {
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $res = curl_exec($ch);//运行curl
        curl_close($ch);
        return $res;
    }
}
//生成不重复的订单号
if(!function_exists('get_out_trade_no')) {
    function get_out_trade_no($header = 'DD')
    {
        //$yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn = $header . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
        return $orderSn;
    }
}
//写入日志
if(!function_exists('write_log')) {
    function write_log($logfile, $logdir, $content)
    {
        if (!file_exists($logfile)) {
            if (!is_dir($logdir)) {
                mkdir($logdir);
            }
        }
        $writelog = fopen($logfile, "a");
        fwrite($writelog, $content);
        fclose($writelog);
    }

}
//将类名改成表名
if(!function_exists('model_name_to_table_name')) {
    function model_name_to_table_name($model_name)
    {
        return strtolower(preg_replace('/(?<=[a-z])([A-Z])/', '_$1', $model_name));
    }
}
//api成功
if(!function_exists('api_success')) {
    function api_success($msg = '操作成功!', $data = '', array $header = [])
    {
        $code   = 200;
        $result = [
            'status' => $code,
            'msg'  => $msg,
            'data' => $data,
        ];
        return $result;
    }
}
//api失败
/*
 *
 * 冻结403
未登录402
无权限发帖404
 * */
if(!function_exists('api_error')) {
    function api_error($code = 400,$msg = '操作失败!', $data = '', array $header = [])
    {
        if (is_array($msg)) {
            $code = $msg['code'];
            $msg  = $msg['msg'];
        }
        $result = [
            'status' => $code,
            'msg'  => $msg,
            'data' => $data,
        ];
        return $result;
    }
}

//判断值是否为空
if(!function_exists('is_empty')) {
    function is_empty($data)
    {

        return (isset($data) && !empty($data)) ? $data : '';
    }
}
//判断值是否为1
if(!function_exists('is_one')) {
    function is_one($data)
    {
        return intval($data == 1) ? 1 : 0;
    }
}
//判断值是否set
if(!function_exists('is_set')) {
    function is_set($data)
    {
        return isset($data) ? $data : '';
    }
}