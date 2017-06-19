<?php
/**
 * Created by PhpStorm.
 * User: Michie
 * Date: 6/18/2017
 * Time: 3:49 PM
 */
namespace Admin\Model;

use Think\Model;

class AuthModel extends Model{
    public function getAuth($where='auth_pid=0'){
        return $this->where($where)->select();
    }
}