<?php
namespace App\Http\Models\Admin;
use Illuminate\Support\Facades\DB;
use App\Http\Factorys\Admin\ModelFactory;


class AuthRuleModel extends ModelFactory
{
    protected $table = 'auth_rule';
    public function __construct()
    {
        parent::__construct($this->table);
        parent::UPDATED_AT;
    }

    public function getAll($where = [])
    {
        //DB::connection()->enableQueryLog();#开启执行日志

        $res = $this->where($where)->orderBy('sort','asc')->get()->toArray();



        //print_r(DB::getQueryLog());die;

        return $res;
    }
    public function getPluck($where,$pluck)
    {
        $res = $this->where($where)->orderBy('sort','asc')->pluck($pluck)->toArray();
        return $res;
    }
    public function editStatus($where = [],$data)
    {
        $res = $this->where($where)->update($data);
        return $res;
    }
//    public function queryOne($data)
//    {
//        $res = $this->where($data)->first();
//        if($res){
//            $res->toArray();
//        }
//        return $res;
//    }
//    public function del($where)
//    {
//        $res = $this->whereRaw($where)->delete();
//        return $res;
//    }
//    public function add($data)
//    {
//        $res = $this->insert($data);
//        return $res;
//    }
//    public function edit($where,$data)
//    {
//        $res = $this->whereRaw($where)->update($data);
//        return $res;
//    }
}