<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/9
 * Time: 15:39
 */

namespace app\admin\controller;


use app\admin\model\GoodsType;
use app\admin\model\GoodsTypeAttribute;
use think\Controller;

class GoodsTypes extends Controller
{
    public function index()
    {
//        $data = GoodsType::all();
        $model = new GoodsType();
        $data = $model->field('tp_goods_type.type_id,tp_goods_type.type_name, COUNT(attribute_id) as attribute')
            ->join('tp_goods_type_attribute ','tp_goods_type.type_name=tp_goods_type_attribute.type_name','LEFT')
            ->group('type_name')->select();
//        dump($data);
        return view('index', [
            'data' => $data
        ]);
    }

    /**
     * 添加商品类别
     * @return \think\response\Json
     */
    public function add()
    {
//        return input('post.type_name');
        $validate = validate('GoodsTypes');
        if (!$validate->batch()->scene('add')->check([
            'type_name' => input('post.type_name')
        ])) {
            return json([
                'status' => 402,
                'msg' => $validate->getError()
            ]);
        }

        if (request()->isPost()) {
            $add = new GoodsType(input('post.'));

            $result = $add->allowField(true)->save();
            if ($result) {
                return json([
                    'status' => 200,
                    'msg' => '添加成功'
                ]);
            }else {
                return json([
                    'status' =>401,
                    'msg' => '添加失败'
                ]);
            }
        }

    }

    public function update()
    {
//        return input('post.');
        $validate = validate('GoodsTypes');
        if (!$validate->batch()->scene('add')->check([
            'type_name' => input('post.type_name')
        ])) {
            return json([
                'status' => 402,
                'msg' => $validate->getError()
            ]);
        }

        if (request()->isPost()) {
            $update = GoodsType::get(input('post.type_id','/d'));
            $update->type_name = input('post.type_name');
            $result = $update->save();
            if ($result) {
                return json([
                    'status' => 200,
                    'msg' => '修改成功'
                ]);
            }else {
                return json([
                    'status' =>401,
                    'msg' => '修改失败'
                ]);
            }
        }
    }

    /**
     * 商品属性列表
     * @return \think\response\View
     */
    public function attributesList()
    {
        $this->assign('type_name', input('get.type_name'));
        $data = GoodsTypeAttribute::all(["type_name" => input('get.type_name')]);

        return view('attribute', [
            'data' => $data
        ]);
    }

    public function attributeAdd()
    {
//        return input('post.');

        $validate = validate('GoodsTypeAttribute');
        if (!$validate->batch()->scene('add')->check([
            'attribute_name' => input('post.attribute_name')
        ])) {
            return json([
                'status' => 402,
                'msg' => $validate->getError()
            ]);
        }

        if (request()->isPost()) {
            $add = new GoodsTypeAttribute(request()->param());
            $result = $add->allowField(true)->save();
            if ($result) {
                return json([
                    'status' => 200,
                    'msg' => '添加成功'
                ]);
            }else {
                return json([
                    'status' =>401,
                    'msg' => '添加失败'
                ]);
            }
        }
    }
}