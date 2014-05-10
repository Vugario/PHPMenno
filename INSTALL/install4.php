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
				<li><h6><img src="images/done.gif" />Maak een account</h6></li>
				<li><h6><img src="images/notdone.gif" />Klaar!</h6></li>
			<ul>
		</div>
		<div id="rechts">
			<h1>Registreer een admin account!</h1>
			<?php
				if(isset($_POST['installeren']) && !empty($_POST['gebruikersnaam']) && !empty($_POST['wachtwoord'])) {
					$gebruikersnaam = mysql_real_escape_string(substr($_POST['gebruikersnaam'],0,30));
					$wachtwoord = hash('sha512', $_POST['wachtwoord']);
				
					mysql_query("INSERT INTO `leden` (`member_id`, `gebruikersnaam`, `wachtwoord`, `geboortedatum`, `email`, `level`, `regdatum`, `ip`, `punten`, `muntjes`, `rang`, `avatar`,`lastonline`,`infractie`,`bank`) VALUES 
                                (1, '".$gebruikersnaam."', '".$wachtwoord."', '18-9-1991', 'demo@demo.com', 6, '2010-12-05 22:28:53', '127.0.0.1', 0, 1000, 'Admin', '',NOW(),'0','0');");

					if(mysql_error() == "") {
						echo "Er is nu een administrator account aan gemaakt. <br />Ga verder met de installatie.";
					}else{
						echo "Er is iets mis gegaan. Is er soms al iemand geregistreerd?";
					}
				}else{
			?>
			
			<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
				Vul hieronder een gebruikersnaam en wachtwoord in, <br />klik daarna op Registreer.<br /><br />
				Gebruikersnaam:<br><input type="text" name="gebruikersnaam" /><br />
				Wachtwoord:<br><input type="password" name="wachtwoord" /><br />
				<br />
				<input type="submit" name="installeren" value="Registreer" /><br />
			</form>
	
			<?php
				}
			?>
			
		</div>
	</div>
	<div id="footer">
		<h4><a href="klaar.php">Volgende>></a></h4>
		<h5>PHPMenno V6 word mogelijk gemaakt door Menno Wolvers & Jeroen van de Weerd</h5>
	</div>
</body>
</html>
