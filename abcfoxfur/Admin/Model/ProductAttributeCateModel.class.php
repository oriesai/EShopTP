<?php
/**
 * Created by PhpStorm.
 * User: Michie
 * Date: 6/15/2017
 * Time: 7:35 PM
 */
namespace Admin\Model;
use Think\Model;

class ProductAttributeCateModel extends Model{
    public function getAttrCatesById($type_id){
        //as we have to get the product names instead of product id, we need to use join query to get all category info and product name
        //__product_type__ is an thinkphp weay to avoid different prefix for tables
       return $this->alias('attr')->join('LEFT JOIN __PRODUCT_TYPE__ pt ON attr.type_id=pt.type_id')->where('attr.type_id='.$type_id)->select();
    }

}