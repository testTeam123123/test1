<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/10
 * Time: 15:53
 */

namespace app\admin\controller;


use app\admin\model\GoodsType;
use app\admin\model\GoodsTypeAttribute;
use think\Controller;
use think\Db;
use think\Hook;

class Goods extends Controller
{


    public function index()
    {

        $model = new GoodsType();
        $type = $model->where('parent_id',0)->select();
//        dump($type);
        return view('index',[
            'type' => $type
        ]);
    }

    /**
     * 获取商品类别属性
     * @return \think\response\Json
     */
    public function obtainAttr()
    {
//        return input('post.');
        if (request()->isPost()) {
            if (input('post.parent_id') != '0') {
                $model = new GoodsType();
                $result = $model->where('parent_id', input('post.parent_id'))->select();
                $where = '';
                foreach ($result as  $val) {
                    $where = ($where == '')
                        ? 'parent_id='.$val['type_id']
                        : $where.' OR parent_id='.$val['type_id'];
                }
//                return $where;
                $listData = $model->where($where)->select();
                if ($result) {
                    return json([
                        'status' => 200,
                        'msg' => $result,
                        'list' => $listData
                    ]);
                } else {
                    return json([
                        'status' => 401,
                        'msg' => '获取失败'
                    ]);
                }
            }
        }
    }

    /**
     * 上传商品图片
     * @return \think\response\Json
     */
    public function addImg()
    {
//        return $_FILES['files'];
        // 获取表单上传文件
        $file = request()->file('files');
        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->move(ROOT_PATH . 'public' . DS . 'static'. DS . 'img' .DS . 'large');
            if($info){
                // 成功上传后 获取上传信息
                // 输出 jpg
//                echo $info->getExtension();
                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
//                echo $info->getSaveName();
                // 输出 42a79759f284b767dfcb2a0197904287.jpg
//                echo $info->getFilename();
                return json([
                    'status' => 200,
                    'msg'=>'/static/img/large/'. $info->getSaveName()
                ]);
            }else{
                // 上传失败获取错误信息
                return json([
                    'status' => 401,
                    'msg'=>$file->getError()
                ]);
            }
        }


    }

    /**
     * 添加商品
     * @return \think\response\Json
     */
    public function addGoods()
    {
//        return input('post.');
        if (request()->isPost()) {

            $validate = validate('Goods');
             if (!$validate->batch()->check([
                 'goods_number' => input('post.goods_number'),
                 'goods_name' => input('post.goods_name'),
                 'goods_count' => input('post.goods_count'),
                 'goods_sell_price' => input('post.goods_sell_price'),
                 'type_id' => input('post.type_id')
             ])) {
                 if (empty(input('post.goods_img/a'))) {
                     return json([
                         'status' => 402,
                         'data' => input('post.'),
                         'msg' => $validate->getError(),
                         'img_error' => '图片不能为空'
                     ]);
                 } else {
                     return json([
                         'status' => 402,
                         'data' => input('post.'),
                         'msg' => $validate->getError()
                     ]);
                 }

             }
            Db::startTrans();
            try{
                $type_arr = input('post.type_arr/a');
                $img_arr = input('post.goods_img/a');
                Db::name('goods')->insert([
                    'goods_number' => input('post.goods_number'),
                    'goods_name' => input('post.goods_name'),
                    'goods_count' => input('post.goods_count'),
                    'goods_enter_price' => round(floatval(input('post.goods_enter_price')), 2),
                    'goods_sell_price' => round(floatval(input('post.goods_sell_price')), 2),
                    'goods_content' => input('post.goods_content'),
                    'goods_add_time' => date('Y-m-d H:i:s', time()),
                    'goods_update_time' =>date('Y-m-d H:i:s', time()),
                ]);


                foreach ($type_arr as  $type) {

                    Db::name('type')->insert([
                        'goods_number' => input('post.goods_number'),
                        'type_id' => input('post.type_id'),
                        'type_attr_id' => $type[0],
                        'type_attr_val' => $type[1]
                    ]);
                }
                foreach ($img_arr as $img) {
                    Db::name('goods_img')->insert([
                        'goods_number' => input('post.type_id'),
                        'img_src' => $img,
                        'img_type' => 1
                    ]);
                }
                Db::commit();
                return json([
                    'status' => 200,
                    'msg'=> '添加成功'
                ]);
            } catch (\Exception $e) {
                Db::rollback();
                return json([
                    'status' => 401,
                    'msg'=> '添加失败'
                ]);
            }
        }
    }

    public function goodsList()
    {
        return view();
    }
}