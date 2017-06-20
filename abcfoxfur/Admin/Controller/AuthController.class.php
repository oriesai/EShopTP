<?php
/**
 * Created by PhpStorm.
 * User: Michie
 * Date: 6/19/2017
 * Time: 8:17 AM
 */

namespace Admin\Controller;

use Admin\Controller\CommonController;

class AuthController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        //need to assign auth to auth controller before using $this afterwards
        $this->auth=D('Auth');
    }

    public function index()
    {
        //get all auth info out , and use recursion to get the level assigned and the rows sorted
        $authList = $this->auth->field('auth_id id,auth_name,auth_pid pid,auth_controller,auth_action')->select();
        $this->authList =recursion($authList);
        $this->display();
    }

    public function add()
    {
        if (IS_POST) {
            if (!$this->auth->create()) {
                $this->error('addition failed!');
                die;
            }
            $res = $this->auth->add();
            if ($res) {
                $this->success('addition success!', U('index'), 2);
                die;
            } else {
                $this->error('addition failed!');
                die;
            }
        }
        $this->topAuth = $this->auth->getAuth();
        $this->display();
    }

    public function edit()
    {
        $auth_id = I('get.auth_id', 0, 'intval');
        if (IS_POST) {
            if (!$this->auth->create()) {
                $this->error($this->auth->getError());
            }
            $res = $this->auth->where('auth_id='.$auth_id)->save();
            if ($res) {
                $this->success('update Auth successfully', U('index'), 3);
                die;
            } else {
                $this->error('update failed');
                die;
            }
        }
        $this->data = $this->auth->find($auth_id);
        $this->topAuth = $this->auth->getAuth();
        $this->display();
    }

    public function delete()
    {
        $auth_id = I('get.auth_id', 0, 'intval');
        $res = $this->auth->delete($auth_id);
        if ($res) {
            $this->success('delete auth successfully', U('index'), 3);
            die;
        } else {
            $this->error('delete failed');
            die;
        }
    }
}