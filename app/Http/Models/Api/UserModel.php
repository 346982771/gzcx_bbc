<?php
namespace App\Http\Models\Api;
use Illuminate\Support\Facades\DB;
use App\Http\Factorys\Api\ModelFactory;
class UserModel extends ModelFactory
{
    protected $table = 'user';

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

    public function getAll($where = '1 = 1')
    {
        $res = $this->whereRaw($where)->orderBy('hide','asc','sort','asc')->get()->toArray();
        return $res;
    }
    public function getList($where = '')
    {
        $res = $this->whereRaw($where)
            ->paginate(config('common.apiPageSize'))
            ->toArray();
        return $res;
    }
    public function editStatus($where = [],$data)
    {
        $res = $this->where($where)->update($data);
        return $res;
    }

    public function news()
    {
        //关联model 关联表的字段    本表的字段
        return $this->hasMany(_API_MODELS_FACTORY."NewsInfoModel", "publisher_id", "id");

    }


}