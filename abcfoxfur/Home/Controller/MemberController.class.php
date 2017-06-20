<?php
/**
 * Created by PhpStorm.
 * User: Michie
 * Date: 6/20/2017
 * Time: 8:28 AM
 */
namespace Home\Controller;
use Think\Controller;
class MemberController extends Controller{

    public function __construct()
    {
        parent::__construct();
        $this->member = D('Member');
    }

    public function login(){
        if(IS_POST){
//            p($_SESSION);
            $member_name=I('username');
            $password=I('password');
            //search for matching member name
            $info = $this->member->where('member_name="'.$member_name.'"')->find();
            if(!$info){
                $this->error('username or password doesnt exist');
            }
            //set salt as the value retrived from db
            $this->member->salt = $info['member_salt'];
            //use model function password for encryption
            $password = $this->member->password($password);
            if($password == $info['member_pwd']){
                //store username and login status if password matches
                session('Home_member_name',$info['member_name']);
                session('Home_is_login',1);
                //last login time
                session('Home_login_time',$info['login_time']);
                $data =array(
                    'Home_login_time' =>time(),
                    'Home_member_id' =>$info['member_id']
                );
                    //update login time data
                   if(!$this->member->save($data)){
                    $this->success('welcome back!',U('index/index'),2);die;
                   }else{
                       $this->error($this->member->getError());die;
                   }
            }
        }
        $this->display();
    }


    public function register(){
        if(IS_POST){
            if(!$info = $this->member->create()){
                $this->error($this->member->getError());die;
            }
            $res = $this->member->add();
            if($res){
                //store user login status in session
                session('Home_member_name',$info['member_name']);
                session('Home_is_login',1);
                $this->success('sign up successfully!',U('index/index'),3);die;
            }else{
                $this->error('sign up failed');die;
            }
        }
        $this->display();
    }

    public function logout(){
        session('Home_member_name',null);
        session('Home_is_login',null);
        session('Home_login_time',null);
        setcookie('PHPSESSID',null);
        $this->success('logout successfully!',U('member/login'),1);
    }
}