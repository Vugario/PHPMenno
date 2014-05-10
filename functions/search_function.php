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
    function search($zoeken) { 
		$string = mysql_real_escape_string($zoeken);
		$sql = "SELECT profiel.*,leden.gebruikersnaam FROM profiel LEFT JOIN leden ON (profiel.member_id = leden.member_id) 
                WHERE profiel.naam LIKE '%".mysql_real_escape_string($string)."%' OR profiel.achternaam LIKE ".$string." OR profiel.woonplaats LIKE ".$string." OR profiel.website LIKE ".$string." OR profiel.grootprofiel LIKE ".$string." OR profiel.favo_fansite LIKE ".$string." OR profiel.favo_kamer LIKE ".$string." OR leden.gebruikersnaam LIKE ".$string."";	
		$result = mysql_query($sql);
        
		if(mysql_num_rows($result) == 0) {
			$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Helaas, maar we hebben niks gevonden.</div>';
			header('Location:zoeken');
		}else{
			echo '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Je zoek opdracht is compleet!</div>';
			echo '<table class="data"><th>Gebruikersnaam</th><th>Profiel</th>';
			$sql_profiel = mysql_query("SELECT profiel_id FROM profiel WHERE member_id='".$row['member_id']."'");
            
			if(mysql_num_rows($sql_profiel) == 1) {
				$profiel = "Ja";
			}else{
				$profiel = "Nee";
			}
			while($row = mysql_fetch_assoc($result)) {
				echo "
					<tr class='row'>
						<td><a href='profiel/gebruiker/?user=".$row['member_id']."'>".ucfirst(stripslashes(substr($row['gebruikersnaam'],0,25)))."</a></td>
						<td>".$profiel."</td>
					</tr>";
			}
			echo '</table>';
		}
    }
	
?>