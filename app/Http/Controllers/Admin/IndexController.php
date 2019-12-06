<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Models\Admin\AdminModel;
class IndexController extends Controller
{
    public function __construct()
    {
        $this->middleware('adminAuth');
    }

    public function index()
    {

        $authRule = Cache::get('rules');
        $AdminModel = new AdminModel();

        $user_rules = $AdminModel->getRules(session()->get('aid'));
        $user_rules = explode(',',$user_rules);
        //声明数组
        $menus = [];

        foreach ($authRule as $key=>$val){

            $authRule[$key]['href'] = $val['href'];
            if($val['pid']==0 && $val['menustatus'] == 1){

                $authRule[$key]['spread'] = false;

                if((session()->get('aid') != 1)){
                    if(in_array($val['id'],$user_rules)){
                        $menus[] = $authRule[$key];

                    }
                }else{
                    $menus[] = $authRule[$key];
                }
            }
        }

        foreach ($menus as &$v){
            foreach ($authRule as $kk=>$vv){
                if($v['id']==$vv['pid'] && $vv['menustatus'] == 1){
                    $authRule[$kk]['spread'] = false;
                    $authRule[$kk]['href'] = url($vv['href']);
                    if(session()->get('aid') != 1) {
                        if (in_array($vv['id'], $user_rules)) {
                            $v['children'][] = $authRule[$kk];
                        }
                    }else{
                        $v['children'][] = $authRule[$kk];
                    }
                }
            }
        }

        $menus = json_encode($menus);

        return view('admin.index.index',['menus' => $menus]);
    }
    public function main()
    {
        return view('admin.index.main');
    }
}