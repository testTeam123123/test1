<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/9
 * Time: 23:27
 */

namespace app\admin\model;


use think\Model;

class GoodsTypeAttribute extends Model
{
    public function goodsType()
    {
        return $this->belongsTo('goods_type','type_id','type_id')->field('type_name');
    }
}