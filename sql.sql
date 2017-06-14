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