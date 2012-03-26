-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 31, 2011 at 09:18 AM
-- Server version: 5.1.56
-- PHP Version: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pennmult_huntdrop`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
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
  `last_active` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_online` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `user_name` (`user_name`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(32) NOT NULL,
  `user_group` varchar(32) NOT NULL,
  `pass` varchar(64) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`ID`, `user_name`, `user_group`, `pass`) VALUES
(1, 'admin', 'admin', '8cb2237d0679ca88db6464eac60da96345513964');

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
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
(1, 0, '2011-09-16', 'Article #1.1', 'article-1-1', 'Rule #1 : Don''t repeat yourself', '<p>\r\n Rule #1 : Don&#39;t repeat yourself</p>\r\n', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE IF NOT EXISTS `blogs` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `series_id` varchar(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `alias` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `tag` varchar(200) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `blog_series`
--

CREATE TABLE IF NOT EXISTS `blog_series` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `series_name` varchar(500) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE IF NOT EXISTS `brands` (
  `brand_id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(150) NOT NULL,
  PRIMARY KEY (`brand_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_name`) VALUES
(1, 'Gorilla Treestands');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `target` int(11) NOT NULL COMMENT '1=contents comments; 2 =profile comments',
  `user_id` varchar(11) NOT NULL,
  `post_type` varchar(11) DEFAULT NULL,
  `post_id` varchar(11) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `contests`
--

CREATE TABLE IF NOT EXISTS `contests` (
  `contest_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(500) NOT NULL,
  `submission_start_date` date NOT NULL,
  `submission_end_date` date NOT NULL,
  `voting_start_date` date NOT NULL,
  `voting_end_date` date NOT NULL,
  `content` text NOT NULL,
  `image` varchar(250) NOT NULL,
  PRIMARY KEY (`contest_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `contests`
--

INSERT INTO `contests` (`contest_id`, `title`, `submission_start_date`, `submission_end_date`, `voting_start_date`, `voting_end_date`, `content`, `image`) VALUES
(1, 'Catch The Fish!', '2011-08-01', '2011-08-15', '2011-08-16', '2011-08-23', '<p>Don''t miss it!</p>\r\n\r\n<p>Send us the best fish you ever caught!</p>\r\n\r\n<h2>Prizes</h2>\r\n\r\n<p>The prizes are as such :</p>\r\n\r\n<ul>\r\n<li>1st winner gets a PS3</li>\r\n<li>2nd winnder gets a BlackBerry Gemini</li>\r\n</ul>', 'contest.jpg'),
(2, 'Catch The Bird', '2011-09-11', '2011-09-18', '2011-09-11', '2011-09-18', '<p>\r\n Catch The Bird</p>\r\n', 'contest2.jpg'),
(3, 'Contest 3', '2011-09-23', '2011-10-07', '2011-10-01', '2011-10-08', '<p>\r\n <span class="Apple-style-span">The battle system used for<span class="Apple-converted-space">&nbsp;</span><i>Tales of Graces</i><span class="Apple-converted-space">&nbsp;</span>is the &quot;Style Shift Linear Motion Battle System&quot; (SS-LiMBS). In this system, characters have two different fighting styles to choose from. The A-style artes are pre-determined, however you can set the B-style artes, and the player is able to freely switch between the styles in battle. The battle system is currently rated one of the best systems in the entire Tales history.</span></p>\r\n<p>\r\n <span class="Apple-style-span">Characters are also able to sidestep in a 360 degree circle around the enemy as well as Free Run. &quot;Blast Calibers&quot;, as used in the<span class="Apple-converted-space">&nbsp;</span><i><a href="http://en.wikipedia.org/wiki/Tales_of_Destiny_(PS2)" title="Tales of Destiny (PS2)">Tales of Destiny (PS2)</a></i><span class="Apple-converted-space">&nbsp;</span>remake, make a return in<span class="Apple-converted-space">&nbsp;</span><i>Tales of Graces</i>.</span></p>\r\n<p>\r\n <span class="Apple-style-span">In battle, players attack using the Chain Capacity point system used in the<span class="Apple-converted-space">&nbsp;</span><i><a href="http://en.wikipedia.org/wiki/Tales_of_Destiny_(PS2)" title="Tales of Destiny (PS2)">Tales of Destiny (PS2)</a></i><span class="Apple-converted-space">&nbsp;</span>remake. The free run maneuver which originated in<span class="Apple-converted-space">&nbsp;</span><i><a href="http://en.wikipedia.org/wiki/Tales_of_the_Abyss" title="Tales of the Abyss">Tales of the Abyss</a></i><span class="Apple-converted-space">&nbsp;</span>is renewed in this game, but it is limited by Chain Capacity points</span></p>\r\n', 'tales-of-graces-20091019043244426_640w.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `forums`
--

CREATE TABLE IF NOT EXISTS `forums` (
  `forum_id` int(11) NOT NULL AUTO_INCREMENT,
  `forum_name` varchar(500) NOT NULL,
  `description` varchar(5000) NOT NULL,
  PRIMARY KEY (`forum_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `forums`
--

INSERT INTO `forums` (`forum_id`, `forum_name`, `description`) VALUES
(1, 'Hunting Skill Share', 'Your woodworking skills are displayed for several lifetimes in each project. Have you had to compromise your '),
(2, 'Equipments', 'Different wood requires different woodworking strategies - from cutting to finishing'),
(3, 'Animals', ''),
(4, 'Website Feedback', ''),
(5, 'Non-hunt Talks', '');

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `friender_id` int(11) NOT NULL,
  `friended_id` int(11) NOT NULL,
  `status` varchar(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE IF NOT EXISTS `likes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `liker_id` int(11) NOT NULL,
  `post_type` varchar(11) DEFAULT NULL,
  `post_id` varchar(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
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
(5, 1, 'Advertise With Us', 'advertise-with-us', '<p>\r\n Advertise With Us</p>\r\n', '2011-09-22 22:41:55'),
(6, 0, 'Help', 'help', '<p>\r\n Help</p>\r\n', '2011-09-22 22:42:14'),
(7, 6, 'General', 'general', '<p>\r\n General Help</p>\r\n', '2011-09-22 22:42:41');

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE IF NOT EXISTS `photos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `entry_date` datetime NOT NULL,
  `src` varchar(500) NOT NULL,
  `thumb` varchar(400) NOT NULL,
  `view` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `ref_id` int(11) NOT NULL COMMENT 'will be either review_id, blog_id, or whatever',
  `account_id` int(11) NOT NULL,
  `entry_date` datetime NOT NULL,
  `last_update` datetime NOT NULL,
  `view` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE IF NOT EXISTS `product_categories` (
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

CREATE TABLE IF NOT EXISTS `profiles` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `alias` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `tag` varchar(200) NOT NULL,
  `image` varchar(150) NOT NULL COMMENT 'for now supports only one image per review?',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE IF NOT EXISTS `ratings` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) NOT NULL,
  `rate` int(2) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE IF NOT EXISTS `reviews` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `object` varchar(150) NOT NULL,
  `rating` int(1) NOT NULL,
  `title` varchar(200) NOT NULL,
  `alias` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(150) NOT NULL COMMENT 'for now supports only one image per review?',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE IF NOT EXISTS `submissions` (
  `submission_id` int(11) NOT NULL AUTO_INCREMENT,
  `contest_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`submission_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) NOT NULL,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `threads`
--

CREATE TABLE IF NOT EXISTS `threads` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `forum_id` varchar(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `alias` varchar(200) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE IF NOT EXISTS `types` (
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
(9, 'comment');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE IF NOT EXISTS `videos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `alias` varchar(200) NOT NULL,
  `youtube_id` varchar(50) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE IF NOT EXISTS `votes` (
  `vote_id` int(11) NOT NULL AUTO_INCREMENT,
  `voter_id` int(11) NOT NULL,
  `contest_id` int(11) NOT NULL,
  `submission_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`vote_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
