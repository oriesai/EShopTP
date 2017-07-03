<?php
/**
 * Created by PhpStorm.
 * User: Michie
 * Date: 6/13/2017
 * Time: 7:32 PM
 */
//filtering entering data----------------------------------------------
function filterXSS($string){
    //相对index.php入口文件，引入HTMLPurifier.auto.php核心文件
    require_once './Public/Admin/htmlpurifier/HTMLPurifier.auto.php';
    // 生成配置对象
    $cfg = HTMLPurifier_Config::createDefault();
    // 以下就是配置：
    $cfg -> set('Core.Encoding', 'UTF-8');
    // 设置允许使用的HTML标签
    $cfg -> set('HTML.Allowed','div,b,strong,i,em,a[href|title],ul,ol,li,br,p[style],span[style],img[width|height|alt|src]');
    // 设置允许出现的CSS样式属性
    $cfg -> set('CSS.AllowedProperties', 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align');
    // 设置a标签上是否允许使用target="_blank"
    $cfg -> set('HTML.TargetBlank', TRUE);
    // 使用配置生成过滤用的对象
    $obj = new HTMLPurifier($cfg);
    // 过滤字符串
    return $obj -> purify($string);
}

//testing php code-----------------------------------------------------
function p($obj){
    dump($obj);die;
}

//encrypting password with formula------------------------------------------------
//pwd (string) -- pw that need to be encrypted
//salt (string) -- salt value
function password($pwd,$salt){
    return sha1($salt.sha1($pwd).sha1($salt));
}

function recursion($list,$pid=0,$level=0){
    //static tree for storing organized row
    static $tree =array();
    foreach($list as $row){
        if($row['pid']==$pid){
            //assign current level and store row in tree
            $row['level']=$level;
            $tree[] =$row;
            recursion($list,$row['id'],$level+1);
        }
    }
    return $tree;
}

/**
 * @param $user [receivers name]
 * @param $mobile [receivers number]
 * @return result obj collection
 */

function sendSMS($user,$mobile){
//parameter settings---------------------------------
    //time for verification
$time=60;
//randomly generated v code
$code=mt_rand(1000,9999);
session('sms_code',$code);
//record the time that send the msg, then now- time()>60 to see if the time has passed 60s
session('sms_time',time());
    //get enterance file from topsdk
  require './Tools/SMS/TopSdk.php';
  // 接下来，我们到阿里大鱼的个人中心的应用测试把使用代码复制过来。
  $c = new TopClient;
  $c ->appkey = '23460212' ;                              // 应用ID
  $c ->secretKey = '0bf80c1a52716c39959fc732b4448bdf';    // 应用密钥
  $req = new AlibabaAliqinFcSmsNumSendRequest;            // 短信发送类
  $req ->setExtend( "" );                                 // 备注信息，可以不填
  $req ->setSmsType( "normal" );                          // 短信的类型，默认是normal即可。
  $req ->setSmsFreeSignName( "墨落" );                     // 短信签名
  $req ->setSmsParam( "{code:'$code',name:'$user',time:'$time'}" );    // 短信模板的参数，json格式[和模板的参数一定要对应上]
  $req ->setRecNum( "$mobile" );                       // 接收短信的手机号码
  $req ->setSmsTemplateCode( "SMS_33335409" );             // 短信模板的模板ID
  $resp = $c ->execute( $req );                           // 发送短信
  return ($resp);
}

//receivers email
//receivers name
//email subject
//email content
function sendMail($address,$nickname,$subject,$content){

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('PRC');
//fix encoding issues
header('Content-Type:text/html;charset=utf-8');
//require './PHPMailerAutoload.php';
require './Tools/Email/class.smtp.php';
require './Tools/Email/class.phpmailer.php';

//Create a new PHPMailer instance
$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 2;
//prevent encoding error in email
$mail->CharSet ='utf-8';
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';
//Set the hostname of the mail server
$mail->Host = "smtp.gmail.com";
//Set the SMTP port number - likely to be 25, 465 or 587
$mail->Port = 465;
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
$mail->SMTPSecure = "ssl";
//Username to use for SMTP authentication
$mail->Username = "ningyanchui@gmail.com";
//Password to use for SMTP authentication
$mail->Password = "y1000121682";
//Set who the message is to be sent from
$mail->setFrom('ningyanchui@gmail.com', '京西商城');
//Set an alternative reply-to address
$mail->addReplyTo('ningyanchui@gmail.com', '京西商城');
//Set who the message is to be sent to
$mail->addAddress($address, $nickname);
//Set the subject line
$mail->Subject = $subject;
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML($content);
//Replace the plain text body with one created manually
//$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
//$mail->addAttachment('');
return $mail->send();
//send the message, check for errors
//if (!$mail->send()) {
//    echo "Mailer Error: " . $mail->ErrorInfo;
//} else {
//    echo "Message sent!";
//}
}