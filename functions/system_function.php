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
	
	PAS IN DIT BESTAND NIKS AAN!
	*/
	$versioncheck = "http://jeroenvdweerd.nl/data/menno/version/version.php?v=";
	$version = "6.3";
    session_start();
    ob_start();
    error_reporting(1);
    require_once('functions/error_function.php');
    require_once('config.php');
    require_once("functions/habbodata_function.php");
	
?>