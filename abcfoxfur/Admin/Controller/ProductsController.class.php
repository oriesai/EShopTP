<?php
/**
 * Created by PhpStorm.
 * User: Michie
 * Date: 6/13/2017
 * Time: 8:59 AM
 */
namespace Admin\Controller;
use Think\Controller;

class ProductsController extends Controller{
    public function index(){
        $this->display();
    }
    public function add(){
        $this->display();
    }
}