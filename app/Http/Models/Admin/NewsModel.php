<?php
namespace App\Http\Models\Admin;
use Illuminate\Support\Facades\DB;
use App\Http\Factorys\Admin\ModelFactory;
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
        $res = $this->whereRaw($where)->orderBy('hide','asc','sort','asc')->get()->toArray();
        return $res;
    }
    public function getList($where = '')
    {
        //DB::connection()->enableQueryLog();#开启执行日志
        $res = /*$this->with(['newsTopic' => function($query){
                $query->select('news_topic_id','main_id')->with(['news' => function($query1){
                    $query1->select('id','title as news_topic_name');
                    }]);
                }])->whereRaw($where)*/
            $this->with(['userInfo' => function($query){$query->select('id','username','headImg');}])
            ->whereRaw($where)->orderBy('id','desc')
            ->paginate(config('common.pageSize'))
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
        $res = $this->with(['newsInfo' => function($query){$query->select('id','news_id','desc','url','type');},'newsTopic' => function($query){
                    $query->select('news_id','main_id','title');
                }])
            ->whereRaw($where)->first()
            ->toArray();
        return $res;
    }

    public function newsInfo()
    {
        //关联model 关联表的字段    本表的字段
        return $this->hasMany(_ADMIN_MODELS_FACTORY."NewsInfoModel", "news_id", "id");
    }
    public function userInfo()
    {
        //关联model 关联表的字段    本表的字段
        return $this->belongsTo(_ADMIN_MODELS_FACTORY."UserModel", "publisher_id", "id");
    }
    public function newsTopic()
    {
        return $this->hasMany(_ADMIN_MODELS_FACTORY."NewsTopicModel", "news_id", "id");
    }
}