<?php
/**
 * Created by PhpStorm.
 * User: Michie
 * Date: 6/13/2017
 * Time: 8:59 AM
 */
namespace Admin\Controller;
use Think\Controller;

class ProductsController extends Controller{
    public function index(){
        $this->display();
    }
    public function add(){
        if(IS_POST){  //receive data from post
            $products = D('Product');  // new model product
            if(!$data = $products->create()){  //if create failed, get error msg, validate, auto and map in model when create
                $this->error($products->getError());
            }
            $res = $products->add($data);  //add inserted data to db
            if($res){
                $this->success('input success');die;
            }else{
                $this->error('insert failed');
            }
        }
        $this->display();
    }
}