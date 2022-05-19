<?php

namespace app\home\controller;

// todo 使用公共文件里的Home控制器
use app\common\controller\Home;

// todo 继承公共控制器Hone
class User extends Home
{
    public function index()
    {

        return $this->fetch();
    }
}
