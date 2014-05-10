<?php

	/*
	PHPMenno V6 - Simpel, Snel en Beter
	---------------------------------------------------
	Copyright (c) 2009, Menno Wolvers 'Menno'
	Copyright (c) 2010, Jeroen van de Weerd 'Jeroen262'
	http://www.JeroenvdWeerd.nl
	---------------------------------------------------
	This program is free software: you can redistribute 
	it and/or modify it under the terms of the 
	GNU General Public License as published by the Free 
	Software Foundation, either version 6 of the 
	License, or	(at your option) any later version.
	*/
	function registeren($gebruikersnaam,$wachtwoord,$dag,$maand,$jaar,$email) {
		$gebruikersnaam = mysql_real_escape_string(substr($gebruikersnaam,0,25)); // Eerst halen we alle rare tekens eruit EN hakken we bij de 255 letters/cijfers de rest eraf, Maximale lengte is 255
		$wachtwoord = hash('sha512', $_POST['wachtwoord']);
		$geboortedatum = mysql_real_escape_string(substr($dag."-".$maand."-".$jaar,0,255));
		$email = mysql_real_escape_string(substr($email,0,60));

		$sql = mysql_query("INSERT INTO leden (gebruikersnaam,wachtwoord,geboortedatum,email,level,regdatum,ip,punten,muntjes,avatar,rang) VALUES ('".$gebruikersnaam."','".mysql_real_escape_string($wachtwoord)."','".$geboortedatum."','".$email."','0',NOW(),'".$_SERVER['REMOTE_ADDR']."','0','".MUNTJESBIJREGISTRATIE."','','habbo')");
		
		$sql_member_id = mysql_query("SELECT member_id FROM leden WHERE gebruikersnaam='".$gebruikersnaam."' AND email='".$email."' AND geboortedatum='".$geboortedatum."' LIMIT 1");
		$row_member_id = mysql_fetch_assoc($sql_member_id);
		
		if(eregi("Duplicate",mysql_error())) {
			$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">De gebruikersnaam bestaad al.</div>';
			header('Location: registreren');
		}elseif(mysql_error() != "") {
			$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Sorry, er ging wat mis.</div>';
			header('Location: registreren');
		}else{
			$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Je kan nu inloggen!</div>';
			header('Location: login');
		}
	}

?>