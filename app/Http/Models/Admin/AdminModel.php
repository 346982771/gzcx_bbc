<?php
namespace App\Http\Models\Admin;
use Illuminate\Support\Facades\DB;
use App\Http\Factorys\Admin\ModelFactory;
class AdminModel extends ModelFactory
{
    protected $table = 'admin';
    public function __construct()
    {
        parent::__construct($this->table);
        parent::UPDATED_AT;
    }
    public function getRules($id)
    {
//        DB::connection()->enableQueryLog();#开启执行日志
//        $sql = '(left join auth_rule as ar on ar.id in(ag.relus))';
        $res = Db::table('admin as a')->leftJoin('auth_group as ag','a.group_id','=','ag.group_id')->where('a.admin_id',$id)->value('ag.rules');
        //print_r(DB::getQueryLog());die;
        return $res;
    }
    public function getList($where = '')
    {

        $res = $this->with(['authGroup:group_id,title'])
            ->whereRaw($where)
            ->select('*')
            ->orderBy('create_time','desc')->paginate(config('common.pageSize'))
            ->toArray();
        return $res;
    }
    public function authGroup()
    {
        //关联model 关联表的字段    本表的字段
        return $this->hasOne("App\Http\Models\Admin\AuthGroupModel", "group_id", "group_id");
    }
}