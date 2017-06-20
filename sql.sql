create table eco_product(
    product_id mediumint unsigned not null auto_increment comment 'primary key id',
    product_name varchar(128) not null comment 'product name',
    product_price decimal(10,2) not null default 0 comment 'product price',
    product_number mediumint unsigned not null default 0 comment 'product quantity',
    product_weight smallint unsigned not null default 0 comment 'product weight',
    product_introduce text comment 'product details',
    brand_id smallint unsigned not null default 0 comment 'product brand',
    cate_id smallint unsigned not null default 0 comment 'product category',
    product_big_logo char(128) not null default '' comment 'big logo',
    product_small_logo char(128) not null default '' comment 'small logo',
    onshelf_time int not null default 0 comment 'product on sale time',
    is_show enum('0','1') not null default '1' comment '0:off shelf  1:on shelf',
    is_del  enum('0','1') not null default '0' comment '0:normal  1:del',
    created_time int null comment 'add product time',
    updated_time int null comment 'upadate product time',
    primary key (product_id),
    unique key (product_name),
    key (product_price),
    key (created_time)
) engine=Innodb charset=utf8 comment='product table';

CREATE TABLE eco_product_photos(
`photo_id` INT unsigned NOT NULL auto_increment comment 'auto id',
`product_id` INT unsigned not NULL comment 'product id',
`src` VARCHAR (250) NOT NULL comment 'product pic url',
PRIMARY KEY (`photo_id`)
)engine=innodb charset=utf8 comment='product photos table'

CREATE TABLE eco_product_type(
type_id SMALLINT unsigned NOT NULL auto_increment comment 'type id',
type_name VARCHAR (32) NOT NULL comment 'product type name',
PRIMARY KEY (type_id)
)engine=Innodb charset=utf8 comment='product type table'

CREATE table eco_product_attribute_cate(
attr_cate_id SMALLINT unsigned NOT NULL auto_increment,
attr_cate_name VARCHAR (32) NOT NULL comment 'attr category name',
type_id SMALLINT unsigned NOT NULL comment 'product type id',
attr_cate_exp tinyint NOT NULL DEFAULT 0 comment 'attribute value expression: 0=text(unique), 1=list 2=multiple choice',
attr_cate_exp_style tinyint NOT NULL DEFAULT 0 comment 'attribute presentation style:0=manually written,1=choose from list',
attr_cate_val VARCHAR (256) NOT NULL DEFAULT '' comment 'attribute selection list option',
PRIMARY KEY (attr_id),
KEY (type_id)
)engine=Innodb charset=utf8 comment='product type attributes category table'

CREATE TABLE `eco_product_attribute`(
attr_id SMALLINT unsigned NOT NULL auto_increment,
product_id mediumint unsigned  NOT NULL,
attr_cate_id SMALLINT unsigned NOT NULL,
attr_value VARCHAR (32) NOT NULL comment'product attribute value',
PRIMARY KEY (attr_id),
KEY (attr_cate_id)
)engine=Innodb charset=utf8 comment='product type attributes table'

CREATE TABLE `eco_admin`(
`aid` SMALLINT unsigned NOT NULL auto_increment comment 'primary key id',
`username` VARCHAR (32) NOT NULL comment 'admin username',
`password` VARCHAR (40) NOT NULL comment 'admin password',
`salt` CHAR (5) NULL comment 'salt value',
`login_time` INT(10) unsigned NOT NULL comment 'last login time',
`role_id` tinyint(3) unsigned NOT NULL DEFAULT 0 comment 'role id, primary key for eco_role',
PRIMARY key(`aid`)
)engine=innodb comment='administrator table'

CREATE TABLE `eco_role`(
`role_id` SMALLINT(6) unsigned NOT NULL auto_increment comment 'role id',
`role_name` VARCHAR (20) NOT NULL comment 'role name',
`role_auth_ids` VARCHAR (128) NULL DEFAULT '' comment 'authority e.g. 1,2,4,5; primary key in auth table',
`role_auth_ac` text NULL comment 'authorization action-controller e.g. index-index,product-add',
PRIMARY KEY (`role_id`)
)engine=innodb comment='role table'

CREATE TABLE `eco_auth`(
`auth_id` SMALLINT(6) unsigned NOT NULL auto_increment comment 'auth id',
`auth_name` VARCHAR (20) NOT NULL comment 'auth name',
`auth_pid` SMALLINT(6) unsigned NOT NULL comment 'pid of auth',
`auth_controller` VARCHAR(32) NOT null DEFAULT '' comment 'authorized controller',
`auth_action` VARCHAR(32) NOT null DEFAULT '' comment 'authorized action',
PRIMARY KEY (`auth_id`)
)engine=innodb comment='auth table'

CREATE TABLE `eco_member`(
  `member_id` mediumint unsigned NOT NULL auto_increment comment 'primary key id',
  `member_name` VARCHAR (32) NOT NULL comment 'member name',
  `member_email` VARCHAR (120) NOT NULL DEFAULT '',
  `member_mobile` CHAR (15) NULL comment 'cell phone number',
  `member_pwd` CHAR (40) NOT NULL comment 'member password',
  `member_salt` CHAR (10) NOT NULL comment 'salt for encryption',
  `openid` CHAR(32) NOT NULL DEFAULT '' comment 'qq registers openid info',
  `member_gender` tinyint NOT NULL DEFAULT 1 comment '1=male,2=female,3=secret',
  `member_activ` tinyint NOT NULL DEFAULT 0 comment 'activation status 0=no 1=yes',
  `member_activ_code` CHAR(40) NOT NULL DEFAULT '' comment 'verify activation code' ,
  `created_time` INT unsigned NOT NULL comment 'register time',
  `login_time` INT unsigned NOT NULL comment 'login time',
  `is_del` tinyint NOT NULL DEFAULT 0 comment '0=normal ,1=account deleted',
  PRIMARY KEY (`member_id`),
  KEY `member_name` (`member_name`)
)engine=innodb comment='member table'