<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/12
 * Time: 15:08
 */

namespace app\admin\validate;


use think\Validate;

class Goods extends Validate
{
    protected $rule = [
        'goods_number' => 'require|unique:goods',
        'goods_name' => 'require',
        'goods_count' => 'require',
        'goods_sell_price' => 'require',
        'type_id' => 'type:type_id',
        'goods_img' => 'array'
    ];

    protected $message = [
        'goods_number.require' => '商品编号不能为空',
        'goods_number.unique' => '商品编号不能重复',
        'goods_name.require' => '商品名称不能为空',
        'goods_count.require' => '商品库存不能为空',
        'goods_sell_price.require' => '商品售价不能为空',
        'type_id.type' => '商品类别不能为空'
    ];


    public function type($val)
    {
        return ($val != '0')?true:'商品类别不能为空';
    }
}