<?php
/**
 * Created by PhpStorm.
 * User: Michie
 * Date: 6/18/2017
 * Time: 9:06 PM
 */

namespace Admin\Controller;

use Admin\Controller\CommonController;

class RoleController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        //need to assign role to role controller before using $this afterwards
        $this->role=D('Role');
        $this->auth=D('Auth');
    }

    public function index()
    {
        //get all role info out and assign to view
        $this->list = $this->role->select();
        $this->display();
    }

    public function add()
    {
        if (IS_POST) {
            if (!$this->role->create()) {
                $this->error('addition failed!');
                die;
            }
            $res = $this->role->add();
            if ($res) {
                $this->success('addition success!', U('index'), 2);
                die;
            } else {
                $this->error('addition failed!');
                die;
            }
        }
        $this->display();
    }

    public function edit()
    {
        $role_id = I('get.role_id', 0, 'intval');
        if (IS_POST) {
            if (!$this->role->create()) {
                $this->error($this->role->getError());
            }
            $res = $this->role->where('role_id='.$role_id)->save();
            if ($res) {
                $this->success('update Role successfully', U('index'), 3);
                die;
            } else {
                $this->error('update failed');
                die;
            }
        }
        $this->data = $this->role->find($role_id);

        $this->display();
    }

    public function delete()
    {
        $role_id = I('get.role_id', 0, 'intval');
        $res = $this->role->delete($role_id);
        if ($res) {
            $this->success('delete role successfully', U('index'), 3);
            die;
        } else {
            $this->error('delete failed');
            die;
        }
    }

    //set auth by role----------------------------------------------
    public function setAuth(){
        $role_id = I('get.role_id', 0, 'intval');
        if($role_id<1){
            $this->error('illegal parameter!');die;
        }
        if(IS_POST){
            //convert auth ids array into a string
            $_POST['role_auth_ids']=implode(',',I('post.auth_id'));
            //get all selected id info except top auth, as we want to get ac after, which top auth id doesnt have
      $where = "auth_pid!=0 AND auth_id IN ({$_POST['role_auth_ids']})";
            $acList = $this->auth->getAuth($where);
            //initialize auth_ac string
            $auth_ac ='';
            foreach($acList as $item){
                $auth_ac .= $item['auth_controller'].'-'.$item['auth_action'].',';
            }
            $_POST['role_auth_ac']=rtrim($auth_ac,',');
            if(!$this->role->create()){
                $this->error($this->role->getError());die;
            }
//            save from eco_auth??!??!
            $sql="update eco_role set `role_auth_ids`='{$_POST['role_auth_ids']}' ,`role_auth_ac`='{$_POST['role_auth_ac']}' where `role_id`=$role_id ";
            $res = $this->role->execute($sql);
            if($res){
                $this->success('update role auth successsfully',U('Role/index'),2);die;
            }else{
                $this->error('update role auth failed');die;
            }
        }
        $this->info = $this->role->find($role_id);

        //get and assign all top auth for auth selections,default search is auth_id=0 so dont need to put parameters in it
        $this->topAuth = $this->auth->getAuth();

        //get and assign corresponding sub auth by auth_id!=0
        $this->subAuth = $this->auth->getAuth('auth_id!=0');
        $this->display();
    }
}