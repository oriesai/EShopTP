<?php
/**
 * Created by PhpStorm.
 * User: Michie
 * Date: 6/13/2017
 * Time: 5:47 PM
 */

namespace Admin\Model;

use Think\Model;

class ProductModel extends Model
{
//    set _map _verification _auto
    protected $_auto = array(
        //1=auto when created only, time is system function
        array('created_time', 'time', 1, 'function'),
        //3=auto when created and update
        array('updated_time', 'gettime', 3, 'callback'),
    );


    protected $_validate = array(
        array('product_name', 'require', 'product name is required'),
        array('product_name', '', 'product exists', 1, 'unique', 2) //ensure name is unique
    );


    protected $_map = array(
        'title' => 'product_name',  //prevent user from knowing its product name
    );


    //default data uses null as if the product info is newly created, then return a timestamp, if it is an update of time, turn the string from data array to timestamp and store it in create()
    protected function gettime($data = null)
    {
        if ($data) {
            return strtotime($data);
        }
        return time();  //get current timestamp
    }


//for getting list -----------------------------
    public function getList($firstRow, $listRows)
    {
        return $this->field('product_id,product_name,product_price,product_number,product_small_logo,is_show')->limit($firstRow . ',' . $listRows)->select();
    }


    //add product in product list------------------
    public function addProduct()
    {
        //if create failed, get error msg, validate, auto and map in model when create
        if (!$data = $this->create()) {
            $this->getError();
        }
        $fileinfo = $this->upload();
        //put src and thumb from upload to post array
        $data['product_big_logo'] = $fileinfo[0]['src'];
        $data['product_small_logo'] = $fileinfo[0]['thumb'];
//add inserted data to db
        return $res = $this->add($data);

    }


    //upload function -------------------------
    public function upload()
    {

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
        //if create upload objezct successfully
        if ($info) {
            return $this->genThumb($info, $config);
        } else {
//                get error message for 5s and die to prevent from going onwards
            $Upload->getError();
            die;
        }

    }


// -------- generate thumb ----------------------
    public function genThumb($info, $config)
    {
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


    }


//delete product from list according to id----------------
    public function delProduct($id)
    {
        $info = $this->where('product_id=' . $id)->find();
        $res = $this->delete($id);
        //find src and thumb src and delete it if success
        $src = './Public/Uploads' . $info['product_big_logo'];
        $thumb = './Public/Uploads' . $info['product_small_logo'];
        //delete thumb and src for record
        file_exists($src) && unlink($src);
        file_exists($thumb) && unlink($thumb);

        return $res;
    }
}
