<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;

// return [
//     '__pattern__' => [
//         'name' => '\w+',
//     ],
//     '[hello]'     => [
//         ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//         ':name' => ['index/hello', ['method' => 'post']],
//     ],

// ];

// Route::get('/','home/index/demo');
// todo 多级控制器 =》 模块、控制器、方法
// Route::get('/user/base/index','home/User.Base/index');

// ! 多级路由写法
Route::group('user',[
    '/base/index' => ['home/User.Base/index',['method' => 'get']],
    // '/base/login' => ['index/User.Base/login',['method' => 'get']]
]);