<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/10
 * Time: 11:04
 */

namespace app\admin\controller;


use app\admin\model\Admin;
use think\Controller;
use think\Hook;
use think\Session;

class User extends Controller
{

    public function login()
    {

        if (request()->isPost()) {
            $validate = validate('User');
            if (!$validate->batch()->check(input('post.'))) {
//                dump($validate->getError());
                $this->assign('error',$validate->getError());
                $this->assign('from',input('post.'));
            }else {
                Session::set('id', input('post.admin_number'));
                $data= new Admin();
                $data->where('admin_number="'.input('post.admin_number').'"')->update([
                    'admin_time' => date('Y-m-d H:i:s')
                ]);
                return redirect('/index/index');
            }

        }
        return view('login');
    }
}