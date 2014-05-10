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
	
		if($url[2] == "bewerken") {
			if(isset($_POST['wijzigen']) && !empty($_POST['gebruikersnaam']) && !empty($_POST['email'])) {
				echo wijzigAccount($_POST['gebruikersnaam'],$_POST['email'],$url[3],$_POST['level'],$_POST['punten']);
		}else{
			$mid = mysql_real_escape_string(substr($url[3],0,255));
			$sql = mysql_query("SELECT gebruikersnaam,email,level,punten FROM leden WHERE member_id='".$mid."'");
			$row = mysql_fetch_assoc($sql);
			echo "<form action='".$_SERVER['REQUEST_URI']."' method='post'>
				<table class='data'>
					<tr>
						<td>Gebruikersnaam</td>
						<td><input type='text' name='gebruikersnaam' maxlength='255' value='".$row['gebruikersnaam']."' /></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><input type='text' name='email' maxlength='255' value='".$row['email']."' /></td>
					</tr>
					<tr>
						<td>Stemmen</td>
						<td><input type='text' name='punten' maxlength='255' value='".$row['punten']."' /></td>
					</tr>
					<tr>
						<td>Level</td>
						<td><input type='text' name='level' style='width:20px;' maxlength='1' value='".$row['level']."' /><br />
						1 = Lid<br /> 2 = Nieuwsreporter<br /> 3 = Forum beheerder<br /> 6 = Administrator</td>
					</tr>
					<tr>
						<th colspan='2'>
							<input type='submit' name='wijzigen' value='Wijzigen' />
						</th>
					</tr>
				</table>
			</form>";
		}
		}

		if($url[2] == "verwijderen") {
			if($verwijderen != "uit") {
				echo verwijderAccount($url[3]);
			}else{
				$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">De optie leden verwijderen is uitgeschakeld.</div>';
				header('Location: '.$root.'admin/leden');
			}
		}
	
		if($url[2] == "ipban") {
			if(isset($_POST['bannen']) && !empty($_POST['reden'])) {
				$ip = mysql_real_escape_string(substr($_POST['ip'],0,15));
				$reden = mysql_real_escape_string($_POST['reden']);
				echo ipban($ip,$reden);
			}else{
				$ip = $url[3];
				$sql = mysql_query("SELECT reden FROM ipban WHERE ip='".$ip."'");
				$raw = mysql_fetch_assoc($sql);
				echo "
				<form action='".$root."admin/leden/ipban' method='post'>
					<table class='data'>
						<tr>
							<td>Te bannen IP</td>
							<td>".$url[3]."</td>
						</tr>				
						
						<tr>
							<td>Reden voor verbanning</td>
							<td><textarea name='reden' style='width:250px; height:100px;'>".$raw['reden']."</textarea></td>
						</tr>
						
						<tr>
							<th colspan='2'>
								<input type='submit' name='bannen' value='Ja, verban het IP' />
							</th>
						</tr>
					</table>
					<input type='hidden' name='ip' value='".$url[3]."' />
				</form>";	
			}
		}
	
		if($url[2] == "overzicht") {
			$sql = mysql_query("SELECT gebruikersnaam,email,member_id,ip FROM leden");
			echo "
				<table class='data'>
					<tr>
						<th>Gebruikersnaam</th>
						<th>IP</th>
						<th>Wijzigen</th>
						<th>Verwijderen</th>
						<th>IP Bannen</th>
					</tr>";
			$i = 0;
			while($row = mysql_fetch_assoc($sql)) {
				$i ^= 1;
				echo "
					<tr class='row" . $i . "'>
						<td>".$row['gebruikersnaam']."</td>
						<td>".$row['ip']."</td>
						<td><a href='" . $root . "admin/leden/bewerken/" . $row['member_id']."'>Wijzigen</a></td>
						<td>
				";
				if($verwijderen != "uit") {
					echo "<a href='" . $root . "admin/leden/verwijderen/" . $row['member_id']."' onclick=\"return confirm('Weet je zeker dat dit account verwijderd moet worden?');\">Verwijderen</a>";
				}else{
					echo "<s>Verwijderen</s>";
				}
				echo "		
						</td>
						<td><a href='" . $root . "admin/leden/ipban/".$row['ip']."'>Ban IP</a></td>
					</tr>";
			}
			echo "</table>";		
		}
	}

?>