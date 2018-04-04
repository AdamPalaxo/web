-- Adminer 4.6.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `project`;
CREATE TABLE `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `deadline` date NOT NULL,
  `type` enum('time','continuous') NOT NULL,
  `web_project` bit(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `project` (`id`, `title`, `deadline`, `type`, `web_project`) VALUES
(4,	'PrvnĂ­ projekt',	'2018-04-20',	'time',	CONV('1', 2, 10) + 0),
(5,	'NovĂ˝ projekt',	'2018-04-02',	'time',	CONV('1', 2, 10) + 0),
(6,	'Test',	'2018-04-02',	'time',	CONV('1', 2, 10) + 0),
(8,	'Test',	'2018-04-02',	'time',	CONV('1', 2, 10) + 0),
(9,	'Test',	'2018-04-02',	'time',	CONV('0', 2, 10) + 0),
(10,	'Test',	'2018-04-02',	'time',	CONV('1', 2, 10) + 0),
(11,	'Test',	'2018-04-02',	'time',	CONV('1', 2, 10) + 0),
(15,	'Test',	'2018-04-02',	'time',	CONV('1', 2, 10) + 0),
(16,	'Test',	'2018-04-02',	'continuous',	CONV('1', 2, 10) + 0),
(17,	'Test',	'2018-04-02',	'time',	CONV('1', 2, 10) + 0),
(18,	'Test',	'1999-04-02',	'time',	CONV('1', 2, 10) + 0),
(19,	'Test',	'2018-04-02',	'time',	CONV('1', 2, 10) + 0),
(20,	'Test',	'2018-04-02',	'time',	CONV('1', 2, 10) + 0),
(21,	'Test',	'2018-04-02',	'continuous',	CONV('1', 2, 10) + 0),
(22,	'Test',	'2018-04-02',	'time',	CONV('0', 2, 10) + 0);

-- 2018-04-04 20:07:55
