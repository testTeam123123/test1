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
use think\Db;
use think\Exception;
use think\Hook;
use think\Request;

class GoodsTypes extends Controller
{


    public function index()
    {
//        Hook::listen('action_begin');
//        $data = GoodsType::all();
        $model = new GoodsType();
//        $data = $model->field('tp_goods_type.type_id,tp_goods_type.type_name, COUNT(attribute_id) as attribute')
//            ->join('tp_goods_type_attribute ','tp_goods_type.type_id=tp_goods_type_attribute.type_id','LEFT')
//            ->group('type_name')->select();
//        dump($data);
//        return view('index', [
//            'data' => $data
//        ]);
        $data = $model->field("type_id, type_name ")->where('parent_id=0')->select();
        $count = [];
        foreach ($data as $id) {
            $list = $model->field('type_id')->where('parent_id', $id['type_id'])->count();
            $count[] .= $list;

        }

        return view('index',[
            'data' => $data,
            'count' => $count
        ]);
    }

    /**
     * 添加商品类别
     * @return \think\response\Json
     */
    public function add()
    {
//        Hook::listen('action_begin');
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

    /**
     * 修改商品类别
     * @return \think\response\Json
     */
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
     * 删除商品类别
     * @return \think\response\Json
     */
    public function delete()
    {
//        return input('post.');
        if (request()->isPost()) {
             GoodsType::destroy(['parent_id'=> input('post.type_id')]);
            $type = GoodsType::destroy(input('post.type_id'));
            if ($type) {
                return json([
                    'status' => 200,
                    'msg' => '删除成功'
                ]);
            }else {
                return json([
                    'status' =>401,
                    'msg' => '删除失败'
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
        $this->assign('type_id', input('get.type'));
////        $data = GoodsTypeAttribute::all(["type_id" => input('get.type')]);
//        $model = new GoodsTypeAttribute();
//        $type_name = $model->goodsType()->select();
//        $this->assign('type_name',$type_name[0]['type_name']);
//        $data = $model->where(["type_id" => input('get.type')])
//            ->order(['attribute_sort' => 'DESC'])->select();
//        return view('attribute', [
//            'data' => $data
//        ]);
        $model = new GoodsType();
        $parent = $model->field('type_name')->where('type_id', input('get.type'))->find();
        $data = $model->where('parent_id', input('get.type'))->select();
//        dump($data);
        $listData = [] ;
        foreach ($data as $id) {
            $list = $model->where('parent_id', $id['type_id'])->select();
            $nameArr = [];
            foreach ($list as $name) {
                $nameArr[] .= $name['type_name'];
            }
            $str = implode(',', $nameArr);
            $listData[] .= $str;

        }
        return view("attribute", [
            'data' => $data,
            'list' => $listData,
            'parent' =>$parent['type_name']
        ]);
    }

    /**
     * 商品属性添加
     * @return \think\response\Json
     */
    public function attributeAdd()
    {
//        return input('post.');
//        return dump(explode(',',  input('post.attribute_explain')));
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
//            $add = new GoodsTypeAttribute(request()->param());
//            $result = $add->allowField(true)->save();
//            return join(['aa']);
            Db::startTrans();
            try {
                $data = Request::instance()
                    ->only(['type_name', 'parent_id'], 'post');
                Db::name("goods_type")->insert($data);
                $type_id = Db::name('goods_type')->getLastInsID();
                $list = explode(',',  input('post.attribute_explain'));
                foreach ($list as $val) {
                    $listData = [
                        'parent_id' => $type_id,
                        'type_name' => $val
                    ];
                    Db::table('tp_goods_type')->insert($listData);
                }
                Db::commit();
                return json([
                    'status' => 200,
                    'msg' => '添加成功'
                ]);
            } catch (\Exception $e) {
                Db::rollback();
                return json([
                    'status' =>401,
                    'msg' => '添加失败'.$e
                ]);
            }
        }
    }

    /**
     * 商品属性修改
     * @return \think\response\Json
     */
    public function attributeUpdate()
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
//            die();
//            $update = new GoodsType();
//            $result = $update->allowField(true)->save(input('post.'),['attribute_id' => input('post.attribute_id')]);

//            if ($result) {
//                return json([
//                    'status' => 200,
//                    'msg' => '修改成功'
//                ]);
//            }else {
//                return json([
//                    'status' =>401,
//                    'msg' => '修改失败'
//                ]);
//            }


    }

    /**
     * 删除商品属性
     * @return \think\response\Json
     */
    public function attributeDelete()
    {
//        return input('post.');
        if (request()->isPost()) {
            $data = GoodsTypeAttribute::destroy(input('post.attribute_id'));
            if ($data) {
                return json([
                    'status' => 200,
                    'msg' => '删除成功'
                ]);
            }else {
                return json([
                    'status' =>401,
                    'msg' => '删除失败'
                ]);
            }
        }
    }
}