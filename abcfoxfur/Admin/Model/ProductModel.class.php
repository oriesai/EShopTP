<?php
/**
 * Created by PhpStorm.
 * User: Michie
 * Date: 6/13/2017
 * Time: 5:47 PM
 */
namespace Admin\Model;
use Think\Model;

class ProductModel extends Model{
//    set _map _verification _auto
    protected $_auto =array(
        //1=auto when created only, time is system function
        array('created_time','time',1,'function'),
        //3=auto when created and update
        array('updated_time','gettime',3,'callback'),
    );
    protected $_validate = array(
      array('product_name','require','product name is required'),
        array('product_name','','product exists',1,'unique',3) //ensure name is unique
    );
    protected $_map = array(
      'title' =>'product_name',  //prevent user from knowing its product name
    );

    //default data uses null as if the product info is newly created, then return a timestamp, if it is an update of time, turn the string from data array to timestamp and store it in create()
    protected function gettime($data=null){
        if($data){
            return strtotime($data);
        }
        return time();  //get current timestamp
}
}
