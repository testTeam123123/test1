<?php

namespace app\index\controller;

use Firebase\JWT\JWT;
use think\Controller;
use think\Hook;
use think\Request;

class Login extends Controller
{
    //token的密钥
    protected $tokenKey = '165&ascnjkcnzIUHUI@$34565hijiUIHUIH%IUH./.IOJIOUIHUIHSDIHCISDUIhuihihi';
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        Hook::listen('my_axios');
        $validate = validate('Login');
        if (!$validate->batch()->check(request()->param())) {
            return json([
                'status' => 401,
                'msg' => $validate->getError(),
                'dara' =>  input('post.')
            ]);
        }
        //存token
//        $token = [
//            'iss' => 'http://myshop1.com',//issuer 请求实体，可以是发起请求的用户的信息，也可是jwt的签发者
//            'aud' => 'http://localhost:9099',//接收jwt的一方
//            'nbf' => 0,//当前时间在nbf设定时间之前，该token无法使用
//            'exp' => time()+600,//token过期时间
//            'data' => [
//                'userId' => '1',
//                'username' => input('post.user_name')
//            ]
//        ];
//
//        $jwt = JWT::encode($token,$this->tokenKey);
        return json([
            'status' => 200,
            'msg' => '登录成功',
//            'token' => $jwt
        ]);


    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
