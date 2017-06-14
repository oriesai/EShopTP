<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>add product</title>
    <link href="/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="/Public/Admin/js/jquery.js"></script>
    <!--calendar-->
    <script type="text/javascript" src="/Public/Admin/time/calendar.js"></script>
	<link rel="stylesheet" href="/Public/Admin/time/calendar.css">
    <!--editor-->
     <script type="text/javascript" charset="utf-8" src="/Public/Editor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Public/Editor/ueditor.all.min.js"> </script>
        <script type="text/javascript" charset="utf-8" src="/Public/Editor/lang/zh-cn/zh-cn.js"></script>


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
    /*resolve conflict of css style*/
    .calendar .nav{
        float:none;
    }
    /*editor style*/
    .textinput2{
        width: 800px;
        height: 300px;
        border:none;
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
        <div class="formtitle"><span class="current">基本信息</span><span>商品描述</span><span>商品相冊</span></div>
        <form action="" method="post" enctype="multipart/form-data">
            <ul class="forminfo">
                <li>
                    <label>product name</label>
                    <input name="product_name" placeholder="请输入商品名称" type="text" class="dfinput" /><i>名称不能超过30个字符</i></li>
                <li>
                    <label>product price</label>
                    <input name="product_price" placeholder="请输入商品价格" type="text" class="dfinput" /><i></i></li>
                <li>
                    <label>product quantity</label>
                    <input name="product_number" placeholder="请输入商品数量" type="text" class="dfinput" />
                </li>
                <li>
                    <label>create time</label>
                    <input id="update" name="created_time" placeholder="请输入添加時間" type="text" class="dfinput" />
                </li>
                <li>
                    <label>product weight</label>
                    <input name="product_weight"  type="text" class="dfinput" placeholder="请输入商品重量"/>
                </li>
                <li>
                    <label>product logo</label>
                    <input name="product_big_logo[]" type="file"  />
                </li>

                <li><label>put on shelf?</label><cite><input name="is_show" type="radio" value="1" checked="checked" />onshelf&nbsp;&nbsp;&nbsp;&nbsp;<input name="is_show" type="radio" value="0" />offshelf</cite>
                </li>



            </ul>
            <ul class="forminfo">
                <li>
                    <label>product_description</label>
                    <textarea name="product_desc" placeholder="请输入商品描述" id='product_desc' cols="" rows="" class="textinput textinput2"></textarea>
                </li>
            </ul>
            <ul class="forminfo">
                hello2!
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
<script>
   //tab selection and section hidding------------------
    $('.formtitle span').click(function(){
//add underline to current tab
       $(this).addClass('current').siblings().removeClass('current');
 //show only the corresponding section
        $('.forminfo').eq($(this).index()).show(500).siblings('.forminfo').hide();
    });
//calender plugin -----------------------
     Calendar.setup({
        inputField     :    "update",
        ifFormat       :    "%Y-%m-%d %H:%M:%S",
        showsTime      :    true,
        timeFormat     :    "12"
    });
//ueditor plugin----------------
    var ue=UE.getEditor('product_desc',{
       initialFrameWidth:800,
       initialFrameHeight:200,
         toolbars: [[
            'fullscreen', 'source', '|', 'undo', 'redo', '|',
            'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
            'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
            'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
            'directionalityltr', 'directionalityrtl', 'indent', '|',
            'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
            'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
            'simpleupload', 'insertimage', 'emotion', 'scrawl', 'insertvideo', 'music', 'attachment', 'map', 'gmap', 'insertframe', 'insertcode', 'webapp', 'pagebreak', 'template', 'background', '|'
        ]]
    });
</script>