<?php

namespace  app\admin\behavior;
use think\Session;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/10
 * Time: 23:08
 */

class Login
{
    public function run(&$params) {
        if (!session('?id')) {
//            dump('session为空');
            return redirect("/user/login");
        }
    }



}