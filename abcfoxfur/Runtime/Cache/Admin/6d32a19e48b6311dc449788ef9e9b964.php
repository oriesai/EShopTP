<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="/Public/Admin/js/jquery.js"></script>
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
        <div class="formtitle"><span>基本信息</span></div>
        <form action="" method="post">
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
                    <label>product weight</label>
                    <input name="product_number" placeholder="请输入商品数量" type="text" class="dfinput" />
                </li>
                <li>
                    <label>update time</label>
                    <input name="product_weight" placeholder="请输入商品重量" type="text" class="dfinput" />
                </li>
                <li>
                    <label>update time</label>
                    <input name="product_big_logo" type="file" class="dfinput" />
                </li>

                <li><label>put on shelf?</label><cite><input name="" type="radio" value="" checked="checked" />onshelf&nbsp;&nbsp;&nbsp;&nbsp;<input name="" type="radio" value="" />offshelf</cite>
                </li>

                <li>
                    <label>商品描述</label>
                    <textarea name="product_introduce" placeholder="请输入商品描述" cols="" rows="" class="textinput"></textarea>
                </li>
                <li>
                    <label>&nbsp;</label>
                    <input name="" id="btnSubmit" type="button" class="btn" value="确认保存" />
                </li>
            </ul>
        </form>
    </div>
</body>

</html>