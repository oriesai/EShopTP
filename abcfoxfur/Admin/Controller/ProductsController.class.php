<?php
/**
 * Created by PhpStorm.
 * User: Michie
 * Date: 6/13/2017
 * Time: 8:59 AM
 */

namespace Admin\Controller;

use Admin\Controller\CommonController;

class ProductsController extends CommonController
{
    public function index()
    {
        //split pages
        $products = D('Product');
        $count = $products->count();
        $this->count = $count;  //assign count
        $Page = new \Think\Page($count, 2);  //instantialize page obj
        $Page->setConfig('prev', 'prev');
        $Page->setConfig('next', 'next');
        //use show() to assign pages number
        $this->style = $Page->show();
        //get list result from model function getList(), with two parameters
        $this->list = $products->getList($Page->firstRow, $Page->listRows);
        //select products field in assigned list
        $this->display();
    }


//handling product photos-------------------
    public function photos()
    {
        //receive gid from a on click, parse id to integer
        $gid = I('get.gid', 0, 'intval');
        if ($gid == 0) {
            //if gid ==0 meaning it comes from other pages then the link, give error message
            $this->error('illegal request,please login');
        };
        $productPhotos = D('ProductPhotos');
        if (IS_POST) {
            $product = D('Product');
            //return thumb and src url (upload function is in product model
            // detect error in photos by using loop, if there is error, it will equal 1
            $flag = 0;
            $i = 0;
            while ($i < count($_FILES['product_photos']['name'])) {
                $_FILES['product_photos']['error'][$i] ? ($flag = 1) : '';
                $i++;
            }
            if (!$flag) {
                $filesinfo = $product->upload();
            } else {
                $this->error('you cannot leave any box empty!');
            }

            //insert into db----------
            foreach ($filesinfo as $k => $v) {
                $data['src'] = $v['src'];
                $data['thumb'] = $v['thumb'];
                //save pid in the array
                $data['product_id'] = $gid;
                $res = $productPhotos->add($data);
                if (!$res) {
                    $this->error('there is a problem with one of the upload files,please try again', '', 3);
                }
            }
            $this->success('upload photos success!', '', 3);
            die;
        }
        //select all thumbs and photos respective to id
        $this->list = $productPhotos->getList($gid);
        $this->display();
    }

//handling add----------------------------
    public
    function add()
    {
        if (IS_POST) {
            if (!$_FILES['product_big_logo']['error'][0]) {
                //have to create product obj first to verify other informations before moving photos to uploads folder
                $products = D('Product');
                $res = $products->addProduct();
                if ($res) {
                    //get all data from post
                    $data = I('post.');
                    //after adding product, res obtains the product id,$data obtains all the post data
                    $result = D('ProductAttribute')->addAllAttr($res, $data);
                    if (!$result) {
                        $this->error(D('ProductAttribute')->getError());
                        die;
                    }
                    $this->success('input success', '', 5);
                    die;
                } else {
                    $this->error('insert failed', '', 5);
                }
            } else {
                $this->error('image error!');
            }
        }
        $this->type_list = D('ProductType')->select();
        $this->display();
    }


//delete photo from photo album-----------------------
    public
    function delPhoto()
    {
        if (IS_AJAX) {
            $productPhoto = D('ProductPhotos');
//        receive id from get method,filter id
            $id = I('get.photo_id', 0, 'intval');
            //store data in info before deleting the record
            echo($productPhoto->deletePhoto($id));

        }
    }


//delete item from item list------------------------
    public
    function delItem()
    {
        //get gid from item list
        $id = I('get.gid', 0, 'intval');
        if (!$id) {
            $this->error('illegal visit');
            die;
        }
        //find id record and delete it,also unlink src and thumb pic
        $product = D('Product');
        $res = $product->delProduct($id);
        if ($res == 'empty') {
            $this->success('delete sucessfully', U('index'));
        }
        if ($res == 1 || $res == 'empty') {
            //delete record's photo from album
            $productPhotos = D('ProductPhotos');
            $res2 = $productPhotos->delAllProductPhotos($id);
            if ($res2) {
                $this->success('delete sucessfully', U('index'));
                die;
            } else {
                $this->error('delete failed');
            }
        }

    }

//edit item-----------------------------------------
    public
    function edit()
    {
        $product = D('Product');
        if (IS_POST) {
            if (!$_FILES['product_big_logo']['error'][0]) {

                //use upload()
                $fileinfo = $product->upload();
                if ($fileinfo) {

                    //if old file exists and new file replaces old files, unlink old files
                    $big_logo = './Public/Uploads' . I('post.product_big_logo');
                    $small_logo = './Public/Uploads' . I('post.product_small_logo');
                    if (file_exists($big_logo)) {
                        unlink($big_logo);
                    };
                    if (file_exists($small_logo)) {
                        unlink($small_logo);
                    };
                    $_POST['product_big_logo'] = $fileinfo[0]['src'];
                    $_POST['product_small_logo'] = $fileinfo[0]['thumb'];
                };
            }

//            verify and autofill by create()
            if (!$product->create()) {
                $this->error($product->geterror());
            }
//            p($product->create());
            //save the modified error
            $res = $product->save();
            if ($res) {
                $this->success('update successful');
                die;
            } else {
                $this->error('update failed');
                die;
            }

        }
        //fetch data from the corresponding id
        $id = I('get.gid', 0, 'intval');
        $this->info = $product->find($id);
        $this->display();
    }

    //getting product attribute categories by product type id---------------------------------------------------------
    public function getAttrCateById()
    {
        if (IS_AJAX) {
            $type_id = I('type_id', 0, 'intval');
            //if product type id is larger then 0,fetch all attr cate fields
            if ($type_id > 0) {
                $attrcate = D('ProductAttributeCate');
                $data = $attrcate->getAttrCatesById($type_id);
                //tp provided functions for encoding ajax
                $this->ajaxReturn($data);
            }
        }
    }
}