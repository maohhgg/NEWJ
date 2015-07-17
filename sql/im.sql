/*  
	项目的数据库格式  
	2013-10-27
	我创建的
*/
CREATE DATABASE tower;

use tower;

#用户表  id 头像 姓名 密码 邮箱 建号时间 最后登录时间 项目数 拖延率

CREATE TABLE users(  
id int(3) auto_increment primary key,
headimg varchar(32) not null default '',
name varchar(24) not null default '',
password varchar(44) not null default '',
email varchar(32) not null default '',
mktime int(10) not null default 0,
lastlogin int(10) not null default 0,
numpro int(2) not null default 0,
proba float(3,2) not null default 0.0
)engine InnoDB charset utf8;


#项目表 id 项目名 所属用户 创建时间 设定完成时间 当前状态

CREATE TABLE project(
id int(5) auto_increment primary key,
name varchar(24) not null default '',
parent varchar(24) not null default '',
mark varchar(1) not null default '',
color varchar(6) not null default '',
mktime int(10) not null default 0,
url varchar(20) not null default '',
itsover tinyint(1) not null default 0
)engine InnoDB charset utf8;


#项目任务表 id 任务名 所属项目 建立时间 结束时间 当前状态 是否延误

CREATE TABLE objorder(
id int(5) auto_increment primary key,
name varchar(24) not null default '',
parent varchar(24) not null default '',
starttime int(10) not null default 0,
endtime int(10) not null default 0,
newstat int(2) not null default 0
)engine InnoDB charset utf8;

#项目任务状态表 id 任务名 建立时间  内容

CREATE TABLE orderview(
id int(5) auto_increment primary key,
parent varchar(24) not null default '',
starttime int(10) not null default 0,
content varchar(144) not null default ''
)engine InnoDB charset utf8;


#用户操作表 id 项目 所属用户 操作时间

CREATE TABLE operate(
id int(5) auto_increment primary key,
project varchar(24) not null default '',
who varchar(24) not null default '',
optime int(10) not null default 0
)engine InnoDB charset utf8;


#项目文件表  id 上传时间 文件位置 所属项目

CREATE TABLE profile(
id int(5) auto_increment primary key,
uptime int(10) not null default 0,
url varchar(32) not null default '',
parent varchar(24) not null default ''
)engine InnoDB charset utf8;


#项目文档  id 所属项目 创建时间 上次修改时间 类容

CREATE TABLE proword(
id int(5) auto_increment primary key,
name varchar(24) not null default '',
ctime int(10) not null default 0,
parent varchar(24) not null default '',
content text
)engine InnoDB charset utf8;


#缓存表 id 申请时间 注册的邮箱 验证码

CREATE TABLE regtmp(
id int(5) auto_increment primary key,
email varchar(32) not null default '',
mktime int(10) not null default 0,
codekey varchar(10) not null default ''
)engine InnoDB charset utf8;

#日历表 id 主题 目标时间 内容

CREATE TABLE calendar(
id int(5) auto_increment primary key,
title varchar(32) not null default '',
mktime int(10) not null default 0,
content varchar(140) not null default '',
parent varchar(32) not null default ''
)engine InnoDB charset utf8;