<?php

namespace App\Http\Factorys\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class ControllerFactory extends Controller
{
    private $type;
    private $class_name;
    protected $Request;
    public function __construct()
    {
        $this->type = [_ADMIN_CONTROLLERS_FACTORY,_ADMIN_MODELS_FACTORY];
        $this->Request = Request();
    }

    protected function newObject(int $type = 0,$name)
    {
        $name .= $type ? 'Model' : 'Controller' ;
        $this->class_name = $this->type[$type].$name;
        return new $this->class_name();
    }


}