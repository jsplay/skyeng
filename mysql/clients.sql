CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `surname` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `status_id` tinyint(1) PRIMARY KEY NOT NULL DEFAULT '1',
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX `status_id` (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
