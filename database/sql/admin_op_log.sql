CREATE TABLE `admin_op_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(10) NOT NULL COMMENT '用户ID',
  `url` varchar(128) DEFAULT NULL COMMENT 'URL',
  `controller` varchar(128) DEFAULT NULL COMMENT 'controller类',
  `class_name` varchar(64) DEFAULT NULL COMMENT '类名',
  `class_method` varchar(64) DEFAULT NULL COMMENT '类方法',
  `method` varchar(32) DEFAULT NULL COMMENT '请求的方法,如get,post,put,delete',
  `real_method` varchar(32) DEFAULT NULL COMMENT '请求的真实方法,如get,post',
  `description` varchar(1024) DEFAULT NULL COMMENT '描述',
  `parameter` TEXT DEFAULT NULL COMMENT '参数,json',
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '后台操作日志表';