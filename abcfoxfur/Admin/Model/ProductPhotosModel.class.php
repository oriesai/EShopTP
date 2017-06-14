<?php
/**
 * Created by PhpStorm.
 * User: Michie
 * Date: 6/14/2017
 * Time: 8:35 AM
 */

namespace Admin\Model;

use Think\Model;

class ProductPhotosModel extends Model
{
//delete photo from album ---------------------------
    public function deletePhoto($id)
    {
        $info = $this->find($id);
        $res = $this->delete($id);
//            if delete record successful, delete photo from directory
        if ($res) {
            $src = './Public/Uploads' . $info['src'];
            file_exists($src) && unlink($src);
            $thumb = './Public/Uploads' . $info['thumb'];
            file_exists($thumb) && unlink($thumb);
        }
        return $res;
    }

    //get photo album list-----------------------
    public function getList($gid)
    {
        return $this->where('product_id=' . $gid)->select();
    }

    //delete all product photos from album-----------------
    public function delAllProductPhotos($id)
    {
        //select all photos id
        $photo_ids = $this->field('photo_id')->where('product_id=' . $id)->select();
        //if there are photos in the album, if not dont return anything
        if (empty($photo_ids)) {
            return 'empty';
        }
            //traversate all items and delete one by one by useing deletePhoto()
            foreach ($photo_ids as $item) {
                $res = $this->deletePhoto($item['photo_id']);
                if (!$res) {
                    //if failed to delete one photo, return false right away
                    return $res;
                }
            }
        return $res;
    }
}