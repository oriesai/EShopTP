<?php
/**
 * Created by PhpStorm.
 * User: Michie
 * Date: 6/13/2017
 * Time: 8:59 AM
 */

namespace Admin\Controller;

use Think\Controller;

class ProductsController extends Controller
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
            //return thumb and src url
            $filesinfo = $this->upload();

            //insert into db----------
            foreach ($filesinfo as $k => $v) {
                $data['src'] = $v['src'];
                $data['thumb'] = $v['thumb'];
            //save pid in the array
                $data['product_id'] = $gid;
                $res = $productPhotos->add($data);
                if (!$res) {
                    $this->error('there is a problem with one of the upload files,please try again', '', 5);die;
                }else{
                    $this->success('upload photos success!','',3);die;
                }
            }
        }
        //select all thumbs and photos respective to id
        $this->list = $productPhotos->where('product_id='.$gid)->select();
        $this->display();
    }

//handling add----------------------------
    public function add()
    {
        if (IS_POST) {
            $fileinfo = $this->upload();
            //put src and thumb from upload to post array
            $_POST['product_big_logo'] = $fileinfo[0]['src'];
            $_POST['product_small_logo'] = $fileinfo[0]['thumb'];
//end of processing uplaod logo ---------

            $products = D('Product');
            //if create failed, get error msg, validate, auto and map in model when create
            if (!$data = $products->create()) {
                $this->error($products->getError());
            }
//add inserted data to db
            $res = $products->add($data);
            if ($res) {
                $this->success('input success','',5);
                die;
            } else {
                $this->error('insert failed','',5);
            }
        }
        $this->display();
    }

//upload function -------------------------
    public function upload()
    {
        // detect error in photos by using loop
        $flag = 0;
        $i = 0;
        while ($i < count($_FILES['product_photos'])) {
            $_FILES['product_photos']['error'][$i] ? ($flag = 1) : 0;
            $i++;
        }
        if (!$flag) {
//        configuration for upload pictures criteria
            $config = array(
                'maxSize' => 8388608,
                'rootPath' => "./Public/Uploads",
                'savePath' => '/Products/',
                'exts' => array('jpg', 'gif', 'png', 'jpeg'),
            );
//        instantiate uploads obj
            $Upload = new \Think\Upload($config);
            $info = $Upload->upload();
// -------- generate thumb ----------------------
            //if create upload object successfully
            if ($info) {
                $Image = new \Think\Image();
                //put photos in an array by foreach loop
                $data = [];
                foreach ($info as $key => $item) {
                    //product big logo is the complete file name(exclude folder)
                    $src = $item['savepath'] . $item['savename'];
                    $thumb = $item['savepath'] . 'thumb_' . $item['savename'];
                    $data['src'] = $src;
                    //generate small logo name
                    $data['thumb'] = $thumb;
                    //open the thumb's original image
                    $Image->open($config['rootPath'] . $src);
                    $Image->thumb(220, 220, 2)->save($config['rootPath'] . $thumb);
                    //put src and thumb img name into a 2d array to send back to main function
                    $fileinfo[$key]['src'] = $src;
                    $fileinfo[$key]['thumb'] = $thumb;
                }
                return $fileinfo;
            } else {
//                get error message for 5s and die to prevent from going onwards
                $this->error($Upload->getError(), '', 5);
                die;
            }
        } else {
            $this->error('you have not uplaod any photos!');
        }
    }
}