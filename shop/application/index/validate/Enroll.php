<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/12
 * Time: 18:01
 */
namespace app\index\validate;

use think\Validate;

class Enroll extends Validate
{
    protected $rule = [
        'user_name' => 'require|unique:user|max:8',
        'user_password' => 'require|min:6|max:16',
        'user_email' => 'require|email',
//        'user_phone' => 'require|regex:((13[0-9])|(14[5|7])|(15([0-3]|[5-9]))|(18[0,5-9]))\\d{8}',
        'user_phone' => 'require|/^1[3-8]{1}[0-9]{9}$/',
        'img|验证码' => 'require'
    ];

    protected $message = [
        'user_name.require' => '用户名不能为空',
        'user_name.max' => '用户名请设置1~8位',
        'user_name.unique' => '用户名已存在',
        'user_password.require' => '密码不能为空',
        'user_password.min' => '密码请设置在6~16位',
        'user_password.max' => '密码请设置在6~16位',
        'user_email.require' => '邮箱不能为空',
        'user_email.email' => '邮箱格式不正确',
        'user_phone.require' => '手机号不能为空',
        'user_phone./^1[3-8]{1}[0-9]{9}$/' => '手机格式不正确',
        'img:require' => '验证码不能为空'
    ];







}