<?php
namespace App\Http\Models\Admin;
use Illuminate\Support\Facades\DB;
use App\Http\Factorys\Admin\ModelFactory;
class NewsTopicModel extends ModelFactory
{
    protected $table = 'news_topic';

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
        $res = $this->whereRaw($where)->orderBy('id','desc')->limit(200)->get()->toArray();
        return $res;
    }
    public function getList($where = '')
    {
        $res = $this->whereRaw($where)
            ->paginate(config('common.pageSize'))
            ->toArray();
        return $res;
    }
    public function editStatus($where = [],$data)
    {
        $res = $this->where($where)->update($data);
        return $res;
    }

    public function getPluck($where,$field)
    {
        $res = $this->whereRaw($where)->pluck($field)->toArray();
        return $res;
    }
    public function news()
    {
        return $this->hasOne(_ADMIN_MODELS_FACTORY."TopicModel",'id','main_id');
    }
}