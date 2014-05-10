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
	if(isset($url[1])) {
		if($url[1] == "overzicht") {
			$sql = mysql_query("SELECT * FROM nieuws_berichten ORDER BY datum DESC LIMIT 6");

			while($row = mysql_fetch_assoc($sql)) {
				$row_member = mysql_fetch_assoc(mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id='".$row['member_id']."'"));
				$aantal_reacties = mysql_num_rows(mysql_query("SELECT reactie_id FROM nieuws_reacties WHERE nieuws_id='".$row['nieuws_id']."'"));
				echo "
				<h4><a href='bericht/".$row['url']."'>".$row['titel']."</a></h4>
				<div style='overflow: hidden; margin-bottom: 5px;'>".$row['kortbericht']."</div>
				<i>Bericht gepost op ".$row['datum']." door ".$row_member['gebruikersnaam'].".</i><br /><br />	
				";
			}
			if(mysql_num_rows($sql) == 0) {
				echo "Er zijn geen nieuws berichten gevonden.";
			}
		}

		if($url[1] == "bericht") {
			$mid = mysql_real_escape_string(substr($url[2],0,255));
			$sql = mysql_query("SELECT * FROM nieuws_berichten WHERE url='".$mid."'");
			$row = mysql_fetch_assoc($sql);
			
			echo "<h4>".$row['titel']."</h4>";
			echo "<div style='overflow: hidden; margin-bottom: 5px;'>".$row['bericht']."</div>";
			echo "<h4>Reacties</h4>";
		}
	}
?>