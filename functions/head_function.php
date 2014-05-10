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
	require_once('functions/system_function.php');
	
	require_once('functions/manage_news_function.php');
	require_once('functions/manage_users_function.php');
    
    require_once('functions/masons/blog/aanmaken_function.php');
	
	require_once('functions/account/login_function.php');
	require_once('functions/account/register_function.php');
	
    require_once('functions/search_function.php');
	require_once('functions/profile_function.php');	
    
    // Functie om urls in te voeren zonder verdere opmaak en tekens 
	function cleanUrl($string) {
		$string = str_replace(" ", "-", trim($string));
		$string = preg_replace("/[^a-z0-9-_]/", "", strtolower($string));
		return $string;
	}
	
    // Functie om het aantal online leden bij te houden
    $s_aantal = mysql_query("SELECT Count(id) FROM bezonline WHERE ip = '".$_SERVER['REMOTE_ADDR']."'") or die(mysql_error());  
    if (!mysql_result($s_aantal, 0)) 
        mysql_query("INSERT INTO bezonline (ip, tijd) VALUES ('".$_SERVER['REMOTE_ADDR']."', '".time()."')") or die(mysql_error()); 
    else {  
        mysql_query("UPDATE bezonline SET tijd = '".time()."' WHERE ip = '".$_SERVER['REMOTE_ADDR']."'") or die(mysql_error()); 
        mysql_query("DELETE FROM bezonline WHERE tijd < ".time()." - 60*5") or die(mysql_error()); 
    }
    
?>