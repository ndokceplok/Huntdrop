-- phpMyAdmin SQL Dump
-- version 3.3.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 26, 2012 at 10:54 PM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_hunterdrop`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(32) NOT NULL,
  `user_group` varchar(32) NOT NULL,
  `fb_uid` varchar(100) NOT NULL,
  `email` varchar(128) NOT NULL,
  `nid` varchar(64) NOT NULL,
  `phone` varchar(32) NOT NULL,
  `hash` varchar(64) NOT NULL,
  `pass` varchar(64) NOT NULL,
  `status` smallint(2) NOT NULL,
  `last_login` datetime NOT NULL,
  `entry_date` datetime NOT NULL,
  `last_update` datetime NOT NULL,
  `last_active` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_online` tinyint(1) NOT NULL,
  `deleted` tinyint(1) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `user_name` (`user_name`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`ID`, `user_name`, `user_group`, `fb_uid`, `email`, `nid`, `phone`, `hash`, `pass`, `status`, `last_login`, `entry_date`, `last_update`, `last_active`, `is_online`, `deleted`, `deleted_at`) VALUES
(1, 'hendra', 'member', '14848592099', 'paulscholes@gmail.com', '', '', '37fa171ed1b3b60d13e874513149ca820d139df9', '21b951534ee4eb386b12cbdaf27ebe49c024741c', 1, '2012-03-11 18:16:48', '2011-05-15 05:10:55', '0000-00-00 00:00:00', '2012-03-11 18:24:47', 1, NULL, NULL),
(2, 'mdennisa', 'member', '1476459151', 'mdennisa@gmail.com', '', '', '71fe13717ae99ad7f80d9419f50e25856eba70df', 'd7ec2a80e1b176aeff75099eff136cd18d6fe96a', 1, '2011-11-07 21:42:42', '2011-05-19 09:33:38', '0000-00-00 00:00:00', '2012-03-11 17:40:26', 1, NULL, NULL),
(10, 'eric', 'member', '', 'eric@gmail.com', '0', '0', '999aeee12fd85a4c01eed538c5672ebe8f848e21', '647037ac328b28daeaabf1abb9504bf66390fe02', 1, '2011-09-13 20:40:06', '2011-08-10 12:38:00', '0000-00-00 00:00:00', '2011-09-13 22:01:08', 1, NULL, NULL),
(15, 'bhks', 'member', '148484452', 'bhks@gmail.com', '', '', '', '', 0, '0000-00-00 00:00:00', '2011-09-23 23:39:19', '0000-00-00 00:00:00', '2012-03-03 00:30:03', 0, NULL, NULL),
(20, 'henson', 'member', '1484859209', 'af@gmail.com', '', '', '1a210dc6ef7976cbd869f59d5a63c676bc11aa14', 'db402214f1151e0da87db570b5a9326ef816ea18', 1, '2011-12-16 21:26:18', '2011-10-19 22:04:30', '0000-00-00 00:00:00', '2012-03-11 17:44:47', 1, NULL, NULL),
(21, 'benhanks', 'member', '1484859209', 'benhanks040888@gmail.com', '0', '0', 'c82f8657103c41bd6c1faa9ce2d02d4cfecb8026', '9ce9015937d25375555f42c5a43ca31aa38fb27f', 1, '2011-11-02 22:40:14', '2011-10-19 23:11:56', '0000-00-00 00:00:00', '2012-03-03 00:24:45', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(32) NOT NULL,
  `user_group` varchar(32) NOT NULL,
  `hash` varchar(64) NOT NULL,
  `pass` varchar(64) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`ID`, `user_name`, `user_group`, `hash`, `pass`) VALUES
(1, 'admin', 'superadmin', 'd8aecbfad275bf8e340f2682cc33395c27bd9660', '318d091164e1d5fdcdcaa5d4fdec6f0ca38daf33'),
(2, 'business', 'business', '21ac2fc04e726dd285b1c23f733f1a7eb974260b', '3e00a7f36124613586d93eecc85f67ba23854073');

-- --------------------------------------------------------

--
-- Table structure for table `advertise_requests`
--

CREATE TABLE `advertise_requests` (
  `request_id` int(11) NOT NULL AUTO_INCREMENT,
  `requester_name` varchar(150) NOT NULL,
  `requester_email` varchar(150) NOT NULL,
  `inquiry` text NOT NULL,
  `request_date` datetime NOT NULL,
  `requester_ip` varchar(20) NOT NULL,
  `request_read` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`request_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `advertise_requests`
--

INSERT INTO `advertise_requests` (`request_id`, `requester_name`, `requester_email`, `inquiry`, `request_date`, `requester_ip`, `request_read`) VALUES
(1, 'Hendra', 'benhanks040888@gmail.com', 'tests\r\n\r\ntests', '2011-11-14 23:27:01', '127.0.0.1', 1),
(2, 'budiman', 'budiman@gmail.com', 'Berapa harga iklan?', '2011-11-19 17:46:17', '127.0.0.1', 1),
(5, 'Olly Murs The Third Album', 'benhanks040888@gmail.com', 'Olly Murs The Third Album', '2012-03-10 00:31:40', '127.0.0.1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT,
  `category` int(11) NOT NULL,
  `date` date NOT NULL,
  `title` varchar(500) NOT NULL,
  `alias` varchar(150) NOT NULL,
  `short_desc` varchar(1000) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(500) NOT NULL,
  `thumb` varchar(500) NOT NULL,
  PRIMARY KEY (`article_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`article_id`, `category`, `date`, `title`, `alias`, `short_desc`, `content`, `image`, `thumb`) VALUES
(1, 0, '2011-11-24', 'Article #1.1', 'article-1-1', 'Rule #1 : Don''t repeat yourself', '<p>\r\n Rule #1 : Don&#39;t repeat yourself</p>\r\n<p>\r\n It&#39;s cool if you want something as good as jQuery</p>\r\n', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `banner_id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_title` varchar(150) NOT NULL,
  `banner_image` varchar(150) NOT NULL,
  `banner_link` varchar(150) NOT NULL,
  `banner_page` varchar(150) NOT NULL,
  `banner_position` varchar(150) NOT NULL,
  `banner_type` varchar(100) NOT NULL,
  `banner_start_date` datetime NOT NULL,
  `banner_end_date` datetime NOT NULL,
  `banner_status` int(11) NOT NULL,
  PRIMARY KEY (`banner_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`banner_id`, `banner_title`, `banner_image`, `banner_link`, `banner_page`, `banner_position`, `banner_type`, `banner_start_date`, `banner_end_date`, `banner_status`) VALUES
(1, 'Moscow', 'mb2011_banner_360x150px.jpg', 'http://benhanks040888.posterous.com', 'home', 'sidebar', '', '2011-12-04 00:00:00', '2011-12-23 23:59:59', 1),
(2, 'Holiday Banners', 'holiday-banner-2012-360-by-150.jpg', 'http://www.siliconera.com', 'home', 'sidebar', '', '2012-03-10 00:00:00', '2012-03-17 23:59:59', 1);

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `series_id` varchar(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `alias` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `tag` varchar(200) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`ID`, `series_id`, `title`, `alias`, `content`, `tag`) VALUES
(2, '11', 'My life so Far in Jakarta', 'my-life-so-far-in-jakarta', '<p>\r\n I haven&#39;t slept yet</p>\r\n', 'life, story'),
(24, '7', 'It''s not red', 'it-s-not-red', '<p>\r\n <font face="Arial, Helvetica, sans-serif">First, we need to start off with a bit about one of the differences between English and Japanese. In English adjectives usually stay in their affirmative form and &#39;not&#39; is added when changing to the negative. In Japanese, however, i adjectives all have an affirmative and a negative form. Thus, &#39;black&#39; and &#39;not black&#39; are both adjectives.</font></p>\r\n<p>\r\n <font face="Arial, Helvetica, sans-serif">In order to change an i adjective from affirmative to negative form, <em>change </em>the <strong>last </strong>i to kunai.</font></p>\r\n<p>\r\n <font face="Arial, Helvetica, sans-serif"><img alt="" src="/ckfiles/images/1180969657815.jpg"  500px; height: 367px;" /></font></p>\r\n', '0'),
(22, '', 'New Project', 'new-project', 'new', '0'),
(13, '2', 'FIFA', 'fifa', 'Best Players', 'fifa'),
(18, '5', 'Harusnya Begini', 'harusnya-begini', 'Maen 1-2-1', '0'),
(17, '5', 'Bleach Futsal', 'bleach-futsal', '<p>\r\n Entah apa apa aja. seakan2 messi disuruh jadi back... setan</p>\r\n', 'palak, ngomel'),
(30, '1', 'Tes 2 Image', 'tes-2-image', '<p>\r\n Testst</p>\r\n', '0'),
(31, '', 'A New Blogsss', 'a-new-blogsss', '<p>\r\n A New Blog</p>\r\n<p>\r\n A New Blog</p>\r\n<p>\r\n A New Blog</p>\r\n', '0'),
(29, '1', 'Tes no image', 'tes-no-image', '<p>\r\n no image</p>\r\n', '0');

-- --------------------------------------------------------

--
-- Table structure for table `blog_series`
--

CREATE TABLE `blog_series` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `series_name` varchar(500) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `blog_series`
--

INSERT INTO `blog_series` (`ID`, `account_id`, `series_name`) VALUES
(1, 1, 'Test'),
(2, 1, 'Kris Allen'),
(3, 2, 'Scotty'),
(12, 0, 'Olly'),
(5, 1, 'Futsal'),
(7, 1, 'New SEries'),
(11, 21, 'Just A Blog');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brand_id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(150) NOT NULL,
  PRIMARY KEY (`brand_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_name`) VALUES
(1, 'Dell'),
(2, 'Persona'),
(3, 'Paramore');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('6edb5db94237d991eff8502cf1b00738', '127.0.0.1', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.77 Safari/535.7', 1332775237, ''),
('6bba16afb69a245271083e7918f74482', '127.0.0.1', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.77 Safari/535.7', 1332500722, ''),
('ef4101647a08e3e02dbdafa0c7e94773', '127.0.0.1', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.77 Safari/535.7', 1332040424, ''),
('959a1fc31c6bffd288aa96d17d83c948', '127.0.0.1', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.77 Safari/535.7', 1331741982, ''),
('029b435da888652f99990dc1a43c9439', '127.0.0.1', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.77 Safari/535.7', 1331745642, ''),
('ef0f732bcb321d00591fd31e62b8d436', '127.0.0.1', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.77 Safari/535.7', 1331826740, ''),
('5bdc7a1a6ba1bfa37c1ebfdc3f24be8a', '127.0.0.1', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.77 Safari/535.7', 1331655682, ''),
('fa352e30985ecb8b9e4d031efa9d434d', '127.0.0.1', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.77 Safari/535.7', 1331560563, ''),
('0864d967462d062e19b167118bcf4206', '127.0.0.1', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.77 Safari/535.7', 1331563543, ''),
('c09518aa5d44571fdc0942e50b6497a1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.77 Safari/535.7', 1331567121, ''),
('bab3a732f5a9c865bb2d36fdafe2121e', '127.0.0.1', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.77 Safari/535.7', 1331916067, ''),
('6f51dc6ad70885bc9c1d6fb0c97bd4b9', '127.0.0.1', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.77 Safari/535.7', 1331950196, '');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `target` int(11) NOT NULL COMMENT '1=contents comments; 2 =profile comments',
  `user_id` varchar(11) NOT NULL,
  `post_type` varchar(11) DEFAULT NULL,
  `post_id` varchar(11) NOT NULL,
  `content` text NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`ID`, `target`, `user_id`, `post_type`, `post_id`, `content`, `hidden`) VALUES
(1, 1, '', '2', '18', 'test comment', 0),
(2, 1, '', '3', '4', 'jelek kali gambarnya', 0),
(18, 1, '', '2', '24', 'Nice pic gan!', 0),
(4, 1, '', '1', '3', 'astaga', 0),
(6, 1, '', '2', '18', 'test lagi', 0),
(29, 1, '', '3', '21', 'testtte ', 0),
(9, 1, '', '3', '11', 'nice!', 0),
(10, 1, '', '3', '11', 'great', 0),
(11, 1, '', '3', '11', 'wtf?', 0),
(12, 2, '2', '', '', 'tes', 0),
(13, 2, '2', '', '', 'tes again', 0),
(15, 1, '', '2', '18', 'bbbb aaaa', 0),
(16, 1, '', '2', '17', 'asik tuh', 0),
(17, 1, '', '4', '1', 'tes', 0),
(19, 2, '1', NULL, '', 'HI AlL!\n\nHI AlL!', 0),
(20, 2, '1', NULL, '', 'jangan usil\nya', 0),
(21, 1, '', '5', '2', 'test', 0),
(22, 1, '', '5', '2', 'test 2', 0),
(23, 1, '', '1', '3', 'tes aja', 0),
(26, 2, '10', NULL, '', 'hoy apa kabar?\n', 0),
(30, 1, '', '3', '22', 'YES', 0),
(31, 1, '', '3', '16', 'OMG this is so\r\n\r\nAWESOME!', 0);

-- --------------------------------------------------------

--
-- Table structure for table `contests`
--

CREATE TABLE `contests` (
  `contest_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(500) NOT NULL,
  `submission_start_date` date NOT NULL,
  `submission_end_date` date NOT NULL,
  `voting_start_date` date NOT NULL,
  `voting_end_date` date NOT NULL,
  `content` text NOT NULL,
  `image` varchar(250) NOT NULL,
  `deleted` tinyint(1) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`contest_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `contests`
--

INSERT INTO `contests` (`contest_id`, `title`, `submission_start_date`, `submission_end_date`, `voting_start_date`, `voting_end_date`, `content`, `image`, `deleted`, `deleted_at`) VALUES
(1, 'Catch The Fish!', '2011-08-01', '2011-08-15', '2011-08-16', '2011-08-23', '<p>\r\n Don&#39;t miss it!</p>\r\n<p>\r\n Send us the best fish you ever caught!</p>\r\n<h2>\r\n Prizes</h2>\r\n<p>\r\n The prizes are as such :</p>\r\n<ul>\r\n <li>\r\n  1st winner gets a PS3</li>\r\n <li>\r\n  2nd winnder gets a BlackBerry Gemini</li>\r\n</ul>\r\n', 'contest.jpg', NULL, NULL),
(2, 'Catch The Bird', '2011-09-11', '2011-09-18', '2011-09-11', '2011-09-18', '<p>\r\n Catch The Bird</p>\r\n', 'contest2.jpg', 1, '2012-03-09 23:00:34'),
(3, 'Contest 3', '2011-09-23', '2011-10-07', '2011-10-01', '2011-10-08', '<p>\r\n <span class="Apple-style-span">The battle system used for<span class="Apple-converted-space">?</span><i>Tales of Graces</i><span class="Apple-converted-space">?</span>is the &quot;Style Shift Linear Motion Battle System&quot; (SS-LiMBS). In this system, characters have two different fighting styles to choose from. The A-style artes are pre-determined, however you can set the B-style artes, and the player is able to freely switch between the styles in battle. The battle system is currently rated one of the best systems in the entire Tales history.</span></p>\r\n<p>\r\n <span class="Apple-style-span">Characters are also able to sidestep in a 360 degree circle around the enemy as well as Free Run. &quot;Blast Calibers&quot;, as used in the<span class="Apple-converted-space">?</span><i><a href="http://en.wikipedia.org/wiki/Tales_of_Destiny_(PS2)" title="Tales of Destiny (PS2)">Tales of Destiny (PS2)</a></i><span class="Apple-converted-space">?</span>remake, make a return in<span class="Apple-converted-space">?</span><i>Tales of Graces</i>.</span></p>\r\n<p>\r\n <span class="Apple-style-span">In battle, players attack using the Chain Capacity point system used in the<span class="Apple-converted-space">?</span><i><a href="http://en.wikipedia.org/wiki/Tales_of_Destiny_(PS2)" title="Tales of Destiny (PS2)">Tales of Destiny (PS2)</a></i><span class="Apple-converted-space">?</span>remake. The free run maneuver which originated in<span class="Apple-converted-space">?</span><i><a href="http://en.wikipedia.org/wiki/Tales_of_the_Abyss" title="Tales of the Abyss">Tales of the Abyss</a></i><span class="Apple-converted-space">?</span>is renewed in this game, but it is limited by Chain Capacity points</span></p>\r\n', 'alaska-hunting.jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `forums`
--

CREATE TABLE `forums` (
  `forum_id` int(11) NOT NULL AUTO_INCREMENT,
  `forum_name` varchar(500) NOT NULL,
  `description` varchar(5000) NOT NULL,
  PRIMARY KEY (`forum_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `forums`
--

INSERT INTO `forums` (`forum_id`, `forum_name`, `description`) VALUES
(1, 'Hunting Skill Share', 'Your woodworking skills are displayed for several lifetimes in each project. Have you had to compromise your '),
(2, 'Equipments', 'Different wood requires different woodworking strategies - from cutting to finishing'),
(3, 'Animals', 'Animals here'),
(4, 'Website Feedback', 'Website feedback here'),
(5, 'Non-hunt Talks', 'Non hunting talks here'),
(6, 'Rare Animals', 'All About Rare Animals'),
(7, 'Misc', 'Talk Here');

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `friender_id` int(11) NOT NULL,
  `friended_id` int(11) NOT NULL,
  `status` varchar(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`ID`, `friender_id`, `friended_id`, `status`) VALUES
(6, 1, 2, '1'),
(15, 1, 10, '1'),
(9, 10, 1, '1'),
(10, 1, 15, '1'),
(11, 1, 20, '1'),
(16, 20, 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `liker_id` int(11) NOT NULL,
  `post_type` varchar(11) DEFAULT NULL,
  `post_id` varchar(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`ID`, `liker_id`, `post_type`, `post_id`) VALUES
(1, 1, '2', '2'),
(2, 10, '2', '24'),
(3, 10, '2', '2'),
(10, 20, '2', '31'),
(5, 10, '4', '2'),
(6, 10, '1', '3'),
(9, 20, '3', '4'),
(8, 1, '3', '16'),
(11, 1, '5', '2'),
(12, 1, '1', '6'),
(13, 21, '1', '3'),
(14, 21, '3', '22');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` varchar(11) NOT NULL,
  `recipient_id` varchar(11) NOT NULL,
  `reply_to_id` varchar(11) NOT NULL,
  `subject` varchar(500) NOT NULL,
  `message` text NOT NULL,
  `entry_date` datetime NOT NULL,
  `read` int(1) NOT NULL,
  `sender_remove` int(1) NOT NULL,
  `recipient_remove` int(1) NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `sender_id`, `recipient_id`, `reply_to_id`, `subject`, `message`, `entry_date`, `read`, `sender_remove`, `recipient_remove`) VALUES
(1, '1', '2', '', 'Test Message', 'Suiko 2\r\nSuiko Tierkreis\r\nSuiko 5\r\nSuiko 3\r\nSuiko 1\r\nSUiko 4', '2011-08-07 18:00:00', 0, 1, 0),
(2, '2', '1', '1', 'Re: Test Message', 'Test Too', '2011-08-09 16:53:26', 1, 0, 0),
(3, '10', '2', '0', 'Hi', 'Hi', '2011-08-10 13:08:32', 1, 0, 0),
(4, '1', '2', '0', 'Oi Eric', 'agagaga', '2011-09-13 20:39:53', 0, 1, 0),
(5, '1', '10', '0', 'test', 'test', '2011-09-13 20:40:53', 1, 0, 0),
(6, '1', '2', '2', 'Re: Re: Test Message', 'HIHI', '2011-10-21 23:51:50', 0, 1, 0),
(7, '1', '2', '0', 'Test', 'Test', '2011-11-07 21:42:35', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(1) NOT NULL,
  `title` varchar(500) NOT NULL,
  `alias` varchar(150) NOT NULL,
  `content` text NOT NULL,
  `last_update` datetime NOT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`page_id`, `parent`, `title`, `alias`, `content`, `last_update`) VALUES
(1, 0, 'About', 'about', '<p>\r\n About HD</p>\r\n', '2011-09-22 22:34:51'),
(2, 1, 'Overview', 'overview', '<p>\r\n Overview of HD</p>\r\n', '2011-09-22 22:38:56'),
(3, 1, 'Story', 'story', '<p>\r\n Story</p>\r\n', '2011-09-22 22:41:37'),
(4, 1, 'Team', 'team', '<p>\r\n Team</p>\r\n', '2011-09-22 22:41:45'),
(5, 0, 'Advertise', 'advertise', '<p>\r\n <strong>Advertise With Us</strong></p>\r\n', '2011-10-12 16:40:25'),
(6, 0, 'Help', 'help', '<p>\r\n Help</p>\r\n', '2011-09-22 22:42:14'),
(7, 6, 'General', 'general', '<p>\r\n General Help</p>\r\n', '2011-09-22 22:42:41');

-- --------------------------------------------------------

--
-- Table structure for table `password_change_requests`
--

CREATE TABLE `password_change_requests` (
  `ID` varchar(50) NOT NULL,
  `time` datetime NOT NULL,
  `account_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `password_change_requests`
--

INSERT INTO `password_change_requests` (`ID`, `time`, `account_id`) VALUES
('f3d92078487f44ffbe1684237278ead785011352', '2012-03-03 18:09:56', 21);

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `entry_date` datetime NOT NULL,
  `src` varchar(500) NOT NULL,
  `thumb` varchar(400) NOT NULL,
  `view` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=63 ;

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`ID`, `post_id`, `account_id`, `entry_date`, `src`, `thumb`, `view`) VALUES
(1, 13, 1, '2011-05-28 15:58:04', '1024x768redarmyfc_com_Sat40837img_10_30619_60121.jpg', '1024x768redarmyfc_com_Sat40837img_10_30619_60121.jpg', 0),
(6, 5, 1, '2011-06-04 08:13:54', 'henson.jpg', '', 0),
(9, 6, 1, '2011-06-16 16:12:34', '[large][AnimePaper]wallpapers_Bleach_mooling89_17322.jpg', '', 0),
(7, 23, 1, '2011-06-05 05:16:00', 'wall1b.jpg', 'wall1b.jpg', 0),
(56, 104, 1, '2011-11-30 23:14:51', '96994418.jpg', '96994418.jpg', 0),
(59, 2, 1, '2012-03-03 22:22:15', '19.jpg', '19.jpg', 0),
(12, 46, 1, '2011-06-30 16:59:08', 'Different-than-others1.jpg', 'Different-than-others1.jpg', 0),
(13, 48, 1, '2011-07-03 05:31:07', '405728489.jpg', '', 0),
(14, 66, 1, '2011-07-21 15:20:43', 'pswebsutomo.JPG', 'pswebsutomo.JPG', 0),
(15, 68, 1, '2011-07-21 15:24:29', '1024x768redarmyfc_com_Sat40837img_10_30619_6012.jpg', '1024x768redarmyfc_com_Sat40837img_10_30619_6012.jpg', 0),
(31, 104, 1, '2011-10-14 15:13:53', 'karl.jpg', 'karl.jpg', 0),
(17, 72, 1, '2011-07-21 15:54:25', 'the_lich_king.jpg', 'the_lich_king.jpg', 0),
(19, 34, 1, '2011-07-21 16:00:41', 's_Two_nintendo_dogs_1024x768.jpg', 's_Two_nintendo_dogs_1024x768.jpg', 0),
(20, 24, 1, '2011-07-22 15:43:24', 'pmlposterb.jpg', 'pmlposterb.jpg', 0),
(21, 76, 2, '2011-08-06 15:24:01', 'tales-of-graces-20091019043244426_640w.jpg', 'tales-of-graces-20091019043244426_640w.jpg', 0),
(22, 77, 1, '2011-08-11 15:26:28', 'Gyakuten-Saiban-1451.jpg', 'Gyakuten-Saiban-1451.jpg', 0),
(28, 86, 1, '2011-08-24 22:22:59', 'ja3bc06c.jpg', 'ja3bc06c.jpg', 0),
(27, 86, 1, '2011-08-24 22:22:59', '1480665_e.jpg', '1480665_e.jpg', 0),
(29, 88, 1, '2011-09-19 22:45:57', 'genius.jpg', 'genius.jpg', 0),
(30, 27, 1, '2011-09-20 22:41:33', 'paramore1.jpg', 'paramore1.jpg', 0),
(49, 41, 1, '2011-10-30 00:35:10', 'alright_wall.jpg', 'alright_wall.jpg', 0),
(44, 118, 1, '2011-10-29 21:08:52', 'contact-smiley.jpg', 'contact-smiley.jpg', 0),
(57, 108, 1, '2011-12-27 21:58:33', 'yuno.jpg', 'yuno.jpg', 0),
(42, 117, 1, '2011-10-29 21:06:00', 'paramore11.jpg', 'paramore11.jpg', 0),
(58, 33, 1, '2012-03-03 22:22:03', 'batman2.jpg', 'batman2.jpg', 0),
(46, 118, 1, '2011-10-29 21:08:52', 'paramore12.jpg', 'paramore12.jpg', 0),
(50, 42, 1, '2011-10-30 00:35:24', '1240548.jpg', '1240548.jpg', 0),
(51, 85, 1, '2011-10-30 00:48:14', 'hanson.jpg', 'hanson.jpg', 0),
(52, 119, 1, '2011-11-01 20:15:29', 'alright_wall1.jpg', 'alright_wall1.jpg', 0),
(53, 74, 1, '2011-11-27 12:18:29', 'nike_henson_man-191.jpg', 'nike_henson_man-191.jpg', 0),
(60, 119, 1, '2012-03-03 22:23:09', 'karl-pilkington-globe1.jpg', 'karl-pilkington-globe1.jpg', 0),
(61, 119, 1, '2012-03-03 22:23:09', 'needle-in-haystack.jpg', 'needle-in-haystack.jpg', 0),
(62, 47, 1, '2012-03-03 22:36:51', 'QuitComplainingAboutYourJob.jpg', 'QuitComplainingAboutYourJob.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `photos_b`
--

CREATE TABLE `photos_b` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `entry_date` datetime NOT NULL,
  `src` varchar(500) NOT NULL,
  `thumb` varchar(400) NOT NULL,
  `view` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `photos_b`
--

INSERT INTO `photos_b` (`ID`, `post_id`, `account_id`, `entry_date`, `src`, `thumb`, `view`) VALUES
(1, 13, 1, '2011-05-28 15:58:04', '1024x768redarmyfc_com_Sat40837img_10_30619_60121.jpg', '1024x768redarmyfc_com_Sat40837img_10_30619_60121.jpg', 0),
(6, 5, 1, '2011-06-04 08:13:54', 'henson.jpg', '', 0),
(9, 6, 1, '2011-06-16 16:12:34', '[large][AnimePaper]wallpapers_Bleach_mooling89_17322.jpg', '', 0),
(7, 23, 1, '2011-06-05 05:16:00', 'wall1b.jpg', 'wall1b.jpg', 0),
(8, 33, 1, '2011-06-15 16:18:43', 'warning-sign.jpg', 'warning-sign.jpg', 0),
(12, 46, 1, '2011-06-30 16:59:08', 'Different-than-others1.jpg', 'Different-than-others1.jpg', 0),
(13, 48, 1, '2011-07-03 05:31:07', '405728489.jpg', '', 0),
(14, 66, 1, '2011-07-21 15:20:43', 'pswebsutomo.JPG', 'pswebsutomo.JPG', 0),
(15, 68, 1, '2011-07-21 15:24:29', '1024x768redarmyfc_com_Sat40837img_10_30619_6012.jpg', '1024x768redarmyfc_com_Sat40837img_10_30619_6012.jpg', 0),
(31, 104, 1, '2011-10-14 15:13:53', 'karl.jpg', 'karl.jpg', 0),
(17, 72, 1, '2011-07-21 15:54:25', 'the_lich_king.jpg', 'the_lich_king.jpg', 0),
(19, 34, 1, '2011-07-21 16:00:41', 's_Two_nintendo_dogs_1024x768.jpg', 's_Two_nintendo_dogs_1024x768.jpg', 0),
(20, 24, 1, '2011-07-22 15:43:24', 'pmlposterb.jpg', 'pmlposterb.jpg', 0),
(21, 76, 2, '2011-08-06 15:24:01', 'tales-of-graces-20091019043244426_640w.jpg', 'tales-of-graces-20091019043244426_640w.jpg', 0),
(22, 77, 1, '2011-08-11 15:26:28', 'Gyakuten-Saiban-1451.jpg', 'Gyakuten-Saiban-1451.jpg', 0),
(28, 86, 1, '2011-08-24 22:22:59', 'ja3bc06c.jpg', 'ja3bc06c.jpg', 0),
(27, 86, 1, '2011-08-24 22:22:59', '1480665_e.jpg', '1480665_e.jpg', 0),
(29, 88, 1, '2011-09-19 22:45:57', 'genius.jpg', 'genius.jpg', 0),
(30, 27, 1, '2011-09-20 22:41:33', 'paramore1.jpg', 'paramore1.jpg', 0),
(33, 117, 1, '2011-10-27 23:10:47', '15841_1161453953682_1147815950_30433153_461723_n1.jpg', '15841_1161453953682_1147815950_30433153_461723_n1.jpg', 0),
(34, 117, 1, '2011-10-27 23:10:47', '4057284892.jpg', '4057284892.jpg', 0),
(35, 117, 1, '2011-10-29 16:10:09', 'paramore11.jpg', 'paramore11.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `ref_id` int(11) NOT NULL COMMENT 'will be either review_id, blog_id, or whatever',
  `account_id` int(11) NOT NULL,
  `entry_date` datetime NOT NULL,
  `last_update` datetime NOT NULL,
  `view` int(11) NOT NULL,
  `deleted` tinyint(1) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=127 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`ID`, `type_id`, `ref_id`, `account_id`, `entry_date`, `last_update`, `view`, `deleted`, `deleted_at`, `deleted_by`) VALUES
(24, 1, 3, 1, '2011-06-06 13:21:22', '2011-09-27 23:11:53', 44, NULL, NULL, NULL),
(2, 2, 2, 2, '2011-05-25 13:29:12', '0000-00-00 00:00:00', 122, NULL, NULL, NULL),
(75, 4, 2, 1, '2011-07-30 09:13:55', '0000-00-00 00:00:00', 16, NULL, NULL, NULL),
(47, 1, 13, 1, '2011-07-02 17:39:57', '0000-00-00 00:00:00', 6, 1, '2012-03-06 23:44:10', 1),
(68, 3, 15, 1, '2011-07-21 15:24:29', '0000-00-00 00:00:00', 98, 1, '2012-03-06 21:50:23', 1),
(44, 9, 2, 1, '2011-06-26 15:36:52', '0000-00-00 00:00:00', 0, NULL, NULL, NULL),
(42, 1, 12, 1, '2011-06-18 16:06:31', '0000-00-00 00:00:00', 17, NULL, NULL, NULL),
(23, 3, 4, 1, '2011-06-05 05:16:00', '0000-00-00 00:00:00', 33, NULL, NULL, NULL),
(13, 2, 13, 1, '2011-05-28 15:58:04', '0000-00-00 00:00:00', 62, NULL, NULL, NULL),
(46, 3, 11, 1, '2011-06-30 16:59:08', '0000-00-00 00:00:00', 45, NULL, NULL, NULL),
(43, 9, 1, 1, '2011-06-26 15:14:46', '0000-00-00 00:00:00', 0, NULL, NULL, NULL),
(27, 1, 6, 2, '2011-06-06 17:55:41', '0000-00-00 00:00:00', 21, NULL, NULL, NULL),
(41, 1, 11, 1, '2011-06-18 16:01:19', '2011-08-11 15:33:13', 30, NULL, NULL, NULL),
(34, 2, 18, 1, '2011-06-15 16:24:30', '0000-00-00 00:00:00', 59, NULL, NULL, NULL),
(33, 2, 17, 1, '2011-06-15 16:18:43', '0000-00-00 00:00:00', 52, NULL, NULL, NULL),
(49, 9, 4, 2, '2011-07-07 16:13:38', '0000-00-00 00:00:00', 0, NULL, NULL, NULL),
(50, 9, 5, 1, '2011-07-09 13:42:37', '0000-00-00 00:00:00', 0, NULL, NULL, NULL),
(51, 9, 6, 1, '2011-07-09 13:46:10', '0000-00-00 00:00:00', 0, NULL, NULL, NULL),
(52, 9, 7, 1, '2011-07-09 13:46:22', '0000-00-00 00:00:00', 0, NULL, NULL, NULL),
(53, 9, 8, 1, '2011-07-09 13:46:33', '0000-00-00 00:00:00', 0, NULL, NULL, NULL),
(54, 9, 9, 1, '2011-07-09 15:30:47', '0000-00-00 00:00:00', 0, NULL, NULL, NULL),
(55, 9, 10, 1, '2011-07-09 15:31:02', '0000-00-00 00:00:00', 0, NULL, NULL, NULL),
(56, 9, 11, 1, '2011-07-09 15:32:12', '0000-00-00 00:00:00', 0, NULL, NULL, NULL),
(57, 9, 12, 1, '2011-07-11 16:11:03', '0000-00-00 00:00:00', 0, NULL, NULL, NULL),
(58, 9, 13, 1, '2011-07-11 16:27:36', '0000-00-00 00:00:00', 0, NULL, NULL, NULL),
(74, 2, 24, 1, '2011-07-29 16:35:09', '0000-00-00 00:00:00', 57, 1, '2012-03-07 23:44:12', 1),
(60, 9, 15, 1, '2011-07-11 16:39:42', '0000-00-00 00:00:00', 0, NULL, NULL, NULL),
(61, 9, 16, 1, '2011-07-11 16:40:58', '0000-00-00 00:00:00', 0, NULL, NULL, NULL),
(63, 4, 1, 1, '2011-07-19 15:31:06', '0000-00-00 00:00:00', 42, NULL, NULL, NULL),
(64, 9, 17, 1, '2011-07-20 15:15:52', '0000-00-00 00:00:00', 0, NULL, NULL, NULL),
(102, 4, 3, 1, '2011-10-11 17:04:47', '0000-00-00 00:00:00', 32, 1, '2012-03-06 21:59:18', 1),
(66, 3, 13, 1, '2011-07-21 15:20:42', '0000-00-00 00:00:00', 22, 1, '2012-03-08 22:10:29', -1),
(72, 2, 22, 1, '2011-07-21 15:54:25', '0000-00-00 00:00:00', 30, NULL, NULL, NULL),
(76, 3, 16, 2, '2011-08-06 15:24:00', '0000-00-00 00:00:00', 41, NULL, NULL, NULL),
(77, 1, 15, 1, '2011-08-11 15:26:28', '0000-00-00 00:00:00', 29, NULL, NULL, NULL),
(78, 9, 18, 10, '2011-08-16 13:41:20', '0000-00-00 00:00:00', 0, NULL, NULL, NULL),
(79, 9, 19, 1, '2011-08-16 15:28:38', '0000-00-00 00:00:00', 0, NULL, NULL, NULL),
(80, 9, 20, 1, '2011-08-16 15:28:52', '0000-00-00 00:00:00', 0, NULL, NULL, NULL),
(86, 2, 30, 1, '2011-08-24 22:22:59', '0000-00-00 00:00:00', 18, NULL, NULL, NULL),
(85, 2, 29, 1, '2011-08-24 21:58:29', '0000-00-00 00:00:00', 10, 1, '2012-03-05 23:44:03', -1),
(87, 5, 1, 1, '2011-09-06 23:19:19', '0000-00-00 00:00:00', 23, 1, '2012-03-06 22:40:51', 1),
(88, 2, 31, 1, '2011-09-06 23:24:51', '0000-00-00 00:00:00', 63, NULL, NULL, NULL),
(89, 5, 2, 2, '2011-09-06 23:26:37', '0000-00-00 00:00:00', 79, NULL, NULL, NULL),
(90, 9, 21, 1, '2011-09-07 23:16:53', '0000-00-00 00:00:00', 0, NULL, NULL, NULL),
(91, 9, 22, 1, '2011-09-07 23:18:14', '0000-00-00 00:00:00', 0, NULL, NULL, NULL),
(92, 8, 2, 10, '2011-09-12 22:56:45', '0000-00-00 00:00:00', 0, NULL, NULL, NULL),
(93, 8, 3, 10, '2011-09-12 23:17:24', '0000-00-00 00:00:00', 0, NULL, NULL, NULL),
(104, 1, 16, 1, '2011-10-13 18:08:54', '0000-00-00 00:00:00', 43, NULL, NULL, NULL),
(95, 8, 5, 10, '2011-09-13 20:07:13', '0000-00-00 00:00:00', 0, NULL, NULL, NULL),
(96, 8, 6, 10, '2011-09-13 20:10:40', '0000-00-00 00:00:00', 0, NULL, NULL, NULL),
(97, 9, 23, 10, '2011-09-13 20:15:51', '0000-00-00 00:00:00', 0, NULL, NULL, NULL),
(106, 8, 10, 20, '2011-10-19 22:23:51', '0000-00-00 00:00:00', 0, NULL, NULL, NULL),
(103, 9, 26, 1, '2011-10-12 22:04:09', '0000-00-00 00:00:00', 0, NULL, NULL, NULL),
(105, 8, 9, 20, '2011-10-19 22:23:08', '0000-00-00 00:00:00', 0, NULL, NULL, NULL),
(101, 8, 8, 1, '2011-10-11 16:04:03', '0000-00-00 00:00:00', 0, NULL, NULL, NULL),
(108, 3, 18, 1, '2011-10-21 23:11:59', '0000-00-00 00:00:00', 25, NULL, NULL, NULL),
(109, 8, 11, 1, '2011-10-22 00:13:48', '0000-00-00 00:00:00', 0, NULL, NULL, NULL),
(110, 8, 12, 1, '2011-10-22 00:19:49', '0000-00-00 00:00:00', 0, NULL, NULL, NULL),
(118, 3, 21, 1, '2011-10-29 21:08:52', '0000-00-00 00:00:00', 108, 1, '2012-03-08 22:39:29', -1),
(119, 3, 22, 1, '2011-11-01 20:14:26', '0000-00-00 00:00:00', 76, NULL, NULL, NULL),
(117, 3, 20, 1, '2011-10-27 23:10:47', '0000-00-00 00:00:00', 24, NULL, NULL, NULL),
(120, 8, 13, 21, '2011-11-04 23:36:56', '0000-00-00 00:00:00', 0, NULL, NULL, NULL),
(122, 9, 29, 1, '2011-11-24 22:05:31', '0000-00-00 00:00:00', 0, NULL, NULL, NULL),
(123, 5, 3, 1, '2011-11-28 20:30:26', '0000-00-00 00:00:00', 17, NULL, NULL, NULL),
(124, 8, 14, 21, '2012-03-02 23:52:10', '0000-00-00 00:00:00', 0, NULL, NULL, NULL),
(125, 9, 30, 1, '2012-03-04 00:37:08', '0000-00-00 00:00:00', 0, NULL, NULL, NULL),
(126, 9, 31, 1, '2012-03-07 21:58:02', '0000-00-00 00:00:00', 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(150) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`category_id`, `category_name`) VALUES
(1, 'Books'),
(2, 'DVDs'),
(3, 'Guns'),
(4, 'Knives');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(10) NOT NULL,
  `address` varchar(1000) NOT NULL,
  `location` varchar(150) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `website` varchar(200) NOT NULL,
  `member_since` datetime NOT NULL,
  `signature` varchar(1000) NOT NULL,
  `about_me` text NOT NULL,
  `occupation` varchar(150) NOT NULL,
  `hobby` varchar(200) NOT NULL,
  `interest` varchar(200) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`ID`, `account_id`, `first_name`, `middle_name`, `last_name`, `dob`, `gender`, `address`, `location`, `photo`, `website`, `member_since`, `signature`, `about_me`, `occupation`, `hobby`, `interest`) VALUES
(1, 1, 'Hendra', '', 'Susanto', '1988-08-04', '', 'jalan jalan', 'Jakarta', 'karl2.jpg', 'hendras.us', '2011-05-15 05:10:55', 'hensigned', 'Happy ME', 'web craftsman', 'gaming', 'human interaction'),
(2, 2, 'm', 'dennis', 'sa', '1984-12-29', '', 'jalan jalan', 'medan', 'needle-in-haystack.jpg', 'dyton.net', '2011-05-19 09:33:38', '', 'I belong to the darkside', 'web ronin', 'drawing', 'philoshopy'),
(10, 10, 'Eric', '', 'Liang', '0000-00-00', '', '', '', 'contact-smiley.jpg', '', '2011-08-10 12:38:00', '', '', '', '', ''),
(12, 15, 'Hendra', '', 'Susanto', '1988-06-01', '', '', '', '1321367952.jpg', '', '2011-09-23 23:39:19', '', '', '', '', ''),
(20, 21, 'Hendra', 'S', 'S', '1985-05-01', '', '', '', '1330706590.jpg', '', '2011-10-19 23:11:56', '', '', '', '', ''),
(19, 20, 'Hendra', '', 'Susanto', '2005-07-05', '', 'Test', '', 'hanson.jpg', '', '2011-10-19 22:04:30', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `alias` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `tag` varchar(200) NOT NULL,
  `image` varchar(150) NOT NULL COMMENT 'for now supports only one image per review?',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`ID`, `title`, `alias`, `content`, `tag`, `image`) VALUES
(4, 'Some Projects', 'some-projects', '<p>\r\n aaa</p>\r\n', '0', ''),
(11, 'Hunt Momon', 'hunt-momon', '<p>\r\n gasga bla</p>\r\n<p>\r\n <strong>bla</strong></p>\r\n', '0', ''),
(13, 'Test', 'test', '<p>\r\n test</p>\r\n', '0', ''),
(15, 'Red Armys', 'red-armys', '<p>\r\n new</p>\r\n', '0', ''),
(18, 'Test ""', 'test', '<p>\r\n Test &quot;&#39;&quot;</p>\r\n', '0', ''),
(16, 'D Projectss', 'd-projectss', '<p>\r\n Some awesome things are in my heads</p>\r\n', '0', ''),
(20, 'Test Project', 'test-project', '<p>\r\n Test Project</p>\r\n', '0', ''),
(21, 'Test Project 2', 'test-project-2', '<p>\r\n Test</p>\r\n', '0', ''),
(22, 'Test RSSS', 'test-rsss', '<p>\r\n Jalan ga ya?</p>\r\n', '0', '');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) NOT NULL,
  `rate` int(2) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`ID`, `post_id`, `rate`) VALUES
(1, 27, 4),
(2, 28, 1),
(3, 29, 1),
(4, 30, 1),
(5, 31, 5),
(6, 47, 0),
(7, 48, 0);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `object` varchar(150) NOT NULL,
  `rating` int(1) NOT NULL,
  `title` varchar(200) NOT NULL,
  `alias` varchar(200) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`ID`, `category_id`, `brand_id`, `object`, `rating`, `title`, `alias`, `content`) VALUES
(3, 2, 2, 'Persona 3', 4, 'Persona 3 is the best game ever', 'persona-3-is-the-best-game-ever', '<p>\r\n Persona is the best game ever!!!</p>\r\n'),
(6, 2, 3, 'monster', 0, 'paramore', 'paramore', '<p>\r\n new single for transformer dark of the moon</p>\r\n'),
(12, 1, 2, 'Born This Way', 3, 'Disappointing', 'disappointing', '<p>\r\n Disappointing</p>\r\n'),
(13, 0, 0, 'Nintendo 3DS', 0, 'Sorta Ok', 'sorta-ok', '<p>\r\n Good</p>\r\n'),
(15, 1, 2, 'Da Vinci Code Meets Phoenix Wright', 5, 'Quite Good Eh', 'quite-good-eh', '<p>\r\n This is quite good.</p>\r\n<p>\r\n Thrilling+</p>\r\n<p>\r\n Right</p>\r\n'),
(16, 2, 1, 'An Idiot Abroad', 3, 'Alright?', 'alright', '<p>\r\n Thuis is really good</p>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `site_configs`
--

CREATE TABLE `site_configs` (
  `key` varchar(500) NOT NULL,
  `value` varchar(1000) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `site_configs`
--

INSERT INTO `site_configs` (`key`, `value`) VALUES
('title', 'HuntDrop'),
('description', 'Celebrating the Original Sport'),
('keywords', 'hunters, huntdrop, hunt drop'),
('analytics', 'UA-26082930-1');

-- --------------------------------------------------------

--
-- Table structure for table `site_configs_backup`
--

CREATE TABLE `site_configs_backup` (
  `title` varchar(200) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `keywords` varchar(1000) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `site_configs_backup`
--

INSERT INTO `site_configs_backup` (`title`, `description`, `keywords`) VALUES
('HuntDrop', 'Celebrating the Original Sport', 'hunters, huntdrop, hunt drop');

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `submission_id` int(11) NOT NULL AUTO_INCREMENT,
  `contest_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`submission_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `submissions`
--

INSERT INTO `submissions` (`submission_id`, `contest_id`, `account_id`, `project_id`) VALUES
(1, 1, 1, 11),
(2, 1, 2, 16);

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`ID`, `email`) VALUES
(3, 'benhanks040888s@gmail.com'),
(2, 'benhanks040888@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) NOT NULL,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=176 ;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`ID`, `post_id`, `name`) VALUES
(45, 67, 'new'),
(56, 72, 'new'),
(59, 13, 'test'),
(60, 13, 'funny'),
(61, 13, 'cool'),
(80, 89, 'non'),
(87, 76, 'tests'),
(91, 63, 'scholes'),
(96, 23, 'game-on'),
(99, 24, 'test'),
(100, 24, 'persona-3'),
(102, 68, 'new'),
(110, 46, 'game'),
(111, 66, 'screenshot'),
(112, 66, 'test'),
(142, 118, 'test'),
(150, 117, 'test'),
(151, 117, 'aaa'),
(155, 108, 'test'),
(161, 85, 'noimage'),
(162, 33, 'test'),
(168, 47, '3ds'),
(169, 119, 'rss'),
(170, 104, 'karl'),
(171, 77, 'novel'),
(172, 102, 'soccer'),
(173, 75, 'song'),
(174, 123, 'blade'),
(175, 87, 'feedback');

-- --------------------------------------------------------

--
-- Table structure for table `threads`
--

CREATE TABLE `threads` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `forum_id` varchar(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `alias` varchar(200) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `threads`
--

INSERT INTO `threads` (`ID`, `forum_id`, `title`, `alias`, `content`) VALUES
(1, '4', 'This Site Rocks', 'this-site-rocks', '<p>\r\n Feedback here</p>\r\n'),
(2, '5', 'Non-hunt Talking', 'non-hunt-talking', '<p>\r\n Non-hunt Talk is kinda interesting too</p>\r\n'),
(3, '2', 'What To Use?', 'what-to-use', '<p>\r\n Can someone tell me what to use to cut through iron?</p>\r\n<p>\r\n Thanks</p>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(150) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`ID`, `label`) VALUES
(1, 'review'),
(2, 'blog'),
(3, 'project'),
(9, 'comment'),
(8, 'likes'),
(4, 'video'),
(5, 'forum');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `alias` varchar(200) NOT NULL,
  `youtube_id` varchar(50) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`ID`, `title`, `alias`, `youtube_id`, `content`) VALUES
(1, 'Paul Scholes Does Hand of God', 'paul-scholes-does-hand-of-god', 'UQy2xBHmFeI', '<p>\r\n Paul Scholes Does Hand of God</p>\r\n'),
(2, 'Ellie Goulding Starry Eyed', 'ellie-goulding-starry-eyed', 'fBf2v4mLM8k', '<p>\r\n New single</p>\r\n'),
(3, 'Baptista''s Super Goal', 'baptista-s-super-goal', '1gQ81yk1uOI', '<p>\r\n <strong>Batista Super Goal</strong></p>\r\n<p>\r\n <em>Batista Super Goal</em></p>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `vote_id` int(11) NOT NULL AUTO_INCREMENT,
  `voter_id` int(11) NOT NULL,
  `contest_id` int(11) NOT NULL,
  `submission_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`vote_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`vote_id`, `voter_id`, `contest_id`, `submission_id`, `project_id`) VALUES
(1, 2, 1, 1, 11),
(2, 1, 1, 2, 16);
