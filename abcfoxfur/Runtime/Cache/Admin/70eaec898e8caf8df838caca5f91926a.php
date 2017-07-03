<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh" xmlns:input="http://www.w3.org/1999/html">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>login</title>
<link rel="stylesheet" type="text/css" href="/Public/Admin/css/styles_login.css">
</head>
<body>
<div class="htmleaf-container">
	<div class="wrapper">
		<div class="container">
			<h1>Welcome</h1>
			
			<form class="form"  action='' method="post" onsubmit="return submitForm(this)">
				<input type="text" name='username' id="username" placeholder="Username">
				<input type="password" name="pwd" id="password" placeholder="Password">
				<input type="test" name="verify" id="captcha" placeholder="captcha">
	<p><img class='code' id="changeCode" src="/Admin/Index/genCode/" alt="" /></p>
				<button type="submit" id="login-button">Login</button>
				<p>New to us?  <a href="#">sign up here</a></p>
			</form>
		</div>
		
		<ul class="bg-bubbles">
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
		</ul>
	</div>
</div>

<script src="/Public/Admin/js/jquery-2.1.1.min.js" type="text/javascript"></script>
<script src="/Public/Admin/js/jquery-2.1.1.2min.js" type="text/javascript">
	<script src="/gg_bd_ad_720x90.js" type="text/javascript"></script>
</script>

<script type="text/javascript">
function submitForm(obj){
	//add effect when success
    //verif form if empty and if captcha value is less then 4
    if(obj.username.value==''||obj.password.value==''||obj.captcha.value==''){
        alert('please fill in all the information');
        return false;
	}
}
document.getElementById('changeCode').onclick = function (){
//    date obj-0 will force it convert into integer
	this.src="<?php echo U('Admin/Index/code');?>?"+(new Date()-0);
};

document.getElementById('changeCode').onclick();

</script>

</body>
</html>