<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/12
 * Time: 23:56
 */

namespace app\index\validate;


use app\index\model\User;
use think\Validate;

class Login extends Validate
{

    protected $rule = [
        'user_name' => 'require|nameField',
        'user_password' => 'require|pwdSure'
    ];

    protected $message = [
        'user_name.require' => '用户名不能为空',
        'user_password.require' => '密码不能为空',
        'user_name.nameField' => '用户名不存在',
        'user_password.pwdSure' => '密码有误'

    ];

    /**
     * 用户名是否存在
     * @param $value
     * @return bool|string
     */
    protected function nameField ($value)
    {

        $data = new User();
        $rule = $data->where('user_name',$value)->find();
        return (count($rule) > 0) ? true : '用户名不存在';
//        $rule = $data->where('user_name='.$value)->find();
//        return (count($rule)>0) ? true : '用户名不存在';
    }
    /*
     * 密码是否正确
     */
    protected function pwdSure ($value, $rule, $data)
    {
//        unset($rule);
        $datas = new User();
        $rule = $datas->where([
            'user_name' => $data['user_name'],
            'user_password' => md5($value)
        ])->find();
        return (count($rule)>0) ? true : '密码有误';
    }
}