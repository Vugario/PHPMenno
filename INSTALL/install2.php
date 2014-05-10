<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta name="author" content="" />
    <link rel="stylesheet" type="text/css" href="style.css" />
	<title>PHPMenno V6.3 installatie</title>
</head>

<body>
	<div id="header"></div>
	<div id="content">
		<div id="links">
			<ul>
				<li><h6><img src="images/done.gif" />Welkom bij V6</h6></li>
				<li><h6><img src="images/done.gif" />Database gegevens</h6></li>
				<li><h6><img src="images/notdone.gif" />Installeer de database</h6></li>
				<li><h6><img src="images/notdone.gif" />Maak een account</h6></li>
				<li><h6><img src="images/notdone.gif" />Klaar!</h6></li>
			<ul>
		</div>
		<div id="rechts">
			<h1>Vul je database gegevens in</h1>
			<?php
				if(!function_exists("file_put_contents")) {
				   function file_put_contents($url, $data) {
					  $filehandle = fopen($url, 'a');
					  fwrite($filehandle, $data);
					  fclose($filehandle);
				   }
				}
			?>
			<?php
				if(is_writable("../config.php") == false) {
					echo "<strong>Oeps!</strong><br />
						  config.php moet schrijfbaar zijn met de permissions 777.<br />
						  Weet je niet hoe dit moet? Lees dan de README!<br />
						 ";
					die();
			}
			?>
			<?php
				if(isset($_POST['submit']) && !empty($_POST['username']) && !empty($_POST ['host']) && !empty($_POST['database']) && mysql_connect($_POST['host'],$_POST['username'], $_POST['password'])	== true && mysql_select_db($_POST['database']) == true) { 
				file_put_contents("../config.php",'<?php

	/*
	PHPMenno V6 - Simpel, Snel en Beter
	---------------------------------------------------
	Copyright (c) 2009, Menno Wolvers \'Menno\'
	Copyright (c) 2010, Jeroen van de Weerd \'Jeroen262\'
	http://www.jeroenvdweerd.nl
	---------------------------------------------------
	This program is free software: you can redistribute 
	it and/or modify it under the terms of the 
	GNU General Public License as published by the Free 
	Software Foundation, either version 6 of the 
	License, or	(at your option) any later version.
	*/    
    $mysql_host = \''.$_POST['host'].'\'; // dit is meestal localhost
    $mysql_user = \''.$_POST['username'].'\'; // voer hier je username van mysql in
    $mysql_password = \''.$_POST['password'].'\'; // voer hier je mysql wachtwoord in
    $mysql_database = \''.$_POST['database'].'\'; // hier vul je de naam van je database in
    
    $root = \''.$_POST['url'].'\'; // Plaats hier de sitemap waar PHPMenno V6 staat. (LET OP! er moet een / aan het eind!)
    $sitenaam = \'PHPMenno V6 <i>beta</i>\'; // Plaats hier de naam van je site
    
    $verwijderen = \'uit\'; // De mogelijkheid om gebruikers te verwijderen in het admin panel
    $winkel = \'aan\'; // Mogen leden de winkel bezoeken of niet
    
    if(!mysql_connect($mysql_host, $mysql_user, $mysql_password)) {
    	die(error(\'<p>Wegens een technisch mankement is het verbinden met de database niet gelukt!</p>Probeer het later nog eens..\'));
    } elseif(!mysql_select_db($mysql_database)) {
    	die(error(\'<p>Wegens een technisch mankement is het selecteren van de juiste database niet gelukt!</p>Probeer het later nog eens..\'));
    
    } else {
    	error_reporting(E_ALL); 
    	ini_set(\'display_errors\', 1);
    }

?>');
				if(file_exists("../config.php")) {
					echo "Het config bestand is met succes aan gemaakt! <br />Je kan nu verder gaan met de installatie.<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><h4><a href='install3.php'>Volgende>></a></h4>";
				}else{
				echo '
					Het is niet gelukt om het config bestand aan te maken.<br />Probeer hem zelf aan te maken, maak in de hoofd map <i>(dus in de map waar index.php in staat)</i> een bestand aan genaamd config.php met de volgende inhoud:<br />
					<br /><br />';
?>                
					&lt;?php

                    	/*
                    	PHPMenno V6 - Simpel, Snel en Beter
                    	---------------------------------------------------
                    	Copyright (c) 2009, Menno Wolvers 'Menno'
                    	Copyright (c) 2010, Jeroen van de Weerd 'Jeroen262'
                    	http://www.jeroenvdweerd.nl
                    	---------------------------------------------------
                    	This program is free software: you can redistribute 
                    	it and/or modify it under the terms of the 
                    	GNU General Public License as published by the Free 
                    	Software Foundation, either version 6 of the 
                    	License, or	(at your option) any later version.
                    	*/    
                        $mysql_host = '".$_POST['host']."'; // dit is meestal localhost
                        $mysql_user = '".$_POST['username']."'; // voer hier je username van mysql in
                        $mysql_password = '".$_POST['password']."'; // voer hier je mysql wachtwoord in
                        $mysql_database = '".$_POST['database']."'; // hier vul je de naam van je database in
                        
                        $root = '".$_POST['url']."'; // Plaats hier de sitemap waar PHPMenno V6 staat. (LET OP! er moet een / aan het eind!)
                        $sitenaam = 'PHPMenno V6 <i>beta</i>'; // Plaats hier de naam van je site
                        
                        $verwijderen = 'uit'; // De mogelijkheid om gebruikers te verwijderen in het admin panel
                        $winkel = 'aan'; // Mogen leden de winkel bezoeken of niet
                        
                        if(!mysql_connect($mysql_host, $mysql_user, $mysql_password)) {
                        	die(error('<p>Wegens een technisch mankement is het verbinden met de database niet gelukt!</p>Probeer het later nog eens..'));
                        } elseif(!mysql_select_db($mysql_database)) {
                        	die(error('<p>Wegens een technisch mankement is het selecteren van de juiste database niet gelukt!</p>Probeer het later nog eens..'));
                        
                        } else {
                        	error_reporting(E_ALL); 
                        	ini_set('display_errors', 1);
                        }
                    
                    ?&gt;
<?php
				}
				}else{
					if(isset($_POST['submit'])) {
						if(mysql_connect($_POST['host'],$_POST['username'],$_POST['password']) == false || mysql_select_db($_POST['database']) == false) {
							echo "<strong>Oeps!</strong><br />Er kon geen verbinding met de database gemaakt worden. <br />Kijk de gegevens nog is na.<br /><br />";
						}
					}
			?>
			
			<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
				Host (meestal localhost)<br />
				<input type="text" name="host" value="localhost"/><br />
				Database naam<br />
				<input type="text" name="database" /><br />
				Gebruikersnaam<br />
				<input type="text" name="username" /><br />
				Wachtwoord<br />
				<input type="password" name="password" /><br /><br />
                Site path (bijvoorbeeld bij hobla.nl/menno/ is het path /menno/)<br />
				<input type="text" name="url" /><br /><br />
				<input type="submit" name="submit" value="Installeer de MySQL"><br>
			</form>
			<?php } ?>
		</div>
	</div>
	<div id="footer">
		<br />
		<h5>PHPMenno V6 word mogelijk gemaakt door Menno Wolvers & Jeroen van de Weerd</h5>
	</div>
</body>
</html>