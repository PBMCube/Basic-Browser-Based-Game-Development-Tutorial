SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mbg_basic_tutorial`
--

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE IF NOT EXISTS `players` (
  `player_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(200) NOT NULL,
  `email` varchar(255) NOT NULL,
  `level` int(11) NOT NULL DEFAULT '1',
  `exp` int(11) NOT NULL DEFAULT '0',
  `expNext` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`player_id`),
  UNIQUE KEY `id_UNIQUE` (`player_id`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `players`
--

INSERT INTO `players` (`player_id`, `username`, `password`, `email`, `level`, `exp`, `expNext`) VALUES
(2, 'Cardinal', 'e20c3d59641e1b9e16bdc5fd7cf91e91', 'cardinal@cardinal.com', 7, 350, 400);
-- --------------------------------------------------------

--
-- Table structure for table `player_stats`
--

CREATE TABLE IF NOT EXISTS `player_stats` (
  `player_id` int(11) NOT NULL,
  `stat_id` int(11) NOT NULL,
  `value` varchar(20) NOT NULL DEFAULT '0',
  KEY `playerStats` (`player_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `player_stats`
--

INSERT INTO `player_stats` (`player_id`, `stat_id`, `value`) VALUES
(2, 9, '1'),
(2, 10, '100'),
(2, 11, '100'),
(2, 12, '100'),
(2, 13, '100'),
(2, 14, '100'),
(2, 5, '112'),
(2, 6, '109'),
(2, 1, '100'),
(2, 2, '100'),
(2, 3, '100'),
(2, 4, '100'),
(2, 7, '106'),
(2, 8, '464'),
(2, 0, '100'),
(2, 15, '9');

-- --------------------------------------------------------

--
-- Table structure for table `player_train_logs`
--

CREATE TABLE IF NOT EXISTS `player_train_logs` (
  `player_id` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  KEY `playerTrainLogs_idx` (`player_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `player_train_logs`
--

INSERT INTO `player_train_logs` (`player_id`, `created`) VALUES
(2, 1397897655);

-- --------------------------------------------------------

--
-- Table structure for table `warehouse`
--

CREATE TABLE IF NOT EXISTS `warehouse` (
  `item_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  KEY `playerItems_idx` (`player_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `warehouse`
--

INSERT INTO `warehouse` (`item_id`, `player_id`, `quantity`) VALUES
(1, 2, 88),
(2, 2, 108),
(3, 2, 107),
(4, 2, 103),
(5, 2, 105),
(6, 2, 105),
(7, 2, 105),
(8, 2, 102);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `player_stats`
--
ALTER TABLE `player_stats`
  ADD CONSTRAINT `playerStats` FOREIGN KEY (`player_id`) REFERENCES `players` (`player_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `player_train_logs`
--
ALTER TABLE `player_train_logs`
  ADD CONSTRAINT `playerTrainLogs` FOREIGN KEY (`player_id`) REFERENCES `players` (`player_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `warehouse`
--
ALTER TABLE `warehouse`
  ADD CONSTRAINT `userItems` FOREIGN KEY (`player_id`) REFERENCES `players` (`player_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
