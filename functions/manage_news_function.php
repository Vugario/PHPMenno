<?php

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
	// Schrijf het nieuws in de database en weergeef een melding
	function nieuwsToevoegen($titel,$kortbericht,$bericht,$actief) {
		$titel = mysql_real_escape_string(substr($titel,0,60));
		$url = cleanUrl($titel);
		$kortbericht = $kortbericht;
		$bericht = $bericht;
		$actief = mysql_real_escape_string(substr($actief,0,3));
		
		mysql_query("INSERT INTO nieuws_berichten (titel,url,kortbericht,bericht,actief,datum,member_id) VALUES ('".$titel."','".$url."','".$kortbericht."','".$bericht."','".$actief."','".date("y-m-d H:i:s")."','".$_SESSION['id']."')");
		if(mysql_error() == "") {
			$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Het nieuws bericht is aangemaakt!</div>';
			header('Location: ../nieuws/overzicht');
		}else{
			$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Er ging wat mis.</div>';
			header('Location: ../nieuws/toevoegen');
		}
	}
	
	// Wijzig het nieuws in de database en weergeef een melding
	function nieuwsWijzigen($titel,$kortbericht,$bericht,$actief,$nieuws_id) {
		$titel = mysql_real_escape_string(substr($titel,0,60));
		$url = cleanUrl($titel);
		$kortbericht = $kortbericht;
		$bericht = $bericht;
		$actief = mysql_real_escape_string(substr($actief,0,3));
		$nieuws_id = mysql_real_escape_string(substr($nieuws_id,0,30));
		
		
		mysql_query("UPDATE nieuws_berichten SET titel='".$titel."',url='".$url."',kortbericht='".$kortbericht."',bericht='".$bericht."',actief='".$actief."' WHERE nieuws_id='".$nieuws_id."'");
		if(mysql_error() == "") {
			$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Het nieuws bericht is aangepast!</div>';
			header('Location: ../overzicht');
		}else{
			$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Er ging wat mis.</div>';
			header('Location: ../overzicht');
		}
	}
	
	// Verwijder het nieuws uit de database en weergeef een melding
	function nieuwsVerwijderen($nieuws_id) {
		$nieuws_id = mysql_real_escape_string(substr($nieuws_id,0,30));
		
		mysql_query("DELETE FROM nieuws_berichten WHERE nieuws_id='".$nieuws_id."'");
		if(mysql_error() == "") {
			$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Het nieuws bericht is verwijderd.</div>';
			header('Location: ../overzicht');
		}else{
			$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Er ging wat mis.</div>';
			header('Location: ../overzicht');
		}
	}
?>