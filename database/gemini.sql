CREATE DATABASE `gemini` DEFAULT CHARACTER SET utf8;


CREATE TABLE `annotation` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `summary` text,
  `selector` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='功能说明步骤';

INSERT INTO gemini.annotation (summary, selector) VALUES ('开始竞猜阶段，用户可以滚动转盘，选择时间，然后提交。页面初始化默认时间为当前时间。', '#wheelpicker');
INSERT INTO gemini.annotation (summary, selector) VALUES ('等待开奖阶段，用户已提交竞猜，但还未开奖。', null);
INSERT INTO gemini.annotation (summary, selector) VALUES ('开奖阶段，答案揭晓，答对的用户给予奖励。', null);
INSERT INTO gemini.annotation (summary, selector) VALUES ('上图为，用户未中奖的情况。', null);
INSERT INTO gemini.annotation (summary, selector) VALUES ('没有参与竞猜的用户，竞猜截止后，和开奖阶段，只能进行浏览。上图为，竞猜已截止。', null);
INSERT INTO gemini.annotation (summary, selector) VALUES ('上图为，未参与的用户，开奖之后浏览的界面。', null);

CREATE TABLE `click` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `selector` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='对话框步骤';

CREATE TABLE `element` (
  `id` bigint(20) NOT NULL,
  `selector` varchar(100) DEFAULT NULL,
  `page_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `forward` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `target_page_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='跳转页面步骤';

INSERT INTO gemini.forward (target_page_id) VALUES (1);
INSERT INTO gemini.forward (target_page_id) VALUES (2);
INSERT INTO gemini.forward (target_page_id) VALUES (3);
INSERT INTO gemini.forward (target_page_id) VALUES (4);
INSERT INTO gemini.forward (target_page_id) VALUES (5);
INSERT INTO gemini.forward (target_page_id) VALUES (6);

CREATE TABLE `page` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `url` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO gemini.page (name, url) VALUES ('开始竞猜阶段', 'archive.page1');
INSERT INTO gemini.page (name, url) VALUES ('等待开奖阶段', 'archive.page2');
INSERT INTO gemini.page (name, url) VALUES ('开奖阶段', 'archive.page3');
INSERT INTO gemini.page (name, url) VALUES ('未中奖', 'archive.page4');
INSERT INTO gemini.page (name, url) VALUES ('没有参与竞猜的用户', 'archive.page5');
INSERT INTO gemini.page (name, url) VALUES ('开奖后浏览', 'archive.page6');

CREATE TABLE `project` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(300) NOT NULL,
  `description` text,
  `url` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO gemini.project (name, description, url) VALUES ('全民大竞猜', '全民大竞猜是飞跃200亿中的其中一项活动。让用户猜猜看，金额会在哪一天到达200亿。奖品将会以代金卷和实物派出。配套管理系统应当提供，修改竞猜截止时间和公布竞猜结果的时间。上图为，项目的示意图。', 'archive.project');

CREATE TABLE `setp` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `usecase_id` bigint(20) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `precondition` text COMMENT '先决条件，当不满足条件是，阻挡用例进行下去',
  `detail_type` varchar(100) DEFAULT NULL COMMENT '多态关联区分',
  `detail_id` bigint(20) DEFAULT NULL COMMENT '多态关联主键',
  `order` bigint(20) DEFAULT NULL,
  `page_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO gemini.setp (usecase_id, name, precondition, detail_type, detail_id, `order`, page_id) VALUES (1, '活动开始', null, 'App\\Forward', 1, 1, 1);
INSERT INTO gemini.setp (usecase_id, name, precondition, detail_type, detail_id, `order`, page_id) VALUES (1, '活动说明', null, 'App\\Annotation', 1, 2, 1);
INSERT INTO gemini.setp (usecase_id, name, precondition, detail_type, detail_id, `order`, page_id) VALUES (1, '等待开奖', null, 'App\\Forward', 2, 3, 2);
INSERT INTO gemini.setp (usecase_id, name, precondition, detail_type, detail_id, `order`, page_id) VALUES (1, '等待开奖说明', null, 'App\\Annotation', 2, 4, 2);
INSERT INTO gemini.setp (usecase_id, name, precondition, detail_type, detail_id, `order`, page_id) VALUES (1, '开奖阶段', null, 'App\\Forward', 3, 5, 3);
INSERT INTO gemini.setp (usecase_id, name, precondition, detail_type, detail_id, `order`, page_id) VALUES (1, '开奖说明', null, 'App\\Annotation', 3, 6, 3);
INSERT INTO gemini.setp (usecase_id, name, precondition, detail_type, detail_id, `order`, page_id) VALUES (1, '未中奖', null, 'App\\Forward', 4, 7, 4);
INSERT INTO gemini.setp (usecase_id, name, precondition, detail_type, detail_id, `order`, page_id) VALUES (1, '未中奖说明', null, 'App\\Annotation', 4, 8, 4);
INSERT INTO gemini.setp (usecase_id, name, precondition, detail_type, detail_id, `order`, page_id) VALUES (1, '没有参与竞猜的用户', null, 'App\\Forward', 5, 9, 5);
INSERT INTO gemini.setp (usecase_id, name, precondition, detail_type, detail_id, `order`, page_id) VALUES (1, '没有参与竞猜的用户说明', null, 'App\\Annotation', 5, 10, 5);
INSERT INTO gemini.setp (usecase_id, name, precondition, detail_type, detail_id, `order`, page_id) VALUES (1, '开奖后浏览', null, 'App\\Forward', 6, 11, 6);
INSERT INTO gemini.setp (usecase_id, name, precondition, detail_type, detail_id, `order`, page_id) VALUES (1, '开奖后浏览说明', null, 'App\\Annotation', 6, 12, 6);

CREATE TABLE `setting` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `key` varchar(300) DEFAULT NULL COMMENT '是否自动播放',
  `value` text,
  `remark` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='设置表';

CREATE TABLE `sheet` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `page_id` bigint(20) DEFAULT NULL,
  `usecase_id` bigint(20) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `element_id` bigint(20) DEFAULT NULL,
  `precondition` text COMMENT '先决条件，当不满足条件是，阻挡用例进行下去',
  `type` int(11) DEFAULT NULL COMMENT '0自定义1页面跳转2弹窗3功能说明',
  `target_page_id` bigint(20) DEFAULT NULL,
  `selector` varchar(100) DEFAULT NULL COMMENT '弹窗节点，type = 2时有效',
  `summary` text COMMENT '功能概述，type = 3时有效',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `sheet1` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `project_id` bigint(20) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `url` text COMMENT '页面url',
  `description` longtext COMMENT '文字',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `usecase` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `project_id` bigint(20) DEFAULT NULL,
  `order` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO gemini.usecase (name, project_id, `order`) VALUES ('立项演示', 1, 1);
INSERT INTO gemini.usecase (name, project_id, `order`) VALUES ('用例a', 1, 2);
