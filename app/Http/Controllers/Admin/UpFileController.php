<?php

namespace App\Http\Controllers\Admin;
use App\Http\Factorys\Admin\ControllerFactory;

use Illuminate\Support\Facades\Cache;
use Vod\Model\VodUploadRequest;
use Vod\VodUploadClient;

class UpFileController extends ControllerFactory
{

//    private $ClassModel;
//    public function __construct()
//    {
//        parent::__construct();
//        $this->ClassModel = $this->newObject(1,'User');
//    }
    //上传视频
    public function upload()
    {

        $file = $this->Request->file('file');

        $client = new VodUploadClient("AKIDqZ6TggMzPRM5eX6i4FDzfDTc6Ree7CvY", "fWGpDPOCnCOOCrKemkWv9B4mMp6Bbsxq");
        $req = new VodUploadRequest();
        dd($file);die;
        $req->MediaFilePath = $file->getRealPath();

        //$req->MediaFilePath = 'D:\phpStudy\PHPTutorial\WWW\site2\public\admin\images\0.jpg';

        try {
            $rsp = $client->upload("ap-guangzhou", $req);
            echo "FileId -> ". $rsp->FileId . "\n";
            echo "MediaUrl -> ". $rsp->MediaUrl . "\n";
        } catch (\Exception $e) {
            // 处理上传异常
            echo $e;
        }
        die;
        //$req = new VodUploadRequest();
    }

}