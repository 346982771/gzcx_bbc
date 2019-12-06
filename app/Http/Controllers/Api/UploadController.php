<?php

namespace App\Http\Controllers\Api;

use App\Http\Factorys\Api\ControllerFactory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
class NewsController extends ControllerFactory
{

    public function uploadFile()
    {
        $time = date('Ymd',time());
        $file = $this->Request->file('file');
        // 获取文件相关信息
        $originalName = $file->getClientOriginalName(); // 文件原名
        $ext = $file->getClientOriginalExtension();     // 扩展名
        $realPath = $file->getRealPath();   //临时文件的绝对路径
        $type = $file->getClientMimeType();     // image/jpeg
        // 上传文件
        $filename = uniqid() . '.' . $ext;
        $data['pic_path'] = '/uploads/'.$time.'/'.$filename;
        // 使用我们新建的uploads本地存储空间（目录）
        //这里的uploads是配置文件的名称
        $bool = Storage::disk()->put('/'.$data['pic_path'], file_get_contents($realPath));
        if($bool){
            return api_success('操作成功！',$this->Request->server('HTTP_HOST').'/storage/app/'.$data['pic_path']);
        }else{
            return api_error();
        }

    }

}