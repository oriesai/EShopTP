<?php
/**
 * Created by PhpStorm.
 * User: Michie
 * Date: 6/20/2017
 * Time: 8:22 AM
 */
namespace Home\Controller;
use Think\Controller;
class ProductsController extends Controller{
    public function index(){
        $this->display();
    }

    public function detail(){
        $this->display();
    }
}