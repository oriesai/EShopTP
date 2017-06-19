<?php
/**
 * Created by PhpStorm.
 * User: Michie
 * Date: 6/15/2017
 * Time: 7:47 PM
 */

namespace Admin\Model;
use Think\Model;

class ProductAttributeModel extends Model{
    public function addAllAttr($product_id,$data){
        foreach($data['attr_cate_ids'] as $k =>$v){
            $info['product_id'] =$product_id;
            $info['attr_cate_id']=$v;
            ///attr values corresponds to attr ids' key
            $info['attr_value'] =$data['attr_values'][$k];
            //add fields into product attribute table
            $res = $this->add($info);
            if(!$res){
                $this->error ='addition of attributes failed!';
                return false;
            }
        }
            return true;
    }
}