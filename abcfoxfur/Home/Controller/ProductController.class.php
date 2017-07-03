<?php
/**
 * Created by PhpStorm.
 * User: Michie
 * Date: 6/20/2017
 * Time: 8:22 AM
 */
namespace Home\Controller;
use Think\Controller;
class ProductController extends Controller{
    public function index(){
        $this->display();
    }

    public function detail(){
        //retrieve product id from get
        $product_id = I('get.id',0,'intval');
       //retrieve product details
        $this->info=D('product')->find($product_id);
        if(!$this->info || $product_id <1){
            $this->error('illegal request!');die;
        }
        //retrieve product photos for the product id
        $this->photos = D('product_photos')->where("product_id=$product_id")->select();
         //retrieve product attributes , as the attr name is stored as attr id in the table,  we have to use join query to ge tthe attr name in product attr cate
        //fetch attr unique key

        $this->attr_simple =D('Product_attribute')->alias('pa')->field('pa.attr_id,attr_value,attr_cate_name')->join('LEFT JOIN __PRODUCT_ATTRIBUTE_CATE__ as a on a.attr_cate_id=pa.attr_cate_id')->where("pa.product_id=$product_id AND attr_cate_exp = 0")->select();
        //fetch attr list key
    $attrs =D('Product_attribute')->alias('pa')->field('pa.attr_id,attr_value,attr_cate_name')->join('LEFT JOIN __PRODUCT_ATTRIBUTE_CATE__ as a on a.attr_cate_id=pa.attr_cate_id')->where("pa.product_id=$product_id AND attr_cate_exp = 1")->select();
        //put info in a 2d array to get out list items according to attr cate
        $data =[];
        foreach($attrs as $item){
            $data[$item['attr_cate_name']][] =$item;
        }
//        p($data);
        $this->attr_radio =$data;
        $this->display();
    }
}