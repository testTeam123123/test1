<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/9
 * Time: 21:57
 */

namespace app\admin\validate;


use app\admin\model\GoodsType;
use think\Validate;

class GoodsTypes extends Validate
{

    protected $rule = [
      'type_name' => 'require|nameOnly:type_name'
    ];

    protected $message = [
        'type_name.require' => '类别名称不能为空'
    ];

    protected $scene = [
        'add' => ['type_name']
    ];

    protected function nameOnly($value)
    {
        $data = new GoodsType();
        if (!empty(input('post.parent_idd'))) {
            $rule = $data->where('attribute_id!='.input('post.parent_id'))
                ->where('parent_id', input('post.type_id'))
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