# Host: sharky
# Database: rssmerger
# Table: 'rssitems'
# 
CREATE TABLE `rssitems` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(100) NOT NULL default '',
  `link` text NOT NULL,
  `date` varchar(50) NOT NULL default '',
  `publisher` varchar(100) NOT NULL default '',
  `description` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM; 


