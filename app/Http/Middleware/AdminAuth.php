<?php

namespace App\Http\Middleware;

use App\Http\Models\Admin\AdminModel;
use Illuminate\Support\Facades\Cache;
use App\Http\Models\Admin\AuthRuleModel;
use Closure;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    private $AuthRuleModel,$AdminModel;

    public function __construct()
    {



//
//        $data = '{"result":{"orderitems":[{"itemtype":"热度","items":[{"name":"询价订单(最近30天)","modelexcessids":[{"id":40040,"value":"1559笔"}],"url":""}]}],"filter":{"displacements":[],"years":[],"gearboxs":[]},"specitems":[{"name":"车系名称","modelexcessids":[{"id":40040,"value":"凯迪拉克XT5"}],"url":""},{"name":"车型名称","modelexcessids":[{"id":40040,"value":"2020款 28T 四驱技术型"}],"url":""},{"name":"车型图片","modelexcessids":[{"id":40040,"value":"https://car2.autoimg.cn/cardfs/product/g29/M07/8C/E1/s_autohomecar__ChcCSF1INR2AGocPAAtQdmK9Gp8245.jpg"}],"url":""}],"paramitems":[{"itemtype":"基本参数","items":[{"name":"车型名称","modelexcessids":[{"id":40040,"value":"凯迪拉克XT5 2020款 28T 四驱技术型"}],"url":""},{"name":"厂商指导价(元)","modelexcessids":[{"id":40040,"value":"34.97万"}],"url":""},{"name":"厂商","modelexcessids":[{"id":40040,"value":"上汽通用凯迪拉克"}],"url":""},{"name":"级别","modelexcessids":[{"id":40040,"value":"中型SUV"}],"url":""},{"name":"能源类型","modelexcessids":[{"id":40040,"value":"汽油"}],"url":""},{"name":"环保标准","modelexcessids":[{"id":40040,"value":"国VI"}],"url":""},{"name":"上市时间","modelexcessids":[{"id":40040,"value":"2019.06"}],"url":""},{"name":"最大功率(kW)","modelexcessids":[{"id":40040,"value":"177"}],"url":""},{"name":"最大扭矩(N·m)","modelexcessids":[{"id":40040,"value":"350"}],"url":""},{"name":"发动机","modelexcessids":[{"id":40040,"value":"2.0T 241马力 L4"}],"url":""},{"name":"变速箱","modelexcessids":[{"id":40040,"value":"9挡手自一体"}],"url":""},{"name":"长*宽*高(mm)","modelexcessids":[{"id":40040,"value":"4813*1903*1682"}],"url":""},{"name":"车身结构","modelexcessids":[{"id":40040,"value":"5门5座SUV"}],"url":""},{"name":"最高车速(km/h)","modelexcessids":[{"id":40040,"value":"210"}],"url":""},{"name":"官方0-100km/h加速(s)","modelexcessids":[{"id":40040,"value":"8.3"}],"url":""},{"name":"实测0-100km/h加速(s)","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"实测100-0km/h制动(m)","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"工信部综合油耗(L/100km)","modelexcessids":[{"id":40040,"value":"7.9"}],"url":""},{"name":"实测油耗(L/100km)","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"整车质保","modelexcessids":[{"id":40040,"value":"三年不限公里"}],"url":""}]},{"itemtype":"车身","items":[{"name":"长度(mm)","modelexcessids":[{"id":40040,"value":"4813"}],"url":""},{"name":"宽度(mm)","modelexcessids":[{"id":40040,"value":"1903"}],"url":""},{"name":"高度(mm)","modelexcessids":[{"id":40040,"value":"1682"}],"url":""},{"name":"轴距(mm)","modelexcessids":[{"id":40040,"value":"2857"}],"url":""},{"name":"前轮距(mm)","modelexcessids":[{"id":40040,"value":"1645"}],"url":""},{"name":"后轮距(mm)","modelexcessids":[{"id":40040,"value":"1645"}],"url":""},{"name":"最小离地间隙(mm)","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"车身结构","modelexcessids":[{"id":40040,"value":"SUV"}],"url":""},{"name":"车门数(个)","modelexcessids":[{"id":40040,"value":"5"}],"url":""},{"name":"座位数(个)","modelexcessids":[{"id":40040,"value":"5"}],"url":""},{"name":"油箱容积(L)","modelexcessids":[{"id":40040,"value":"82"}],"url":""},{"name":"行李厢容积(L)","modelexcessids":[{"id":40040,"value":"584-1634"}],"url":""},{"name":"整备质量(kg)","modelexcessids":[{"id":40040,"value":"1915"}],"url":""}]},{"itemtype":"发动机","items":[{"name":"发动机型号","modelexcessids":[{"id":40040,"value":"LSY"}],"url":""},{"name":"排量(mL)","modelexcessids":[{"id":40040,"value":"1998"}],"url":""},{"name":"排量(L)","modelexcessids":[{"id":40040,"value":"2.0"}],"url":""},{"name":"进气形式","modelexcessids":[{"id":40040,"value":"涡轮增压"}],"url":""},{"name":"气缸排列形式","modelexcessids":[{"id":40040,"value":"L"}],"url":""},{"name":"气缸数(个)","modelexcessids":[{"id":40040,"value":"4"}],"url":""},{"name":"每缸气门数(个)","modelexcessids":[{"id":40040,"value":"4"}],"url":""},{"name":"压缩比","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"配气机构","modelexcessids":[{"id":40040,"value":"DOHC"}],"url":""},{"name":"缸径(mm)","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"行程(mm)","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"最大马力(Ps)","modelexcessids":[{"id":40040,"value":"241"}],"url":""},{"name":"最大功率(kW)","modelexcessids":[{"id":40040,"value":"177"}],"url":""},{"name":"最大功率转速(rpm)","modelexcessids":[{"id":40040,"value":"5000"}],"url":""},{"name":"最大扭矩(N·m)","modelexcessids":[{"id":40040,"value":"350"}],"url":""},{"name":"最大扭矩转速(rpm)","modelexcessids":[{"id":40040,"value":"1500-4000"}],"url":""},{"name":"发动机特有技术","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"燃料形式","modelexcessids":[{"id":40040,"value":"汽油"}],"url":""},{"name":"燃油标号","modelexcessids":[{"id":40040,"value":"95号"}],"url":""},{"name":"供油方式","modelexcessids":[{"id":40040,"value":"直喷"}],"url":""},{"name":"缸盖材料","modelexcessids":[{"id":40040,"value":"铝合金"}],"url":""},{"name":"缸体材料","modelexcessids":[{"id":40040,"value":"铝合金"}],"url":""},{"name":"环保标准","modelexcessids":[{"id":40040,"value":"国VI"}],"url":""}]},{"itemtype":"变速箱","items":[{"name":"挡位个数","modelexcessids":[{"id":40040,"value":"9"}],"url":""},{"name":"变速箱类型","modelexcessids":[{"id":40040,"value":"手自一体变速箱(AT)"}],"url":""},{"name":"简称","modelexcessids":[{"id":40040,"value":"9挡手自一体"}],"url":""}]},{"itemtype":"底盘转向","items":[{"name":"驱动方式","modelexcessids":[{"id":40040,"value":"前置四驱"}],"url":""},{"name":"四驱形式","modelexcessids":[{"id":40040,"value":"适时四驱"}],"url":""},{"name":"中央差速器结构","modelexcessids":[{"id":40040,"value":"多片离合器"}],"url":""},{"name":"前悬架类型","modelexcessids":[{"id":40040,"value":"麦弗逊式独立悬架"}],"url":""},{"name":"后悬架类型","modelexcessids":[{"id":40040,"value":"五连杆独立悬架"}],"url":""},{"name":"助力类型","modelexcessids":[{"id":40040,"value":"电动助力"}],"url":""},{"name":"车体结构","modelexcessids":[{"id":40040,"value":"承载式"}],"url":""}]},{"itemtype":"车轮制动","items":[{"name":"前制动器类型","modelexcessids":[{"id":40040,"value":"通风盘式"}],"url":""},{"name":"后制动器类型","modelexcessids":[{"id":40040,"value":"通风盘式"}],"url":""},{"name":"驻车制动类型","modelexcessids":[{"id":40040,"value":"电子驻车"}],"url":""},{"name":"前轮胎规格","modelexcessids":[{"id":40040,"value":"235/65 R18"}],"url":""},{"name":"后轮胎规格","modelexcessids":[{"id":40040,"value":"235/65 R18"}],"url":""},{"name":"备胎规格","modelexcessids":[{"id":40040,"value":"非全尺寸"}],"url":""}]}],"koubeiitems":[],"minprice":[{"name":"参考价(万)","modelexcessids":[{"id":40040,"value":"3989,28.97"}],"url":""}],"specconfigitems":[],"configitems":[{"itemtype":"主/被动安全装备","items":[{"name":"主/副驾驶座安全气囊","modelexcessids":[{"id":40040,"value":"主● / 副●"}],"url":""},{"name":"前/后排侧气囊","modelexcessids":[{"id":40040,"value":"前● / 后-"}],"url":""},{"name":"前/后排头部气囊(气帘)","modelexcessids":[{"id":40040,"value":"前● / 后●"}],"url":""},{"name":"膝部气囊","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"后排安全带式气囊","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"后排中央安全气囊","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"被动行人保护","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"零胎压继续行驶","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"ISOFIX儿童座椅接口","modelexcessids":[{"id":40040,"value":"●"}],"url":""},{"name":"ABS防抱死","modelexcessids":[{"id":40040,"value":"●"}],"url":""},{"name":"制动力分配(EBD/CBC等)","modelexcessids":[{"id":40040,"value":"●"}],"url":""},{"name":"刹车辅助(EBA/BAS/BA等)","modelexcessids":[{"id":40040,"value":"●"}],"url":""},{"name":"牵引力控制(ASR/TCS/TRC等)","modelexcessids":[{"id":40040,"value":"●"}],"url":""},{"name":"车身稳定控制(ESC/ESP/DSC等)","modelexcessids":[{"id":40040,"value":"●"}],"url":""},{"name":"并线辅助","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"车道偏离预警系统","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"车道保持辅助系统","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"道路交通标识识别","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"主动刹车/主动安全系统","modelexcessids":[{"id":40040,"value":"●"}],"url":""},{"name":"夜视系统","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"疲劳驾驶提示","modelexcessids":[{"id":40040,"value":"-"}],"url":""}]},{"itemtype":"辅助/操控配置","items":[{"name":"前/后驻车雷达","modelexcessids":[{"id":40040,"value":"前● / 后●"}],"url":""},{"name":"倒车车侧预警系统","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"自动泊车入位","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"发动机启停技术","modelexcessids":[{"id":40040,"value":"●"}],"url":""},{"name":"自动驻车","modelexcessids":[{"id":40040,"value":"●"}],"url":""},{"name":"上坡辅助","modelexcessids":[{"id":40040,"value":"●"}],"url":""},{"name":"陡坡缓降","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"空气悬架","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"电磁感应悬架","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"可变转向比","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"中央差速器锁止功能","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"整体主动转向系统","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"涉水感应系统","modelexcessids":[{"id":40040,"value":"-"}],"url":""}]},{"itemtype":"外部/防盗配置","items":[{"name":"运动外观套件","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"电动后备厢","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"感应后备厢","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"电动后备厢位置记忆","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"尾门玻璃独立开启","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"车顶行李架","modelexcessids":[{"id":40040,"value":"●"}],"url":""},{"name":"发动机电子防盗","modelexcessids":[{"id":40040,"value":"●"}],"url":""},{"name":"车内中控锁","modelexcessids":[{"id":40040,"value":"●"}],"url":""},{"name":"无钥匙启动系统","modelexcessids":[{"id":40040,"value":"●"}],"url":""},{"name":"主动闭合式进气格栅","modelexcessids":[{"id":40040,"value":"●"}],"url":""},{"name":"电池预加热","modelexcessids":[{"id":40040,"value":"-"}],"url":""}]},{"itemtype":"内部配置","items":[{"name":"多功能方向盘","modelexcessids":[{"id":40040,"value":"●"}],"url":""},{"name":"方向盘换挡","modelexcessids":[{"id":40040,"value":"●"}],"url":""},{"name":"方向盘加热","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"方向盘记忆","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"全液晶仪表盘","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"HUD抬头数字显示","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"内置行车记录仪","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"主动降噪","modelexcessids":[{"id":40040,"value":"●"}],"url":""},{"name":"电动可调踏板","modelexcessids":[{"id":40040,"value":"-"}],"url":""}]},{"itemtype":"座椅配置","items":[{"name":"运动风格座椅","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"主/副驾驶座电动调节","modelexcessids":[{"id":40040,"value":"主● / 副●"}],"url":""},{"name":"副驾驶位后排可调节按钮","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"后排座椅电动调节","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"后排小桌板","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"第二排独立座椅","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"后排座椅电动放倒","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"前/后中央扶手","modelexcessids":[{"id":40040,"value":"前● / 后●"}],"url":""},{"name":"后排杯架","modelexcessids":[{"id":40040,"value":"●"}],"url":""}]},{"itemtype":"多媒体配置","items":[{"name":"GPS导航系统","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"导航路况信息显示","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"道路救援呼叫","modelexcessids":[{"id":40040,"value":"●"}],"url":""},{"name":"中控液晶屏分屏显示","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"蓝牙/车载电话","modelexcessids":[{"id":40040,"value":"●"}],"url":""},{"name":"手势控制","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"车联网","modelexcessids":[{"id":40040,"value":"●"}],"url":""},{"name":"OTA升级","modelexcessids":[{"id":40040,"value":"●"}],"url":""},{"name":"车载电视","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"后排控制多媒体","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"220V/230V电源","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"行李厢12V电源接口","modelexcessids":[{"id":40040,"value":"●"}],"url":""}]},{"itemtype":"灯光配置","items":[{"name":"LED日间行车灯","modelexcessids":[{"id":40040,"value":"●"}],"url":""},{"name":"自适应远近光","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"自动头灯","modelexcessids":[{"id":40040,"value":"●"}],"url":""},{"name":"转向辅助灯","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"转向头灯","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"前大灯雨雾模式","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"大灯高度可调","modelexcessids":[{"id":40040,"value":"●"}],"url":""},{"name":"大灯清洗装置","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"大灯延时关闭","modelexcessids":[{"id":40040,"value":"●"}],"url":""},{"name":"触摸式阅读灯","modelexcessids":[{"id":40040,"value":"-"}],"url":""}]},{"itemtype":"玻璃/后视镜","items":[{"name":"前/后电动车窗","modelexcessids":[{"id":40040,"value":"前● / 后●"}],"url":""},{"name":"车窗防夹手功能","modelexcessids":[{"id":40040,"value":"●"}],"url":""},{"name":"后风挡遮阳帘","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"后排侧隐私玻璃","modelexcessids":[{"id":40040,"value":"●"}],"url":""},{"name":"后雨刷","modelexcessids":[{"id":40040,"value":"●"}],"url":""},{"name":"可加热喷水嘴","modelexcessids":[{"id":40040,"value":"-"}],"url":""}]},{"itemtype":"空调/冰箱","items":[{"name":"后排独立空调","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"后座出风口","modelexcessids":[{"id":40040,"value":"●"}],"url":""},{"name":"温度分区控制","modelexcessids":[{"id":40040,"value":"●"}],"url":""},{"name":"车载空气净化器","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"车内PM2.5过滤装置","modelexcessids":[{"id":40040,"value":"●"}],"url":""},{"name":"负离子发生器","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"车内香氛装置","modelexcessids":[{"id":40040,"value":"-"}],"url":""},{"name":"车载冰箱","modelexcessids":[{"id":40040,"value":"-"}],"url":""}]}],"bigpicprefix":"w_","floorprice":[{"name":"最底价","modelexcessids":[{"orderurl":"","id":40040,"value":"false,低价购车"}],"url":""}],"smallpicprefix":"s_"},"returncode":0,"cdntime":1573003649,"message":""}';
//        $data = json_decode($data,true);
//        dump($data);die;








        $this->AuthRuleModel = new AuthRuleModel();
        $this->AdminModel = new AdminModel();

        if(!Cache::get('rules')){
            $rules = $this->AuthRuleModel->getAll(['status' => 1]);
            Cache::put('rules', $rules, 3600);

        }


    }

    public function handle($request, Closure $next)
    {

        if (session()->get('aid')) {
            $not_auth_list = ['admin/index/index','admin/index/main'];
            $not_auth_list = $this->AuthRuleModel->getPluck(['authopen' => 1],'href');
            $not_auth_list[] = 'admin/index/index';
            $not_auth_list[] = 'admin/index/main';

            if(in_array($request->path(),$not_auth_list)){

                return $next($request);
            }else{
                if(session()->get('aid') == 1){
                    return $next($request);
                }else{

                    $rules = Cache::get('rules');

                    $user_rules = $this->AdminModel->getRules(session()->get('aid'));

                    $user_rules = explode(',',$user_rules);
                    $user_auth = [];
                    //dd($rules);die;
                    $rule = '';
                    foreach($rules as $rules_k => $rules_v){
                        if($rules_v['href'] == $request->path()){
                            $rule = $rules_v['id'];
                        }
                    }

                    if(!$rule){
                        return $next($request);
                    }

                    foreach($user_rules as $user_rules_v){
                        if($user_rules_v == $rule){
                            return $next($request);
                        }
                    }
                    //return redirect(url()->previous());
                    return redirect('/admin/index/index');
                }
            }

        }
        return redirect('/admin/login/index');
    }
}
