<?php
/**
 * Created by PhpStorm.
 * User: Michie
 * Date: 6/18/2017
 * Time: 7:15 PM
 */

namespace Admin\Controller;

use Think\Controller;

class CommonController extends Controller
{
    public function __construct(){
        parent::__construct();
        //array that doesnt need to be verified
        $action =array('index/login','index/logout','index/code','index');
        //check if the controller action is in the verify-free array using TP constant and chang all input letters in lower case
        $res = in_array(strtolower(CONTROLLER_NAME.'/'.ACTION_NAME),$action);
        //if its not in the verify array and the session does not have login status, jump to login page
        if(!$res && session(is_login)!=1){
            $this->error('please login first!',U('Admin/index/login'));
        }
    }

}