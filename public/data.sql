
CREATE TABLE IF NOT EXISTS `psx_example` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `place` int(10) NOT NULL,
  `region` varchar(64) NOT NULL,
  `population` int(10) NOT NULL,
  `users` int(10) NOT NULL,
  `world_users` float NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

INSERT INTO `psx_example` (`id`, `place`, `region`, `population`, `users`, `world_users`, `datetime`) VALUES
(1, 1, 'China', 1338612968, 360000000, 20.8, '2009-11-29 15:21:49'),
(2, 2, 'United States', 307212123, 227719000, 13.1, '2009-11-29 15:22:40'),
(3, 3, 'Japan', 127078679, 95979000, 5.5, '2009-11-29 15:23:18'),
(4, 4, 'India', 1156897766, 81000000, 4.7, '2009-11-29 15:24:47'),
(5, 5, 'Brazil', 198739269, 67510400, 3.9, '2009-11-29 15:25:20'),
(6, 6, 'Germany', 82329758, 54229325, 3.1, '2009-11-29 15:25:58'),
(7, 7, 'United Kingdom', 61113205, 46683900, 2.7, '2009-11-29 15:26:27'),
(8, 8, 'Russia', 140041247, 45250000, 2.6, '2009-11-29 15:27:07'),
(9, 9, 'France', 62150775, 43100134, 2.5, '2009-11-29 15:27:37'),
(10, 10, 'Korea South', 48508972, 37475800, 2.2, '2009-11-29 15:28:06');


