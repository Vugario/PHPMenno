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
        
	function blogsToevoegen($titel,$bericht,$actief) {
		$titel = mysql_real_escape_string(htmlentities($titel,0,255));
        $url = cleanUrl($titel);
		$bericht = $bericht;
		$actief = mysql_real_escape_string(htmlentities($actief,0,3));
		
		mysql_query("INSERT INTO blogs_berichten (titel,url,bericht,actief,datum,member_id)
                    VALUES ('".$titel."','".$url."','".$bericht."','".$actief."','".date("y-m-d H:i:s")."','".$_SESSION['id']."')");
		if(mysql_error() == "") {
            $_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">De blog is succesvol aangemaakt!</div>';
            header('Location:bekijken');
		}elseif(eregi("Duplicate",mysql_error())) {
			$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Deze titel bestaad al.</div>';
            header('Location:toevoegen');
		}else{
			$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Er is om een onbekende reden wat fout gegaan.</div>';
            header('Location:toevoegen');
		}
	}
    	
	function blogsWijzigen($titel,$bericht,$actief,$blogs_id) {
		$titel = mysql_real_escape_string(substr(htmlspecialchars($titel,0,75)));
		$bericht = mysql_real_escape_string(substr(htmlspecialchars($bericht,0,5000)));
		$actief = mysql_real_escape_string(substr(htmlspecialchars($actief,0,3)));
		$blogs_id = mysql_real_escape_string(substr(htmlspecialchars($blogs_id,0,30)));
		
		mysql_query("UPDATE blogs_berichten SET titel='".$titel."',bericht='".$bericht."',actief='".$actief."' WHERE blogs_id='".$blogs_id."'");
		if(mysql_error() == "") {
			echo "Deze blog is succesvol gewijzigd.<br /><strong>".$titel."</strong><br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
		}elseif(eregi("Duplicate",mysql_error())) {
			echo "Deze titel komt al voor in het blog archief.<br />Kies een andere.<br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
		}else{
			echo "Er is iets fout gegaan.<br /><a href=\"javascript:history.go(-2)\">Ga terug</a>";
		}
	}
	
	function blogsVerwijderen($blogs_id) {
		$blogs_id = mysql_real_escape_string(substr($blogs_id,0,30));
		
		mysql_query("DELETE FROM blogs_berichten WHERE blogs_id='".$blogs_id."'");
		if(mysql_error() == "") {
			echo "Deze blog is succesvol verwijderd.<br /><a href=\"javascript:history.go(-2)\">Ga terug</a>";
		}else{
			echo "Er is iets fout gegaan, Misschien bestaat hij niet meer.<br><a href=\"javascript:history.go(-1)\">Ga terug</a>";
		}
	}

?>