<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>登录商城</title>
    <link rel="stylesheet" href="/Public/Home/style/base.css" type="text/css">
    <link rel="stylesheet" href="/Public/Home/style/global.css" type="text/css">
    <link rel="stylesheet" href="/Public/Home/style/header.css" type="text/css">
    <link rel="stylesheet" href="/Public/Home/style/login.css" type="text/css">
    <link rel="stylesheet" href="/Public/Home/style/footer.css" type="text/css">
</head>
<body>
<!-- 顶部导航 start -->
<div class="topnav">
    <div class="topnav_bd w990 bc">
        <div class="topnav_left">

        </div>
        <div class="topnav_right fr">
            <ul>
                <?php if($_SESSION['Home_is_login']== 1): ?><li>Welcome back, <?php echo (session('Home_member_name')); ?>！[<a href="<?php echo U('Member/logout');?>">logout</a>]</li>
                    <?php else: ?>
                    <li>Welcome to JingXi！[<a href="<?php echo U('Member/login');?>">登录</a>] [<a href="<?php echo U('Member/register');?>">免费注册</a>]
                    </li><?php endif; ?>
                <li class="line">|</li>
                <li>我的订单</li>
                <li class="line">|</li>
                <li>客户服务</li>

            </ul>
        </div>
    </div>
</div>
<!-- 顶部导航 end -->

<div style="clear:both;"></div>

<!-- 页面头部 start -->
<div class="header w990 bc mt15">
    <div class="logo w990">
        <h2 class="fl"><a href="index.html"><img src="/Public/Home/images/logo.png" alt="京西商城"></a></h2>
    </div>
</div>
<!-- 页面头部 end -->



<style>
    .login_form .txt2 {
        width: 150px;
    }

    .sms_btn {
        color: #fff;
        background-color: #ff4444;
        display: inline-block;
        cursor: pointer;
        height: 32px;
        line-height: 32px;
        font-size: 14px;
        width: 140px;
        text-align: center;
    }
    .disabled{
        cursor:not-allowed;
        background-color: #ffcccc;
    }
</style>
<!-- 登录主体部分start -->
<div class="login w990 bc mt10 regist">
    <div class="login_hd">
        <h2>用户注册</h2>
        <b></b>
    </div>
    <div class="login_bd">
        <div class="login_form fl">
            <form action="" method="post">
                <ul>
                    <li>
                        <label for="">用户名：</label>
                        <input type="text" class="txt" name="username"/>
                        <p>3-20位字符，可由中文、字母、数字和下划线组成</p>
                    </li>
                    <li>
                        <label for="">手機號碼：</label>
                        <input type="text" class="txt" name="mobile"/>
                        <p>請填寫手機號碼</p>
                    </li>
                    <li>
                        <label for="">email：</label>
                        <input type="text" class="txt" name="email"/>
                        <p>用於找回密碼</p>
                    </li>
                    <li>
                        <label for="">密码：</label>
                        <input type="password" class="txt" name="password"/>
                        <p>6-20位字符，可使用字母、数字和符号的组合，不建议使用纯数字、纯字母、纯符号</p>
                    </li>
                    <li>
                        <label for="">确认密码：</label>
                        <input type="password" class="txt" name="check_pwd"/>
                        <p><span>请再次输入密码</p>
                    </li>
                    <li>
                        <label for="">驗證碼：</label>
                        <input type="text" class="txt txt2" name="sms_code"/>
                        <span class="sms_btn disabled">點擊發送短信驗證碼</span>
                        <p>發送手機驗證碼</p>
                    </li>
                    <li>
                        <label for="">&nbsp;</label>
                        <input value="1" name="is_read" type="checkbox" class="chb" checked="checked"/> 我已阅读并同意《用户注册协议》
                    </li>
                    <li>
                        <label for="">&nbsp;</label>
                        <input type="submit" value="" class="login_btn"/>
                    </li>
                </ul>
            </form>


        </div>

        <div class="mobile fl">
            <h3>手机快速注册</h3>
            <p>中国大陆手机用户，编辑短信 “<strong>XX</strong>”发送到：</p>
            <p><strong>1069099988</strong></p>
        </div>

    </div>
</div>
<!-- 登录主体部分end -->
<script src="/Public/Home/js/jquery-1.8.3.min.js"></script>
<script>
    var t;
    var timer=0;  //status of timer, 1 is active, 0 is inactive
    //when mobile is entered and the format is correct. also the timer is inactive, remove the disable attr, if neither of those, add disabled class
    $('input[name=mobile]').blur(function () {
        var mb = $('input[name=mobile]').val();
        if ((/\d{11}/.test(mb)) && timer == 0) {
            $('.sms_btn').removeClass('disabled');
        }else{
        $('.sms_btn').addClass('disabled')

        }
    });
//    <!--send ajax to back end for routing sms to servicer-->
    //store the button object, as we need to change the text on it later on
    $('.sms_btn').click(function () {
        var _this = $(this);
        //if the button has disabled class, prevent user from clicking and running timer
        var res = _this.hasClass('disabled');
        if (res) {
            return false;
        }
        //set timer to 5s
        var time = 5;
        //add disabled class when clicked (premise is it doesnt have disabled class)
        $('.sms_btn').addClass('disabled');
        //timer interval to be 1000 minusing, if time is lesser then one,remove disabled and rewrite html in the button, clear timer to prevent it from going negative
            t = setInterval(function () {
           if(time <=1 ){
               $('.sms_btn').removeClass('disabled');
               _this.html('點擊發送短信驗證碼');
               //stop timer when it hits 0
               clearInterval(t);
           }else{
               // write seconds in button interior
               _this.html( --time + '秒');
           }
        },1000);

    var mb =$('input[name=mobile]').val();

//use ajax to send mobile number to sms_verify
        $.get("<?php echo U('Member/sms_verify');?>", {'mobile':mb}, function (msg) {
            console.log(msg);
        });
    });

</script>

<div style="clear:both;"></div>
<!-- 底部版权 start -->
<div class="footer w1210 bc mt15">
    <p class="links">
        <a href="">关于我们</a> |
        <a href="">联系我们</a> |
        <a href="">人才招聘</a> |
        <a href="">商家入驻</a> |
        <a href="">千寻网</a> |
        <a href="">奢侈品网</a> |
        <a href="">广告服务</a> |
        <a href="">移动终端</a> |
        <a href="">友情链接</a> |
        <a href="">销售联盟</a> |
        <a href="">京西论坛</a>
    </p>
    <p class="copyright">
        © 2005-2013 京东网上商城 版权所有，并保留所有权利。 ICP备案证书号:京ICP证070359号
    </p>
    <p class="auth">
        <a href=""><img src="/Public/Home/images/xin.png" alt=""/></a>
        <a href=""><img src="/Public/Home/images/kexin.jpg" alt=""/></a>
        <a href=""><img src="/Public/Home/images/police.jpg" alt=""/></a>
        <a href=""><img src="/Public/Home/images/beian.gif" alt=""/></a>
    </p>
</div>
<!-- 底部版权 end -->

</body>
</html>