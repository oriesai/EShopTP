<?php
/**
 * Created by PhpStorm.
 * User: Michie
 * Date: 6/15/2017
 * Time: 4:50 PM
 */
namespace Admin\Controller;
use Think\Controller;

class ProductAttributeCateController extends Controller{
    public function index(){
        $this->type_id = I('get.type_id',0,'intval');
        //get all attributes categories from product type
        $this->list = D('ProductAttributeCate')->getAttrCatesById($this->type_id);
        $this->display();
    }

//adding product attribute category-------------------------------
    public function add(){
        if(IS_POST){
            $attrCate = D('ProductAttributeCate');
            if(!$attrCate->create()){
                $this->error($attrCate->getError());
            }
            //add new attr category to the table
            $res =$attrCate->add();
            if($res){
                //bring the new posted product type id back to the corresponding product attribute category list
                $this->success('added attibute category success!',U('index',array('type_id'=>I('post.type_id',0,'intval'))),10);die;
            }else{
                $this->error('add attribute category failed!');die;
            }
        }
        //assign product type id to view
        $this->type_id = I('get.type_id',0,'intval');
      $productType = D('ProductType');
      //asisgn product type list to view for product type traversal
      $this->type_list = $productType->select();
        $this->display();
    }
}