<?php

require_once('config.php');

?>
<img src="images/installatie.gif" /><br>
<br>
<span style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">
<?php

if(isset($_POST['installeren']) && !empty($_POST['gebruikersnaam']) && !empty($_POST['wachtwoord'])) {
	$gebruikersnaam = mysql_real_escape_string(substr($_POST['gebruikersnaam'],0,30));
	$wachtwoord = mysql_real_escape_string(md5(substr($_POST['wachtwoord'],0,30)));
	

	mysql_query("CREATE TABLE `alert` (
  `alert_id` int(11) NOT NULL auto_increment,
  `member_id` int(11) NOT NULL,
  `reden` text NOT NULL,
  `gelezen` enum('Nee','Ja') NOT NULL default 'Nee',
  `datum` datetime NOT NULL,
  `door` varchar(20) NOT NULL,
  PRIMARY KEY  (`alert_id`),
  UNIQUE KEY `datum` (`datum`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
mysql_query("CREATE TABLE `askamod` (
  `askamod_id` int(30) NOT NULL auto_increment,
  `vraag` text NOT NULL,
  `member_id` int(30) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `gelezen` enum('ja','nee') NOT NULL,
  PRIMARY KEY  (`askamod_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
mysql_query("
CREATE TABLE `berichten` (
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
mysql_query("
CREATE TABLE `berichten_balk` (
  `bericht_id` int(30) NOT NULL auto_increment,
  `member_id` int(30) NOT NULL,
  `bericht` varchar(255) NOT NULL,
  PRIMARY KEY  (`bericht_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("
CREATE TABLE `berichten_balk_ip` (
  `ip` varchar(255) NOT NULL,
  `moment` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
");
mysql_query("
CREATE TABLE `berichten_opgeslagen` (
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
mysql_query("
CREATE TABLE `berichten_verzonden` (
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
mysql_query("

CREATE TABLE `bezonline` (
  `id` int(11) NOT NULL auto_increment,
  `ip` varchar(50) NOT NULL default '',
  `tijd` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("
CREATE TABLE `content` (
  `paginaid` int(11) NOT NULL auto_increment,
  `volgordeid` int(11) NOT NULL default '0',
  `titel` varchar(255) NOT NULL default '',
  `datum` datetime NOT NULL default '0000-00-00 00:00:00',
  `content` text NOT NULL,
  PRIMARY KEY  (`paginaid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("
CREATE TABLE `faq` (
  `faq_id` int(30) NOT NULL auto_increment,
  `vraag` varchar(45) NOT NULL,
  `antwoord` text NOT NULL,
  PRIMARY KEY  (`faq_id`),
  UNIQUE KEY `vraag` (`vraag`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("
CREATE TABLE `forum_berichten` (
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
mysql_query("
CREATE TABLE `forum_categorie` (
  `categorie_id` int(30) NOT NULL auto_increment,
  `titel` varchar(255) NOT NULL,
  `uitleg` varchar(255) NOT NULL,
  PRIMARY KEY  (`categorie_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("
CREATE TABLE `forum_reacties` (
  `reactie_id` int(30) NOT NULL auto_increment,
  `member_id` int(30) NOT NULL,
  `bericht` text NOT NULL,
  `bericht_id` int(30) NOT NULL,
  `categorie_id` int(30) NOT NULL,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY  (`reactie_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("
CREATE TABLE `forum_timeout` (
  `ip` varchar(15) NOT NULL,
  `moment` varchar(20) NOT NULL,
  `member_id` int(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
");
mysql_query("
CREATE TABLE `gastenboek` (
  `gastenboek_id` int(30) NOT NULL auto_increment,
  `member_id` int(30) NOT NULL,
  PRIMARY KEY  (`gastenboek_id`),
  UNIQUE KEY `member_id` (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("
CREATE TABLE `gastenboek_berichten` (
  `bericht_id` int(30) NOT NULL auto_increment,
  `gastenboek_id` int(30) NOT NULL,
  `habbonaam` varchar(255) NOT NULL,
  `datum` datetime NOT NULL,
  `bericht` text NOT NULL,
  PRIMARY KEY  (`bericht_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("
CREATE TABLE `gastenboek_ip` (
  `ip` varchar(255) NOT NULL,
  `moment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
");
mysql_query("
CREATE TABLE `gekochte_badges` (
  `gekocht_id` int(30) NOT NULL auto_increment,
  `badge_id` int(30) NOT NULL,
  `member_id` int(30) NOT NULL,
  PRIMARY KEY  (`gekocht_id`),
  UNIQUE KEY `badge_id` (`badge_id`,`member_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("
CREATE TABLE `gekochte_meubi` (
  `gekocht_id` int(30) NOT NULL auto_increment,
  `meubi_id` int(30) NOT NULL,
  `member_id` int(30) NOT NULL,
  PRIMARY KEY  (`gekocht_id`),
  UNIQUE KEY `meubi_id` (`meubi_id`,`member_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("
CREATE TABLE `gekochte_rangen` (
  `gekocht_id` int(30) NOT NULL auto_increment,
  `rang_id` int(30) NOT NULL,
  `member_id` int(30) NOT NULL,
  PRIMARY KEY  (`gekocht_id`),
  UNIQUE KEY `rang_id` (`member_id`,`rang_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("
CREATE TABLE `instellingen` (
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
mysql_query("
CREATE TABLE `ipban` (
  `ipban_id` int(30) NOT NULL auto_increment,
  `ip` varchar(15) NOT NULL,
  `reden` text NOT NULL,
  PRIMARY KEY  (`ipban_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("
CREATE TABLE `leden` (
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
  PRIMARY KEY  (`member_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `gebruikersnaam_2` (`gebruikersnaam`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("
CREATE TABLE `nieuws_berichten` (
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
mysql_query("
CREATE TABLE `nieuws_reacties` (
  `reactie_id` int(30) NOT NULL auto_increment,
  `member_id` int(30) NOT NULL,
  `bericht` text NOT NULL,
  `datum` datetime NOT NULL,
  `ip` varchar(20) NOT NULL,
  `nieuws_id` int(30) NOT NULL,
  PRIMARY KEY  (`reactie_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("
CREATE TABLE `nieuws_reacties_ip` (
  `ip` varchar(255) NOT NULL,
  `moment` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
");
mysql_query("
CREATE TABLE `poll` (
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
mysql_query("
CREATE TABLE `poll_ip` (
  `ip` varchar(255) NOT NULL,
  `poll_id` int(30) NOT NULL,
  UNIQUE KEY `ip` (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
");
mysql_query("
CREATE TABLE `profiel` (
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
mysql_query("
CREATE TABLE `shop_badges` (
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
mysql_query("
CREATE TABLE `shop_meubi` (
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
mysql_query("
CREATE TABLE `shop_rangen` (
  `rang_id` int(30) NOT NULL auto_increment,
  `titel` varchar(255) NOT NULL,
  `prijs` int(30) NOT NULL,
  `beschrijving` text NOT NULL,
  `actief` enum('uit','aan') NOT NULL,
  PRIMARY KEY  (`rang_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("
CREATE TABLE `speciale_badges` (
  `badge_id` int(30) NOT NULL auto_increment,
  `titel` varchar(25) NOT NULL,
  `plaatje` text NOT NULL,
  PRIMARY KEY  (`badge_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("
CREATE TABLE `speciale_badges_members` (
  `speciale_id` int(30) NOT NULL auto_increment,
  `member_id` int(30) NOT NULL,
  `badge_id` int(30) NOT NULL,
  PRIMARY KEY  (`speciale_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
mysql_query("
CREATE TABLE `stemmen_ip` (
  `ip` varchar(255) NOT NULL,
  `moment` varchar(255) NOT NULL,
  `member_id` int(30) NOT NULL,
  UNIQUE KEY `member_id` (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
");
mysql_query("
CREATE TABLE `vrienden` (
  `member_id` int(30) NOT NULL,
  `vriend_id` int(30) NOT NULL,
  `actief` enum('actief','dood') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
") or die(mysql_error());
	mysql_query("INSERT INTO `instellingen` (`instellingen_id`, `shop`, `berichten`, `stemmen`, `poll`, `gastenboek`, `status`, `avatar_habbo`, `habbo_gegevens`, `meubi`) VALUES 
(1, 'aan', 'aan', 'aan', 'aan', 'aan', 'aan', 'habbo', 'aan', 'aan');
") or die(mysql_error());
	mysql_query("CREATE TABLE `sessies` (
  `sessie_id` int(30) NOT NULL auto_increment,
  `ip` varchar(20) NOT NULL,
  `hash` varchar(50) NOT NULL,
  `member_id` int(30) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY  (`sessie_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;") or die(mysql_error());
	//mysql_query("") or die(mysql_error());
	//mysql_query("") or die(mysql_error());
	//mysql_query("") or die(mysql_error());
	//mysql_query("") or die(mysql_error());
	//mysql_query("") or die(mysql_error());
	//mysql_query("") or die(mysql_error());
	//mysql_query("") or die(mysql_error());
	//mysql_query("") or die(mysql_error());
	//mysql_query("") or die(mysql_error());
	//mysql_query("") or die(mysql_error());
	//mysql_query("") or die(mysql_error());
	//mysql_query("") or die(mysql_error());
	//mysql_query("") or die(mysql_error());
	
	mysql_query("INSERT INTO `leden` (`member_id`, `gebruikersnaam`, `wachtwoord`, `geboortedatum`, `email`, `level`, `regdatum`, `ip`, `punten`, `muntjes`, `rang`, `avatar`) VALUES 
(1, '".$gebruikersnaam."', '".$wachtwoord."', '18-9-1991', 'test@email.com', 6, '2007-08-29 22:28:53', '127.0.0.1', 0, 1000, 'Habbo', 'http://img516.imageshack.us/img516/5683/b0705xs43174s28094s0517st4.gif');");
	
	if(mysql_error() == "") {
		echo "Je systeem is succesvol geinstalleerd.<br />
		<h2>Verwijder nu install.php</h2><a href=\"index.php\">Ga verder</a>";
	}else{
		echo "Er zijn fouten aangetroffen.<br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
	}
}else{
	?>
	<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
		Registreer hier je admin account waarmee je zometeen wilt inloggen.<br>
		Gebruikersnaam:<br><input type="text" name="gebruikersnaam" /><br />
		Wachtwoord:<br><input type="password" name="wachtwoord" /><br />
		<br />
		<input type="submit" name="installeren" value="Installeren" /><br />
	</form>
	<?php
}
?></span>