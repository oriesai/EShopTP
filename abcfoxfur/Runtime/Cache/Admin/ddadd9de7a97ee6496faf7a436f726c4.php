<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>无标题文档</title>
    <link href="/Public/Admin/css/style.css" rel="stylesheet" type="text/css"/>
    <script language="JavaScript" src="/Public/Admin/js/jquery.js"></script>
    <script type="text/javascript">
        $(function () {
            //导航切换
            $(".menuson li").click(function () {
                $(".menuson li.active").removeClass("active")
                $(this).addClass("active");
            });

            $('.title').click(function () {
                var $ul = $(this).next('ul');
                $('dd').find('ul').slideUp();
                if ($ul.is(':visible')) {
                    $(this).next('ul').slideUp();
                } else {
                    $(this).next('ul').slideDown();
                }
            });
        })
    </script>
</head>

<body style="background:#f0f9fd;">
<div class="lefttop"><span></span>※ 控制面板 ※</div>
<dl class="leftmenu">
    <?php if(is_array($topAuth)): $i = 0; $__LIST__ = $topAuth;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$top): $mod = ($i % 2 );++$i; if($top['is_show'] == '1'): ?><dd>
            <div class="title">
                <span><img src="/Public/Admin/images/leftico01.png"/></span><?php echo ($top["auth_name"]); ?>
            </div>
            <ul class="menuson">
                <?php if(is_array($subAuth)): $i = 0; $__LIST__ = $subAuth;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub): $mod = ($i % 2 );++$i; if($sub['auth_pid'] == $top['auth_id'] and $sub['is_show'] == '1'): ?><li>
                            <cite></cite><a href="<?php echo U($sub['auth_controller'].'/'.$sub['auth_action']);?>"
                                            target="rightFrame"><?php echo ($sub["auth_name"]); ?></a><i></i>
                        </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </dd><?php endif; endforeach; endif; else: echo "" ;endif; ?>
</dl>
</body>

</html>