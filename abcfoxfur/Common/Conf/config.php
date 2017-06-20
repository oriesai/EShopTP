<?php
return array(
	//'配置项'=>'配置值'

    /* 数据库设置 */
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  '127.0.0.1', // 服务器地址
    'DB_NAME'               =>  'ecommerce',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'y3070288',          // 密码
    'DB_PREFIX'             =>  'eco_',    // 数据库表前缀
    'DEFAULT_MODULE' => 'Home',
//set custom constant directory in an array
    'TMPL_PARSE_STRING' => array(
        '__ADMIN__' => __ROOT__.'/Public/Admin',
        '__HOME__' => __ROOT__.'/Public/Home',
        '__EDITOR__' => __ROOT__.'/Public/Editor',
        '__UPLOADS__' => __ROOT__.'/Public/Uploads'
    ),
    // 默认参数过滤方法 用于I函数...
        'DEFAULT_FILTER'        =>  'filterXSS',
);