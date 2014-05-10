<?php

if(isset($_SESSION['admin']) || isset($_SESSION['nieuwsreporter']) || isset($_SESSION['forumbeheerder'])) {
	if(isset($_GET['a'])) {
		if($_GET['a'] == "bekijken") {
			$sql = mysql_query("SELECT * FROM askamod");
			echo "<table>
					<tr>
						<td><strong>Van wie?</strong></td>
						<td><strong>Titel</strong></td>
						<td><strong>IP</strong></td>
					</tr>";
			while($row = mysql_fetch_assoc($sql)) {
				$sql_leden = mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id='".$row['member_id']."'");
				$row_leden = mysql_fetch_assoc($sql_leden);
				if($row['gelezen'] == "nee") {
					$titel = "<strong>".substr($row['vraag'],0,30)."</strong>";
				}else{
					$titel = substr($row['vraag'],0,30);
				}
				echo "<tr>
						<td><a href=\"?p=admin_askamod&id=".$row['askamod_id']."\">".$row_leden['gebruikersnaam']."</a></td>
						<td><a href=\"?p=admin_askamod&id=".$row['askamod_id']."\">".$titel."</a></td>
						<td>".$row['ip']."</td>
					</tr>";
			}
			echo "</table>";
		}
		if(mysql_num_rows($sql) == 0) {
			echo "Er zijn geen vragen te beantwoorden.<br><a href='#' onclick='history.go(-1)'>Ga terug</a>";
		}
	}else{
		if(isset($_GET['id'])) {
			if(isset($_POST['id']) && isset($_POST['verwijderen'])) {
				$id_user = mysql_real_escape_string($_POST['id']);
				mysql_query("DELETE FROM askamod WHERE askamod_id='".$id_user."'");
				echo "<strong>Hij is succesvol verwijderd</strong><br /><a href='#' onclick='history.go(-2)'>Ga terug</a>";
			}else{
				$id_user = mysql_real_escape_string($_GET['id']);
				$sql = mysql_query("SELECT * FROM askamod WHERE askamod_id='".$id_user."'");
				$row = mysql_fetch_assoc($sql);
				
				$sql_leden = mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id='".$row['member_id']."'");
				$row_leden = mysql_fetch_assoc($sql_leden);		
					
				echo "<strong>".$row_leden['gebruikersnaam']."</strong> - ".$row['ip']."<br /><br />".$row['vraag']."<br /><br />
				<form action=\"".$_SERVER['PHP_SELF']."?p=admin_askamod&id=".$id_user."\" method=\"POST\">
				<input type='hidden' name='id' value='".$id_user."'>
				<input type='submit' name='verwijderen' value='Verwijderen' />
				<input type=\"button\" onclick=\"location='?p=admin_alert&mid=".$row['member_id']."&naam=".$row_leden['gebruikersnaam']."'\" value=\"Reageer\">
				</form>";
			}
		}else{
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=?p=admin_askamod&a=bekijken\" />";
		}
	}
}else{
	echo "Ben jij een admin?<br /><a href='#' onclick='history.go(-1)'>Ga terug</a>";
}
?>