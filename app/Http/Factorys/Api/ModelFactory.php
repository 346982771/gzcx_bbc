<?php

namespace App\Http\Factorys\Api;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
class ModelFactory extends Model
{
    private $type;
    private $class_name;
    private $table_name;
    //public $execute;

    const UPDATED_AT = null;
    public function __construct($table_name)
    {
        $this->type = [_API_CONTROLLERS_FACTORY,_API_MODELS_FACTORY];
        $this->table_name = $table_name;

        //$this->execute = $this->execute ? $this->execute : DB::table($this->table_name);
    }

    protected function newObject(int $type = 0,$name)
    {
        $table_name = model_name_to_table_name($name);
        $name .= $type ? 'Model' : 'Controller' ;
        $this->class_name = $this->type[$type].$name;
        return new $this->class_name();
    }
    public function queryOne($data)
    {

        $res = DB::table($this->table_name)->where($data)->first();
        return $res;
    }
    public function del($where)
    {
        $res = DB::table($this->table_name)->whereRaw($where)->delete();
        return $res;
    }
    public function add($data)
    {

        //DB::connection()->enableQueryLog();#开启执行日志
        $res = DB::table($this->table_name)->insert($data);

        //print_r(DB::getQueryLog());die;
        return $res;
    }
    public function edit($where,$data)
    {
        $res = DB::table($this->table_name)->whereRaw($where)->update($data);
        return $res;
    }
    public function fieldIncrement($where,$field,$num)
    {
        $res = DB::table($this->table_name)->whereRaw($where)->increment($field,$num);
        return $res;
    }
    public function fieldDecrement($where,$field,$num)
    {
        $res = DB::table($this->table_name)->whereRaw($where)->increment($field,$num);
        return $res;
    }
    public function getInsertId($data)
    {
        $res = DB::table($this->table_name)->insertGetId($data);
        return $res;
    }
    public function getValue($where,$value)
    {
        $res = DB::table($this->table_name)->where($where)->value($value);
        return $res;
    }
}