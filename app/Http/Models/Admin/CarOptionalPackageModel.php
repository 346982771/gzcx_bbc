<?php
namespace App\Http\Models\Admin;
use Illuminate\Support\Facades\DB;
use App\Http\Factorys\Admin\ModelFactory;
class CarOptionalPackageModel extends ModelFactory
{
    protected $table = 'car_optional_package';

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
        $res = $this->whereRaw($where)->orderBy('sort','asc','id','asc')->get()->toArray();
        return $res;
    }
    public function getList($where = '')
    {
        $res = $this->whereRaw($where)->orderBy('hide','asc','sort','asc')
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