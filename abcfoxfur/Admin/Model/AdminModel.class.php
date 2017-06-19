<?php
/**
 * Created by PhpStorm.
 * User: Michie
 * Date: 6/18/2017
 * Time: 3:49 PM
 */
namespace Admin\Model;

use Think\Model;

class AdminModel extends Model{
    protected $_auto =array(
//        auto encryption with password field once model is created
      array('password','encryption',3,'callback')
    );

    protected function encryption($data){
        return password($data,$_POST['salt']);
    }
}