/*
Navicat MySQL Data Transfer

Source Server         : 192.168.1.111
Source Server Version : 50552
Source Host           : 192.168.1.111:3306
Source Database       : chat

Target Server Type    : MYSQL
Target Server Version : 50552
File Encoding         : 65001

Date: 2018-12-11 16:58:32
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for T_MIM_CHAT_RECORD
-- ----------------------------
DROP TABLE IF EXISTS `T_MIM_CHAT_RECORD`;
CREATE TABLE `T_MIM_CHAT_RECORD` (
  `SID` int(11) NOT NULL AUTO_INCREMENT,
  `USID_FROM` int(11) NOT NULL COMMENT '发言人sid',
  `SCENE_TYPE` tinyint(1) NOT NULL COMMENT '场景类型',
  `SCENE_ID` int(11) NOT NULL COMMENT '场景id',
  `STATUS` tinyint(1) NOT NULL COMMENT '状态',
  `CREATE_TIME` datetime NOT NULL COMMENT '创建时间',
  `CONTENT` text NOT NULL COMMENT '聊天内容',
  `CONTENT_TYPE` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`SID`)
) ENGINE=InnoDB AUTO_INCREMENT=882 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of T_MIM_CHAT_RECORD
-- ----------------------------
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('265', '13', '3', '14', '1', '2017-06-21 15:35:39', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('266', '14', '3', '13', '1', '2017-06-21 15:35:48', '2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('267', '14', '3', '13', '1', '2017-06-21 15:35:59', '{\"fid\":\"20170621153559134\",\"sid\":7,\"type\":\"jpeg\",\"filter\":\"image\",\"destription\":null,\"name\":\"Penguins.jpg\",\"size\":\"777835\",\"create_time\":\"2017-06-21 15:35:59\",\"suffix\":\"jpg\",\"src\":\"..\\/upload_file\\/2017\\/06\\/21\\/20170621153559134.jpg\",\"width\":\"1024\",\"height\":\"768\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('268', '13', '3', '14', '1', '2017-06-21 15:36:15', '{\"fid\":\"20170621153615861\",\"sid\":8,\"type\":\"jpeg\",\"filter\":\"image\",\"destription\":null,\"name\":\"Tulips.jpg\",\"size\":\"620888\",\"create_time\":\"2017-06-21 15:36:15\",\"suffix\":\"jpg\",\"src\":\"..\\/upload_file\\/2017\\/06\\/21\\/20170621153615861.jpg\",\"width\":\"1024\",\"height\":\"768\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('269', '14', '3', '13', '1', '2017-06-21 15:36:23', '{\"fid\":\"20170621153623302\",\"sid\":9,\"type\":\"jpeg\",\"filter\":\"image\",\"destription\":null,\"name\":\"Lighthouse.jpg\",\"size\":\"561276\",\"create_time\":\"2017-06-21 15:36:23\",\"suffix\":\"jpg\",\"src\":\"..\\/upload_file\\/2017\\/06\\/21\\/20170621153623302.jpg\",\"width\":\"1024\",\"height\":\"768\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('270', '14', '3', '13', '1', '2017-06-21 15:36:31', '{\"fid\":\"20170621153631422\",\"sid\":10,\"type\":\"jpeg\",\"filter\":\"image\",\"destription\":null,\"name\":\"Koala.jpg\",\"size\":\"780831\",\"create_time\":\"2017-06-21 15:36:31\",\"suffix\":\"jpg\",\"src\":\"..\\/upload_file\\/2017\\/06\\/21\\/20170621153631422.jpg\",\"width\":\"1024\",\"height\":\"768\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('271', '14', '3', '13', '1', '2017-06-30 09:26:53', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('272', '13', '3', '14', '1', '2017-06-30 09:28:32', '111\n', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('273', '14', '3', '13', '1', '2017-06-30 09:32:22', '333', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('274', '13', '3', '14', '1', '2017-06-30 09:32:30', '4', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('275', '14', '3', '13', '1', '2017-06-30 09:48:15', '{\"fid\":\"20170630094815981\",\"sid\":11,\"type\":\"png\",\"filter\":\"image\",\"destription\":null,\"name\":\"464.png\",\"size\":\"524\",\"create_time\":\"2017-06-30 09:48:15\",\"suffix\":\"png\",\"src\":\"..\\/upload_file\\/2017\\/06\\/30\\/20170630094815981.png\",\"width\":\"97\",\"height\":\"29\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('276', '14', '3', '13', '1', '2017-06-30 09:50:12', '{\"fid\":\"20170630095012840\",\"sid\":12,\"type\":\"png\",\"filter\":\"image\",\"destription\":null,\"name\":\"491.png\",\"size\":\"73668\",\"create_time\":\"2017-06-30 09:50:12\",\"suffix\":\"png\",\"src\":\"..\\/upload_file\\/2017\\/06\\/30\\/20170630095012840.png\",\"width\":\"800\",\"height\":\"800\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('277', '14', '3', '13', '1', '2017-06-30 09:51:17', '123', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('278', '14', '3', '13', '1', '2017-06-30 09:52:42', '{\"fid\":\"20170630095242995\",\"sid\":13,\"type\":\"png\",\"filter\":\"image\",\"destription\":null,\"name\":\"313.png\",\"size\":\"73668\",\"create_time\":\"2017-06-30 09:52:42\",\"suffix\":\"png\",\"src\":\"..\\/upload_file\\/2017\\/06\\/30\\/20170630095242995.png\",\"width\":\"800\",\"height\":\"800\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('279', '14', '3', '13', '1', '2017-06-30 10:02:34', '{\"fid\":\"20170630100234390\",\"sid\":14,\"type\":\"png\",\"filter\":\"image\",\"destription\":null,\"name\":\"154.png\",\"size\":\"73668\",\"create_time\":\"2017-06-30 10:02:34\",\"suffix\":\"png\",\"src\":\"..\\/upload_file\\/2017\\/06\\/30\\/20170630100234390.png\",\"width\":\"800\",\"height\":\"800\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('280', '14', '3', '13', '1', '2017-06-30 10:08:31', '{\"fid\":\"20170630100831995\",\"sid\":15,\"type\":\"png\",\"filter\":\"image\",\"destription\":null,\"name\":\"847.png\",\"size\":\"73668\",\"create_time\":\"2017-06-30 10:08:31\",\"suffix\":\"png\",\"src\":\"..\\/upload_file\\/2017\\/06\\/30\\/20170630100831995.png\",\"width\":\"800\",\"height\":\"800\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('281', '13', '3', '14', '1', '2017-06-30 10:09:14', '{\"fid\":\"20170630100914242\",\"sid\":16,\"type\":\"png\",\"filter\":\"image\",\"destription\":null,\"name\":\"498.png\",\"size\":\"92879\",\"create_time\":\"2017-06-30 10:09:14\",\"suffix\":\"png\",\"src\":\"..\\/upload_file\\/2017\\/06\\/30\\/20170630100914242.png\",\"width\":\"800\",\"height\":\"800\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('282', '13', '3', '14', '1', '2017-06-30 10:10:13', '{\"fid\":\"20170630101013697\",\"sid\":17,\"type\":\"png\",\"filter\":\"image\",\"destription\":null,\"name\":\"967.png\",\"size\":\"92879\",\"create_time\":\"2017-06-30 10:10:13\",\"suffix\":\"png\",\"src\":\"..\\/upload_file\\/2017\\/06\\/30\\/20170630101013697.png\",\"width\":\"800\",\"height\":\"800\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('283', '14', '3', '13', '1', '2017-06-30 10:10:43', '{\"fid\":\"20170630101043144\",\"sid\":18,\"type\":\"png\",\"filter\":\"image\",\"destription\":null,\"name\":\"374.png\",\"size\":\"73668\",\"create_time\":\"2017-06-30 10:10:43\",\"suffix\":\"png\",\"src\":\"..\\/upload_file\\/2017\\/06\\/30\\/20170630101043144.png\",\"width\":\"800\",\"height\":\"800\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('284', '14', '3', '13', '1', '2017-06-30 10:11:38', 'http://192.168.1.189/moa/application/index.php?/index', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('285', '14', '3', '13', '1', '2017-06-30 10:11:43', '123123', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('286', '14', '3', '13', '1', '2017-06-30 10:11:47', 'hdfadfhttp://192.168.1.189/moa/application/index.php?/index', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('287', '14', '3', '13', '1', '2017-06-30 10:11:58', 'hdfadfhttp192.168.1.189/moa/application/index.php?/index', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('288', '14', '3', '13', '1', '2017-06-30 10:12:04', 'hdfadfhttp192.168.1.189/', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('289', '14', '3', '13', '1', '2017-06-30 10:12:10', '/', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('290', '14', '3', '13', '1', '2017-06-30 10:12:25', '/', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('291', '14', '3', '13', '1', '2017-06-30 10:12:36', '<a>', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('292', '14', '3', '13', '1', '2017-06-30 10:13:04', '/', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('293', '14', '3', '13', '1', '2017-06-30 10:13:08', '/', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('294', '14', '3', '13', '1', '2017-06-30 10:15:04', '{\"fid\":\"20170630101504432\",\"sid\":19,\"type\":\"jpeg\",\"filter\":\"image\",\"destription\":null,\"name\":\"Penguins.jpg\",\"size\":\"777835\",\"create_time\":\"2017-06-30 10:15:04\",\"suffix\":\"jpg\",\"src\":\"..\\/upload_file\\/2017\\/06\\/30\\/20170630101504432.jpg\",\"width\":\"1024\",\"height\":\"768\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('295', '14', '3', '13', '1', '2017-06-30 10:15:12', '{\"fid\":\"20170630101512544\",\"sid\":20,\"type\":\"text\\/xml\",\"filter\":\"doc\",\"destription\":null,\"name\":\"vgroup.xml\",\"size\":\"61\",\"create_time\":\"2017-06-30 10:15:12\",\"suffix\":\"xml\",\"src\":\"..\\/upload_file\\/2017\\/06\\/30\\/20170630101512544.xml\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('296', '14', '3', '13', '1', '2017-06-30 10:41:34', '{\"fid\":\"20170630104134219\",\"sid\":23,\"type\":\"text\\/xml\",\"filter\":\"doc\",\"destription\":null,\"name\":\"vgroup.xml\",\"size\":\"61\",\"create_time\":\"2017-06-30 10:41:34\",\"suffix\":\"xml\",\"src\":\"..\\/upload_file\\/2017\\/06\\/30\\/20170630104134219.xml\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('297', '14', '3', '13', '1', '2017-06-30 10:42:38', '{\"fid\":\"20170630104238273\",\"sid\":24,\"type\":\"text\\/xml\",\"filter\":\"doc\",\"destription\":null,\"name\":\"vgroup.xml\",\"size\":\"61\",\"create_time\":\"2017-06-30 10:42:38\",\"suffix\":\"xml\",\"src\":\"..\\/upload_file\\/2017\\/06\\/30\\/20170630104238273.xml\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('298', '14', '3', '13', '1', '2017-06-30 10:45:00', '{\"fid\":\"20170630104500922\",\"sid\":25,\"type\":\"text\\/xml\",\"filter\":\"doc\",\"destription\":null,\"name\":\"vgroup.xml\",\"size\":\"61\",\"create_time\":\"2017-06-30 10:45:00\",\"suffix\":\"xml\",\"src\":\"..\\/upload_file\\/2017\\/06\\/30\\/20170630104500922.xml\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('299', '14', '3', '13', '1', '2017-06-30 10:46:30', '{\"fid\":\"20170630104630674\",\"sid\":26,\"type\":\"jps\",\"filter\":\"\",\"destription\":null,\"name\":\"devil may crry 4 - 2 - esrb t pegi 12+.jps\",\"size\":\"332260\",\"create_time\":\"2017-06-30 10:46:30\",\"suffix\":\"jps\",\"src\":\"..\\/upload_file\\/2017\\/06\\/30\\/20170630104630674.jps\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('300', '14', '3', '13', '1', '2017-06-30 10:49:01', '{\"fid\":\"20170630104901370\",\"sid\":27,\"type\":\"application\\/octet-stream\",\"filter\":\"\",\"destription\":null,\"name\":\"bitoa.conf\",\"size\":\"377\",\"create_time\":\"2017-06-30 10:49:01\",\"suffix\":\"conf\",\"src\":\"..\\/upload_file\\/2017\\/06\\/30\\/20170630104901370.conf\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('301', '14', '3', '13', '1', '2017-06-30 10:49:01', '{\"fid\":\"20170630104901798\",\"sid\":28,\"type\":\"jpeg\",\"filter\":\"image\",\"destription\":null,\"name\":\"Lighthouse.jpg\",\"size\":\"561276\",\"create_time\":\"2017-06-30 10:49:01\",\"suffix\":\"jpg\",\"src\":\"..\\/upload_file\\/2017\\/06\\/30\\/20170630104901798.jpg\",\"width\":\"1024\",\"height\":\"768\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('302', '14', '3', '13', '1', '2017-06-30 11:02:21', '{\"fid\":\"20170630110221142\",\"sid\":29,\"type\":\"application\\/octet-stream\",\"filter\":\"\",\"destription\":null,\"name\":\"bitoa.conf\",\"size\":\"377\",\"create_time\":\"2017-06-30 11:02:21\",\"suffix\":\"conf\",\"src\":\"..\\/upload_file\\/2017\\/06\\/30\\/20170630110221142.conf\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('303', '14', '3', '13', '1', '2017-06-30 11:02:21', '{\"fid\":\"20170630110221850\",\"sid\":30,\"type\":\"jpeg\",\"filter\":\"image\",\"destription\":null,\"name\":\"Lighthouse.jpg\",\"size\":\"561276\",\"create_time\":\"2017-06-30 11:02:21\",\"suffix\":\"jpg\",\"src\":\"..\\/upload_file\\/2017\\/06\\/30\\/20170630110221850.jpg\",\"width\":\"1024\",\"height\":\"768\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('304', '13', '3', '14', '1', '2017-07-03 17:02:27', '大豆', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('305', '13', '3', '14', '1', '2017-07-03 17:02:31', 'd', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('306', '13', '3', '14', '1', '2017-07-03 17:02:32', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('307', '13', '3', '14', '1', '2017-07-03 17:03:56', '电风扇伏阁受读风格', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('308', '13', '3', '14', '1', '2017-07-03 17:07:34', '达到顶峰', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('309', '13', '3', '14', '1', '2017-07-03 17:09:06', '大豆', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('310', '13', '3', '14', '1', '2017-07-03 17:09:55', '大豆', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('311', '14', '3', '13', '1', '2017-07-03 17:10:59', '啊啊啊', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('312', '13', '3', '14', '1', '2017-07-03 17:11:36', '11', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('313', '13', '3', '14', '1', '2017-07-03 17:11:43', '你好', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('314', '13', '3', '14', '1', '2017-07-03 17:12:34', '大豆', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('315', '13', '3', '14', '1', '2017-07-03 17:12:38', '1234234', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('316', '13', '3', '14', '1', '2017-07-03 17:12:40', '11111', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('317', '13', '3', '14', '1', '2017-07-03 17:12:43', '骨灰盒', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('318', '14', '3', '13', '1', '2017-07-03 17:12:44', '阿达的', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('319', '13', '3', '14', '1', '2017-07-03 17:12:45', '顶顶顶顶的', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('320', '13', '3', '14', '1', '2017-07-03 17:12:59', 'dfadfadf', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('321', '13', '3', '14', '1', '2017-07-03 17:13:19', '<script>alert()</script>', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('322', '14', '3', '13', '1', '2017-07-03 17:15:25', '啊啊', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('323', '13', '3', '14', '1', '2017-07-03 17:15:59', '{\"fid\":\"20170703171559373\",\"sid\":32,\"type\":\"text\\/xml\",\"filter\":\"doc\",\"destription\":null,\"name\":\"vgroup.xml\",\"size\":\"61\",\"create_time\":\"2017-07-03 17:15:59\",\"suffix\":\"xml\",\"src\":\"..\\/upload_file\\/2017\\/07\\/03\\/20170703171559373.xml\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('324', '13', '3', '14', '1', '2017-07-03 17:16:17', '地方法分发给', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('325', '13', '3', '14', '1', '2017-07-03 17:17:18', '{\"fid\":\"20170703171718682\",\"sid\":33,\"type\":\"png\",\"filter\":\"image\",\"destription\":null,\"name\":\"820.png\",\"size\":\"430643\",\"create_time\":\"2017-07-03 17:17:18\",\"suffix\":\"png\",\"src\":\"..\\/upload_file\\/2017\\/07\\/03\\/20170703171718682.png\",\"width\":\"1200\",\"height\":\"463\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('326', '13', '3', '14', '1', '2017-07-03 17:27:02', '{\"fid\":\"20170703172702310\",\"sid\":34,\"type\":\"png\",\"filter\":\"image\",\"destription\":null,\"name\":\"190.png\",\"size\":\"430643\",\"create_time\":\"2017-07-03 17:27:02\",\"suffix\":\"png\",\"src\":\"..\\/upload_file\\/2017\\/07\\/03\\/20170703172702310.png\",\"width\":\"1200\",\"height\":\"463\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('327', '13', '3', '14', '1', '2017-07-03 17:30:09', '阿道夫', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('328', '13', '3', '14', '1', '2017-07-03 17:32:31', '123', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('329', '13', '3', '14', '1', '2017-07-03 17:34:02', '{\"fid\":\"20170703173402545\",\"sid\":35,\"type\":\"png\",\"filter\":\"image\",\"destription\":null,\"name\":\"417.png\",\"size\":\"527116\",\"create_time\":\"2017-07-03 17:34:02\",\"suffix\":\"png\",\"src\":\"..\\/upload_file\\/2017\\/07\\/03\\/20170703173402545.png\",\"width\":\"1339\",\"height\":\"934\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('330', '13', '3', '14', '1', '2017-07-03 17:34:09', '{\"fid\":\"20170703173407398\",\"sid\":36,\"type\":\"png\",\"filter\":\"image\",\"destription\":null,\"name\":\"145.png\",\"size\":\"527116\",\"create_time\":\"2017-07-03 17:34:07\",\"suffix\":\"png\",\"src\":\"..\\/upload_file\\/2017\\/07\\/03\\/20170703173407398.png\",\"width\":\"1339\",\"height\":\"934\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('331', '13', '3', '14', '1', '2017-07-03 17:34:09', '{\"fid\":\"20170703173408528\",\"sid\":37,\"type\":\"png\",\"filter\":\"image\",\"destription\":null,\"name\":\"855.png\",\"size\":\"527116\",\"create_time\":\"2017-07-03 17:34:08\",\"suffix\":\"png\",\"src\":\"..\\/upload_file\\/2017\\/07\\/03\\/20170703173408528.png\",\"width\":\"1339\",\"height\":\"934\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('332', '13', '3', '14', '1', '2017-07-03 17:34:09', '{\"fid\":\"2017070317340868\",\"sid\":38,\"type\":\"png\",\"filter\":\"image\",\"destription\":null,\"name\":\"501.png\",\"size\":\"527116\",\"create_time\":\"2017-07-03 17:34:08\",\"suffix\":\"png\",\"src\":\"..\\/upload_file\\/2017\\/07\\/03\\/2017070317340868.png\",\"width\":\"1339\",\"height\":\"934\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('333', '13', '3', '14', '1', '2017-07-03 17:34:12', '{\"fid\":\"20170703173410596\",\"sid\":39,\"type\":\"png\",\"filter\":\"image\",\"destription\":null,\"name\":\"111.png\",\"size\":\"527116\",\"create_time\":\"2017-07-03 17:34:10\",\"suffix\":\"png\",\"src\":\"..\\/upload_file\\/2017\\/07\\/03\\/20170703173410596.png\",\"width\":\"1339\",\"height\":\"934\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('334', '13', '3', '14', '1', '2017-07-03 17:34:18', '{\"fid\":\"2017070317341872\",\"sid\":40,\"type\":\"png\",\"filter\":\"image\",\"destription\":null,\"name\":\"850.png\",\"size\":\"527116\",\"create_time\":\"2017-07-03 17:34:18\",\"suffix\":\"png\",\"src\":\"..\\/upload_file\\/2017\\/07\\/03\\/2017070317341872.png\",\"width\":\"1339\",\"height\":\"934\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('335', '13', '3', '14', '1', '2017-07-03 17:34:18', '{\"fid\":\"20170703173418485\",\"sid\":41,\"type\":\"png\",\"filter\":\"image\",\"destription\":null,\"name\":\"369.png\",\"size\":\"527116\",\"create_time\":\"2017-07-03 17:34:18\",\"suffix\":\"png\",\"src\":\"..\\/upload_file\\/2017\\/07\\/03\\/20170703173418485.png\",\"width\":\"1339\",\"height\":\"934\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('336', '13', '3', '14', '1', '2017-07-03 17:34:18', '{\"fid\":\"20170703173418589\",\"sid\":42,\"type\":\"png\",\"filter\":\"image\",\"destription\":null,\"name\":\"759.png\",\"size\":\"527116\",\"create_time\":\"2017-07-03 17:34:18\",\"suffix\":\"png\",\"src\":\"..\\/upload_file\\/2017\\/07\\/03\\/20170703173418589.png\",\"width\":\"1339\",\"height\":\"934\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('337', '13', '3', '14', '1', '2017-07-03 17:36:32', '{\"fid\":\"20170703173632716\",\"sid\":43,\"type\":\"png\",\"filter\":\"image\",\"destription\":null,\"name\":\"877.png\",\"size\":\"527116\",\"create_time\":\"2017-07-03 17:36:32\",\"suffix\":\"png\",\"src\":\"..\\/upload_file\\/2017\\/07\\/03\\/20170703173632716.png\",\"width\":\"1339\",\"height\":\"934\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('338', '14', '3', '13', '1', '2017-07-03 17:37:25', '你好', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('339', '13', '3', '14', '1', '2017-07-03 17:42:00', '{\"fid\":\"20170703174200435\",\"sid\":44,\"type\":\"jpeg\",\"filter\":\"image\",\"destription\":null,\"name\":\"331.jpeg\",\"size\":\"30557\",\"create_time\":\"2017-07-03 17:42:00\",\"suffix\":\"jpeg\",\"src\":\"..\\/upload_file\\/2017\\/07\\/03\\/20170703174200435.jpeg\",\"width\":\"310\",\"height\":\"220\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('340', '14', '3', '13', '1', '2017-07-04 10:07:37', '123', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('341', '13', '3', '14', '1', '2017-07-04 10:10:27', '{\"fid\":\"20170704101027663\",\"sid\":48,\"type\":\"jpeg\",\"filter\":\"image\",\"destription\":null,\"name\":\"2.jpg\",\"size\":\"157192\",\"create_time\":\"2017-07-04 10:10:27\",\"suffix\":\"jpg\",\"src\":\"..\\/upload_file\\/2017\\/07\\/04\\/20170704101027663.jpg\",\"width\":\"956\",\"height\":\"945\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('342', '14', '3', '13', '1', '2017-07-04 14:46:27', 'aaa', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('343', '14', '3', '13', '1', '2017-07-04 14:46:33', '333', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('344', '13', '3', '14', '1', '2017-07-04 14:55:22', '你好', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('345', '13', '3', '14', '1', '2017-07-04 14:55:38', '{\"fid\":\"201707041455380\",\"sid\":49,\"type\":\"jpeg\",\"filter\":\"image\",\"destription\":null,\"name\":\"Desert.jpg\",\"size\":\"845941\",\"create_time\":\"2017-07-04 14:55:38\",\"suffix\":\"jpg\",\"src\":\"..\\/upload_file\\/2017\\/07\\/04\\/201707041455380.jpg\",\"width\":\"1024\",\"height\":\"768\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('346', '13', '3', '14', '1', '2017-07-05 10:25:48', '{\"fid\":\"20170705102541435\",\"sid\":52,\"type\":\"jpeg\",\"filter\":\"image\",\"destription\":null,\"name\":\"Lighthouse.jpg\",\"size\":\"561276\",\"create_time\":\"2017-07-05 10:25:41\",\"suffix\":\"jpg\",\"src\":\"..\\/upload_file\\/2017\\/07\\/05\\/20170705102541435.jpg\",\"width\":\"1024\",\"height\":\"768\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('347', '13', '3', '14', '1', '2017-07-05 10:28:09', '{\"fid\":\"20170705102807960\",\"sid\":56,\"type\":\"jpeg\",\"filter\":\"image\",\"destription\":null,\"name\":\"Tulips.jpg\",\"size\":\"620888\",\"create_time\":\"2017-07-05 10:28:07\",\"suffix\":\"jpg\",\"src\":\"..\\/upload_file\\/2017\\/07\\/05\\/20170705102807960.jpg\",\"width\":\"1024\",\"height\":\"768\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('348', '13', '3', '14', '1', '2017-07-05 10:29:37', '{\"fid\":\"20170705102933439\",\"sid\":57,\"type\":\"jpeg\",\"filter\":\"image\",\"destription\":null,\"name\":\"Desert.jpg\",\"size\":\"845941\",\"create_time\":\"2017-07-05 10:29:33\",\"suffix\":\"jpg\",\"src\":\"..\\/upload_file\\/2017\\/07\\/05\\/20170705102933439.jpg\",\"width\":\"1024\",\"height\":\"768\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('349', '13', '3', '14', '1', '2017-07-05 11:03:36', '{\"fid\":\"20170705110333321\",\"sid\":62,\"type\":\"jpeg\",\"filter\":\"image\",\"destription\":null,\"name\":\"Hydrangeas.jpg\",\"size\":\"595284\",\"create_time\":\"2017-07-05 11:03:33\",\"suffix\":\"jpg\",\"src\":\"..\\/upload_file\\/2017\\/07\\/05\\/20170705110333321.jpg\",\"width\":\"1024\",\"height\":\"768\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('350', '13', '3', '14', '1', '2017-07-05 15:51:25', '{\"fid\":\"20170705155115244\",\"sid\":63,\"type\":\"jpeg\",\"filter\":\"image\",\"destription\":null,\"name\":\"Desert.jpg\",\"size\":\"845941\",\"create_time\":\"2017-07-05 15:51:15\",\"suffix\":\"jpg\",\"src\":\"..\\/upload_file\\/2017\\/07\\/05\\/20170705155115244.jpg\",\"width\":\"1024\",\"height\":\"768\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('351', '13', '3', '14', '1', '2017-07-05 16:37:13', '{\"fid\":\"20170705163708175\",\"sid\":65,\"type\":\"jpeg\",\"filter\":\"image\",\"destription\":null,\"name\":\"Hydrangeas.jpg\",\"size\":\"595284\",\"create_time\":\"2017-07-05 16:37:08\",\"suffix\":\"jpg\",\"src\":\"..\\/upload_file\\/2017\\/07\\/05\\/20170705163708175.jpg\",\"width\":\"1024\",\"height\":\"768\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('352', '13', '3', '14', '1', '2017-07-05 16:38:03', '111', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('353', '13', '3', '14', '1', '2017-07-05 16:38:07', '1111', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('354', '13', '3', '14', '1', '2017-07-05 16:38:14', '22', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('355', '13', '3', '14', '1', '2017-07-05 16:44:42', '{\"fid\":\"20170705164441882\",\"sid\":67,\"type\":\"jpeg\",\"filter\":\"image\",\"destription\":null,\"name\":\"Chrysanthemum.jpg\",\"size\":\"879394\",\"create_time\":\"2017-07-05 16:44:41\",\"suffix\":\"jpg\",\"src\":\"..\\/upload_file\\/2017\\/07\\/05\\/20170705164441882.jpg\",\"width\":\"1024\",\"height\":\"768\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('356', '13', '3', '14', '1', '2017-07-05 16:44:49', '12121212', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('357', '13', '3', '14', '1', '2017-07-05 16:46:06', '12312321', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('358', '13', '3', '14', '1', '2017-07-05 16:49:34', '{\"fid\":\"2017070516493180\",\"sid\":68,\"type\":\"jpeg\",\"filter\":\"image\",\"destription\":null,\"name\":\"Chrysanthemum.jpg\",\"size\":\"879394\",\"create_time\":\"2017-07-05 16:49:31\",\"suffix\":\"jpg\",\"src\":\"..\\/upload_file\\/2017\\/07\\/05\\/2017070516493180.jpg\",\"width\":\"1024\",\"height\":\"768\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('359', '13', '3', '14', '1', '2017-07-05 16:49:39', '12313123', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('360', '13', '3', '14', '1', '2017-07-05 16:49:55', '12312', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('361', '13', '3', '14', '1', '2017-07-05 16:51:48', '165156', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('362', '13', '3', '14', '1', '2017-07-05 16:52:48', '12', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('363', '13', '3', '14', '1', '2017-07-05 16:53:23', '1231', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('364', '13', '3', '14', '1', '2017-07-05 16:54:08', '123213', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('365', '13', '3', '14', '1', '2017-07-05 16:54:12', ' 12312313', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('366', '13', '3', '14', '1', '2017-07-05 16:54:13', ' 12312313', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('367', '13', '3', '14', '1', '2017-07-05 16:54:15', ' 1231231', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('368', '13', '3', '14', '1', '2017-07-05 16:54:16', ' 12312313', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('369', '13', '3', '14', '1', '2017-07-05 16:54:19', ' 33333', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('370', '13', '3', '14', '1', '2017-07-05 16:54:26', ' 3333', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('371', '13', '3', '14', '1', '2017-07-05 16:54:34', ' 你好', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('372', '13', '3', '14', '1', '2017-07-05 16:54:34', ' ', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('373', '13', '3', '14', '1', '2017-07-05 16:54:38', ' 123', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('374', '13', '3', '14', '1', '2017-07-05 16:56:25', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('375', '13', '3', '14', '1', '2017-07-05 16:56:26', ' 2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('376', '13', '3', '14', '1', '2017-07-05 16:56:28', ' 3', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('377', '13', '3', '14', '1', '2017-07-05 16:56:29', ' 4', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('378', '13', '3', '14', '1', '2017-07-05 16:56:37', ' 5', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('379', '13', '3', '14', '1', '2017-07-05 16:56:40', ' 6', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('380', '13', '3', '14', '1', '2017-07-05 16:56:42', ' 7', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('381', '13', '3', '14', '1', '2017-07-05 16:56:46', ' 8', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('382', '13', '3', '14', '1', '2017-07-05 16:56:49', ' 9', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('383', '13', '3', '14', '1', '2017-07-05 16:56:52', ' 10', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('384', '13', '3', '14', '1', '2017-07-05 17:01:16', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('385', '13', '3', '14', '1', '2017-07-05 17:01:17', ' 2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('386', '13', '3', '14', '1', '2017-07-05 17:01:19', ' 3', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('387', '13', '3', '14', '1', '2017-07-05 17:01:20', ' 4', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('388', '13', '3', '14', '1', '2017-07-05 17:01:23', ' 6', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('389', '13', '3', '14', '1', '2017-07-05 17:01:25', ' 2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('390', '13', '3', '14', '1', '2017-07-05 17:01:28', ' 3', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('391', '13', '3', '14', '1', '2017-07-05 17:01:34', ' 2313', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('392', '13', '3', '14', '1', '2017-07-05 17:01:37', ' 1212', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('393', '13', '3', '14', '1', '2017-07-05 17:03:44', ' 13213', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('394', '13', '3', '14', '1', '2017-07-05 17:05:28', '12', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('395', '13', '3', '14', '1', '2017-07-05 17:05:30', '123', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('396', '13', '3', '14', '1', '2017-07-05 17:06:07', '12', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('397', '13', '3', '14', '1', '2017-07-05 17:06:09', ' 32', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('398', '13', '3', '14', '1', '2017-07-05 17:06:11', ' 1231', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('399', '13', '3', '14', '1', '2017-07-05 17:06:13', ' 123323', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('400', '13', '3', '14', '1', '2017-07-05 17:06:16', ' 1231232131', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('401', '13', '3', '14', '1', '2017-07-05 17:06:19', ' 55555', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('402', '13', '3', '14', '1', '2017-07-05 17:06:22', ' 6666', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('403', '13', '3', '14', '1', '2017-07-05 17:06:25', ' 498', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('404', '13', '3', '14', '1', '2017-07-05 17:06:29', ' 12312', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('405', '13', '3', '14', '1', '2017-07-05 17:06:33', ' 1111', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('406', '13', '3', '14', '1', '2017-07-05 17:06:36', ' 12312', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('407', '13', '3', '14', '1', '2017-07-05 17:10:09', '21212', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('408', '13', '3', '14', '1', '2017-07-05 17:10:11', ' 313131', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('409', '13', '3', '14', '1', '2017-07-05 17:10:12', ' 1331', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('410', '13', '3', '14', '1', '2017-07-05 17:10:14', ' 3113', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('411', '13', '3', '14', '1', '2017-07-05 17:10:16', ' 13111', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('412', '13', '3', '14', '1', '2017-07-05 17:10:19', ' 3333', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('413', '13', '3', '14', '1', '2017-07-05 17:11:19', '1111', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('414', '13', '3', '14', '1', '2017-07-05 17:11:21', ' 2222', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('415', '13', '3', '14', '1', '2017-07-05 17:11:22', ' 3333', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('416', '13', '3', '14', '1', '2017-07-05 17:11:24', ' 4444', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('417', '13', '3', '14', '1', '2017-07-05 17:12:27', ' 555', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('418', '13', '3', '14', '1', '2017-07-05 17:12:54', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('419', '13', '3', '14', '1', '2017-07-05 17:12:55', ' 2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('420', '13', '3', '14', '1', '2017-07-05 17:12:57', ' 3', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('421', '13', '3', '14', '1', '2017-07-05 17:12:58', ' 4', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('422', '13', '3', '14', '1', '2017-07-05 17:13:00', ' 5', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('423', '13', '3', '14', '1', '2017-07-05 17:13:02', ' 6', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('424', '13', '3', '14', '1', '2017-07-05 17:13:03', ' 7', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('425', '13', '3', '14', '1', '2017-07-05 17:13:05', ' 8', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('426', '13', '3', '14', '1', '2017-07-05 17:13:06', ' 9', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('427', '13', '3', '14', '1', '2017-07-05 17:13:09', ' 10', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('428', '13', '3', '14', '1', '2017-07-05 17:13:11', ' 11', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('429', '13', '3', '14', '1', '2017-07-05 17:13:13', ' 12', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('430', '13', '3', '14', '1', '2017-07-05 17:13:16', ' 13', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('431', '13', '3', '14', '1', '2017-07-05 17:14:33', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('432', '13', '3', '14', '1', '2017-07-05 17:15:15', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('433', '13', '3', '14', '1', '2017-07-05 17:15:17', ' 2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('434', '13', '3', '14', '1', '2017-07-05 17:15:18', ' 3', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('435', '13', '3', '14', '1', '2017-07-05 17:15:19', ' 4', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('436', '13', '3', '14', '1', '2017-07-05 17:15:20', ' 5', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('437', '13', '3', '14', '1', '2017-07-05 17:15:21', ' 6', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('438', '13', '3', '14', '1', '2017-07-05 17:15:22', ' ', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('439', '13', '3', '14', '1', '2017-07-05 17:15:23', ' 7', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('440', '13', '3', '14', '1', '2017-07-05 17:15:24', ' ', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('441', '13', '3', '14', '1', '2017-07-05 17:15:29', ' 8', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('442', '13', '3', '14', '1', '2017-07-05 17:15:32', ' 9', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('443', '13', '3', '14', '1', '2017-07-05 17:18:13', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('444', '13', '3', '14', '1', '2017-07-05 17:18:13', ' ', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('445', '13', '3', '14', '1', '2017-07-05 17:18:14', ' 2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('446', '13', '3', '14', '1', '2017-07-05 17:18:15', ' 3', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('447', '13', '3', '14', '1', '2017-07-05 17:18:16', ' 4', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('448', '13', '3', '14', '1', '2017-07-05 17:18:31', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('449', '13', '3', '14', '1', '2017-07-05 17:18:32', ' 2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('450', '13', '3', '14', '1', '2017-07-05 17:18:33', ' 3', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('451', '13', '3', '14', '1', '2017-07-05 17:18:34', ' 4', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('452', '13', '3', '14', '1', '2017-07-05 17:18:36', ' 5', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('453', '13', '3', '14', '1', '2017-07-05 17:20:06', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('454', '13', '3', '14', '1', '2017-07-05 17:20:07', ' ', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('455', '13', '3', '14', '1', '2017-07-05 17:20:10', ' 2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('456', '13', '3', '14', '1', '2017-07-05 17:20:11', ' 3', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('457', '13', '3', '14', '1', '2017-07-05 17:20:17', ' 4', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('458', '13', '3', '14', '1', '2017-07-05 17:27:13', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('459', '13', '3', '14', '1', '2017-07-05 17:27:13', ' ', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('460', '13', '3', '14', '1', '2017-07-05 17:27:14', ' 2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('461', '13', '3', '14', '1', '2017-07-05 17:27:16', ' 3', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('462', '13', '3', '14', '1', '2017-07-05 17:27:17', ' 4', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('463', '13', '3', '14', '1', '2017-07-05 17:27:18', ' 5', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('464', '13', '3', '14', '1', '2017-07-10 09:46:17', '{\"fid\":\"20170710094613453\",\"sid\":71,\"type\":\"jpeg\",\"filter\":\"image\",\"destription\":null,\"name\":\"Desert.jpg\",\"size\":\"845941\",\"create_time\":\"2017-07-10 09:46:13\",\"suffix\":\"jpg\",\"src\":\"..\\/upload_file\\/2017\\/07\\/10\\/20170710094613453.jpg\",\"width\":\"1024\",\"height\":\"768\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('465', '13', '3', '14', '1', '2017-07-10 09:46:31', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('466', '13', '3', '14', '1', '2017-07-10 09:46:34', '2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('467', '13', '3', '14', '1', '2017-07-10 09:51:23', '{\"fid\":\"20170710095121279\",\"sid\":72,\"type\":\"jpeg\",\"filter\":\"image\",\"destription\":null,\"name\":\"Jellyfish.jpg\",\"size\":\"775702\",\"create_time\":\"2017-07-10 09:51:21\",\"suffix\":\"jpg\",\"src\":\"..\\/upload_file\\/2017\\/07\\/10\\/20170710095121279.jpg\",\"width\":\"1024\",\"height\":\"768\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('468', '13', '3', '14', '1', '2017-07-10 09:51:26', '1\n', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('469', '13', '3', '14', '1', '2017-07-10 09:51:28', '2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('470', '13', '3', '14', '1', '2017-07-10 09:51:47', '3', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('471', '13', '3', '14', '1', '2017-07-12 17:17:14', '你好', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('472', '13', '3', '14', '1', '2017-07-12 17:20:35', '你好', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('473', '13', '3', '14', '1', '2017-07-12 17:23:26', 'dafasdf', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('474', '13', '3', '14', '1', '2017-07-12 17:23:54', '代码没有用您这个示例. 如果是我的程序有问题的话，能不能给些思路呢，我现在不知道是自己哪里写的有问题，也不知道如何测试排除，崩溃时的崩溃信息显示错误模块是libcef.dll.另外，我是把用cef3显示的页面加载到了mfc的对话框里面，不知道您的网页是不是显示到浏览器中的。', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('475', '13', '3', '14', '1', '2017-07-12 17:27:01', '{\"fid\":\"20170712172659198\",\"sid\":73,\"type\":\"application\\/x-msdownload\",\"filter\":\"\",\"destription\":null,\"name\":\"libEGL.dll\",\"size\":\"75264\",\"create_time\":\"2017-07-12 17:26:59\",\"suffix\":\"dll\",\"src\":\"..\\/upload_file\\/2017\\/07\\/12\\/20170712172659198.dll\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('476', '13', '3', '14', '1', '2017-07-13 10:04:13', '{\"fid\":\"20170713100406879\",\"sid\":75,\"type\":\"application\\/octet-stream\",\"filter\":\"\",\"destription\":null,\"name\":\"\\u65b0\\u5efa WinRAR \\u538b\\u7f29\\u6587\\u4ef6.rar\",\"size\":\"20\",\"create_time\":\"2017-07-13 10:04:06\",\"suffix\":\"rar\",\"src\":\"..\\/upload_file\\/2017\\/07\\/13\\/20170713100406879.rar\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('477', '13', '3', '14', '1', '2017-07-13 10:06:06', '{\"fid\":\"20170713100603619\",\"sid\":76,\"type\":\"text\\/plain\",\"filter\":\"doc\",\"destription\":null,\"name\":\"\\u65b0\\u5efa\\u6587\\u672c\\u6587\\u6863 (2).txt\",\"size\":\"8\",\"create_time\":\"2017-07-13 10:06:03\",\"suffix\":\"txt\",\"src\":\"..\\/upload_file\\/2017\\/07\\/13\\/20170713100603619.txt\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('478', '13', '3', '14', '1', '2017-07-13 10:07:52', '{\"fid\":\"20170713100741879\",\"sid\":77,\"type\":\"text\\/plain\",\"filter\":\"doc\",\"destription\":null,\"name\":\"\\u65b0\\u5efa\\u6587\\u672c\\u6587\\u6863 (2).txt\",\"size\":\"8\",\"create_time\":\"2017-07-13 10:07:41\",\"suffix\":\"txt\",\"src\":\"..\\/upload_file\\/2017\\/07\\/13\\/20170713100741879.txt\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('479', '13', '3', '14', '1', '2017-07-13 10:08:54', '{\"fid\":\"20170713100851927\",\"sid\":78,\"type\":\"application\\/octet-stream\",\"filter\":\"\",\"destription\":null,\"name\":\"\\u65b0\\u5efa WinRAR \\u538b\\u7f29\\u6587\\u4ef6.rar\",\"size\":\"20\",\"create_time\":\"2017-07-13 10:08:51\",\"suffix\":\"rar\",\"src\":\"..\\/upload_file\\/2017\\/07\\/13\\/20170713100851927.rar\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('480', '13', '3', '14', '1', '2017-07-13 10:10:29', '{\"fid\":\"20170713101018180\",\"sid\":79,\"type\":\"jpeg\",\"filter\":\"image\",\"destription\":null,\"name\":\"Penguins.jpg\",\"size\":\"777835\",\"create_time\":\"2017-07-13 10:10:18\",\"suffix\":\"jpg\",\"src\":\"..\\/upload_file\\/2017\\/07\\/13\\/20170713101018180.jpg\",\"width\":\"1024\",\"height\":\"768\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('481', '14', '3', '13', '1', '2017-07-13 10:23:59', '{\"fid\":\"20170713102357115\",\"sid\":80,\"type\":\"application\\/octet-stream\",\"filter\":\"\",\"destription\":null,\"name\":\"1483245566117274.rar\",\"size\":\"118166\",\"create_time\":\"2017-07-13 10:23:57\",\"suffix\":\"rar\",\"src\":\"..\\/upload_file\\/2017\\/07\\/13\\/20170713102357115.rar\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('482', '13', '3', '14', '1', '2017-07-13 10:30:00', '{\"fid\":\"20170713102958429\",\"sid\":81,\"type\":\"application\\/x-msdownload\",\"filter\":\"\",\"destription\":null,\"name\":\"libEGL.dll\",\"size\":\"75264\",\"create_time\":\"2017-07-13 10:29:58\",\"suffix\":\"dll\",\"src\":\"..\\/upload_file\\/2017\\/07\\/13\\/20170713102958429.dll\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('483', '13', '3', '14', '1', '2017-07-13 11:31:51', '{\"fid\":\"20170713113149929\",\"sid\":87,\"type\":\"text\\/plain\",\"filter\":\"doc\",\"destription\":null,\"name\":\"URL.txt\",\"size\":\"32\",\"create_time\":\"2017-07-13 11:31:49\",\"suffix\":\"txt\",\"src\":\"..\\/upload_file\\/2017\\/07\\/13\\/20170713113149929.txt\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('484', '13', '3', '14', '1', '2017-07-13 11:32:43', '{\"fid\":\"20170713113242485\",\"sid\":88,\"type\":\"text\\/plain\",\"filter\":\"doc\",\"destription\":null,\"name\":\"LogHistory.txt\",\"size\":\"3085\",\"create_time\":\"2017-07-13 11:32:42\",\"suffix\":\"txt\",\"src\":\"..\\/upload_file\\/2017\\/07\\/13\\/20170713113242485.txt\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('485', '13', '3', '14', '1', '2017-07-13 11:39:13', '{\"fid\":\"20170713113907674\",\"sid\":89,\"type\":\"application\\/octet-stream\",\"filter\":\"\",\"destription\":null,\"name\":\"level0\",\"size\":\"11436\",\"create_time\":\"2017-07-13 11:39:07\",\"suffix\":\"evel0\",\"src\":\"..\\/upload_file\\/2017\\/07\\/13\\/20170713113907674.evel0\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('486', '13', '3', '14', '1', '2017-07-13 11:41:22', '{\"fid\":\"20170713114120224\",\"sid\":91,\"type\":\"text\\/xml\",\"filter\":\"doc\",\"destription\":null,\"name\":\"vgroup.xml\",\"size\":\"61\",\"create_time\":\"2017-07-13 11:41:20\",\"suffix\":\"xml\",\"src\":\"..\\/upload_file\\/2017\\/07\\/13\\/20170713114120224.xml\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('487', '13', '3', '14', '1', '2017-07-13 11:41:51', '{\"fid\":\"20170713114149332\",\"sid\":92,\"type\":\"application\\/octet-stream\",\"filter\":\"\",\"destription\":null,\"name\":\"natives_blob.bin\",\"size\":\"430257\",\"create_time\":\"2017-07-13 11:41:49\",\"suffix\":\"bin\",\"src\":\"..\\/upload_file\\/2017\\/07\\/13\\/20170713114149332.bin\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('488', '13', '3', '14', '1', '2017-07-13 11:45:17', '{\"fid\":\"20170713114515702\",\"sid\":93,\"type\":\"text\\/plain\",\"filter\":\"doc\",\"destription\":null,\"name\":\"URL.txt\",\"size\":\"69\",\"create_time\":\"2017-07-13 11:45:15\",\"suffix\":\"txt\",\"src\":\"..\\/upload_file\\/2017\\/07\\/13\\/20170713114515702.txt\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('489', '13', '3', '14', '1', '2017-07-13 13:56:08', '{\"fid\":\"20170713135603888\",\"sid\":94,\"type\":\"application\\/octet-stream\",\"filter\":\"\",\"destription\":null,\"name\":\"11111.rar\",\"size\":\"20\",\"create_time\":\"2017-07-13 13:56:03\",\"suffix\":\"rar\",\"src\":\"..\\/upload_file\\/2017\\/07\\/13\\/20170713135603888.rar\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('490', '13', '3', '14', '1', '2017-07-13 16:28:16', '{\"fid\":\"2017071316281447\",\"sid\":95,\"type\":\"application\\/octet-stream\",\"filter\":\"\",\"destription\":null,\"name\":\"level0\",\"size\":\"11436\",\"create_time\":\"2017-07-13 16:28:14\",\"suffix\":\"evel0\",\"src\":\"..\\/upload_file\\/2017\\/07\\/13\\/2017071316281447.evel0\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('491', '14', '3', '13', '1', '2017-07-13 16:51:42', '{\"fid\":\"20170713165139805\",\"sid\":96,\"type\":\"application\\/gzip\",\"filter\":\"\",\"destription\":null,\"name\":\"co.tar.gz\",\"size\":\"51394\",\"create_time\":\"2017-07-13 16:51:39\",\"suffix\":\"tar.gz\",\"src\":\"..\\/upload_file\\/2017\\/07\\/13\\/20170713165139805.tar.gz\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('492', '13', '3', '14', '1', '2017-07-13 17:28:26', '{\"fid\":\"20170713172824304\",\"sid\":97,\"type\":\"application\\/octet-stream\",\"filter\":\"\",\"destription\":null,\"name\":\"11111.rar\",\"size\":\"20\",\"create_time\":\"2017-07-13 17:28:24\",\"suffix\":\"rar\",\"src\":\"..\\/upload_file\\/2017\\/07\\/13\\/20170713172824304.rar\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('493', '14', '3', '13', '1', '2017-07-13 17:48:46', '{\"fid\":\"20170713174844783\",\"sid\":99,\"type\":\"text\\/plain\",\"filter\":\"doc\",\"destription\":null,\"name\":\"eoa\\u6d4b\\u8bd5\\u7528\\u6237.txt\",\"size\":\"232\",\"create_time\":\"2017-07-13 17:48:44\",\"suffix\":\"txt\",\"src\":\"..\\/upload_file\\/2017\\/07\\/13\\/20170713174844783.txt\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('494', '14', '3', '13', '1', '2017-07-13 17:50:37', '{\"fid\":\"20170713175034201\",\"sid\":100,\"type\":\"text\\/plain\",\"filter\":\"doc\",\"destription\":null,\"name\":\"eoa\\u6d4b\\u8bd5\\u7528\\u6237.txt\",\"size\":\"232\",\"create_time\":\"2017-07-13 17:50:34\",\"suffix\":\"txt\",\"src\":\"..\\/upload_file\\/2017\\/07\\/13\\/20170713175034201.txt\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('495', '14', '3', '13', '1', '2017-07-13 17:51:10', '{\"fid\":\"20170713175107662\",\"sid\":101,\"type\":\"text\\/plain\",\"filter\":\"doc\",\"destription\":null,\"name\":\"eoa\\u6d4b\\u8bd5\\u7528\\u6237.txt\",\"size\":\"232\",\"create_time\":\"2017-07-13 17:51:07\",\"suffix\":\"txt\",\"src\":\"..\\/upload_file\\/2017\\/07\\/13\\/20170713175107662.txt\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('496', '13', '3', '14', '1', '2017-07-14 10:10:34', '{\"fid\":\"20170714101030311\",\"sid\":102,\"type\":\"text\\/plain\",\"filter\":\"doc\",\"destription\":null,\"name\":\"\\u65b0\\u5efa\\u6587\\u672c\\u6587\\u6863 (2).txt\",\"size\":\"113\",\"create_time\":\"2017-07-14 10:10:30\",\"suffix\":\"txt\",\"src\":\"..\\/upload_file\\/2017\\/07\\/14\\/20170714101030311.txt\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('497', '13', '3', '14', '1', '2017-07-14 10:12:06', '{\"fid\":\"20170714101204216\",\"sid\":103,\"type\":\"text\\/html\",\"filter\":\"doc\",\"destription\":null,\"name\":\"tables.html\",\"size\":\"68953\",\"create_time\":\"2017-07-14 10:12:04\",\"suffix\":\"html\",\"src\":\"..\\/upload_file\\/2017\\/07\\/14\\/20170714101204216.html\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('498', '13', '3', '14', '1', '2017-07-14 10:13:46', '{\"fid\":\"20170714101344736\",\"sid\":104,\"type\":\"text\\/plain\",\"filter\":\"doc\",\"destription\":null,\"name\":\"1111.txt\",\"size\":\"7\",\"create_time\":\"2017-07-14 10:13:44\",\"suffix\":\"txt\",\"src\":\"..\\/upload_file\\/2017\\/07\\/14\\/20170714101344736.txt\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('499', '13', '3', '14', '1', '2017-07-14 10:15:12', '{\"fid\":\"20170714101510331\",\"sid\":105,\"type\":\"text\\/plain\",\"filter\":\"doc\",\"destription\":null,\"name\":\"1111.txt\",\"size\":\"7\",\"create_time\":\"2017-07-14 10:15:10\",\"suffix\":\"txt\",\"src\":\"..\\/upload_file\\/2017\\/07\\/14\\/20170714101510331.txt\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('500', '13', '3', '14', '1', '2017-07-14 10:16:23', '{\"fid\":\"20170714101620690\",\"sid\":106,\"type\":\"application\\/octet-stream\",\"filter\":\"\",\"destription\":null,\"name\":\"11111.rar\",\"size\":\"20\",\"create_time\":\"2017-07-14 10:16:20\",\"suffix\":\"rar\",\"src\":\"..\\/upload_file\\/2017\\/07\\/14\\/20170714101620690.rar\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('501', '13', '3', '14', '1', '2017-07-14 10:17:18', '{\"fid\":\"20170714101716565\",\"sid\":107,\"type\":\"application\\/octet-stream\",\"filter\":\"\",\"destription\":null,\"name\":\"1111.rar\",\"size\":\"79\",\"create_time\":\"2017-07-14 10:17:16\",\"suffix\":\"rar\",\"src\":\"..\\/upload_file\\/2017\\/07\\/14\\/20170714101716565.rar\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('502', '13', '3', '14', '1', '2017-07-14 10:22:32', '{\"fid\":\"20170714102228315\",\"sid\":108,\"type\":\"application\\/octet-stream\",\"filter\":\"\",\"destription\":null,\"name\":\"1111.rar\",\"size\":\"79\",\"create_time\":\"2017-07-14 10:22:28\",\"suffix\":\"rar\",\"src\":\"..\\/upload_file\\/2017\\/07\\/14\\/20170714102228315.rar\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('503', '13', '3', '14', '1', '2017-07-14 10:26:10', '{\"fid\":\"20170714102606724\",\"sid\":109,\"type\":\"text\\/html\",\"filter\":\"doc\",\"destription\":null,\"name\":\"user.html\",\"size\":\"23615\",\"create_time\":\"2017-07-14 10:26:06\",\"suffix\":\"html\",\"src\":\"\\/moa\\/upload_file\\/2017\\/07\\/14\\/20170714102606724.html\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('504', '14', '3', '13', '1', '2017-07-14 10:28:54', '{\"fid\":\"20170714102853221\",\"sid\":110,\"type\":\"text\\/html\",\"filter\":\"doc\",\"destription\":null,\"name\":\"treeview.html\",\"size\":\"23994\",\"create_time\":\"2017-07-14 10:28:53\",\"suffix\":\"html\",\"src\":\"http:\\/\\/192.168.1.189\\/moa\\/upload_file\\/2017\\/07\\/14\\/20170714102853221.html\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('505', '14', '3', '13', '1', '2017-07-14 10:53:29', '{\"fid\":\"20170714105327892\",\"sid\":111,\"type\":\"text\\/html\",\"filter\":\"doc\",\"destription\":null,\"name\":\"treeview.html\",\"size\":\"23994\",\"create_time\":\"2017-07-14 10:53:27\",\"suffix\":\"html\",\"src\":\"\\/var\\/www\\/html\\/moa\\/upload_file\\/2017\\/07\\/14\\/20170714105327892.html\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('506', '14', '3', '13', '1', '2017-07-14 10:54:12', '{\"fid\":\"20170714105411320\",\"sid\":112,\"type\":\"text\\/html\",\"filter\":\"doc\",\"destription\":null,\"name\":\"user.html\",\"size\":\"23615\",\"create_time\":\"2017-07-14 10:54:11\",\"suffix\":\"html\",\"src\":\"http:\\/\\/192.168.1.189\\/var\\/www\\/html\\/moa\\/upload_file\\/2017\\/07\\/14\\/20170714105411320.html\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('507', '14', '3', '13', '1', '2017-07-14 11:02:26', '{\"fid\":\"20170714110224556\",\"sid\":113,\"type\":\"text\\/html\",\"filter\":\"doc\",\"destription\":null,\"name\":\"tables.html\",\"size\":\"68953\",\"create_time\":\"2017-07-14 11:02:24\",\"suffix\":\"html\",\"src\":\"http:\\/\\/192.168.1.189\\/var\\/www\\/html\\/moa\\/upload_file\\/2017\\/07\\/14\\/20170714110224556.html\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('508', '14', '3', '13', '1', '2017-07-14 11:03:27', '{\"fid\":\"20170714110325540\",\"sid\":114,\"type\":\"text\\/html\",\"filter\":\"doc\",\"destription\":null,\"name\":\"form.html\",\"size\":\"8493\",\"create_time\":\"2017-07-14 11:03:25\",\"suffix\":\"html\",\"src\":\"http:\\/\\/192.168.1.189\\/var\\/www\\/html\\/moa\\/upload_file\\/2017\\/07\\/14\\/20170714110325540.html\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('509', '13', '3', '14', '1', '2017-07-14 11:09:56', '{\"fid\":\"2017071411095598\",\"sid\":115,\"type\":\"text\\/plain\",\"filter\":\"doc\",\"destription\":null,\"name\":\"\\u65b0\\u5efa\\u6587\\u672c\\u6587\\u6863 (2).txt\",\"size\":\"113\",\"create_time\":\"2017-07-14 11:09:55\",\"suffix\":\"txt\",\"src\":\"..\\/upload_file\\/2017\\/07\\/14\\/2017071411095598.txt\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('510', '14', '3', '13', '1', '2017-07-14 11:36:36', '{\"fid\":\"20170714113635121\",\"sid\":116,\"type\":\"text\\/html\",\"filter\":\"doc\",\"destription\":null,\"name\":\"page.html\",\"size\":\"7287\",\"create_time\":\"2017-07-14 11:36:35\",\"suffix\":\"html\",\"src\":\"http:\\/\\/192.168.1.189\\/moa\\/upload_file\\/2017\\/07\\/14\\/20170714113635121.html\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('511', '13', '3', '14', '1', '2017-07-14 11:45:14', '{\"fid\":\"20170714114511522\",\"sid\":117,\"type\":\"text\\/plain\",\"filter\":\"doc\",\"destription\":null,\"name\":\"\\u65b0\\u5efa\\u6587\\u672c\\u6587\\u6863 (2).txt\",\"size\":\"113\",\"create_time\":\"2017-07-14 11:45:11\",\"suffix\":\"txt\",\"src\":\"http:\\/\\/192.168.1.189\\/moa\\/upload_file\\/2017\\/07\\/14\\/20170714114511522.txt\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('512', '13', '3', '14', '1', '2017-07-19 10:06:35', '{\"fid\":\"20170719100632761\",\"sid\":119,\"type\":\"jpeg\",\"filter\":\"image\",\"destription\":null,\"name\":\"Jellyfish.jpg\",\"size\":\"775702\",\"create_time\":\"2017-07-19 10:06:32\",\"suffix\":\"jpg\",\"src\":\"..\\/upload_file\\/2017\\/07\\/19\\/20170719100632761.jpg\",\"width\":\"1024\",\"height\":\"768\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('513', '13', '2', '6', '1', '2017-07-19 10:38:45', '{\"fid\":\"20170719103842934\",\"sid\":121,\"type\":\"jpeg\",\"filter\":\"image\",\"destription\":null,\"name\":\"war3.jpg\",\"size\":\"15972\",\"create_time\":\"2017-07-19 10:38:42\",\"suffix\":\"jpg\",\"src\":\"..\\/upload_file\\/2017\\/07\\/19\\/20170719103842934.jpg\",\"width\":\"294\",\"height\":\"300\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('514', '13', '3', '14', '1', '2017-07-19 10:39:58', '{\"fid\":\"20170719103956915\",\"sid\":125,\"type\":\"jpeg\",\"filter\":\"image\",\"destription\":null,\"name\":\"war3.jpg\",\"size\":\"15972\",\"create_time\":\"2017-07-19 10:39:56\",\"suffix\":\"jpg\",\"src\":\"..\\/upload_file\\/2017\\/07\\/19\\/20170719103956915.jpg\",\"width\":\"294\",\"height\":\"300\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('515', '13', '2', '6', '1', '2017-07-19 11:48:57', '{\"fid\":\"20170719114855736\",\"sid\":127,\"type\":\"jpeg\",\"filter\":\"image\",\"destription\":null,\"name\":\"war3.jpg\",\"size\":\"15972\",\"create_time\":\"2017-07-19 11:48:55\",\"suffix\":\"jpg\",\"src\":\"..\\/upload_file\\/2017\\/07\\/19\\/20170719114855736.jpg\",\"width\":\"294\",\"height\":\"300\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('516', '13', '2', '6', '1', '2017-07-19 15:04:17', '{\"fid\":\"20170719150417714\",\"sid\":128,\"type\":\"png\",\"filter\":\"image\",\"destription\":null,\"name\":\"495.png\",\"size\":\"702787\",\"create_time\":\"2017-07-19 15:04:17\",\"suffix\":\"png\",\"src\":\"..\\/upload_file\\/2017\\/07\\/19\\/20170719150417714.png\",\"width\":\"1200\",\"height\":\"463\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('517', '13', '3', '14', '1', '2017-07-21 15:55:13', 'asdasd', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('518', '13', '3', '14', '1', '2017-07-21 15:55:28', '{\"fid\":\"20170721155522320\",\"sid\":129,\"type\":\"jpeg\",\"filter\":\"image\",\"destription\":null,\"name\":\"Desert.jpg\",\"size\":\"845941\",\"create_time\":\"2017-07-21 15:55:22\",\"suffix\":\"jpg\",\"src\":\"..\\/upload_file\\/2017\\/07\\/21\\/20170721155522320.jpg\",\"width\":\"1024\",\"height\":\"768\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('519', '13', '3', '14', '1', '2017-07-21 15:57:35', '{\"fid\":\"20170721155730625\",\"sid\":130,\"type\":\"application\\/octet-stream\",\"filter\":\"\",\"destription\":null,\"name\":\"appchat.rar\",\"size\":\"85\",\"create_time\":\"2017-07-21 15:57:30\",\"suffix\":\"rar\",\"src\":\"..\\/upload_file\\/2017\\/07\\/21\\/20170721155730625.rar\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('520', '13', '3', '14', '1', '2017-07-21 16:02:35', '{\"fid\":\"20170721160233723\",\"sid\":132,\"type\":\"application\\/octet-stream\",\"filter\":\"\",\"destription\":null,\"name\":\"1111.rar\",\"size\":\"20\",\"create_time\":\"2017-07-21 16:02:33\",\"suffix\":\"rar\",\"src\":\"..\\/upload_file\\/2017\\/07\\/21\\/20170721160233723.rar\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('521', '13', '3', '14', '1', '2017-07-21 16:15:55', '{\"fid\":\"20170721161553493\",\"sid\":133,\"type\":\"jpeg\",\"filter\":\"image\",\"destription\":null,\"name\":\"war3.jpg\",\"size\":\"15972\",\"create_time\":\"2017-07-21 16:15:53\",\"suffix\":\"jpg\",\"src\":\"http:\\/\\/192.168.1.189\\/moa\\/upload_file\\/2017\\/07\\/21\\/20170721161553493.jpg\",\"width\":\"294\",\"height\":\"300\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('522', '13', '3', '14', '1', '2017-07-21 16:18:41', '{\"fid\":\"2017072116183918\",\"sid\":134,\"type\":\"application\\/octet-stream\",\"filter\":\"\",\"destription\":null,\"name\":\"appchat.rar\",\"size\":\"85\",\"create_time\":\"2017-07-21 16:18:39\",\"suffix\":\"rar\",\"src\":\"http:\\/\\/192.168.1.189\\/moa\\/upload_file\\/2017\\/07\\/21\\/2017072116183918.rar\"}', '3');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('523', '14', '3', '13', '1', '2017-07-24 09:56:06', '121', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('524', '14', '3', '13', '1', '2017-07-24 10:35:29', '33', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('525', '14', '3', '13', '1', '2017-07-24 10:40:56', '11', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('526', '14', '3', '13', '1', '2017-07-24 10:41:38', '212', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('527', '15', '3', '13', '1', '2017-07-24 10:42:35', '2121', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('528', '15', '3', '13', '1', '2017-07-24 11:04:37', '13', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('529', '15', '3', '13', '1', '2017-07-24 11:04:49', '123', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('530', '15', '3', '13', '1', '2017-07-24 11:05:37', '112', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('531', '15', '3', '13', '1', '2017-07-24 11:07:39', '122', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('532', '15', '3', '13', '1', '2017-07-24 11:07:43', '121', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('533', '14', '3', '13', '1', '2017-07-24 11:58:16', '12', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('534', '14', '3', '13', '1', '2017-07-24 11:58:21', '11', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('535', '15', '3', '13', '1', '2017-07-24 14:29:31', '12', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('536', '15', '3', '13', '1', '2017-07-24 14:35:26', 'w', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('537', '15', '3', '13', '1', '2017-07-24 14:35:40', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('538', '15', '3', '13', '1', '2017-07-24 14:37:49', '212', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('539', '15', '3', '13', '1', '2017-07-24 14:40:11', '13', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('540', '15', '3', '13', '1', '2017-07-24 14:42:17', '212', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('541', '15', '3', '13', '1', '2017-07-24 14:43:46', '123', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('542', '15', '3', '13', '1', '2017-07-24 14:44:51', '11', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('543', '15', '3', '13', '1', '2017-07-24 14:45:02', '123', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('544', '15', '3', '13', '1', '2017-07-24 15:27:40', '123', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('545', '15', '3', '13', '1', '2017-07-24 15:28:41', '234344', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('546', '15', '3', '13', '1', '2017-07-24 15:29:02', '1231', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('547', '14', '3', '13', '1', '2017-07-24 15:29:32', '1212', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('548', '14', '3', '13', '1', '2017-07-24 15:30:22', '123123', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('549', '14', '3', '13', '1', '2017-07-24 15:30:27', '1231231321', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('550', '14', '3', '13', '1', '2017-07-24 15:30:56', '1231231', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('551', '14', '3', '13', '1', '2017-07-24 15:35:24', '123', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('552', '14', '3', '13', '1', '2017-07-24 15:35:57', '12121', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('553', '14', '3', '13', '1', '2017-07-25 09:18:09', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('554', '14', '3', '13', '1', '2017-07-25 09:18:19', '11', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('555', '14', '3', '13', '1', '2017-07-25 10:17:58', '123', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('556', '14', '3', '13', '1', '2017-07-25 10:20:47', '123', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('557', '14', '3', '13', '1', '2017-07-25 10:20:49', '23423', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('558', '14', '3', '13', '1', '2017-07-25 10:20:50', '12313', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('559', '15', '3', '13', '1', '2017-07-25 10:21:03', '1212', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('560', '15', '3', '13', '1', '2017-07-25 10:21:05', '32', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('561', '13', '3', '14', '1', '2017-08-01 10:47:28', '{\"fid\":\"20170801104726230\",\"sid\":136,\"type\":\"jpeg\",\"filter\":\"image\",\"destription\":null,\"name\":\"wallpaper031-1920x1200.jpg\",\"size\":\"380643\",\"create_time\":\"2017-08-01 10:47:26\",\"suffix\":\"jpg\",\"src\":\"..\\/upload_file\\/2017\\/08\\/01\\/20170801104726230.jpg\",\"width\":\"1920\",\"height\":\"1200\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('562', '13', '3', '14', '1', '2017-08-02 09:55:38', '{\"fid\":\"20170802095535995\",\"sid\":137,\"type\":\"jpeg\",\"filter\":\"image\",\"destription\":null,\"name\":\"u=3397685319,2008470547&fm=26&gp=0.jpg\",\"size\":\"29894\",\"create_time\":\"2017-08-02 09:55:35\",\"suffix\":\"jpg\",\"src\":\"..\\/upload_file\\/2017\\/08\\/02\\/20170802095535995.jpg\",\"width\":\"500\",\"height\":\"281\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('563', '13', '3', '14', '1', '2017-08-02 10:15:43', '{\"fid\":\"2017080210154164\",\"sid\":141,\"type\":\"jpeg\",\"filter\":\"image\",\"destription\":null,\"name\":\"u=1800040434,3815499765&fm=26&gp=0.jpg\",\"size\":\"13318\",\"create_time\":\"2017-08-02 10:15:41\",\"suffix\":\"jpg\",\"src\":\"..\\/upload_file\\/2017\\/08\\/02\\/2017080210154164.jpg\",\"width\":\"480\",\"height\":\"300\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('564', '13', '3', '14', '1', '2017-08-02 10:17:29', '{\"fid\":\"20170802101727287\",\"sid\":142,\"type\":\"jpeg\",\"filter\":\"image\",\"destription\":null,\"name\":\"u=3251648589,2125454540&fm=26&gp=0.jpg\",\"size\":\"5860\",\"create_time\":\"2017-08-02 10:17:27\",\"suffix\":\"jpg\",\"src\":\"..\\/upload_file\\/2017\\/08\\/02\\/20170802101727287.jpg\",\"width\":\"221\",\"height\":\"300\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('565', '13', '3', '14', '1', '2017-08-02 10:39:46', '{\"fid\":\"20170802103944101\",\"sid\":143,\"type\":\"jpeg\",\"filter\":\"image\",\"destription\":null,\"name\":\"u=761076562,1091449883&fm=26&gp=0.jpg\",\"size\":\"15239\",\"create_time\":\"2017-08-02 10:39:44\",\"suffix\":\"jpg\",\"src\":\"..\\/upload_file\\/2017\\/08\\/02\\/20170802103944101.jpg\",\"width\":\"375\",\"height\":\"300\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('566', '13', '3', '14', '1', '2017-08-02 10:43:47', '{\"fid\":\"20170802104346466\",\"sid\":144,\"type\":\"jpeg\",\"filter\":\"image\",\"destription\":null,\"name\":\"u=256830002,907578723&fm=26&gp=0.jpg\",\"size\":\"12715\",\"create_time\":\"2017-08-02 10:43:46\",\"suffix\":\"jpg\",\"src\":\"..\\/upload_file\\/2017\\/08\\/02\\/20170802104346466.jpg\",\"width\":\"255\",\"height\":\"300\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('567', '13', '3', '14', '1', '2017-08-02 11:14:06', '{\"fid\":\"20170802111405499\",\"sid\":145,\"type\":\"jpeg\",\"filter\":\"image\",\"destription\":null,\"name\":\"timg.jpg\",\"size\":\"40477\",\"create_time\":\"2017-08-02 11:14:05\",\"suffix\":\"jpg\",\"src\":\"..\\/upload_file\\/2017\\/08\\/02\\/20170802111405499.jpg\",\"width\":\"405\",\"height\":\"720\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('568', '13', '3', '14', '1', '2017-08-02 11:24:54', '{\"fid\":\"20170802112453147\",\"sid\":148,\"type\":\"jpeg\",\"filter\":\"image\",\"destription\":null,\"name\":\"u=807282151,3949355161&fm=26&gp=0.jpg\",\"size\":\"6688\",\"create_time\":\"2017-08-02 11:24:53\",\"suffix\":\"jpg\",\"src\":\"..\\/upload_file\\/2017\\/08\\/02\\/20170802112453147.jpg\",\"width\":\"480\",\"height\":\"300\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('569', '13', '3', '14', '1', '2017-08-02 11:26:17', '{\"fid\":\"20170802112615858\",\"sid\":150,\"type\":\"jpeg\",\"filter\":\"image\",\"destription\":null,\"name\":\"u=1308907753,1841589618&fm=26&gp=0.jpg\",\"size\":\"15018\",\"create_time\":\"2017-08-02 11:26:15\",\"suffix\":\"jpg\",\"src\":\"..\\/upload_file\\/2017\\/08\\/02\\/20170802112615858.jpg\",\"width\":\"400\",\"height\":\"300\"}', '2');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('570', '8', '3', '9', '0', '2018-08-23 16:48:51', 'sadfa', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('571', '8', '3', '9', '0', '2018-08-24 09:50:58', 'afa', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('572', '13', '3', '14', '1', '2018-08-24 09:58:14', 'gdfgsdg', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('573', '8', '3', '9', '0', '2018-08-24 10:03:07', 'fsf', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('574', '13', '3', '14', '1', '2018-08-24 10:08:22', '0.0\n', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('575', '13', '3', '14', '1', '2018-08-24 10:11:31', '121', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('576', '14', '3', '13', '1', '2018-08-24 10:11:39', '234', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('577', '14', '3', '13', '1', '2018-08-24 10:20:56', 'adf', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('578', '13', '3', '14', '1', '2018-08-24 10:21:12', 'dasf', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('579', '14', '3', '13', '1', '2018-08-24 10:29:26', 'sefasfas', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('580', '14', '3', '13', '1', '2018-08-24 14:12:06', 'sad', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('581', '14', '3', '13', '1', '2018-08-24 16:11:19', 'sdf', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('582', '13', '3', '14', '1', '2018-08-24 18:10:30', '大法师', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('583', '14', '3', '13', '1', '2018-08-24 18:15:28', '0.0', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('584', '14', '3', '13', '1', '2018-08-24 18:15:41', 'sdg', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('585', '14', '3', '13', '1', '2018-08-24 18:24:27', 'ss', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('586', '14', '3', '13', '1', '2018-08-24 18:24:34', 'df', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('587', '14', '3', '13', '1', '2018-08-24 18:32:09', '1564\n', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('588', '14', '3', '13', '1', '2018-08-24 18:32:30', 'hgj', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('589', '14', '3', '13', '1', '2018-08-24 18:38:05', 'g', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('590', '14', '3', '13', '1', '2018-08-24 18:43:31', '6786', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('591', '14', '3', '13', '1', '2018-08-24 18:51:49', 'y', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('592', '14', '3', '13', '1', '2018-08-24 18:51:52', 'i', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('593', '14', '3', '13', '1', '2018-08-24 18:54:20', 'i', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('594', '14', '3', '13', '1', '2018-08-24 18:55:04', 'i', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('595', '14', '3', '13', '1', '2018-08-24 18:55:12', 'o', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('596', '14', '3', '13', '1', '2018-08-24 18:55:51', '9', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('597', '14', '3', '13', '1', '2018-08-24 18:56:29', '5', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('598', '14', '3', '13', '1', '2018-08-24 19:05:28', 'd', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('599', '14', '3', '13', '1', '2018-08-24 19:07:16', 'g', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('600', '14', '3', '13', '1', '2018-08-24 19:07:53', 'i', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('601', '14', '3', '13', '1', '2018-08-24 19:08:29', 'f', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('602', '14', '3', '13', '1', '2018-08-24 19:09:29', 'f', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('603', '14', '3', '13', '1', '2018-08-24 19:11:05', 'i', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('604', '14', '3', '13', '1', '2018-08-24 19:11:44', 'i', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('605', '14', '3', '13', '1', '2018-08-24 19:11:49', 'i', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('606', '14', '3', '13', '1', '2018-08-24 19:11:57', 'k', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('607', '14', '3', '13', '1', '2018-08-24 19:35:17', 'h', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('608', '14', '3', '13', '1', '2018-08-24 19:35:51', 'f', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('609', '14', '3', '13', '1', '2018-08-24 19:39:41', 'g', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('610', '14', '3', '13', '1', '2018-08-24 19:41:13', 'rty', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('611', '14', '3', '13', '1', '2018-08-24 19:41:19', 'hgfh', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('612', '13', '3', '14', '1', '2018-08-24 19:41:28', '规范化的', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('613', '14', '3', '13', '1', '2018-08-24 19:41:57', 'fg', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('614', '13', '3', '14', '1', '2018-08-24 21:37:37', '0.0\n', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('615', '13', '3', '14', '1', '2018-08-24 22:46:58', '9', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('616', '14', '3', '13', '1', '2018-08-24 22:56:23', 'gfds', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('617', '13', '3', '14', '1', '2018-08-25 01:26:21', '0.0', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('618', '14', '3', '13', '1', '2018-08-25 01:26:36', 'asdf', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('619', '14', '3', '13', '1', '2018-08-25 03:54:27', '0.0', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('620', '13', '3', '14', '1', '2018-08-25 03:55:13', '0.0', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('621', '14', '3', '13', '1', '2018-08-25 08:45:14', 'sdgfg\n\ngdsgsg', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('622', '14', '3', '13', '1', '2018-08-25 08:45:17', 'ghhghh', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('623', '14', '3', '13', '1', '2018-08-25 08:45:19', '43535', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('624', '14', '3', '13', '1', '2018-08-25 08:58:37', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('625', '14', '3', '13', '1', '2018-08-25 08:59:31', '4', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('626', '14', '3', '13', '1', '2018-08-25 08:59:40', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('627', '14', '3', '13', '1', '2018-08-25 09:00:35', 'fsg', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('628', '14', '3', '13', '1', '2018-08-25 09:00:42', 'hfgdh', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('629', '14', '3', '13', '1', '2018-08-25 09:01:04', 'j', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('630', '14', '3', '13', '1', '2018-08-25 09:01:11', 'h', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('631', '14', '3', '13', '1', '2018-08-25 09:11:43', 'fd', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('632', '14', '3', '13', '1', '2018-08-25 09:12:15', 'd', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('633', '14', '3', '13', '1', '2018-08-25 09:12:21', 'sdfg', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('634', '14', '3', '13', '1', '2018-08-25 09:13:21', 'jj', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('635', '14', '3', '13', '1', '2018-08-25 09:13:25', 'gjf', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('636', '14', '3', '13', '1', '2018-08-25 09:16:04', 'b', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('637', '15', '3', '13', '1', '2018-08-25 09:16:48', 'sdf', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('638', '15', '3', '13', '1', '2018-08-25 09:16:51', 'dfdsf', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('639', '15', '3', '13', '1', '2018-08-25 09:16:51', 'gf', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('640', '15', '3', '13', '1', '2018-08-25 09:16:52', 'gf', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('641', '15', '3', '13', '1', '2018-08-25 09:16:53', 'asf', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('642', '14', '3', '13', '1', '2018-08-25 09:17:25', 'fg', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('643', '14', '3', '13', '1', '2018-08-25 09:17:26', 'df', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('644', '15', '3', '13', '1', '2018-08-25 09:17:31', 'cb', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('645', '14', '3', '13', '1', '2018-08-25 09:20:05', 'fg', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('646', '14', '3', '13', '1', '2018-08-25 09:20:15', 'gh', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('647', '15', '3', '13', '1', '2018-08-25 09:20:21', 'fghd', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('648', '15', '3', '13', '1', '2018-08-25 09:20:23', 'dsf', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('649', '15', '3', '13', '1', '2018-08-25 09:20:24', 'gdf', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('650', '14', '3', '13', '1', '2018-08-25 09:20:31', 'dsgs', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('651', '13', '3', '15', '1', '2018-08-25 09:22:33', 'dsa', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('652', '13', '3', '15', '1', '2018-08-25 09:22:48', 'k', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('653', '14', '3', '13', '1', '2018-08-29 15:55:45', 'sdf', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('654', '14', '3', '13', '1', '2018-08-29 15:55:46', 'gfdgs', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('655', '14', '3', '13', '1', '2018-08-29 15:55:46', 'af', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('656', '14', '3', '13', '1', '2018-08-29 15:55:48', '2334', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('657', '14', '3', '13', '1', '2018-08-29 15:55:49', '43', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('658', '13', '3', '14', '1', '2018-08-29 15:55:54', 'fdsf', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('659', '14', '3', '15', '1', '2018-08-30 15:12:13', 'f', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('660', '14', '3', '15', '1', '2018-08-30 15:12:14', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('661', '14', '3', '15', '1', '2018-08-30 15:12:14', '2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('662', '14', '3', '15', '1', '2018-08-30 15:12:15', '3', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('663', '14', '3', '15', '1', '2018-08-30 15:12:15', '4', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('664', '14', '3', '15', '1', '2018-08-30 15:12:16', '5', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('665', '14', '3', '15', '1', '2018-08-30 15:12:16', '6', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('666', '14', '3', '15', '1', '2018-08-30 15:12:16', '7', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('667', '14', '3', '15', '1', '2018-08-30 15:12:17', '8', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('668', '14', '3', '15', '1', '2018-08-30 15:12:18', '9\\', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('669', '14', '3', '15', '1', '2018-08-30 15:12:25', '10', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('670', '15', '3', '14', '1', '2018-08-30 15:14:50', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('671', '15', '3', '14', '1', '2018-08-30 15:14:50', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('672', '15', '3', '14', '1', '2018-08-30 15:14:51', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('673', '15', '3', '14', '1', '2018-08-30 15:14:51', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('674', '15', '3', '14', '1', '2018-08-30 15:14:51', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('675', '15', '3', '14', '1', '2018-08-30 15:14:52', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('676', '15', '3', '14', '1', '2018-08-30 15:14:52', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('677', '15', '3', '14', '1', '2018-08-30 15:14:52', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('678', '15', '3', '14', '1', '2018-08-30 15:14:53', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('679', '15', '3', '14', '1', '2018-08-30 15:14:53', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('680', '15', '3', '14', '1', '2018-08-30 15:14:53', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('681', '15', '3', '14', '1', '2018-08-30 15:14:54', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('682', '15', '3', '14', '1', '2018-08-30 15:14:54', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('683', '15', '3', '14', '1', '2018-08-30 15:14:55', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('684', '15', '3', '14', '1', '2018-08-30 15:15:27', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('685', '15', '3', '14', '1', '2018-08-30 15:15:28', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('686', '15', '3', '14', '1', '2018-08-30 15:15:28', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('687', '15', '3', '14', '1', '2018-08-30 15:15:29', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('688', '15', '3', '14', '1', '2018-08-30 15:15:29', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('689', '15', '3', '14', '1', '2018-08-30 15:15:29', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('690', '15', '3', '14', '1', '2018-08-30 15:15:29', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('691', '15', '3', '14', '1', '2018-08-30 15:15:30', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('692', '15', '3', '14', '1', '2018-08-30 15:15:30', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('693', '15', '3', '14', '1', '2018-08-30 15:15:31', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('694', '15', '3', '14', '1', '2018-08-30 15:15:34', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('695', '15', '3', '14', '1', '2018-08-30 15:15:34', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('696', '15', '3', '14', '1', '2018-08-30 15:15:34', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('697', '15', '3', '14', '1', '2018-08-30 15:15:35', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('698', '15', '3', '14', '1', '2018-08-30 15:15:35', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('699', '15', '3', '14', '1', '2018-08-30 15:15:36', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('700', '15', '3', '14', '1', '2018-08-30 15:19:57', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('701', '15', '3', '14', '1', '2018-08-30 15:19:58', '2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('702', '15', '3', '14', '1', '2018-08-30 15:19:58', '2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('703', '15', '3', '14', '1', '2018-08-30 15:19:58', '2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('704', '15', '3', '14', '1', '2018-08-30 15:19:58', '2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('705', '15', '3', '14', '1', '2018-08-30 15:19:59', '2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('706', '15', '3', '14', '1', '2018-08-30 15:19:59', '2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('707', '15', '3', '14', '1', '2018-08-30 15:19:59', '2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('708', '15', '3', '14', '1', '2018-08-30 15:20:00', '2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('709', '15', '3', '14', '1', '2018-08-30 15:20:00', '2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('710', '15', '3', '14', '1', '2018-08-30 15:20:01', '2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('711', '15', '3', '14', '1', '2018-08-30 15:20:02', '2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('712', '15', '3', '14', '1', '2018-08-30 15:20:02', '2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('713', '15', '3', '14', '1', '2018-08-30 15:20:03', '2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('714', '15', '3', '14', '1', '2018-08-30 15:20:03', '2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('715', '15', '3', '14', '1', '2018-08-30 15:20:04', '2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('716', '15', '3', '14', '1', '2018-08-30 15:20:11', '3', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('717', '15', '3', '14', '1', '2018-08-30 15:20:11', '3', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('718', '15', '3', '14', '1', '2018-08-30 15:20:13', '34', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('719', '15', '3', '14', '1', '2018-08-30 15:20:13', '5', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('720', '15', '3', '14', '1', '2018-08-30 15:20:15', '6', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('721', '15', '3', '14', '1', '2018-08-30 15:20:16', '7', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('722', '15', '3', '14', '1', '2018-08-30 15:20:17', '8', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('723', '15', '3', '14', '1', '2018-08-30 15:20:18', '9', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('724', '15', '3', '14', '1', '2018-08-30 15:20:18', '0', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('725', '15', '3', '14', '1', '2018-08-30 15:21:20', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('726', '15', '3', '14', '1', '2018-08-30 15:21:21', '2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('727', '15', '3', '14', '1', '2018-08-30 15:21:21', '3', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('728', '15', '3', '14', '1', '2018-08-30 15:21:22', '4', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('729', '15', '3', '14', '1', '2018-08-30 15:21:22', '55', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('730', '15', '3', '14', '1', '2018-08-30 15:21:23', '6', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('731', '15', '3', '14', '1', '2018-08-30 15:21:23', '7', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('732', '15', '3', '14', '1', '2018-08-30 15:21:24', '8', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('733', '15', '3', '14', '1', '2018-08-30 15:21:24', '9', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('734', '15', '3', '14', '1', '2018-08-30 15:21:26', '0', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('735', '15', '3', '14', '1', '2018-08-30 15:21:30', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('736', '15', '3', '14', '1', '2018-08-30 15:21:31', '12', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('737', '15', '3', '14', '1', '2018-08-30 15:21:32', '3', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('738', '15', '3', '14', '1', '2018-08-30 15:21:32', '4', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('739', '15', '3', '14', '1', '2018-08-30 15:21:32', '5', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('740', '15', '3', '14', '1', '2018-08-30 15:21:33', '6', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('741', '15', '3', '14', '1', '2018-08-30 15:21:33', '6', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('742', '15', '3', '14', '1', '2018-08-30 15:21:34', '7', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('743', '15', '3', '14', '1', '2018-08-30 15:21:34', '8', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('744', '15', '3', '14', '1', '2018-08-30 15:21:34', '9', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('745', '15', '3', '14', '1', '2018-08-30 15:21:37', '0', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('746', '15', '3', '14', '1', '2018-08-30 15:22:13', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('747', '15', '3', '14', '1', '2018-08-30 15:22:14', '12', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('748', '15', '3', '14', '1', '2018-08-30 15:22:14', '3', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('749', '15', '3', '14', '1', '2018-08-30 15:22:15', '4', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('750', '15', '3', '14', '1', '2018-08-30 15:22:15', '5', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('751', '15', '3', '14', '1', '2018-08-30 15:22:15', '56', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('752', '15', '3', '14', '1', '2018-08-30 15:22:16', '6', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('753', '15', '3', '14', '1', '2018-08-30 15:22:16', '7', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('754', '15', '3', '14', '1', '2018-08-30 15:22:16', '8', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('755', '15', '3', '14', '1', '2018-08-30 15:22:17', '9', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('756', '15', '3', '14', '1', '2018-08-30 15:22:17', '9', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('757', '15', '3', '14', '1', '2018-08-30 15:22:18', '0', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('758', '15', '3', '14', '1', '2018-08-30 15:22:19', '8', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('759', '15', '3', '14', '1', '2018-08-30 15:32:14', 's', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('760', '15', '3', '14', '1', '2018-08-30 15:32:15', 'sdf', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('761', '15', '3', '14', '1', '2018-08-30 15:32:16', 'g', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('762', '15', '3', '14', '1', '2018-08-30 15:32:17', 'h', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('763', '15', '3', '14', '1', '2018-08-30 15:32:18', 'g', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('764', '15', '3', '14', '1', '2018-08-30 15:32:18', 'g', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('765', '15', '3', '14', '1', '2018-08-30 15:32:19', 'f', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('766', '15', '3', '14', '1', '2018-08-30 15:32:39', 's', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('767', '15', '3', '14', '1', '2018-08-30 15:32:39', 's', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('768', '15', '3', '14', '1', '2018-08-30 15:32:40', 's', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('769', '15', '3', '14', '1', '2018-08-30 15:32:40', 's', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('770', '15', '3', '14', '1', '2018-08-30 15:32:40', 's', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('771', '15', '3', '14', '1', '2018-08-30 15:32:40', 's', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('772', '15', '3', '14', '1', '2018-08-30 15:32:41', 's', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('773', '15', '3', '14', '1', '2018-08-30 15:32:41', 's', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('774', '15', '3', '14', '1', '2018-08-30 15:32:43', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('775', '15', '3', '14', '1', '2018-08-30 15:32:44', '2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('776', '15', '3', '14', '1', '2018-08-30 15:32:45', '3', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('777', '15', '3', '14', '1', '2018-08-30 15:32:46', '4', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('778', '15', '3', '14', '1', '2018-08-30 15:32:46', '5', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('779', '15', '3', '14', '1', '2018-08-30 15:32:47', '6', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('780', '15', '3', '14', '1', '2018-08-30 15:32:48', '7', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('781', '15', '3', '14', '1', '2018-08-30 15:33:07', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('782', '15', '3', '14', '1', '2018-08-30 15:33:07', '2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('783', '15', '3', '14', '1', '2018-08-30 15:33:08', '3', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('784', '15', '3', '14', '1', '2018-08-30 15:33:09', '4', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('785', '15', '3', '14', '1', '2018-08-30 15:33:09', '5', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('786', '15', '3', '14', '1', '2018-08-30 15:33:09', '6', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('787', '15', '3', '14', '1', '2018-08-30 15:33:10', '7', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('788', '15', '3', '14', '1', '2018-08-30 15:33:11', '9', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('789', '15', '3', '14', '1', '2018-08-30 15:33:13', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('790', '15', '3', '14', '1', '2018-08-30 15:33:14', '2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('791', '15', '3', '14', '1', '2018-08-30 15:33:15', '3', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('792', '15', '3', '14', '1', '2018-08-30 15:33:19', '4', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('793', '15', '3', '14', '1', '2018-08-30 15:33:21', '5', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('794', '15', '3', '14', '1', '2018-08-30 15:33:22', '6', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('795', '15', '3', '14', '1', '2018-08-30 15:33:23', '7', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('796', '15', '3', '14', '1', '2018-08-30 15:33:24', '8', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('797', '15', '3', '14', '1', '2018-08-30 15:33:25', '8', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('798', '15', '3', '14', '1', '2018-08-30 15:37:51', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('799', '15', '3', '14', '1', '2018-08-30 15:37:52', '2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('800', '15', '3', '14', '1', '2018-08-30 15:37:53', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('801', '15', '3', '14', '1', '2018-08-30 15:37:54', '2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('802', '15', '3', '14', '1', '2018-08-30 15:37:55', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('803', '15', '3', '14', '1', '2018-08-30 15:37:56', '11', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('804', '15', '3', '14', '1', '2018-08-30 15:37:57', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('805', '15', '3', '14', '1', '2018-08-30 15:37:58', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('806', '15', '3', '14', '1', '2018-08-30 15:37:59', '2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('807', '15', '3', '14', '1', '2018-08-30 15:38:00', '3', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('808', '15', '3', '14', '1', '2018-08-30 15:38:01', '4', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('809', '15', '3', '14', '1', '2018-08-30 15:38:02', '5', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('810', '15', '3', '14', '1', '2018-08-30 15:38:04', '6', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('811', '15', '3', '14', '1', '2018-08-30 15:38:05', '7', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('812', '15', '3', '14', '1', '2018-08-30 15:38:25', 'w', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('813', '15', '3', '14', '1', '2018-08-30 15:38:27', 'w', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('814', '15', '3', '14', '1', '2018-08-30 15:38:27', 'w', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('815', '15', '3', '14', '1', '2018-08-30 15:38:28', 'w', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('816', '15', '3', '14', '1', '2018-08-30 15:38:28', 'w', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('817', '15', '3', '14', '1', '2018-08-30 15:38:29', 'w', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('818', '15', '3', '14', '1', '2018-08-30 15:38:29', 'w', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('819', '15', '3', '14', '1', '2018-08-30 15:38:33', 'e', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('820', '15', '3', '14', '1', '2018-08-30 15:38:33', 'e', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('821', '15', '3', '14', '1', '2018-08-30 15:38:37', 'e', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('822', '15', '3', '14', '1', '2018-08-30 15:39:05', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('823', '15', '3', '14', '1', '2018-08-30 15:39:07', '2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('824', '15', '3', '14', '1', '2018-08-30 15:39:18', '2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('825', '15', '3', '14', '1', '2018-08-30 15:39:23', '3', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('826', '15', '3', '14', '1', '2018-08-30 15:39:33', '5', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('827', '15', '3', '14', '1', '2018-08-30 15:42:54', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('828', '15', '3', '14', '1', '2018-08-30 15:42:55', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('829', '15', '3', '14', '1', '2018-08-30 15:42:55', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('830', '15', '3', '14', '1', '2018-08-30 15:42:55', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('831', '15', '3', '14', '1', '2018-08-30 15:42:56', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('832', '15', '3', '14', '1', '2018-08-30 15:42:56', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('833', '15', '3', '14', '1', '2018-08-30 15:42:56', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('834', '15', '3', '14', '1', '2018-08-30 15:42:57', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('835', '15', '3', '14', '1', '2018-08-30 15:42:57', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('836', '15', '3', '14', '1', '2018-08-30 15:42:58', '2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('837', '15', '3', '14', '1', '2018-08-30 15:42:59', '3', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('838', '15', '3', '14', '1', '2018-08-30 15:43:00', '4', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('839', '15', '3', '14', '1', '2018-08-30 15:43:00', '5', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('840', '15', '3', '14', '1', '2018-08-30 15:43:01', '6', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('841', '15', '3', '14', '1', '2018-08-30 15:44:27', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('842', '15', '3', '14', '1', '2018-08-30 15:44:28', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('843', '15', '3', '14', '1', '2018-08-30 15:44:28', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('844', '15', '3', '14', '1', '2018-08-30 15:44:28', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('845', '15', '3', '14', '1', '2018-08-30 15:44:29', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('846', '15', '3', '14', '1', '2018-08-30 15:44:29', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('847', '15', '3', '14', '1', '2018-08-30 15:44:29', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('848', '15', '3', '14', '1', '2018-08-30 15:44:30', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('849', '15', '3', '14', '1', '2018-08-30 15:44:30', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('850', '15', '3', '14', '1', '2018-08-30 15:44:31', '2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('851', '15', '3', '14', '1', '2018-08-30 15:44:32', '3', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('852', '15', '3', '14', '1', '2018-08-30 15:44:33', '4', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('853', '15', '3', '14', '1', '2018-08-30 15:44:34', '5', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('854', '15', '3', '14', '1', '2018-08-30 16:44:22', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('855', '15', '3', '14', '1', '2018-08-30 16:44:23', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('856', '15', '3', '14', '1', '2018-08-30 16:44:23', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('857', '15', '3', '14', '1', '2018-08-30 16:44:23', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('858', '15', '3', '14', '1', '2018-08-30 16:44:24', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('859', '15', '3', '14', '1', '2018-08-30 16:44:24', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('860', '15', '3', '14', '1', '2018-08-30 16:44:24', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('861', '15', '3', '14', '1', '2018-08-30 16:44:25', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('862', '15', '3', '14', '1', '2018-08-30 16:44:25', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('863', '15', '3', '14', '1', '2018-08-30 16:44:25', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('864', '15', '3', '14', '1', '2018-08-30 16:44:26', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('865', '13', '3', '8', '0', '2018-08-31 14:41:01', 'rf', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('866', '13', '3', '8', '0', '2018-09-03 11:13:19', '0.0', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('867', '13', '3', '14', '1', '2018-09-03 11:13:59', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('868', '13', '3', '14', '1', '2018-09-03 11:14:00', '2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('869', '13', '3', '14', '1', '2018-09-03 11:14:01', '3', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('870', '13', '3', '14', '1', '2018-09-03 11:14:02', '4', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('871', '13', '3', '14', '1', '2018-09-03 11:14:02', '5', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('872', '13', '3', '14', '1', '2018-09-03 11:14:04', '6', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('873', '14', '3', '13', '1', '2018-09-03 14:18:18', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('874', '14', '3', '13', '1', '2018-09-03 14:18:19', '2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('875', '14', '3', '13', '1', '2018-09-03 14:18:21', '3', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('876', '14', '3', '13', '1', '2018-09-03 14:18:22', '4', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('877', '14', '3', '13', '1', '2018-09-03 14:18:23', '5', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('878', '14', '3', '13', '1', '2018-09-03 14:18:23', '6', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('879', '13', '3', '14', '0', '2018-09-03 15:25:46', '1', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('880', '13', '3', '14', '0', '2018-09-03 15:25:48', '2', '1');
INSERT INTO `T_MIM_CHAT_RECORD` VALUES ('881', '13', '3', '14', '0', '2018-09-03 15:25:49', '4', '1');

-- ----------------------------
-- Table structure for T_MIM_FRIEND_ACTION
-- ----------------------------
DROP TABLE IF EXISTS `T_MIM_FRIEND_ACTION`;
CREATE TABLE `T_MIM_FRIEND_ACTION` (
  `SID` int(11) NOT NULL AUTO_INCREMENT,
  `USID_FROM` int(11) NOT NULL COMMENT '源用户sid',
  `USID_TO` int(11) NOT NULL COMMENT '目标用户sid',
  `CREATE_TIME` datetime NOT NULL COMMENT '创建时间',
  `DEAL_TIME` datetime NOT NULL COMMENT '处理时间',
  `TYPE` tinyint(1) NOT NULL COMMENT '好友方式(添加/删除) 0:删除 1:添加',
  `STATUS` tinyint(4) NOT NULL COMMENT '处理状态(完成/待处理) 0:待处理,1:完成',
  PRIMARY KEY (`SID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户好友添加删除操作表';

-- ----------------------------
-- Records of T_MIM_FRIEND_ACTION
-- ----------------------------

-- ----------------------------
-- Table structure for T_MIM_GROUP
-- ----------------------------
DROP TABLE IF EXISTS `T_MIM_GROUP`;
CREATE TABLE `T_MIM_GROUP` (
  `SID` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(50) NOT NULL COMMENT '群组名称',
  `MAX` mediumint(9) NOT NULL COMMENT '组员人数上限',
  `CREATOR` varchar(50) NOT NULL COMMENT '创建人',
  `CREATE_TIME` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`SID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of T_MIM_GROUP
-- ----------------------------
INSERT INTO `T_MIM_GROUP` VALUES ('6', '测试群组01', '10', 'superadmin.1', '2017-05-18 17:02:47');

-- ----------------------------
-- Table structure for T_MIM_GROUP_ACTION
-- ----------------------------
DROP TABLE IF EXISTS `T_MIM_GROUP_ACTION`;
CREATE TABLE `T_MIM_GROUP_ACTION` (
  `SID` int(11) NOT NULL AUTO_INCREMENT,
  `GID` int(11) NOT NULL COMMENT '群组id',
  `USID_FROM` int(11) NOT NULL COMMENT '请求人sid',
  `CREATE_TIME` datetime NOT NULL COMMENT '请求时间',
  `USID_DEAL` int(11) NOT NULL COMMENT '处理人sid',
  `DEAL_TIME` datetime NOT NULL COMMENT '处理时间',
  `TYPE` tinyint(4) NOT NULL COMMENT '操作类型 0:删除,1:加入,2:解散',
  `STATUS` tinyint(4) NOT NULL COMMENT '处理状态 0:待处理,1:完成',
  PRIMARY KEY (`SID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of T_MIM_GROUP_ACTION
-- ----------------------------

-- ----------------------------
-- Table structure for T_MIM_GROUP_USER
-- ----------------------------
DROP TABLE IF EXISTS `T_MIM_GROUP_USER`;
CREATE TABLE `T_MIM_GROUP_USER` (
  `SID` int(11) NOT NULL AUTO_INCREMENT,
  `UID` int(11) NOT NULL COMMENT '用户id',
  `GID` int(11) NOT NULL COMMENT '群组id',
  `IS_ADMIN` tinyint(1) NOT NULL COMMENT '是否管理员',
  PRIMARY KEY (`SID`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of T_MIM_GROUP_USER
-- ----------------------------
INSERT INTO `T_MIM_GROUP_USER` VALUES ('25', '14', '6', '0');
INSERT INTO `T_MIM_GROUP_USER` VALUES ('26', '13', '6', '0');
INSERT INTO `T_MIM_GROUP_USER` VALUES ('27', '12', '6', '0');
INSERT INTO `T_MIM_GROUP_USER` VALUES ('28', '11', '6', '0');
INSERT INTO `T_MIM_GROUP_USER` VALUES ('29', '10', '6', '0');
INSERT INTO `T_MIM_GROUP_USER` VALUES ('30', '9', '6', '0');

-- ----------------------------
-- Table structure for T_MIM_NOTICE
-- ----------------------------
DROP TABLE IF EXISTS `T_MIM_NOTICE`;
CREATE TABLE `T_MIM_NOTICE` (
  `SID` int(11) NOT NULL AUTO_INCREMENT,
  `USID` int(11) NOT NULL COMMENT '被提醒人sid',
  `CONTENT` varchar(500) NOT NULL COMMENT '提醒内容',
  `CREATE_TIME` datetime NOT NULL COMMENT '创建日期',
  `SCENE_TYPE` tinyint(1) NOT NULL,
  `SCENE_ID` int(11) NOT NULL,
  `STATUS` tinyint(4) NOT NULL COMMENT '消息状态',
  PRIMARY KEY (`SID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='提醒消息表';

-- ----------------------------
-- Records of T_MIM_NOTICE
-- ----------------------------

-- ----------------------------
-- Table structure for T_MIM_USER
-- ----------------------------
DROP TABLE IF EXISTS `T_MIM_USER`;
CREATE TABLE `T_MIM_USER` (
  `SID` int(11) NOT NULL AUTO_INCREMENT,
  `UID` varchar(50) NOT NULL COMMENT '用户uid',
  `NAME` varchar(50) NOT NULL COMMENT '用户名称',
  `PASSWORD` char(32) NOT NULL COMMENT '密码',
  `STATUS` tinyint(1) NOT NULL COMMENT '状态',
  `IMG` varchar(128) NOT NULL COMMENT '头像',
  `SEX` tinyint(1) NOT NULL,
  `PHONE` varchar(50) NOT NULL,
  `EMAIL` varchar(50) NOT NULL,
  `CONTENT` varchar(500) NOT NULL,
  `BIRTHDAY` datetime NOT NULL COMMENT '//出生日期',
  PRIMARY KEY (`SID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of T_MIM_USER
-- ----------------------------
INSERT INTO `T_MIM_USER` VALUES ('8', 'superadmin', 'MOA超管', 'e10adc3949ba59abbe56e057f20f883e', '1', '3.jpg', '0', '121212222', '22222@qq.com', 'MOA超管', '2016-08-29 00:00:00');
INSERT INTO `T_MIM_USER` VALUES ('9', 'wytj0304.1', '王岳', 'e10adc3949ba59abbe56e057f20f883e', '1', '4.jpg', '0', '13821286446', 'wytj0304@hotmail.com', '王岳', '1983-03-04 00:00:00');
INSERT INTO `T_MIM_USER` VALUES ('10', 'bit000002.1', '王岳', 'e10adc3949ba59abbe56e057f20f883e', '1', '4.jpg', '0', '13821286446', 'wytj0304@hotmail.com', '王岳', '1983-03-04 00:00:00');
INSERT INTO `T_MIM_USER` VALUES ('11', 'bit000001.1', '史勇', 'e10adc3949ba59abbe56e057f20f883e', '1', '4.jpg', '0', '', '', '史勇', '2017-05-01 00:00:00');
INSERT INTO `T_MIM_USER` VALUES ('12', 'superadmin.2', '超管', 'e10adc3949ba59abbe56e057f20f883e', '1', '4.jpg', '0', '', '', '超管', '2016-08-29 00:00:00');
INSERT INTO `T_MIM_USER` VALUES ('13', 'text01', '测试单用户01', 'e10adc3949ba59abbe56e057f20f883e', '1', '8.jpg', '0', '123456789', '350084079@qq.com', '测试单用户01', '2017-05-17 00:00:00');
INSERT INTO `T_MIM_USER` VALUES ('14', 'text02', ' 测试用户02', 'e10adc3949ba59abbe56e057f20f883e', '1', '9.jpg', '0', '123456789', '123456@qq.com', ' 测试用户02', '2017-05-02 00:00:00');
INSERT INTO `T_MIM_USER` VALUES ('15', 'text03', '测试用户03', 'e10adc3949ba59abbe56e057f20f883e', '1', '3.jpg', '0', '123456789', '123456@qq.com', '测试用户03', '2017-07-17 00:00:00');

-- ----------------------------
-- Table structure for T_MIM_USER_CLIENT
-- ----------------------------
DROP TABLE IF EXISTS `T_MIM_USER_CLIENT`;
CREATE TABLE `T_MIM_USER_CLIENT` (
  `SID` int(11) NOT NULL AUTO_INCREMENT,
  `USID` int(11) NOT NULL COMMENT '用户sid',
  `SCENE_TYPE` tinyint(1) NOT NULL COMMENT '场景类型 1:首页 2:群聊 3:私聊',
  `SCENE_ID` int(11) NOT NULL COMMENT '场景id',
  `SOCKET_ID` varchar(50) NOT NULL COMMENT '绑定的socket连接id',
  `CREATE_TIME` datetime NOT NULL,
  PRIMARY KEY (`SID`)
) ENGINE=InnoDB AUTO_INCREMENT=1027 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of T_MIM_USER_CLIENT
-- ----------------------------
INSERT INTO `T_MIM_USER_CLIENT` VALUES ('1009', '13', '0', '1', '7f0000010a8c000001ef', '2018-09-03 16:51:54');
INSERT INTO `T_MIM_USER_CLIENT` VALUES ('1010', '14', '0', '1', '7f0000010a8c000001f0', '2018-09-03 16:52:20');
INSERT INTO `T_MIM_USER_CLIENT` VALUES ('1026', '13', '0', '1', '7f0000010a8c00000010', '2018-09-04 16:11:31');

-- ----------------------------
-- Table structure for T_MIM_USER_FRIEND
-- ----------------------------
DROP TABLE IF EXISTS `T_MIM_USER_FRIEND`;
CREATE TABLE `T_MIM_USER_FRIEND` (
  `SID` int(11) NOT NULL AUTO_INCREMENT,
  `USID_A` int(11) NOT NULL,
  `USID_B` int(11) NOT NULL,
  PRIMARY KEY (`SID`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of T_MIM_USER_FRIEND
-- ----------------------------
INSERT INTO `T_MIM_USER_FRIEND` VALUES ('1', '8', '9');
INSERT INTO `T_MIM_USER_FRIEND` VALUES ('2', '8', '11');
INSERT INTO `T_MIM_USER_FRIEND` VALUES ('3', '11', '8');
INSERT INTO `T_MIM_USER_FRIEND` VALUES ('22', '13', '15');
INSERT INTO `T_MIM_USER_FRIEND` VALUES ('24', '14', '15');
INSERT INTO `T_MIM_USER_FRIEND` VALUES ('25', '14', '13');
INSERT INTO `T_MIM_USER_FRIEND` VALUES ('26', '13', '8');
INSERT INTO `T_MIM_USER_FRIEND` VALUES ('27', '13', '9');
INSERT INTO `T_MIM_USER_FRIEND` VALUES ('28', '13', '10');
INSERT INTO `T_MIM_USER_FRIEND` VALUES ('29', '13', '11');
INSERT INTO `T_MIM_USER_FRIEND` VALUES ('30', '13', '12');

-- ----------------------------
-- Table structure for T_MOA_ATTENDANCE
-- ----------------------------
DROP TABLE IF EXISTS `T_MOA_ATTENDANCE`;
CREATE TABLE `T_MOA_ATTENDANCE` (
  `SID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '//自增主键',
  `UID` varchar(128) NOT NULL COMMENT '//用户ID',
  `REGTIME` date NOT NULL COMMENT '//签到日期',
  `CHECKTIME` time NOT NULL COMMENT '//签到时间',
  `CHECKIP` varchar(128) NOT NULL COMMENT '//签到IP',
  `TYPE` tinyint(1) NOT NULL COMMENT '//类型',
  `DEVSE` varchar(500) NOT NULL COMMENT '//备注',
  PRIMARY KEY (`SID`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of T_MOA_ATTENDANCE
-- ----------------------------
INSERT INTO `T_MOA_ATTENDANCE` VALUES ('29', 'wytj0304.1', '2017-04-06', '09:59:21', '117.10.22.22', '1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36');
INSERT INTO `T_MOA_ATTENDANCE` VALUES ('30', 'superadmin.1', '2017-05-15', '16:06:18', '125.38.35.231', '1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36');

-- ----------------------------
-- Table structure for T_MOA_GROUP
-- ----------------------------
DROP TABLE IF EXISTS `T_MOA_GROUP`;
CREATE TABLE `T_MOA_GROUP` (
  `SID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '//自增SID',
  `TITLE` varchar(128) NOT NULL COMMENT '//组名',
  `LEADER` varchar(128) NOT NULL COMMENT '//组长',
  `CONTENT` text NOT NULL COMMENT '//说明备注',
  `CREATOR` varchar(128) NOT NULL COMMENT '//创建人',
  `CREATE_TIME` datetime NOT NULL COMMENT '//创建时间',
  `IS_PUBLIC` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1公共 0私有',
  PRIMARY KEY (`SID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of T_MOA_GROUP
-- ----------------------------
INSERT INTO `T_MOA_GROUP` VALUES ('1', '管理组', '[bit000001.1]', '', 'bit000001.1', '2017-05-15 16:18:55', '1');

-- ----------------------------
-- Table structure for T_MOA_GROUP_USER
-- ----------------------------
DROP TABLE IF EXISTS `T_MOA_GROUP_USER`;
CREATE TABLE `T_MOA_GROUP_USER` (
  `SID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '//自增SID',
  `GROUP` bigint(20) NOT NULL COMMENT '//关联组SID',
  `UID` varchar(128) NOT NULL COMMENT '//关联用户UID',
  PRIMARY KEY (`SID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of T_MOA_GROUP_USER
-- ----------------------------
INSERT INTO `T_MOA_GROUP_USER` VALUES ('2', '1', 'bit000001.1');
INSERT INTO `T_MOA_GROUP_USER` VALUES ('3', '1', 'wytj0304.1');

-- ----------------------------
-- Table structure for T_MOA_NOTICE
-- ----------------------------
DROP TABLE IF EXISTS `T_MOA_NOTICE`;
CREATE TABLE `T_MOA_NOTICE` (
  `SID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '//自增SID',
  `TYPE` tinyint(1) NOT NULL COMMENT '//类型 1通知 2加班 3假期',
  `START_TIME` datetime NOT NULL COMMENT '起始时间',
  `END_TIME` datetime NOT NULL COMMENT '结束日期',
  `CONTENT` varchar(1000) NOT NULL COMMENT '//内容',
  `CREATE_TIME` datetime NOT NULL COMMENT ' 创建时间',
  `CREATOR` varchar(128) NOT NULL COMMENT '//创建人',
  `SEND_TYPE` tinyint(1) NOT NULL DEFAULT '0' COMMENT '//发送类型 0全部 1用户',
  PRIMARY KEY (`SID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of T_MOA_NOTICE
-- ----------------------------

-- ----------------------------
-- Table structure for T_MOA_NOTICE_USER
-- ----------------------------
DROP TABLE IF EXISTS `T_MOA_NOTICE_USER`;
CREATE TABLE `T_MOA_NOTICE_USER` (
  `SID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '//自增SID',
  `NOTICE_SID` bigint(20) NOT NULL COMMENT '通知SID',
  `UID` varchar(128) NOT NULL COMMENT '//接收用户UID',
  PRIMARY KEY (`SID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of T_MOA_NOTICE_USER
-- ----------------------------

-- ----------------------------
-- Table structure for T_MOA_ROLE
-- ----------------------------
DROP TABLE IF EXISTS `T_MOA_ROLE`;
CREATE TABLE `T_MOA_ROLE` (
  `SID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增SID',
  `NAME` varchar(128) NOT NULL COMMENT '权限名称',
  `ACTION` text NOT NULL COMMENT '权限内容',
  PRIMARY KEY (`SID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of T_MOA_ROLE
-- ----------------------------
INSERT INTO `T_MOA_ROLE` VALUES ('1', '工作管理员', '[\"moa_action_group_add\",\"moa_action_group_edit\",\"moa_action_group_del\",\"moa_action_group_media\",\"moa_action_group_user\",\"moa_action_task_add\",\"moa_action_task_edit\",\"moa_action_task_del\",\"moa_action_task_media\",\"moa_action_task_chat\",\"moa_action_task_user\",\"moa_action_milestone_add\",\"moa_action_milestone_edit\",\"moa_action_milestone_del\",\"moa_action_milestone_chat\",\"moa_action_milestone_media\",\"moa_action_milestone_user\"]');
INSERT INTO `T_MOA_ROLE` VALUES ('2', '组长管理员', '[\"moa_action_group_edit\",\"moa_action_group_media\",\"moa_action_group_user\",\"moa_action_task_edit\",\"moa_action_task_media\",\"moa_action_task_chat\",\"moa_action_task_user\",\"moa_action_milestone_edit\",\"moa_action_milestone_chat\",\"moa_action_milestone_media\",\"moa_action_milestone_user\"]');
INSERT INTO `T_MOA_ROLE` VALUES ('3', '员工', '[\"moa_action_group_media\",\"moa_action_group_user\",\"moa_action_task_media\",\"moa_action_task_chat\",\"moa_action_milestone_chat\",\"moa_action_milestone_media\"]');

-- ----------------------------
-- Table structure for T_MOA_SESSION
-- ----------------------------
DROP TABLE IF EXISTS `T_MOA_SESSION`;
CREATE TABLE `T_MOA_SESSION` (
  `SESS_KEY` varchar(32) NOT NULL,
  `EXPIRY_DATE` bigint(20) NOT NULL,
  `SESS_VALUE` varchar(4000) NOT NULL,
  `LOGIN_DATE` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `LOGIN_IP` bigint(20) NOT NULL,
  `UID` varchar(50) NOT NULL,
  PRIMARY KEY (`SESS_KEY`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of T_MOA_SESSION
-- ----------------------------
INSERT INTO `T_MOA_SESSION` VALUES ('evjns4ml7o336pfsuts0ejsth2', '1536055891', 'moa|a:9:{s:4:\"role\";a:6:{i:0;s:22:\"moa_action_group_media\";i:1;s:21:\"moa_action_group_user\";i:2;s:21:\"moa_action_task_media\";i:3;s:20:\"moa_action_task_chat\";i:4;s:25:\"moa_action_milestone_chat\";i:5;s:26:\"moa_action_milestone_media\";}s:3:\"sid\";s:2:\"13\";s:3:\"uid\";s:6:\"text01\";s:8:\"is_admin\";s:1:\"0\";s:4:\"name\";s:17:\"测试单用户01\";s:3:\"sex\";s:1:\"0\";s:5:\"email\";s:16:\"350084079@qq.com\";s:5:\"phone\";s:9:\"123456789\";s:3:\"img\";s:5:\"8.jpg\";}mim|s:32:\"c51ce410c124a10e0db5e4b97fc2af39\";', '2018-09-04 16:11:31', '3232235901', '');
INSERT INTO `T_MOA_SESSION` VALUES ('msupd0ar5acgkugt52f3o6g3d4', '1535971938', 'moa|a:9:{s:4:\"role\";s:1:\"0\";s:3:\"sid\";s:2:\"14\";s:3:\"uid\";s:6:\"text02\";s:8:\"is_admin\";s:1:\"0\";s:4:\"name\";s:15:\" 测试用户02\";s:3:\"sex\";s:1:\"0\";s:5:\"email\";s:13:\"123456@qq.com\";s:5:\"phone\";s:9:\"123456789\";s:3:\"img\";s:5:\"9.jpg\";}mim|s:32:\"aab3238922bcc25a6f606eb525ffdc56\";', '2018-09-03 16:52:18', '3232235901', '');
INSERT INTO `T_MOA_SESSION` VALUES ('o4tre02d1uum5eo7vo4fh2kbq3', '1535971914', 'moa|a:9:{s:4:\"role\";a:6:{i:0;s:22:\"moa_action_group_media\";i:1;s:21:\"moa_action_group_user\";i:2;s:21:\"moa_action_task_media\";i:3;s:20:\"moa_action_task_chat\";i:4;s:25:\"moa_action_milestone_chat\";i:5;s:26:\"moa_action_milestone_media\";}s:3:\"sid\";s:2:\"13\";s:3:\"uid\";s:6:\"text01\";s:8:\"is_admin\";s:1:\"0\";s:4:\"name\";s:17:\"测试单用户01\";s:3:\"sex\";s:1:\"0\";s:5:\"email\";s:16:\"350084079@qq.com\";s:5:\"phone\";s:9:\"123456789\";s:3:\"img\";s:5:\"8.jpg\";}mim|s:32:\"c51ce410c124a10e0db5e4b97fc2af39\";', '2018-09-03 16:51:54', '3232235901', '');

-- ----------------------------
-- Table structure for T_MOA_TASK
-- ----------------------------
DROP TABLE IF EXISTS `T_MOA_TASK`;
CREATE TABLE `T_MOA_TASK` (
  `SID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '//自增SID',
  `TITLE` varchar(128) NOT NULL COMMENT '//任务名称',
  `CREATOR` varchar(128) NOT NULL COMMENT '//创建者',
  `CREATE_TIME` datetime NOT NULL COMMENT '//创建时间',
  `CONTENT` varchar(1000) NOT NULL COMMENT '//任务描述',
  `FILE_TYPE` tinyint(1) NOT NULL DEFAULT '1' COMMENT '文件库状态 1开启 0关闭',
  `CHAT_TYPE` tinyint(1) NOT NULL DEFAULT '1' COMMENT '聊天群状态 1开启 0关闭',
  `MF_GROUP_ID` bigint(20) NOT NULL,
  `IS_PUBLIC` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1公开 0非公开',
  `CONFIRM` tinyint(1) NOT NULL DEFAULT '0' COMMENT '//完成状态 0未完成 1已完成',
  PRIMARY KEY (`SID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of T_MOA_TASK
-- ----------------------------

-- ----------------------------
-- Table structure for T_MOA_TASK_CHAT
-- ----------------------------
DROP TABLE IF EXISTS `T_MOA_TASK_CHAT`;
CREATE TABLE `T_MOA_TASK_CHAT` (
  `SID` int(11) NOT NULL AUTO_INCREMENT,
  `TID` int(11) NOT NULL,
  `MID` int(11) NOT NULL,
  `MIM_GROUP_ID` int(11) NOT NULL,
  PRIMARY KEY (`SID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of T_MOA_TASK_CHAT
-- ----------------------------

-- ----------------------------
-- Table structure for T_MOA_TASK_MILESTONE
-- ----------------------------
DROP TABLE IF EXISTS `T_MOA_TASK_MILESTONE`;
CREATE TABLE `T_MOA_TASK_MILESTONE` (
  `SID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '//自增SID',
  `T_SID` bigint(20) NOT NULL COMMENT '//任务SID',
  `TITLE` varchar(128) NOT NULL COMMENT '//里程碑名称',
  `START_TIME` datetime NOT NULL COMMENT '//起始时间',
  `END_TIME` datetime NOT NULL COMMENT '//结束时间',
  `LEADER` varchar(128) NOT NULL COMMENT '//里程碑组长',
  `CREATE_TIME` datetime NOT NULL COMMENT '//创建时间',
  `CONTENT` varchar(1000) NOT NULL COMMENT '里程碑描述',
  `STATUS` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1开启 0关闭',
  `MF_GROUP_ID` bigint(20) NOT NULL COMMENT '//文件库group',
  `PROGRESS` varchar(10) NOT NULL DEFAULT '0' COMMENT '//进度',
  `CONFIRM` tinyint(1) NOT NULL DEFAULT '0' COMMENT '完成状态 0未完成 1已完成',
  PRIMARY KEY (`SID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of T_MOA_TASK_MILESTONE
-- ----------------------------

-- ----------------------------
-- Table structure for T_MOA_TASK_MILESTONE_USER
-- ----------------------------
DROP TABLE IF EXISTS `T_MOA_TASK_MILESTONE_USER`;
CREATE TABLE `T_MOA_TASK_MILESTONE_USER` (
  `SID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '//自增SID',
  `M_SID` bigint(20) NOT NULL COMMENT '//里程碑SID',
  `M_UID` varchar(128) NOT NULL COMMENT '//人员UID',
  PRIMARY KEY (`SID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of T_MOA_TASK_MILESTONE_USER
-- ----------------------------

-- ----------------------------
-- Table structure for T_MOA_TASK_USER
-- ----------------------------
DROP TABLE IF EXISTS `T_MOA_TASK_USER`;
CREATE TABLE `T_MOA_TASK_USER` (
  `SID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '//自增SID',
  `T_SID` bigint(20) NOT NULL COMMENT '//任务SID',
  `T_UID` varchar(128) NOT NULL COMMENT '//人员UID',
  PRIMARY KEY (`SID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of T_MOA_TASK_USER
-- ----------------------------

-- ----------------------------
-- Table structure for T_MOA_USER
-- ----------------------------
DROP TABLE IF EXISTS `T_MOA_USER`;
CREATE TABLE `T_MOA_USER` (
  `SID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '//自增SID',
  `UID` varchar(128) NOT NULL COMMENT '//用户UID',
  `PASSWORD` char(32) NOT NULL COMMENT '//登录密码',
  `NAME` varchar(128) NOT NULL COMMENT '//姓名',
  `SEX` tinyint(1) NOT NULL DEFAULT '1' COMMENT '//性别(1女0男)',
  `IMG` varchar(500) NOT NULL COMMENT '//头像',
  `PHONE` varchar(128) NOT NULL COMMENT '//联系方式',
  `EMAIL` varchar(500) NOT NULL COMMENT '//邮箱',
  `ROLE` int(11) NOT NULL COMMENT '//权限角色',
  `STATUS` tinyint(1) NOT NULL DEFAULT '1' COMMENT '//状态（1启用0冻结）',
  `IS_ADMIN` tinyint(1) NOT NULL COMMENT '是否为管理员',
  `CONTENT` text NOT NULL COMMENT '//备注',
  PRIMARY KEY (`SID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of T_MOA_USER
-- ----------------------------
INSERT INTO `T_MOA_USER` VALUES ('8', 'superadmin', 'e10adc3949ba59abbe56e057f20f883e', 'MOA超管', '0', '3.jpg', '121212222', '22222@qq.com', '0', '1', '1', '');
INSERT INTO `T_MOA_USER` VALUES ('9', 'wytj0304.1', 'e10adc3949ba59abbe56e057f20f883e', '王岳', '0', '4.jpg', '13821286446', 'wytj0304@hotmail.com', '1', '1', '0', '');
INSERT INTO `T_MOA_USER` VALUES ('10', 'bit000002.1', 'e10adc3949ba59abbe56e057f20f883e', '王岳', '0', '4.jpg', '13821286446', 'wytj0304@hotmail.com', '0', '1', '1', '');
INSERT INTO `T_MOA_USER` VALUES ('11', 'bit000001.1', 'e10adc3949ba59abbe56e057f20f883e', '史勇', '0', '4.jpg', '', '', '1', '1', '1', '');
INSERT INTO `T_MOA_USER` VALUES ('12', 'superadmin.2', 'e10adc3949ba59abbe56e057f20f883e', '超管', '0', '4.jpg', '', '', '0', '1', '1', '');
INSERT INTO `T_MOA_USER` VALUES ('13', 'text01', 'e10adc3949ba59abbe56e057f20f883e', '测试单用户01', '0', '8.jpg', '123456789', '350084079@qq.com', '3', '1', '0', '');
INSERT INTO `T_MOA_USER` VALUES ('14', 'text02', 'e10adc3949ba59abbe56e057f20f883e', ' 测试用户02', '0', '9.jpg', '123456789', '123456@qq.com', '0', '1', '0', '');
INSERT INTO `T_MOA_USER` VALUES ('15', 'text03', 'e10adc3949ba59abbe56e057f20f883e', '测试用户03', '0', '3.jpg', '123456789', '123456@qq.com', '1', '1', '0', '');
