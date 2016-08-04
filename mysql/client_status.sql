CREATE TABLE `client_status` (
  `status_id` int(20) AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `status_name` varchar(20) NOT NULL,
  `status_name_ru` varchar(20) NOT NULL,
  INDEX `status_id` (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `client_status` (`status_id`, `status_name`, `status_name_ru`) VALUES
(1, 'new', 'новый'),
(2, 'registered', 'зарегистрирован'),
(3, 'refused', 'отказался'),
(4, 'notavailable', 'недоступен');
