<?php

namespace Admin\Controller;

use Admin\Controller\CommonController;

class IndexController extends CommonController
{
    public function index()
    {
        $this->display();
    }

    public function left()
    {
        $role_id =$_SESSION['Admin_role_id'];
        $roleInfo = D('Role')->find($role_id);
        //fetch top auth
        $where = "auth_pid=0 AND auth_id IN ({$roleInfo['role_auth_ids']})";
        $this->topAuth = D('Auth')->getAuth($where);
        //fetch sub auth
        $where = "auth_pid!=0 AND auth_id IN ({$roleInfo['role_auth_ids']})";
        $this->subAuth = D('Auth')->getAuth($where);
        $this->display();
    }

    public function top()
    {
        $this->display();
    }

    public function main()
    {
        $this->display();
    }

    public function login()
    {
        if (IS_POST) {
            //receive entered captcha and check using verify obj
            $code = I('verify');
            $verify = new \Think\Verify();
            if(!$verify->check($code)){
                $this->error('wrong verification code!');die;
            }

            //if it is from post we can omit the post
            $username = I('username');
            $pwd = I('pwd');
            $res = D('Admin')->where('username="' . $username . '"')->find();
            if ($res) {
                //if password encoded is different from entered pwd,give password error
                if (password($pwd, $res['salt']) != $res['password']) {
                    $this->error('username or password error!'); die;
                }
                session("Admin_username",$res['username']); //store username
                session('Admin_is_login',1); //store login status
                session('Admin_role_id',$res['role_id']);//store role info of the admin
                //update last login time
                $data = array(
                  'aid' =>$res['aid'], //designated id
                    'login_time' => time(),  //store current timestamp
                );

                D('Admin')->save($data); //update data

                $this->success("welcome Back,$username!", U('index/index'));die;
            }else{
                //username error
                $this->error('username or password error!');die;
            }
        }
        $this->pw = password('1234', '11dd2');
        $this->display();
    }
    //logout function(INCOMPLETE)-------------------------------------------------
    public function logout(){
       session('Admin_username',null);
       session('Admin_is_login',null);
       session('Admin_role_id',null);
            $this->redirect('login');
    }

    //for generating captcha------------------------------------------
    public function code(){
        $verify =new \Think\Verify();
        $verify->length =2;
        $verify ->entry();
    }
}