<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>无标题文档</title>
    <link href="/Public/Admin/css/style.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/Public/Admin/js/jquery.js"></script>
    <style>
        /*page*/
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".click").click(function () {
                $(".tip").fadeIn(200);
            });

            $(".tiptop a").click(function () {
                $(".tip").fadeOut(200);
            });

            $(".sure").click(function () {
                $(".tip").fadeOut(100);
            });

            $(".cancel").click(function () {
                $(".tip").fadeOut(100);
            });

        });
    </script>
</head>

<body>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="#">首页</a></li>
        <li><a href="#">数据表</a></li>
        <li><a href="#">基本内容</a></li>
    </ul>
</div>
<div class="rightinfo">
    <div class="tools">
        <ul class="toolbar">
            <li><span><img src="/Public/Admin/images/t01.png"/></span>添加</li>
            <li><span><img src="/Public/Admin/images/t02.png"/></span>修改</li>
            <li><span><img src="/Public/Admin/images/t03.png"/></span>删除</li>
            <li><span><img src="/Public/Admin/images/t04.png"/></span>统计</li>
        </ul>
    </div>
    <table class="tablelist">
        <thead>
        <tr>
            <th>
                <input name="" type="checkbox" value="" id="checkAll"/>
            </th>
            <th>商品编号</th>
            <th>商品名稱</th>
            <th>商品價格</th>
            <th>商品庫存</th>
            <th>是否上架</th>
            <th>商品預覽圖</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
                <td>
                    <input name="" type="checkbox" value=""/>
                </td>
                <td><?php echo ($v["product_id"]); ?></td>
                <td><?php echo ($v["product_name"]); ?></td>
                <td><?php echo ($v["product_price"]); ?></td>
                <td><?php echo ($v["product_number"]); ?></td>
                <td><?php echo ($v["is_show"]); ?></td>
                <td>
                    <?php if($v["product_small_logo"] != '' ): ?><img src=" /Public/Uploads<?php echo ($v["product_small_logo"]); ?>"
                                                                       alt=""/><?php endif; ?>
                </td>
                <td>
                    <!--jump to photos action, bringing gid with it-->
                    <a href="<?php echo U('Products/Photos',array('gid' =>$v['product_id']));?>" class="tablelink">更多圖片</a>
                    <a href="#" class="tablelink">查看</a>
                    <a href="#" class="tablelink"> 删除</a>
                </td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
    <div class="pagin">
        <!--p is automatically made by show()-->
        <div class="message">共<i class="blue"><?php echo ($count); ?></i>条记录，当前显示第&nbsp;<i class="blue"><?php echo ((isset($_GET['p']) && ($_GET['p'] !== ""))?($_GET['p']):1); ?></i>页
        </div>
        <ul class="paginList">
            <style>
                .paginList a,
                .paginList span {
                    float: left;
                    width: 31px;
                    height: 28px;
                    border: 1px solid #DDD;
                    text-align: center;
                    line-height: 30px;
                    border-left: none;
                    color: #3399d5;
                }

                .paginList .current {
                    background: #d5d5d5;
                    cursor: default;
                    color: #737373;
                }
            </style>
            <?php echo ($style); ?>

        </ul>
    </div>
    <div class="tip">
        <div class="tiptop"><span>提示信息</span>
            <a></a>
        </div>
        <div class="tipinfo">
            <span><img src="/Public/Admin/images/ticon.png"/></span>
            <div class="tipright">
                <p>是否确认对信息的修改 ？</p>
                <cite>如果是请点击确定按钮 ，否则请点取消。</cite>
            </div>
        </div>
        <div class="tipbtn">
            <input name="" type="button" class="sure" value="确定"/>&nbsp;
            <input name="" type="button" class="cancel" value="取消"/>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.tablelist tbody tr:odd').addClass('odd');
</script>
</body>

</html>