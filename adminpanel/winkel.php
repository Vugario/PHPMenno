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
	if(isset($url[2])) {
	
		if($url[2] == "overzicht") {
			$sql = mysql_query("SELECT * FROM shop_badges");
			echo "
				<table class='data'>
					<tr>
						<th><strong>Plaatje</strong></th>
						<th><strong>Titel</strong></th>
						<th><strong>Beschrijving</strong></th>
						<th><strong>Aanpassen</strong></th>
					</tr>";
			while($row_badges = mysql_fetch_assoc($sql)) {
?>
					<tr>
						<td style="text-align: center;">
							<img src="<?php echo $row_badges['plaatje'] ?>">
						</td>
						
						<td>
							<strong><?php echo $row_badges['titel'] ?></strong>
						</td>
						
						<td>
							<?php echo $row_badges['beschrijving'] ?>
						</td>
						
						<td>
							<a>Wijzigen</a> <a>Verwijderen</a> <a>Uitzetten</a>
						</td>
					</tr>
						
<?php
			}
			echo "</table>";
		}
	}
?>