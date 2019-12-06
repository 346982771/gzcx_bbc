<?php
namespace App\Http\Models\Api;
use Illuminate\Support\Facades\DB;
use App\Http\Factorys\Api\ModelFactory;
class NewsModel extends ModelFactory
{
    protected $table = 'news';

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
        $res = $this->whereRaw($where)->orderBy('hide','asc')->orderBy('sort','asc')->get()->toArray();
        return $res;
    }
    public function getList($where = '',$order = 'create_time desc')
    {
        //DB::connection()->enableQueryLog();#开启执行日志
        $res = $this->with(['userInfo' => function($query){$query->select('id','headImg','username');}])->whereRaw($where)
            ->select('*')
            ->orderByRaw($order)
            ->paginate(config('common.apiPageSize'))
            ->toArray();
        //print_r(DB::getQueryLog());die;
        return $res;
    }

    public function editStatus($where = [],$data)
    {
        $res = $this->where($where)->update($data);
        return $res;
    }
    public function queryOne($where = '')
    {
        $res = $this->with(['newsInfo' => function($query){
                    $query->select('id as news_info_id','news_id','desc','url','sort','video_cloud_id')->orderBy('sort','asc')
                        ->orderBy('id','asc');
                }])->select('title','id','topic','create_time','publisher_id','content','cover_url','praise_num','visited_num')
            ->whereRaw($where)->first();
        return $res;
    }

    public function newsInfo()
    {
        //关联model 关联表的字段    本表的字段
        return $this->hasMany(_API_MODELS_FACTORY."NewsInfoModel", "news_id", "id");
    }
    public function userInfo()
    {
        //关联model 本表的字段
        return $this->belongsTo(_API_MODELS_FACTORY."UserModel", 'publisher_id', 'id');
        //return $this->hasOne(_API_MODELS_FACTORY."UserModel","id","publisher_id");
    }
}