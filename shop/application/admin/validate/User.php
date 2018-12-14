<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/10
 * Time: 11:05
 */

namespace app\admin\validate;


use app\admin\model\Admin;
use think\Validate;

class User extends Validate
{
    protected $rule = [
        'admin_number' => 'require|numberField:admin_number',
        'admin_password' => 'require|pwdSure:admin_password'
    ];

    protected $message = [
        'admin_number.require' => '编号不能为空',
        'admin_password.require' => '密码不能为空',
        'admin_number.numberField' => '编号不存在'
    ];

    /**
     * 用户名是否存在
     * @param $value
     * @return bool|string
     */
    protected function numberField ($value)
    {
        $data = new Admin();
        $rule = $data->where('admin_number='.$value)->find();
        return (count($rule)>0) ? true : '编号不存在';
    }
    protected function pwdSure ($value)
    {
        $data = new Admin();
        $rule = $data->where([
            'admin_number' => input('post.admin_number'),
            'admin_password' => $value
        ])->find();
        return (count($rule)>0) ? true : '密码有误';
    }
}