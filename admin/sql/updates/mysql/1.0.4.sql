DROP TABLE IF EXISTS `#__hapity`;
 
CREATE TABLE `#__hapity` (
	`id`       INT(11)     NOT NULL AUTO_INCREMENT,
	`key` TEXT NOT NULL,
	`published` tinyint(4) NOT NULL,
	PRIMARY KEY (`id`)
)
	ENGINE =MyISAM
	AUTO_INCREMENT =0
	DEFAULT CHARSET =utf8;
 
