<?php
/**
 * Created by PhpStorm.
 * User: Michie
 * Date: 6/18/2017
 * Time: 8:17 PM
 */

namespace Admin\Controller;

use Admin\Controller\CommonController;

class AdminController extends CommonController
{
    public function index()
    {
        //get all admin info out and assign to view
        $this->list = D('Admin')->select();
        $this->display();
    }

    public function add()
    {
        if (IS_POST) {
            $admin = D('Admin');
            $_POST['login_time'] = time();
            $_POST['salt'] = mt_rand(10000, 99999);
            if (!$admin->create()) {
                $this->error('addition failed!');
                die;
            }
            $res = $admin->add();
            if ($res) {
                $this->success('addition success!', U('index'), 2);
                die;
            } else {
                $this->error('addition failed!');
                die;
            }
            //assign role to select all roles from role model to admin list
        }
        $this->roleList = D('Role')->select();
        $this->display();
    }

    public function edit()
    {
        $aid = I('get.aid', 0, 'intval');
        $admin = D('Admin');
        if (IS_POST) {
            //modify password
//            $_POST['password'] = password($_POST['password'],$_POST['salt']);
            if (!$admin->create()) {
                $this->error($admin->getError());
            }
            $res = $admin->where('aid=' . $aid)->save();
            if ($res) {
                $this->success('update Admin successfully', U('index'), 3);
                die;
            } else {
                $this->error('update failed');
                die;
            }
        }
        $this->roleList = D('Role')->select();
        $this->data = $admin->find($aid);
        $this->display();
    }

    public function delete()
    {
        $aid = I('get.aid', 0, 'intval');
        $admin = D('Admin');
        $res = $admin->delete($aid);
        if ($res) {
            $this->success('delete admin successfully', U('index'), 3);
            die;
        } else {
            $this->error('delete failed');
            die;
        }
    }
}