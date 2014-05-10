<?php

require_once('config.php');

?>
<img src="images/installatie.gif" /><br>
<h1>Update van V3 naar V4</h1>
<br>
<span style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">
<?php

	

mysql_query("CREATE TABLE IF NOT EXISTS `alert` (
  `alert_id` int(11) NOT NULL auto_increment,
  `member_id` int(11) NOT NULL,
  `reden` text NOT NULL,
  `gelezen` enum('Nee','Ja') NOT NULL default 'Nee',
  `datum` datetime NOT NULL,
  `door` varchar(20) NOT NULL,
  PRIMARY KEY  (`alert_id`),
  UNIQUE KEY `datum` (`datum`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
mysql_query("CREATE TABLE IF NOT EXISTS `askamod` (
  `askamod_id` int(30) NOT NULL auto_increment,
  `vraag` text NOT NULL,
  `member_id` int(30) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `gelezen` enum('ja','nee') NOT NULL,
  PRIMARY KEY  (`askamod_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
mysql_query("CREATE TABLE IF NOT EXISTS `berichten` (
  `bericht_id` int(30) NOT NULL auto_increment,
  `aan` varchar(255) NOT NULL,
  `door` varchar(255) NOT NULL,
  `titel` varchar(255) NOT NULL,
  `bericht` text NOT NULL,
  `gelezen` enum('ja','nee') NOT NULL,
  `datum` datetime NOT NULL,
  PRIMARY KEY  (`bericht_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("CREATE TABLE IF NOT EXISTS `berichten_balk` (
  `bericht_id` int(30) NOT NULL auto_increment,
  `member_id` int(30) NOT NULL,
  `bericht` varchar(255) NOT NULL,
  PRIMARY KEY  (`bericht_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("CREATE TABLE IF NOT EXISTS `berichten_balk_ip` (
  `ip` varchar(255) NOT NULL,
  `moment` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
");
mysql_query("CREATE TABLE IF NOT EXISTS `berichten_opgeslagen` (
  `opgeslagen_id` int(30) NOT NULL auto_increment,
  `bericht_id` int(30) NOT NULL,
  `aan` varchar(255) NOT NULL,
  `door` varchar(255) NOT NULL,
  `titel` varchar(255) NOT NULL,
  `bericht` text NOT NULL,
  `gelezen` enum('ja','nee') NOT NULL,
  `datum` datetime NOT NULL,
  PRIMARY KEY  (`opgeslagen_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("CREATE TABLE IF NOT EXISTS `berichten_verzonden` (
  `bericht_id` int(30) NOT NULL auto_increment,
  `aan` varchar(255) NOT NULL,
  `door` varchar(255) NOT NULL,
  `titel` varchar(255) NOT NULL,
  `bericht` text NOT NULL,
  `gelezen` enum('ja','nee') NOT NULL,
  `datum` datetime NOT NULL,
  PRIMARY KEY  (`bericht_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("CREATE TABLE IF NOT EXISTS `bezonline` (
  `id` int(11) NOT NULL auto_increment,
  `ip` varchar(50) NOT NULL default '',
  `tijd` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("CREATE TABLE IF NOT EXISTS`content` (
  `paginaid` int(11) NOT NULL auto_increment,
  `volgordeid` int(11) NOT NULL default '0',
  `titel` varchar(255) NOT NULL default '',
  `datum` datetime NOT NULL default '0000-00-00 00:00:00',
  `content` text NOT NULL,
  PRIMARY KEY  (`paginaid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("CREATE TABLE IF NOT EXISTS `faq` (
  `faq_id` int(30) NOT NULL auto_increment,
  `vraag` varchar(45) NOT NULL,
  `antwoord` text NOT NULL,
  PRIMARY KEY  (`faq_id`),
  UNIQUE KEY `vraag` (`vraag`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("CREATE TABLE IF NOT EXISTS `forum_berichten` (
  `bericht_id` int(30) NOT NULL auto_increment,
  `titel` varchar(255) NOT NULL,
  `bericht` text NOT NULL,
  `ip` varchar(15) NOT NULL,
  `datum` datetime NOT NULL,
  `member_id` int(30) NOT NULL,
  `categorie` int(10) NOT NULL,
  PRIMARY KEY  (`bericht_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("CREATE TABLE IF NOT EXISTS `forum_categorie` (
  `categorie_id` int(30) NOT NULL auto_increment,
  `titel` varchar(255) NOT NULL,
  `uitleg` varchar(255) NOT NULL,
  PRIMARY KEY  (`categorie_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("CREATE TABLE IF NOT EXISTS `forum_reacties` (
  `reactie_id` int(30) NOT NULL auto_increment,
  `member_id` int(30) NOT NULL,
  `bericht` text NOT NULL,
  `bericht_id` int(30) NOT NULL,
  `categorie_id` int(30) NOT NULL,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY  (`reactie_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("CREATE TABLE IF NOT EXISTS `forum_timeout` (
  `ip` varchar(15) NOT NULL,
  `moment` varchar(20) NOT NULL,
  `member_id` int(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
");
mysql_query("CREATE TABLE IF NOT EXISTS `gastenboek` (
  `gastenboek_id` int(30) NOT NULL auto_increment,
  `member_id` int(30) NOT NULL,
  PRIMARY KEY  (`gastenboek_id`),
  UNIQUE KEY `member_id` (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("CREATE TABLE IF NOT EXISTS `gastenboek_berichten` (
  `bericht_id` int(30) NOT NULL auto_increment,
  `gastenboek_id` int(30) NOT NULL,
  `habbonaam` varchar(255) NOT NULL,
  `datum` datetime NOT NULL,
  `bericht` text NOT NULL,
  PRIMARY KEY  (`bericht_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("CREATE TABLE IF NOT EXISTS `gastenboek_ip` (
  `ip` varchar(255) NOT NULL,
  `moment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
");
mysql_query("CREATE TABLE IF NOT EXISTS `gekochte_badges` (
  `gekocht_id` int(30) NOT NULL auto_increment,
  `badge_id` int(30) NOT NULL,
  `member_id` int(30) NOT NULL,
  PRIMARY KEY  (`gekocht_id`),
  UNIQUE KEY `badge_id` (`badge_id`,`member_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("CREATE TABLE IF NOT EXISTS `gekochte_meubi` (
  `gekocht_id` int(30) NOT NULL auto_increment,
  `meubi_id` int(30) NOT NULL,
  `member_id` int(30) NOT NULL,
  PRIMARY KEY  (`gekocht_id`),
  UNIQUE KEY `meubi_id` (`meubi_id`,`member_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("CREATE TABLE IF NOT EXISTS `gekochte_rangen` (
  `gekocht_id` int(30) NOT NULL auto_increment,
  `rang_id` int(30) NOT NULL,
  `member_id` int(30) NOT NULL,
  PRIMARY KEY  (`gekocht_id`),
  UNIQUE KEY `rang_id` (`member_id`,`rang_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("CREATE TABLE IF NOT EXISTS `instellingen` (
  `instellingen_id` int(1) NOT NULL auto_increment,
  `shop` enum('aan','uit') NOT NULL default 'aan',
  `berichten` enum('aan','uit') NOT NULL default 'aan',
  `stemmen` enum('aan','uit') NOT NULL default 'aan',
  `poll` enum('aan','uit') NOT NULL default 'aan',
  `gastenboek` enum('aan','uit') NOT NULL default 'aan',
  `status` enum('aan','uit') NOT NULL,
  `avatar_habbo` enum('avatar','habbo') NOT NULL,
  `habbo_gegevens` enum('aan','uit') NOT NULL,
  `meubi` enum('aan','uit') NOT NULL,
  PRIMARY KEY  (`instellingen_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("CREATE TABLE IF NOT EXISTS `ipban` (
  `ipban_id` int(30) NOT NULL auto_increment,
  `ip` varchar(15) NOT NULL,
  `reden` text NOT NULL,
  PRIMARY KEY  (`ipban_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("CREATE TABLE IF NOT EXISTS `leden` (
  `member_id` int(30) NOT NULL auto_increment,
  `gebruikersnaam` varchar(255) NOT NULL,
  `wachtwoord` varchar(255) NOT NULL,
  `geboortedatum` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `level` int(1) NOT NULL default '0',
  `regdatum` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  `punten` int(30) NOT NULL default '0',
  `muntjes` int(30) NOT NULL default '0',
  `rang` varchar(255) NOT NULL default 'habbo',
  `avatar` text,
  `bank` int(30) NOT NULL,
  `infractie` int(1) default '0',
  `lastonline` datetime NOT NULL,
  PRIMARY KEY  (`member_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `gebruikersnaam_2` (`gebruikersnaam`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("ALTER TABLE `leden` ADD `bank` VARCHAR( 255 ) NULL DEFAULT '0' AFTER `lastonline` ;");
mysql_query("ALTER TABLE `leden` ADD `lastonline` DATETIME NOT NULL AFTER `avatar` ;");
mysql_query("CREATE TABLE IF NOT EXISTS `nieuws_berichten` (
  `nieuws_id` int(30) NOT NULL auto_increment,
  `titel` varchar(25) NOT NULL,
  `bericht` text NOT NULL,
  `actief` enum('aan','uit') NOT NULL,
  `datum` datetime NOT NULL,
  `member_id` int(30) NOT NULL,
  PRIMARY KEY  (`nieuws_id`),
  UNIQUE KEY `titel` (`titel`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("CREATE TABLE IF NOT EXISTS `nieuws_reacties` (
  `reactie_id` int(30) NOT NULL auto_increment,
  `member_id` int(30) NOT NULL,
  `bericht` text NOT NULL,
  `datum` datetime NOT NULL,
  `ip` varchar(20) NOT NULL,
  `nieuws_id` int(30) NOT NULL,
  PRIMARY KEY  (`reactie_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("CREATE TABLE IF NOT EXISTS `nieuws_reacties_ip` (
  `ip` varchar(255) NOT NULL,
  `moment` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
");
mysql_query("CREATE TABLE IF NOT EXISTS `poll` (
  `poll_id` int(30) NOT NULL auto_increment,
  `member_id` int(30) NOT NULL,
  `vraag` varchar(255) NOT NULL,
  `ant1` varchar(255) NOT NULL,
  `ant2` varchar(255) NOT NULL,
  `ant3` varchar(255) NOT NULL,
  `ant4` varchar(255) NOT NULL,
  `aantal1` int(30) NOT NULL default '0',
  `aantal2` int(30) NOT NULL default '0',
  `aantal3` int(30) NOT NULL default '0',
  `aantal4` int(30) NOT NULL default '0',
  PRIMARY KEY  (`poll_id`),
  UNIQUE KEY `member_id` (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("CREATE TABLE IF NOT EXISTS `poll_ip` (
  `ip` varchar(255) NOT NULL,
  `poll_id` int(30) NOT NULL,
  UNIQUE KEY `ip` (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
");
mysql_query("CREATE TABLE IF NOT EXISTS `profiel` (
  `profiel_id` int(30) NOT NULL auto_increment,
  `member_id` int(30) NOT NULL,
  `naam` varchar(255) default NULL,
  `achternaam` varchar(255) default NULL,
  `woonplaats` varchar(255) default NULL,
  `hobby` varchar(255) default NULL,
  `website` varchar(255) default NULL,
  `favo_fansite` varchar(255) default NULL,
  `favo_kamer` varchar(255) default NULL,
  `grootprofiel` longtext,
  `land` varchar(255) NOT NULL,
  PRIMARY KEY  (`profiel_id`),
  UNIQUE KEY `member_id` (`member_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("CREATE TABLE IF NOT EXISTS `shop_badges` (
  `badge_id` int(30) NOT NULL auto_increment,
  `titel` varchar(255) NOT NULL,
  `beschrijving` varchar(255) NOT NULL,
  `langebeschrijving` text NOT NULL,
  `plaatje` text NOT NULL,
  `prijs` int(30) NOT NULL,
  `actief` enum('uit','aan') NOT NULL,
  PRIMARY KEY  (`badge_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("CREATE TABLE IF NOT EXISTS `shop_meubi` (
  `meubi_id` int(30) NOT NULL auto_increment,
  `titel` varchar(255) NOT NULL,
  `beschrijving` varchar(255) NOT NULL,
  `langebeschrijving` text NOT NULL,
  `plaatje` text NOT NULL,
  `prijs` int(30) NOT NULL,
  `actief` enum('uit','aan') NOT NULL,
  PRIMARY KEY  (`meubi_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("CREATE TABLE IF NOT EXISTS `shop_rangen` (
  `rang_id` int(30) NOT NULL auto_increment,
  `titel` varchar(255) NOT NULL,
  `prijs` int(30) NOT NULL,
  `beschrijving` text NOT NULL,
  `actief` enum('uit','aan') NOT NULL,
  PRIMARY KEY  (`rang_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("CREATE TABLE IF NOT EXISTS `speciale_badges` (
  `badge_id` int(30) NOT NULL auto_increment,
  `titel` varchar(25) NOT NULL,
  `plaatje` text NOT NULL,
  PRIMARY KEY  (`badge_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("CREATE TABLE IF NOT EXISTS `speciale_badges_members` (
  `speciale_id` int(30) NOT NULL auto_increment,
  `member_id` int(30) NOT NULL,
  `badge_id` int(30) NOT NULL,
  PRIMARY KEY  (`speciale_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("CREATE TABLE IF NOT EXISTS `stemmen_ip` (
  `ip` varchar(255) NOT NULL,
  `moment` varchar(255) NOT NULL,
  `member_id` int(30) NOT NULL,
  UNIQUE KEY `ip` (`ip`,`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
");
mysql_query("CREATE TABLE IF NOT EXISTS `vrienden` (
  `member_id` int(30) NOT NULL,
  `vriend_id` int(30) NOT NULL,
  `actief` enum('actief','dood') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
") or die(mysql_error());
	mysql_query("CREATE TABLE IF NOT EXISTS `sessies` (
  `sessie_id` int(30) NOT NULL auto_increment,
  `ip` varchar(20) NOT NULL,
  `hash` varchar(50) NOT NULL,
  `member_id` int(30) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY  (`sessie_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;") or die(mysql_error());
	mysql_query("CREATE TABLE IF NOT EXISTS `poll_ant` (
  `id` int(30) NOT NULL auto_increment,
  `antwoord` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;") or die(mysql_error());
	mysql_query("CREATE TABLE IF NOT EXISTS `poll_ip` (
  `ip` varchar(255) NOT NULL,
  `poll_id` int(30) NOT NULL,
  UNIQUE KEY `ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;") or die(mysql_error());
	mysql_query("CREATE TABLE IF NOT EXISTS `overschrijvingen` (
  `overschrijf_id` int(30) NOT NULL auto_increment,
  `muntjes` int(30) NOT NULL,
  `naar_id` int(30) NOT NULL,
  `van_id` int(30) NOT NULL,
  `datum` datetime NOT NULL,
  `bericht` varchar(255) NOT NULL,
  PRIMARY KEY  (`overschrijf_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;") or die(mysql_error());
	mysql_query("CREATE TABLE IF NOT EXISTS `tijd_bannen` (
`tijd_id` INT( 30 ) NOT NULL AUTO_INCREMENT ,
`member_id` INT( 30 ) NOT NULL ,
`tijd` VARCHAR( 255 ) NOT NULL ,
`reden` VARCHAR( 255 ) NOT NULL ,
PRIMARY KEY ( `tijd_id` )
) ENGINE = MYISAM ") or die(mysql_error());
	mysql_query("CREATE TABLE IF NOT EXISTS `blogs_berichten` (
  `blogs_id` int(30) NOT NULL auto_increment,
  `titel` varchar(75) NOT NULL,
  `bericht` text NOT NULL,
  `actief` enum('aan','uit') NOT NULL,
  `datum` datetime NOT NULL,
  `member_id` int(30) NOT NULL,
  PRIMARY KEY  (`blogs_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;") or die(mysql_error());
	mysql_query("CREATE TABLE IF NOT EXISTS `blogs_reacties` (
  `reactie_id` int(30) NOT NULL auto_increment,
  `member_id` int(30) NOT NULL,
  `bericht` text NOT NULL,
  `datum` datetime NOT NULL,
  `ip` varchar(20) NOT NULL,
  `blogs_id` int(30) NOT NULL,
  PRIMARY KEY  (`reactie_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;") or die(mysql_error());
	mysql_query("CREATE TABLE IF NOT EXISTS `blogs_reacties_ip` (
  `ip` varchar(255) NOT NULL,
  `moment` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;") or die(mysql_error());
	mysql_query("CREATE TABLE IF NOT EXISTS `muntjesperdag` (
  `id` int(30) NOT NULL auto_increment,
  `member_id` int(30) NOT NULL,
  `dag` date NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `member_id` (`member_id`,`dag`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;") or die(mysql_error());
	mysql_query("CREATE TABLE IF NOT EXISTS `clublid` (
  `clublid_id` int(30) NOT NULL auto_increment,
  `member_id` int(30) NOT NULL,
  `datum` date NOT NULL,
  PRIMARY KEY  (`clublid_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;") or die(mysql_error());

	mysql_query("CREATE TABLE IF NOT EXISTS `rente` (
  `id` int(30) NOT NULL auto_increment,
  `member_id` int(30) NOT NULL,
  `dag` date NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `member_id` (`member_id`,`dag`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;") or die(mysql_error());
	mysql_query("CREATE TABLE IF NOT EXISTS `waarschuwingen` (
  `id` int(11) NOT NULL auto_increment,
  `member_id` int(11) NOT NULL,
  `reden` text NOT NULL,
  `datum` datetime NOT NULL,
  `door` varchar(20) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `datum` (`datum`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;") or die(mysql_error());
	mysql_query("CREATE TABLE IF NOT EXISTS `infracties` (
  `id` int(11) NOT NULL auto_increment,
  `member_id` int(11) NOT NULL,
  `reden` text NOT NULL,
  `datum` datetime NOT NULL,
  `door` varchar(20) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `datum` (`datum`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;") or die(mysql_error());
	mysql_query("CREATE TABLE IF NOT EXISTS `banners` (
  `banner_id` int(35) NOT NULL auto_increment,
  `banner` varchar(555) NOT NULL,
  `url` varchar(555) NOT NULL,
  `actief` varchar(3) NOT NULL default 'uit',
  UNIQUE KEY `banner_id` (`banner_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;") or die(mysql_error());
	//mysql_query("") or die(mysql_error());
	//mysql_query("") or die(mysql_error());
	//mysql_query("") or die(mysql_error());
	//mysql_query("") or die(mysql_error());
	//mysql_query("") or die(mysql_error());
	//mysql_query("") or die(mysql_error());
	
	if(mysql_error() == "") {
		echo "Je systeem is succesvol geinstalleerd.<br />
		<h2>Verwijder nu update.php en install.php</h2><a href=\"index.php\">Ga verder</a>";
	}else{
		echo "Er zijn fouten aangetroffen.<br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
	}
?>
</span>