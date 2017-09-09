-- ---
-- Globals
-- ---

-- SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
-- SET FOREIGN_KEY_CHECKS=0;

-- ---
-- Table 'user'
-- 
-- ---

DROP TABLE IF EXISTS `user`;
		
CREATE TABLE `user` (
  `id` INTEGER NOT NULL AUTO_INCREMENT,
  `user_name` VARCHAR(30) NOT NULL,
  `user_password` VARCHAR(60) NOT NULL,
  `user_auth` INTEGER NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` TIMESTAMP NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
);

-- ---
-- Table 'auto_login'
-- 
-- ---

DROP TABLE IF EXISTS `auto_login`;
		
CREATE TABLE `auto_login` (
  `id` INTEGER NOT NULL AUTO_INCREMENT,
  `user_id` INTEGER NOT NULL,
  `c_key` VARCHAR(40) NOT NULL,
  `expire` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` TIMESTAMP NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
);

-- ---
-- Table 'item'
-- 
-- ---

DROP TABLE IF EXISTS `item`;
		
CREATE TABLE `item` (
  `id` INTEGER NOT NULL AUTO_INCREMENT,
  `column1` MEDIUMTEXT NULL DEFAULT NULL,
  `column2` MEDIUMTEXT NULL DEFAULT NULL,
  `column3` MEDIUMTEXT NULL DEFAULT NULL,
  `column4` MEDIUMTEXT NULL DEFAULT NULL,
  `column5` MEDIUMTEXT NULL DEFAULT NULL,
  `column6` MEDIUMTEXT NULL DEFAULT NULL,
  `column7` MEDIUMTEXT NULL DEFAULT NULL,
  `column8` MEDIUMTEXT NULL DEFAULT NULL,
  `column9` MEDIUMTEXT NULL DEFAULT NULL,
  `column10` MEDIUMTEXT NULL DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` INTEGER NOT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` INTEGER NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- ---
-- Table 'history'
-- 
-- ---

DROP TABLE IF EXISTS `history`;
		
CREATE TABLE `history` (
  `id` INTEGER NOT NULL AUTO_INCREMENT,
  `user_id` INTEGER NOT NULL,
  `action` VARCHAR(200) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` TIMESTAMP NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
);

-- ---
-- Foreign Keys 
-- ---


-- ---
-- Table Properties
-- ---

-- ALTER TABLE `user` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `auto_login` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `item` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `history` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ---
-- Test Data
-- ---

-- INSERT INTO `user` (`id`,`user_name`,`user_password`,`user_auth`,`created_at`,`updated_at`) VALUES
-- ('','','','','','');
-- INSERT INTO `auto_login` (`id`,`user_id`,`c_key`,`expire`,`created_at`,`updated_at`) VALUES
-- ('','','','','','');
-- INSERT INTO `item` (`id`,`column1`,`column2`,`column3`,`column4`,`column5`,`column6`,`column7`,`column8`,`column9`,`column10`,`created_at`,`created_by`,`updated_at`,`updated_by`) VALUES
-- ('','','','','','','','','','','','','','','');
-- INSERT INTO `history` (`id`,`user_id`,`action`,`created_at`,`updated_at`) VALUES
-- ('','','','','');