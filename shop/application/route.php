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

\think\Route::domain('admin.myshop1.com','admin');
\think\Route::resource('login', 'index/login');
\think\Route::resource('index', 'index/index');
\think\Route::resource('enroll', 'index/enroll');
return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

    'login' => ['index/login/save',['method' => 'OPTIONS']],
    'enroll' => ['index/enroll/save',['method' => 'OPTIONS']]
];
