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
	//Wijzig het account en geef een melding
	function wijzigAccount($gebruikersnaam,$email,$member_id,$level,$punten) {
		if(isset($_SESSION['admin'])) {
			
			$gebruikersnaam = mysql_real_escape_string(substr($gebruikersnaam,0,255));
			$punten = mysql_real_escape_string(substr($punten,0,255));
			$email = mysql_real_escape_string(substr($email,0,255));
			$member_id = mysql_real_escape_string(substr($member_id,0,255));
			$level = mysql_real_escape_string(substr($level,0,1));
			
			mysql_query("UPDATE leden SET punten='".$punten."',gebruikersnaam='".$gebruikersnaam."',email='".$email."',level='".$level."' WHERE member_id='".$member_id."'");
			if(mysql_error() == "") {
				$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">De gebruiker is aangepast!</div>';
				header('Refresh: 0');
			}else{
				echo "Er is iets fout gegaan.<br /><a href='#' onclick='history.go(-1)'>Ga terug</a>".mysql_error();
			}
		}else{
			return "Je bent geen admin.";
		}
	}
	
	//Verwijder het account en geef een melding
	function verwijderAccount($member_id) {
		if(isset($_SESSION['admin'])) {
			
			$member_id = mysql_real_escape_string($member_id);
			mysql_query("DELETE FROM leden WHERE member_id='".$member_id."'");
			$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">De gebruiker is verwijderd!</div>';
			header("Location: ../../leden");
		}else{
			return "Je bent geen admin.";
		}
	}
	
	//Geef iemand een ipban en geef een melding
	function ipban($ip,$reden) {
		$ip = mysql_real_escape_string(substr($ip,0,255));
		$reden = mysql_real_escape_string(nl2br($reden));
		$sql = mysql_query("SELECT * FROM ipban WHERE ip='".$ip."'");
		if(mysql_num_rows($sql) < 1) {
			mysql_query("INSERT INTO ipban (ip,reden) VALUES ('".$ip."','".$reden."')");
			$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Het ip is verbannen!</div>';
			header('Location: ../leden');
		}else{
			mysql_query("UPDATE ipban SET ip='".$ip."', reden='".$reden."' WHERE ip = '".$ip."'");
			$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">De reden is aangepast!</div>';
			header('Location: ../leden');
		}
	}
	
?>