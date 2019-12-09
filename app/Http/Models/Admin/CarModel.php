<?php
namespace App\Http\Models\Admin;
use Illuminate\Support\Facades\DB;
use App\Http\Factorys\Admin\ModelFactory;
class CarModel extends ModelFactory
{
    protected $table = 'car';

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
        $res = Db::table($this->table.' as c')->leftJoin('car_type as ct','c.type','=','ct.id')
            ->leftJoin('car_brand as cb','c.brand','=','cb.id')
            ->leftJoin('car_brand as cb1','c.brand1','=','cb1.id')->whereRaw($where)
            ->select('c.*','ct.title as type_title','cb.title as brand_title','cb1.title as brand1_title')
            ->paginate(config('common.pageSize'))
            ->toArray();
        return $res;
    }
    public function editStatus($where = [],$data)
    {
        $res = $this->where($where)->update($data);
        return $res;
    }


}