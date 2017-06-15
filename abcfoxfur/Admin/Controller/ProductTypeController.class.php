<?php
/**
 * Created by PhpStorm.
 * User: Michie
 * Date: 6/15/2017
 * Time: 11:55 AM
 */

namespace Admin\Controller;

use Think\Controller;

class ProductTypeController extends Controller
{
    public function index()
    {
        $type = D('ProductType');
        $this->data = $type->getAll();
        $this->display();
    }

    public function add()
    {
        if (IS_POST) {
            $type = D('ProductType');
            if (!$type->create()) {
                $this->error($type->getError());
            }
            $res = $type->add();
            if ($res) {
                $this->success('added type successfully', U('index'), 3);
                die;
            } else {
                $this->error('addition failed');
                die;
            }
        }
        $this->display();
    }


    public
    function edit()
    {
        $type_id = I('get.type_id', 0, 'intval');
        $type = D('ProductType');
        if (IS_POST) {
            if (!$type->create()) {
                $this->error($type->getError());
            }
            $res = $type->updateTypeById($type_id);
            if ($res) {
                $this->success('update type successfully', U('index'), 3);
                die;
            } else {
                $this->error('update failed');
                die;
            }
        }
        $this->data = $type->getTypeById($type_id);
        $this->display();
    }

    public
    function delete()
    {
        $type_id = I('get.type_id', 0, 'intval');
        $type = D('ProductType');
        $res = $type->deleteTypeById($type_id);
        if ($res) {
            $this->success('delete type successfully', U('index'), 3);
            die;
        } else {
            $this->error('delete failed');
            die;
        }

    }
}
