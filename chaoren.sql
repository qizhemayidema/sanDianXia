insert into machine_manager values (null,'admin','e10adc3949ba59abbe56e057f20f883e');


create table `machine_manager`(
`id` int(11) NOT NULL AUTO_INCREMENT,
`user_name` varchar(32) not null,
`password` varchar(32) not null,
primary key(`id`)
)engine=innodb charset=utf8;

CREATE TABLE `machine_user` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`avatar_url` varchar(256) not null comment '头像',
`nickname` varchar(256) not null comment '昵称',
`sex` tinyint(1) NOT NULL COMMENT '用户性别 0 未知 1 男 2 女',
`country` varchar(48) DEFAULT NULL COMMENT '国家',
`province` varchar(48) DEFAULT NULL COMMENT '省份',
`city` varchar(48) DEFAULT NULL COMMENT '城市',
`openid` varchar(64) NOT NULL default '' COMMENT 'openid',
`real_name` char(30) DEFAULT NULL COMMENT '真实姓名',
`phone` char(11) NOT NULL default '' COMMENT '手机号',
`profession` varchar(120) DEFAULT NULL COMMENT '销售品牌',
`is_apply` tinyint(1) not null default 1 comment '是否接受新通知 0 否 1 是',
`attr_id` int(11) not null default 0 comment '订阅的分类 属性id 默认0',
`sub_area` text comment '订阅地区 ,分割',
`vip_id` int(11) NOT NULL DEFAULT 0 COMMENT 'vip_id 默认0 普通会员',
`store_service_id` int(11) not null DEFAULT 0 comment '店铺会员id 默认0',
`money` decimal(10,2) NOT NULL DEFAULT 0 COMMENT '账号余额',
`pay_money` decimal(10,2) NOT NULL DEFAULT 0 COMMENT '用户充值 总价格 只是充值余额的',
`status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 未被冻结  1 已冻结',
`create_time` int(11) NOT NULL COMMENT '创建时间',
`version` int(11)  NOT NULL DEFAULT 1 comment '防止并发产生问题使用的版本号 初始为1',
 PRIMARY KEY (`id`),
 index(`is_apply`),
index(`vip_id`),
index(`status`),
index(`attr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table `machine_category`(
`id` int(11) not null  auto_increment,
`name` varchar(32) not null comment '名称',
primary key(`id`)
)engine=innodb charset=utf8;

create table `machine_attribute`(
`id` int(11) not null  auto_increment,
`cate_id` int(11) not null comment '分类id',
`attr_name` varchar(32) not null comment '属性名称',
primary key(`id`),
index(`cate_id`)
)engine=innodb charset=utf8;

create table `machine_vip`(
`id` int(11) not null  auto_increment,
`name` varchar(32) not null comment '名称',
`money` decimal(10,2) not null comment '多少钱 vip 一年',
`discount` decimal(10,2) not null comment '折扣',
`precedence` int(11) not null comment '优先多少秒收到消息',
`delay` int(11) not null comment '延时队列使用 这里为延时N秒',
primary key(`id`)
)engine=innodb charset=utf8;

create table `machine_user_business`(
`id` int(11) not null  auto_increment,
`type` tinyint(1) not null comment '1 vip开通  2  店铺服务开通',
`user_id` int(11) not  null comment '用户id',
`business_id` int(11) not null comment '公共id',
`create_time` int(11) not null comment '创建时间',
`length_of_time` int(11) not null comment '开通的到期时间',
primary key(`id`),
index(`type`),
index(`user_id`),
index(`business_id`)
)engine=innodb charset=utf8;

create table `machine_store_service`(
`id` int(11) not null auto_increment,
`name` varchar(32) not null comment '名称',
`money` decimal(10,2) not null comment '多少钱 vip 一年',
`vip_id` int(11) not null default 0 comment '是否满足vip才能开启,默认0',
primary key(`id`),
index(`vip_id`)
)engine=innodb charset=utf8;

create table `machine_user_money_history`(
`id` int(11) not null  auto_increment,
`type` tinyint(1) not null comment '1 开通会员 2 开通店铺服务 3 抢商机 4 充值',
`user_id` int(11) not  null comment '用户id',
`money` decimal(10,2) not null comment '变动金额',
`create_time` int(11) not null comment '创建时间',
primary key(`id`),
index(`user_id`)
)engine=innodb charset=utf8;


CREATE TABLE `machine_message` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`store_id` int(11) not null default 0 comment '店铺id',
`goods_id` int(11) not null default 0 comment '商品id',
`name` varchar(32) not null comment '称呼',
`phone` char(11) not null comment '手机号',
`title` varchar(128) NOT NULL COMMENT '消息标题',
`content` text not null comment '详细需求',
`ltd` varchar(128) not null default '' comment '公司名称',
`cate_id` int(11) not null default 0 comment '分类id',
`attr_id` int(11) not null default 0 comment '属性id',
`province` varchar(128)  not null comment '省',
`city` varchar(128) not null comment '市',
`area` varchar(128) not null default '' comment '区',
`address` varchar(128) not null comment '详细地址',
`msg_price` decimal(10,2) not null comment '商机价格 单价',
`accept_sum` tinyint(1) not null default 0 comment '已接单次数',
`validity_time` int(11) not null comment '有效期截止到 存储的为时间戳',
`status` tinyint(1) not null default 0 comment '审核状态 0 未审核 1 未通过 2 已通过',
`version` int(11) NOT NULL DEFAULT 1 comment '防止并发产生问题使用的版本号 初始为1',
`create_time` int(11) not null comment '创建时间',
`delete_time` int(11) not null default 0 comment '删除时间 默认 0',
PRIMARY KEY (`id`),
index(`attr_id`),
index(`validity_time`),
index(`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


create table `machine_user_message`(
`id` int(11) NOT NULL AUTO_INCREMENT,
`user_id` int(11) not  null comment '用户id',
`message_id` int(11) not  null comment '消息id',
`num` int(11) not  null comment '购买消息次数',
`create_time` int(11) not null comment '创建时间',
PRIMARY KEY (`id`),
index(`user_id`),
index(`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE  `machine_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_code` char(32) NOT NULL COMMENT '订单号',
  `user_id` int(11) NOT NULL COMMENT '下单用户',
  `type` tinyint(1) not null comment '1 充值订单 2 开通会员订单 3 开通店铺订单',
  `type_status` tinyint(1) not null default 0 comment '订单的类型状态 如果type=2,则此字段值为 1 开通会员 2 升级会员 3续费会员',
  `common_id` int(11) not null default 0 comment '公用id 指向需要的id',
  `pay_money` decimal(10,2) NOT NULL COMMENT '支付金额 单位元',
  `title` varchar(128) NOT NULL COMMENT '订单标题',
  `status` tinyint(1) DEFAULT NULL default 1 COMMENT '状态 1 未付款 2 已付款',
  `create_time` int(11) NOT NULL COMMENT '订单创建时间',
  `pay_time` int(11) DEFAULT NULL COMMENT '付款时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARSET=utf8;

create table `machine_feedback`(
`id` int(11) not null auto_increment,
`user_id` int(11) not null comment '用户id',
`content` text not null comment '反馈内容',
`create_time` int(11) not null comment '创建时间',
primary key(`id`)
)engine=innodb charset=utf8;



create table `machine_store`(
`id` int(11) NOT NULL AUTO_INCREMENT,
`user_id` int(11) NOT NULL comment '用户id',
`store_name` varchar(64) not null default '' comment '公司名称',
`banner` varchar(256) not null default '' comment '顶部banner',
`logo` varchar(256) not null default '' comment 'logo',
`contact` varchar(64) not null default '' comment '联系 销售的称谓',
`message_num` int(11) not null default 0 comment '被留言次数',
`area` varchar(64) not null default '' comment '公司所在地区',
`business_scope` varchar(128) not null default '' comment '经营范围',
`phone` char(11) not null default '' comment '联系电话',
`create_time` int(11) not null comment '创建时间',
`end_time` int(11) not null comment '到期时间',
`username` varchar(32) not null comment '账号',
`password` varchar(32) not null comment '密码',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table `machine_goods`(
`id` int auto_increment,
`store_id` int(11) not null comment '店铺id',
`cate_id` int(11) not null comment '分类id',
`attr_id` int(11) not null comment '属性id',
`store_cate_id` int(11) not null comment '店铺分类id',
`title` varchar(64) not null comment '标题',
`pic` varchar(128) not null comment '封面图',
`roll_pic` varchar(999) not null comment '轮播图',
`sku_desc` text not null comment '规格介绍',
`desc` text not null comment '商品介绍',
`status` tinyint(1) not null default 1 comment '状态 0 删除 1 正常',
`click` int(11) not null default 0 comment '点击量',
`create_time` int(11) not null comment '创建时间',
primary key(`id`)
)engine=innodb charset=utf8;

create table `machine_store_cate`(
`id` int auto_increment,
`store_id` int(11) not null comment '店铺id',
`name` varchar(64) not null comment '名称',
`is_banner` tinyint(1) not null default 0 comment '是否导航栏 显示 0 否 1 是',
primary key(`id`)
)engine=innodb charset=utf8;


create table `machine_store_article`(
`id` int auto_increment,
`type` int(11) not null comment '1 咨询 2 常见问题',
`store_id` int(11) not null comment '店铺id',
`title` varchar(64) not null comment '标题',
`desc` text not null comment '介绍',
`pic` varchar(300) not null comment '封面图',
`status` tinyint(1) not null default 1 comment '状态 0 删除 1 正常',
`click` int(11) not null default 0 comment '点击量',
`create_time` int(11) not null comment '创建时间',
primary key(`id`)
)engine=innodb charset=utf8;

create table `machine_image`(
`id` int auto_increment,
`type` int(11) not null comment '1 首页轮播 2 服务网点',
`url` varchar(256) not null comment '图路径',
primary key(`id`),
index `type`(`type`)
)engine=innodb charset=utf8;