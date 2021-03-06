<?php
  // 使用短信接口必须先引入 入口文件 TopSdk.php
  date_default_timezone_set('PRC');

  require './TopSdk.php';
  // 接下来，我们到阿里大鱼的个人中心的应用测试把使用代码复制过来。
  $c = new TopClient;
  $c ->appkey = '23460212' ;                              // 应用ID
  $c ->secretKey = '0bf80c1a52716c39959fc732b4448bdf';    // 应用密钥
  $req = new AlibabaAliqinFcSmsNumSendRequest;            // 短信发送类
  $req ->setExtend( "" );                                 // 备注信息，可以不填
  $req ->setSmsType( "normal" );                          // 短信的类型，默认是normal即可。
  $req ->setSmsFreeSignName( "墨落" );                     // 短信签名
  $req ->setSmsParam( "{code:'abdef',name:'小红',time:'2017-10'}" );    // 短信模板的参数，json格式[和模板的参数一定要对应上]
  $req ->setRecNum( "15872179315" );                       // 接收短信的手机号码
  $req ->setSmsTemplateCode( "SMS_33335409" );             // 短信模板的模板ID

  $resp = $c ->execute( $req );                           // 发送短信
  print_r( $resp );