<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/9
 * Time: 21:57
 */

namespace app\admin\validate;


use think\Validate;

class GoodsTypes extends Validate
{

    protected $rule = [
      'type_name' => 'require|unique:goods_type'
    ];

    protected $message = [
        'type_name.require' => '类别名称不能为空',
        'type_name.unique' => '类别名称重复',
    ];

    protected $scene = [
        'add' => ['type_name']
    ];

}