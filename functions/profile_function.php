<?php

	/*
	PHPMenno V6 - Simpel, Snel en Beter
	---------------------------------------------------
	Copyright (c) 2009, Menno Wolvers 'Menno'
	Copyright (c) 2010, Jeroen van de Weerd 'Jeroen262'
	http://www.istic.nl
	---------------------------------------------------
	This program is free software: you can redistribute 
	it and/or modify it under the terms of the 
	GNU General Public License as published by the Free 
	Software Foundation, either version 6 of the 
	License, or	(at your option) any later version.
	*/
	//Maak een nieuw profiel aan en zet deze in de database
	function nieuwProfiel($naam,$achternaam,$woonplaats,$hobby,$website,$favo_fansite,$favo_kamer,$land) {
		$naam = mysql_real_escape_string(htmlentities($naam,0,255));
		$achternaam = mysql_real_escape_string(htmlentities($achternaam,0,255));
		$woonplaats = mysql_real_escape_string(htmlentities($woonplaats,0,255));
		$hobby = mysql_real_escape_string(htmlentities($hobby,0,255));
		$website = mysql_real_escape_string(htmlentities($website,0,255));
		$favo_fansite = mysql_real_escape_string(htmlentities($favo_fansite,0,255));
		$favo_kamer = mysql_real_escape_string(htmlentities($favo_kamer,0,255));
		$land = mysql_real_escape_string(htmlentities($land,0,255));
		
		{
			mysql_query("INSERT INTO profiel (member_id,gebruikersnaam,naam,achternaam,woonplaats,hobby,website,favo_fansite,favo_kamer,grootprofiel,land)
						VALUES ('".$_SESSION['id']."','".$_SESSION['gebruikersnaam']."','".$naam."','".$achternaam."','".$woonplaats."','".$hobby."','".$website."','".$favo_fansite."','".$favo_kamer."','','".$land."')");
			if(mysql_error() == "") {
				$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Je profiel is succesvol aangemaakt!</div>';
				header('Location:aanpassen');
			}else{
				$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Er ging wat mis.</div>';
				header('Location:');
			}
		}
	}
	
	
	
	
	
	
	function aanpassenProfiel($naam,$achternaam,$woonplaats,$hobby,$website,$favo_fansite,$favo_kamer,$land) {
		$naam = mysql_real_escape_string(htmlentities($naam,0,255));
		$achternaam = mysql_real_escape_string(htmlentities($achternaam,0,255));
		$woonplaats = mysql_real_escape_string(htmlentities($woonplaats,0,255));
		$hobby = mysql_real_escape_string(htmlentities($hobby,0,255));
		$website = mysql_real_escape_string(htmlentities($website,0,255));
		$favo_fansite = mysql_real_escape_string(htmlentities($favo_fansite,0,255));
		$favo_kamer = mysql_real_escape_string(htmlentities($favo_kamer,0,255));
		$land = mysql_real_escape_string(htmlentities($land,0,255));
		
		mysql_query("UPDATE profiel SET land='".$land."',naam='".$naam."',achternaam='".$achternaam."',woonplaats='".$woonplaats."',hobby='".$hobby."',website='".$website."',favo_fansite='".$favo_fansite."',favo_kamer='".$favo_kamer."' WHERE member_id='".$_SESSION['id']."'");
		
		if(mysql_error() == "") {
				$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Je profiel is geupdate!</div>';
				header('Location:aanpassen');
		}else{
			return mysql_error();
		}
	}
	function wijzigGrootprofiel ($grootprofiel) {
		
		mysql_query("UPDATE profiel SET grootprofiel='".$grootprofiel."' WHERE member_id='".$_SESSION['id']."'");
		
		if(mysql_error() == "") {
			$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Je groot profiel is aangepast!</div>';
			header('Location:grootprofiel');
		}else{
			return mysql_error();
		}
	}

?>