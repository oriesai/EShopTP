<?php
/**
 * Created by PhpStorm.
 * User: Michie
 * Date: 6/15/2017
 * Time: 1:34 PM
 */
namespace Admin\Model;
use Think\Model;
class ProductTypeModel extends Model{
    protected $_validate = array(
        array('type_name','require','product type is a required field!',3),
    );

    //get all product type------------------------------
    public function getAll(){
        //make split page
        $count = $this->count();
        $Page = new \Think\Page($count,2);
        $data['style']=$Page ->show();
        $data['list']=$this->field('type_id,type_name')->limit($Page->firstRow.','.$Page->listRows)->select();
        return $data;
    }

    public function getTypeById($type_id){
        $data=$this->field('type_id,type_name')->where('type_id='.$type_id)->find();
        return $data;
    }

    public function updateTypeById($type_id){
        $res = $this->save($type_id);
        return $res;
    }

    public function deleteTypeById($type_id){
        return $res = $this->delete($type_id);
    }
}