<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use App\Http\Models\Admin\AdminModel;
class LoginController extends Controller
{
    public function index(Request $request)
    {

        if($request->isMethod('post')){
            $data = $request->post();

            if(!captcha_check(is_empty($data['captcha']))){
                $result = ['code' => 0,'msg' => '验证码错误！'];
            }
            $admin = new AdminModel();
            $res = $admin->queryOne(['loginname' => $data['username']]);
            if($res && $res['password'] == md5($data['password'])){
                session()->put('loginname',$res['loginname']);
                session()->put('username',$res['username']);
                session()->put('aid',$res['admin_id']);
//                    session()->put('loginname',$res['loginname']);
//                    session()->put('loginname',$res['loginname']);
                $avatar = $res['img'] ? $res['img'] : '/public/admin/images/0.jpg';
                session()->put('avatar',$avatar);
                $result = ['code' => 1,'msg' => '登陆成功！','url' => url("admin/index/index")];
            }else{
                $result = ['code' => 0,'msg' => '用户名或密码错误！'];
            }

            return $result;
        }else{
            Session()->flush();
            return view('admin.login.index');
        }

    }
    public function delCache()
    {
        Cache::flush();
        return ['code' => 1,'msg' => '操作成功'];
    }
}