<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>add administrator</title>
    <link href="/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="/Public/Admin/js/jquery.js"></script>
</head>

<body>
    <div class="place">
        <span>位置：</span>
        <ul class="placeul">
            <li><a href="#">首页</a></li>
            <li><a href="#">添加權限</a></li>
        </ul>
    </div>
    <div class="formbody">
        <div class="formtitle"><span>基本信息</span></div>
        <form action="" method="post">
            <ul class="forminfo">
                <li>
                    <label>權限名稱</label>
                    <input name="auth_name" placeholder="请输入權限名稱" type="text" class="dfinput" />
                </li>
                <li>
                    <label>&nbsp;父級權限</label>
                    <select name="auth_pid">
                        <option value="0">--頂級--</option>
                        <?php if(is_array($topAuth)): $i = 0; $__LIST__ = $topAuth;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><option value="<?php echo ($item["auth_id"]); ?>"><?php echo ($item["auth_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </li>
                <li>
                    <label>控制器名稱</label>
                    <input name="auth_controller" placeholder="请输入控制器名稱" type="text" class="dfinput" />
                </li>
                <li>
                    <label>動作名稱</label>
                    <input name="auth_action" placeholder="请输入動作名稱" type="text" class="dfinput" />
                </li>
                 <li>
                    <label>&nbsp;</label>
                    <input name="" id="btnSubmit" rows='5' cols='20' type="button" class="btn" value="确认保存" />
                </li>
            </ul>
        </form>
    </div>
</body>
<script type="text/javascript">
//jQuery代码
$(function(){
    //给btnsubmit绑定点击事件
    $('#btnSubmit').on('click',function(){
        //表单提交
        $('form').submit();
    });


    //如果是从列表中选择则显示textarea
    $('input[name=attr_write]').on('click',function(){
        if($(this).val() == 1){
            $('textarea').parent().show();
        }else{
            $('textarea').parent().hide();
        }
    });
});
</script>
</html>