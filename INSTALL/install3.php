<?php include '../config.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta name="author" content="" />
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link rel='shortcut icon' href='img/favicon.ico' type='image/x-icon' />
	<title>PHPMenno V6 installatie</title>
</head>

<body>
	<div id="header"></div>
	<div id="content">
		<div id="links">
			<ul>
				<li><h6><img src="images/done.gif" />Welkom bij V6</h6></li>
				<li><h6><img src="images/done.gif" />Database gegevens</h6></li>
				<li><h6><img src="images/done.gif" />Installeer de database</h6></li>
				<li><h6><img src="images/notdone.gif" />Maak een account</h6></li>
				<li><h6><img src="images/notdone.gif" />Klaar!</h6></li>
			<ul>
		</div>
		<div id="rechts">
			<h1>Installeer de database</h1>
			<?php
				if(isset($_POST['installeren'])) {					

					mysql_query("
                        CREATE TABLE IF NOT EXISTS `berichten` (
                          `bericht_id` int(30) NOT NULL AUTO_INCREMENT,
                          `aan` varchar(255) NOT NULL,
                          `door` varchar(255) NOT NULL,
                          `titel` varchar(255) NOT NULL,
                          `bericht` text NOT NULL,
                          `gelezen` enum('ja','nee') NOT NULL,
                          `datum` datetime NOT NULL,
                          PRIMARY KEY (`bericht_id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
                    ") or die(mysql_error());
                      
                    mysql_query("  
                        CREATE TABLE IF NOT EXISTS `berichten_balk` (
                          `bericht_id` int(30) NOT NULL AUTO_INCREMENT,
                          `member_id` int(30) NOT NULL,
                          `bericht` varchar(50) NOT NULL,
                          PRIMARY KEY (`bericht_id`)
                        ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;
                    ") or die(mysql_error());
                     
                    mysql_query("   
                        CREATE TABLE IF NOT EXISTS `berichten_balk_ip` (
                          `ip` varchar(255) NOT NULL,
                          `moment` varchar(255) NOT NULL
                        ) ENGINE=MyISAM DEFAULT CHARSET=latin1;
                    ") or die(mysql_error());
                    
                    mysql_query("     
                        CREATE TABLE IF NOT EXISTS `berichten_opgeslagen` (
                          `opgeslagen_id` int(30) NOT NULL AUTO_INCREMENT,
                          `bericht_id` int(30) NOT NULL,
                          `aan` varchar(255) NOT NULL,
                          `door` varchar(255) NOT NULL,
                          `titel` varchar(255) NOT NULL,
                          `bericht` text NOT NULL,
                          `gelezen` enum('ja','nee') NOT NULL,
                          `datum` datetime NOT NULL,
                          PRIMARY KEY (`opgeslagen_id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
                    ") or die(mysql_error());
                    
                    mysql_query("     
                        CREATE TABLE IF NOT EXISTS `berichten_verzonden` (
                          `bericht_id` int(30) NOT NULL AUTO_INCREMENT,
                          `aan` varchar(255) NOT NULL,
                          `door` varchar(255) NOT NULL,
                          `titel` varchar(255) NOT NULL,
                          `bericht` text NOT NULL,
                          `gelezen` enum('ja','nee') NOT NULL,
                          `datum` datetime NOT NULL,
                          PRIMARY KEY (`bericht_id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
                    ") or die(mysql_error());
                    
                    mysql_query("     
                        CREATE TABLE IF NOT EXISTS `bezonline` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `ip` varchar(50) NOT NULL DEFAULT '',
                          `tijd` varchar(50) NOT NULL DEFAULT '',
                          PRIMARY KEY (`id`)
                        ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;
                    ") or die(mysql_error());
                    
                    mysql_query("     
                        CREATE TABLE IF NOT EXISTS `blogs_berichten` (
                          `blogs_id` int(30) NOT NULL AUTO_INCREMENT,
                          `titel` varchar(255) NOT NULL,
                          `url` varchar(255) NOT NULL,
                          `bericht` varchar(5000) NOT NULL,
                          `actief` enum('aan','uit') NOT NULL,
                          `datum` datetime NOT NULL,
                          `member_id` int(30) NOT NULL,
                          PRIMARY KEY (`blogs_id`)
                        ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;
                    ") or die(mysql_error());
                        
                    mysql_query(" 
                        CREATE TABLE IF NOT EXISTS `blogs_reacties` (
                          `reactie_id` int(30) NOT NULL AUTO_INCREMENT,
                          `member_id` int(30) NOT NULL,
                          `bericht` text NOT NULL,
                          `datum` datetime NOT NULL,
                          `ip` varchar(20) NOT NULL,
                          `blogs_id` int(30) NOT NULL,
                          PRIMARY KEY (`reactie_id`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
                    ") or die(mysql_error());
                    
                     mysql_query("     
                        CREATE TABLE IF NOT EXISTS `blogs_reacties_ip` (
                          `ip` varchar(255) NOT NULL,
                          `moment` varchar(255) NOT NULL
                        ) ENGINE=MyISAM DEFAULT CHARSET=latin1;
                     ") or die(mysql_error());
                     
                      mysql_query("    
                        CREATE TABLE IF NOT EXISTS `clublid` (
                          `clublid_id` int(30) NOT NULL AUTO_INCREMENT,
                          `member_id` int(30) NOT NULL,
                          `datum` date NOT NULL,
                          PRIMARY KEY (`clublid_id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
                      ") or die(mysql_error());
                      
                       mysql_query("   
                        CREATE TABLE IF NOT EXISTS `content` (
                          `paginaid` int(11) NOT NULL AUTO_INCREMENT,
                          `volgordeid` int(11) NOT NULL DEFAULT '0',
                          `titel` varchar(255) NOT NULL DEFAULT '',
                          `datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
                          `content` text NOT NULL,
                          PRIMARY KEY (`paginaid`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
                    ") or die(mysql_error());
                    
                     mysql_query("     
                        CREATE TABLE IF NOT EXISTS `faq` (
                          `faq_id` int(30) NOT NULL AUTO_INCREMENT,
                          `vraag` varchar(45) NOT NULL,
                          `antwoord` text NOT NULL,
                          PRIMARY KEY (`faq_id`),
                          UNIQUE KEY `vraag` (`vraag`)
                        ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;
                    ") or die(mysql_error());
                    
                     mysql_query("     
                        CREATE TABLE IF NOT EXISTS `gastenboek` (
                          `gastenboek_id` int(30) NOT NULL AUTO_INCREMENT,
                          `member_id` int(30) NOT NULL,
                          PRIMARY KEY (`gastenboek_id`),
                          UNIQUE KEY `member_id` (`member_id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
                        ") or die(mysql_error());
                        
                       mysql_query("   
                        CREATE TABLE IF NOT EXISTS `gastenboek_berichten` (
                          `bericht_id` int(30) NOT NULL AUTO_INCREMENT,
                          `gastenboek_id` int(30) NOT NULL,
                          `habbonaam` varchar(255) NOT NULL,
                          `datum` datetime NOT NULL,
                          `bericht` text NOT NULL,
                          PRIMARY KEY (`bericht_id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
                      ") or die(mysql_error());
                      
                       mysql_query("   
                        CREATE TABLE IF NOT EXISTS `gastenboek_ip` (
                          `ip` varchar(255) NOT NULL,
                          `moment` varchar(255) NOT NULL
                        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
                      ") or die(mysql_error());
                      
                       mysql_query("   
                        CREATE TABLE IF NOT EXISTS `gekochte_badges` (
                          `gekocht_id` int(30) NOT NULL AUTO_INCREMENT,
                          `badge_id` int(30) NOT NULL,
                          `member_id` int(30) NOT NULL,
                          PRIMARY KEY (`gekocht_id`),
                          UNIQUE KEY `badge_id` (`badge_id`,`member_id`)
                        ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;
                    ") or die(mysql_error());
                    
                     mysql_query("     
                        CREATE TABLE IF NOT EXISTS `gekochte_meubi` (
                          `gekocht_id` int(30) NOT NULL AUTO_INCREMENT,
                          `meubi_id` int(30) NOT NULL,
                          `member_id` int(30) NOT NULL,
                          PRIMARY KEY (`gekocht_id`),
                          UNIQUE KEY `meubi_id` (`meubi_id`,`member_id`)
                        ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;
                    ") or die(mysql_error());
                    
                     mysql_query("     
                        CREATE TABLE IF NOT EXISTS `gekochte_rangen` (
                          `gekocht_id` int(30) NOT NULL AUTO_INCREMENT,
                          `rang_id` int(30) NOT NULL,
                          `member_id` int(30) NOT NULL,
                          PRIMARY KEY (`gekocht_id`),
                          UNIQUE KEY `rang_id` (`member_id`,`rang_id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
                    ") or die(mysql_error());
                    
                     mysql_query("     
                        CREATE TABLE IF NOT EXISTS `infracties` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `member_id` int(11) NOT NULL,
                          `reden` text NOT NULL,
                          `datum` datetime NOT NULL,
                          `door` varchar(20) NOT NULL,
                          PRIMARY KEY (`id`),
                          UNIQUE KEY `datum` (`datum`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
                     ") or die(mysql_error());
                     
                      mysql_query("    
                        CREATE TABLE IF NOT EXISTS `instellingen` (
                          `instellingen_id` int(1) NOT NULL AUTO_INCREMENT,
                          `shop` enum('aan','uit') NOT NULL DEFAULT 'aan',
                          `berichten` enum('aan','uit') NOT NULL DEFAULT 'aan',
                          `stemmen` enum('aan','uit') NOT NULL DEFAULT 'aan',
                          `poll` enum('aan','uit') NOT NULL DEFAULT 'aan',
                          `gastenboek` enum('aan','uit') NOT NULL DEFAULT 'aan',
                          `status` enum('aan','uit') NOT NULL,
                          `avatar_habbo` enum('avatar','habbo') NOT NULL,
                          `habbo_gegevens` enum('aan','uit') NOT NULL,
                          `meubi` enum('aan','uit') NOT NULL,
                          PRIMARY KEY (`instellingen_id`)
                        ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;
                    ") or die(mysql_error());
                    
                    mysql_query("    
                        INSERT INTO `instellingen` (`instellingen_id`, `shop`, `berichten`, `stemmen`, `poll`, `gastenboek`, `status`, `avatar_habbo`, `habbo_gegevens`, `meubi`) VALUES
                        (1, 'aan', 'aan', 'aan', 'aan', 'aan', 'aan', 'habbo', 'aan', 'aan');
                    ") or die(mysql_error());
                    
                     mysql_query("     
                        CREATE TABLE IF NOT EXISTS `ipban` (
                          `ipban_id` int(30) NOT NULL AUTO_INCREMENT,
                          `ip` varchar(15) NOT NULL,
                          `reden` text NOT NULL,
                          PRIMARY KEY (`ipban_id`)
                        ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;
                    ") or die(mysql_error());
                    
                     mysql_query("     
                        CREATE TABLE IF NOT EXISTS `leden` (
                          `member_id` int(30) NOT NULL AUTO_INCREMENT,
                          `gebruikersnaam` varchar(255) NOT NULL,
                          `wachtwoord` varchar(255) NOT NULL,
                          `geboortedatum` varchar(255) NOT NULL,
                          `email` varchar(255) NOT NULL,
                          `level` int(1) NOT NULL DEFAULT '0',
                          `regdatum` datetime NOT NULL,
                          `ip` varchar(15) NOT NULL,
                          `punten` int(30) NOT NULL DEFAULT '0',
                          `muntjes` int(30) NOT NULL DEFAULT '0',
                          `rang` varchar(255) NOT NULL DEFAULT 'habbo',
                          `avatar` text,
                          `bank` int(30) NOT NULL,
                          `infractie` int(1) DEFAULT '0',
                          `lastonline` datetime NOT NULL,
                          `bezoekers` int(11) NOT NULL DEFAULT '0',
                          PRIMARY KEY (`member_id`),
                          UNIQUE KEY `email` (`email`),
                          UNIQUE KEY `gebruikersnaam_2` (`gebruikersnaam`)
                        ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1445 ;
                       ") or die(mysql_error());
                        
                        mysql_query("    
                        CREATE TABLE IF NOT EXISTS `muntjesperdag` (
                          `id` int(30) NOT NULL AUTO_INCREMENT,
                          `member_id` int(30) NOT NULL,
                          `dag` date NOT NULL,
                          PRIMARY KEY (`id`),
                          UNIQUE KEY `member_id` (`member_id`,`dag`)
                        ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;
                       ") or die(mysql_error());
                       
                       mysql_query("     
                        CREATE TABLE IF NOT EXISTS `nieuws_berichten` (
                          `nieuws_id` int(30) NOT NULL AUTO_INCREMENT,
                          `titel` varchar(60) NOT NULL,
                          `url` varchar(255) NOT NULL,
                          `kortbericht` text NOT NULL,
                          `bericht` text NOT NULL,
                          `actief` enum('aan','uit') NOT NULL,
                          `datum` datetime NOT NULL,
                          `member_id` int(30) NOT NULL,
                          PRIMARY KEY (`nieuws_id`),
                          UNIQUE KEY `titel` (`titel`)
                        ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;
                      ") or die(mysql_error());
                      
                      mysql_query("      
                        CREATE TABLE IF NOT EXISTS `nieuws_reacties` (
                          `reactie_id` int(30) NOT NULL AUTO_INCREMENT,
                          `member_id` int(30) NOT NULL,
                          `bericht` text NOT NULL,
                          `datum` datetime NOT NULL,
                          `ip` varchar(20) NOT NULL,
                          `nieuws_id` int(30) NOT NULL,
                          PRIMARY KEY (`reactie_id`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
                      ") or die(mysql_error());
                      
                      mysql_query("      
                        CREATE TABLE IF NOT EXISTS `nieuws_reacties_ip` (
                          `ip` varchar(255) NOT NULL,
                          `moment` varchar(255) NOT NULL
                        ) ENGINE=MyISAM DEFAULT CHARSET=latin1;
                      ") or die(mysql_error());
                      
                      mysql_query("      
                        CREATE TABLE IF NOT EXISTS `overschrijvingen` (
                          `overschrijf_id` int(30) NOT NULL AUTO_INCREMENT,
                          `muntjes` int(30) NOT NULL,
                          `naar_id` varchar(255) NOT NULL,
                          `van_id` varchar(255) NOT NULL,
                          `datum` datetime NOT NULL,
                          `bericht` varchar(255) NOT NULL,
                          PRIMARY KEY (`overschrijf_id`)
                        ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;
                     ") or die(mysql_error());
                     
                     mysql_query("       
                        CREATE TABLE IF NOT EXISTS `profiel` (
                          `profiel_id` int(30) NOT NULL AUTO_INCREMENT,
                          `member_id` int(30) NOT NULL,
                          `gebruikersnaam` varchar(255) NOT NULL,
                          `naam` varchar(255) DEFAULT NULL,
                          `achternaam` varchar(255) DEFAULT NULL,
                          `woonplaats` varchar(255) DEFAULT NULL,
                          `hobby` varchar(255) DEFAULT NULL,
                          `website` varchar(255) DEFAULT NULL,
                          `favo_fansite` varchar(255) DEFAULT NULL,
                          `favo_kamer` varchar(255) DEFAULT NULL,
                          `grootprofiel` longtext,
                          `land` varchar(255) NOT NULL,
                          PRIMARY KEY (`profiel_id`),
                          UNIQUE KEY `member_id` (`member_id`)
                        ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;
                     ") or die(mysql_error());
                     
                     mysql_query("       
                        CREATE TABLE IF NOT EXISTS `rente` (
                          `id` int(30) NOT NULL AUTO_INCREMENT,
                          `member_id` int(30) NOT NULL,
                          `dag` date NOT NULL,
                          PRIMARY KEY (`id`),
                          UNIQUE KEY `member_id` (`member_id`,`dag`)
                        ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;
                    ") or die(mysql_error());
                    
                    mysql_query("        
                        CREATE TABLE IF NOT EXISTS `sessies` (
                          `sessie_id` int(30) NOT NULL AUTO_INCREMENT,
                          `ip` varchar(20) NOT NULL,
                          `hash` varchar(50) NOT NULL,
                          `member_id` int(30) NOT NULL,
                          `date` datetime NOT NULL,
                          PRIMARY KEY (`sessie_id`)
                        ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=116 ;
                    ") or die(mysql_error());
                     
                     mysql_query("       
                        CREATE TABLE IF NOT EXISTS `shop_badges` (
                          `badge_id` int(30) NOT NULL AUTO_INCREMENT,
                          `titel` varchar(255) NOT NULL,
                          `beschrijving` varchar(255) NOT NULL,
                          `langebeschrijving` text NOT NULL,
                          `plaatje` text NOT NULL,
                          `prijs` int(30) NOT NULL,
                          `actief` enum('uit','aan') NOT NULL,
                          PRIMARY KEY (`badge_id`)
                        ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;
                           ") or die(mysql_error());
                   
                   mysql_query("         
                        CREATE TABLE IF NOT EXISTS `shop_meubi` (
                          `meubi_id` int(30) NOT NULL AUTO_INCREMENT,
                          `titel` varchar(255) NOT NULL,
                          `beschrijving` varchar(255) NOT NULL,
                          `langebeschrijving` text NOT NULL,
                          `plaatje` text NOT NULL,
                          `prijs` int(30) NOT NULL,
                          `actief` enum('uit','aan') NOT NULL,
                          PRIMARY KEY (`meubi_id`)
                        ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;
                         ") or die(mysql_error());
                   
                   mysql_query("         
                        CREATE TABLE IF NOT EXISTS `shop_rangen` (
                          `rang_id` int(30) NOT NULL AUTO_INCREMENT,
                          `titel` varchar(255) NOT NULL,
                          `prijs` int(30) NOT NULL,
                          `beschrijving` text NOT NULL,
                          `actief` enum('uit','aan') NOT NULL,
                          PRIMARY KEY (`rang_id`)
                        ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;
                        ") or die(mysql_error());
                    
                    mysql_query("        
                        CREATE TABLE IF NOT EXISTS `speciale_badges` (
                          `badge_id` int(30) NOT NULL AUTO_INCREMENT,
                          `titel` varchar(25) NOT NULL,
                          `plaatje` text NOT NULL,
                          PRIMARY KEY (`badge_id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
                    ") or die(mysql_error());
                    
                    mysql_query("        
                        CREATE TABLE IF NOT EXISTS `speciale_badges_members` (
                          `speciale_id` int(30) NOT NULL AUTO_INCREMENT,
                          `member_id` int(30) NOT NULL,
                          `badge_id` int(30) NOT NULL,
                          PRIMARY KEY (`speciale_id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;                    
                    ") or die(mysql_error());

					
					if(mysql_error() == "") {
						echo "De database is geinstalleerd, ga nu verder met de installatie.<br />";
					}else{
						echo "Er is wat fout gegaan.";
					}
				}else{
					?>
					Klik op Installeer de database om de database te installeren. <br />Ga daarna verder met de installatie.<br /><br />
					<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
						<input type="submit" name="installeren" value="Installeer de database" /><br />
					</form>
				<?php
					}
				?>
		</div>
	</div>
	<div id="footer">
		<h4><a href="install4.php">Volgende>></a></h4>
		<h5>PHPMenno V6 word mogelijk gemaakt door Menno Wolvers & Jeroen van de Weerd</h5>
	</div>
</body>
</html>
