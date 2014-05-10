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
	// Als de gebruiker wil inlogen, controleer gegevens en geef een sessie mee
	function inloggen($gebruikersnaam,$wachtwoord) {
		$gebruikersnaam = mysql_real_escape_string(substr($gebruikersnaam,0,25));
		$wachtwoord = hash('sha512', $_POST['wachtwoord']);
		$sql = mysql_query("SELECT member_id,gebruikersnaam,level,rang FROM leden WHERE gebruikersnaam='".$gebruikersnaam."' AND wachtwoord='".mysql_real_escape_string($wachtwoord)."'");
		if(mysql_num_rows($sql) < 1) { // Zijn de gegevens fout? Stuur de gebruiker dan terug naar de login page en weergeef een error.
			$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">De ingevulde gegevens kloppen niet.</div>';
			header('Location: login');
		}else{
			// Geef de gebruiker een sessie van zijn level (rang) mee
			$row = mysql_fetch_assoc($sql);
			if($row['rang'] != "verbannen") {
				if($row['level'] == 6) {
					$_SESSION['admin'] = 1;
				}
				if($row['level'] == 2) {
					$_SESSION['nieuwsreporter'] = 1;
				}
				if($row['level'] == 3) {
					$_SESSION['forumbeheerder'] = 1;
				}
				
		$_SESSION['id'] = $row['member_id'];
		$_SESSION['gebruikersnaam'] = $row['gebruikersnaam'];
		$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
		
		// Voeg rente toe aan het ingelogde account
		$dag = date("Y-m-d");
		mysql_query("INSERT INTO rente (member_id,dag) VALUES ('".$_SESSION['id']."',NOW())");
		if(mysql_error() != ""){
		}else{
			{
				$sql_bank = mysql_query("SELECT bank FROM leden WHERE member_id='".$_SESSION['id']."'");
				$row_bank = mysql_fetch_assoc($sql_bank);
				
				$aantal = $row_bank['bank'];
				$aantal = $aantal * 1.02;
				$aantal = round($aantal);
				mysql_query("UPDATE leden SET bank='".$aantal."' WHERE member_id='".$_SESSION['id']."'");
			}
		}
		
		// Geef muntjesperdag aan ingelogde account
		$aantal = 200; // Hoeveel muntjes er bij komen per dag (het getal 200)
		$dag = date("Y-m-d");
		mysql_query("INSERT INTO muntjesperdag (member_id,dag) VALUES ('".$_SESSION['id']."',NOW())");
		mysql_query("UPDATE leden SET muntjes=muntjes+".$aantal." WHERE member_id='".$_SESSION['id']."'");
		
		// Voeg een "save hash" toe
		$sessdata = $_SESSION['id'];
		$sessdata_str = serialize($sessdata);
		$savehash = hash('sha512', $sessdata_str);
		$_SESSION['hash'] = $savehash;
				mysql_query("INSERT INTO sessies (member_id,hash,ip,date) VALUES ('".$row['member_id']."','".$savehash."','".$_SERVER['REMOTE_ADDR']."',NOW())");
				if(mysql_error() != "") {
					echo "Er is wat mis gegaan!";
					die();
				}
				return "
				Eventuele muntjes en rente worden bij geschreven.<br /><br />
				<strong>".$gebruikersnaam."</strong>, Je bent nu succesvol ingelogd!<br>
				<meta http-equiv='refresh' content='2;URL=beveiligdepagina' />";
			}else{
				echo "Je account is verbannen van deze website, je kan daarom niet inloggen.<br />";
			}
		}
	}
	
?>