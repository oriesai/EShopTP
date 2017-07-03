<?php
/**
 * Created by PhpStorm.
 * User: Michie
 * Date: 6/20/2017
 * Time: 9:20 AM
 */
namespace Home\Model;
use Think\Model;
class MemberModel extends Model{
    protected $_map = array(
        //reflection rules, fake name=> real name
        'username' =>'member_name',
        'password' =>'member_pwd',
        'mobile' =>'member_mobile',
        'email' =>'member_email'
    );

    //automatically create time, salt and encrypt pw
    protected $_auto = array(
      array('created_time','time',1,'function'),
        array('login_time','time',3,'function'),
        array('member_salt','createSalt',3,'callback'),
        array('member_pwd','password',3,'callback')
    );
    protected $_validate = array(
        array('member_name','require','name is a required field'),
        array('member_name','','name has existed!',1,'unique'),
        //check password
        array('member_pwd','check_pwd','password does not match!',1,'confirm',3),
        array('sms_code','checkSMS','wrong verify code',1,'callback',1),

    );

    protected function createSalt(){
        //make a randomized alphabet plus number string and extract 6 from them to generate salt
        $dist = array_merge(range('a','z'),range('0','9'));
        shuffle($dist);
        $dist = implode('',$dist);
        //assign salt to model object for password to use the value in next autocomplete function
        $this->salt = substr($dist,0,6);
        return $this->salt;
    }

    public function password($data){
        //encryption formula
        return sha1(md5($this->salt.$data).$this->salt);
    }

    public function checkSMS($data){
        return $data ==session('sms_code');
    }

}