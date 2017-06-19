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
                    <label>管理員名稱</label>
                    <input name="username" placeholder="请输入管理員名稱" type="text" class="dfinput" value="<?php echo ($data["username"]); ?>" />
                </li>
                 <li>
                    <label>角色</label>
                     <select name="role_id" class="dfinput">
                         <?php if(is_array($roleList)): $i = 0; $__LIST__ = $roleList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["role_id"]); ?>" <?php if($v['role_id'] == $data['role_id']): ?>selected="selected"<?php endif; ?> ><?php echo ($v["role_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                     </select>
                </li>
                <li>
                    <label>密碼</label>
                    <input name="password" placeholder="请输入密碼" type="password" class="dfinput" value="" />
                    <input name="aid" type="hidden" class="dfinput" value="<?php echo ($_GET['aid']); ?>" />
                </li>
                <li>
                    <label>&nbsp;</label>
                    <input type="hidden" name='salt' value="<?php echo ($data["salt"]); ?>">
                    <input name="" id="btnSubmit" type="button" class="btn" value="确认保存" />
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
    })
});
</script>
</html>