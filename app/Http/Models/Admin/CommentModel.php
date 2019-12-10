<?php
namespace App\Http\Models\Admin;
use Illuminate\Support\Facades\DB;
use App\Http\Factorys\Admin\ModelFactory;
class CommentModel extends ModelFactory
{
    protected $table = 'comment';
    public function __construct()
    {
        parent::__construct($this->table);
        parent::UPDATED_AT;
    }

    public function getValue($where,$value)
    {
        $res = $this->where($where)->value($value);
        return $res;
    }
    public function getMaxValue($where,$value,$order = '')
    {
        //DB::connection()->enableQueryLog();#开启执行日志
        $res = $this;
        if($where){
            $res->where($where);
        }
        $res = $res->orderByRaw($order)->value($value);
        //print_r(DB::getQueryLog());die;
        return $res;
    }
    public function getAll($where = '1 = 1')
    {
        $res = $this->whereRaw($where)
            ->orderBy('hide','asc')->orderBy('sort','asc')->get()->toArray();
        return $res;
    }
    public function getList($where = '')
    {
        //DB::connection()->enableQueryLog();#开启执行日志
        $res = $this->with(['userInfo' => function($query){$query->select('id','username','headImg');}])
            ->whereRaw($where)
            ->orderBy('id','desc')
            ->paginate(config('common.pageSize'))
            ->toArray();
        //print_r(DB::getQueryLog());die;
        return $res;
    }
    public function editStatus($where = [],$data)
    {
        $res = $this->whereRaw($where)->update($data);
        return $res;
    }
    public function queryOne($where = '')
    {
        $res = $this
            ->whereRaw($where)->first()
            ->toArray();
        return $res;
    }

    public function userInfo()
    {
        //关联model 关联表的字段    本表的字段
        return $this->belongsTo(_ADMIN_MODELS_FACTORY."UserModel", "publisher_id", "id");
    }

}