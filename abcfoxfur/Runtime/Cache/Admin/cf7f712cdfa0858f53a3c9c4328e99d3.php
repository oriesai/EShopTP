<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>add product</title>
    <link href="/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="/Public/Admin/js/jquery.js"></script>
    <link rel="stylesheet" href="/Public/Admin/lightbox/css/lightbox.css" />





<style>
   .forminfo li label{
        width: 150px;
    }
    .formtitle span{
        position:static;
        margin-right:5px;
        border-bottom:none;
        cursor:pointer;

    }
    .formtitle span.current{
        border-bottom:3px solid blue;
    }

    .forminfo{
        display:none;
    }

    .forminfo:first-child{
        display:block;
    }
    .plus{
        cursor:pointer;
    }
    /*style for photo list*/
    .photo_list li{
        float:left;
        border:1px solid #ccc;
        padding:4px;
        margin: 2px;
        text-align:center;
    }
    .photo_list li img{
        width: 120px;
    }
    .del_photo{
        cursor:pointer;
        font-size: 20px;
    }
</style>
</head>
<body>
    <div class="place">
        <span>位置：</span>
        <ul class="placeul">
            <li><a href="#">首页</a></li>
            <li><a href="#">表单</a></li>
        </ul>
    </div>
    <div class="formbody">
        <div class="formtitle"><span class="current">商品相冊</span></div>
        <ul class="photo_list">
            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li>
                    <span class="del_photo" data-id="<?php echo ($v["photo_id"]); ?>">[ - ]</span><br/>
                    <!--insert lightbox plugin-->
                  <a href="/Public/Uploads/<?php echo ($v["src"]); ?>" data-lightbox="abc" data-title="product photo"><img src="/Public/Uploads/<?php echo ($v["thumb"]); ?>" alt=""></a>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <form action="" method="post" enctype="multipart/form-data">

            <ul class="forminfo">
                <li><span class="plus">[ + ]</span>&nbsp;&nbsp;<input type="file" name="product_photos[]" value="choose file"/></li>
            </ul>
            <ul class="btn">
                <li>
                    <input id="btnSubmit" type="submit" class="btn" value="确认保存" />
                </li>
            </ul>
        </form>
    </div>
</body>

</html>
<script language="JavaScript" src="/Public/Admin/lightbox/js/jquery-1.10.1.js"></script>
<script language="JavaScript" src="/Public/Admin/lightbox/js/lightbox.js"></script>
<script>
   //tab selection and section hidding------------------
    $('.formtitle span').click(function(){
//add underline to current tab
       $(this).addClass('current').siblings().removeClass('current');
 //show only the corresponding section
        $('.forminfo').eq($(this).index()).show(500).siblings('.forminfo').hide();
    });
    //adding file upload section----------------------
    $('.forminfo').on('click','.plus',function (e) {
      $(e.target).parent().clone().find('span').removeClass('plus').addClass('minus').html('[ - ]').parent().appendTo('.forminfo');
    });
    //remove file upload section----------------------
    $('.forminfo').on('click','.minus',function (e) {
      $(e.target).parent().remove();
    });
    //remove photo from gallery----------------
    $('.del_photo').click(function () {
        //define this so that closure objects can use
       var _this =$(this);
       var id =_this.attr('data-id');
       //use ajax to delete photos in db and location
       $.get(
          '<?php echo U("Products/delPhoto");?>',
           {'photo_id':id},
           function (res) {
               if (res){
                   _this.parent().remove();
               }else{
                   alert('deletion failed!');
               }
           },
           'text');
    });
</script>