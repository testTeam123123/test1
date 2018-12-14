<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/10
 * Time: 9:42
 */

namespace app\admin\validate;

use app\admin\model\GoodsType;
use think\Validate;

class GoodsTypeAttribute extends Validate
{
    protected $rule = [
        'type_name' => 'require|nameOnly:type_name'
    ];

    protected $message = [
        'type_name.require' => '属性名称不能为空'
    ];

    protected $scene = [
        'add' => ['type_name']
    ];

    protected function nameOnly($value)
    {
        $data = new GoodsType();
        if (!empty(input('post.parent_idd'))) {
            $rule = $data->where('parent_id!='.input('post.parent_idd'))
                ->where('parent_id', input('post.parent_id'))
                ->where('type_name' , $value)->find();

            return (count($rule)>0) ? '属性名称重复' : true;
        } else {
            $rule = $data->where( [
                'type_name' => $value,
                'parent_id' => input('post.type_id')
            ])->find();
            return (count($rule)>0) ? '属性名称重复' : true;
        }
    }
}