<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/12
 * Time: 16:12
 */

namespace app\index\behavior;
class Axios
{
    public function run(&$params)
    {
        header('Access-Control-Allow-Origin:*');//允许访问的域（跨域url地址）
        header('Access-Control-Allow-Methods:*');//允许的请求类型
        header('Access-Control-Allow-Headers:*');//允许接受的header头信息
        header('Access-Control-Allow-Credentials:false');//是否带证书
    }
}