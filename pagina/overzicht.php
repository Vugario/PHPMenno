<?php
		$mid = mysql_real_escape_string(substr($_GET['mid'],0,30));
		$sql = mysql_query("SELECT * FROM leden WHERE member_id='".$mid."'");
		$row = mysql_fetch_assoc($sql);
		if($row['member_id'] == $_SESSION['id']) {
				?>
				Hieronder zie je je waarschuwingen en infracties<br><br>
<b>* Infractie</b><br>Bij een x aantal fracties krijg je automatisch een ban. Zorg ervoor dat je er geen krijgt, deze ban is namelijk permanent!<br><br><b>* Waarschuwing</b><br>
Dit zijn enkel en alleen waarschuwingen, deze verdwijnen <b>niet</b>.
<?php
				$mid = mysql_real_escape_string(substr($_GET['mid'],0,30));
				$sql = mysql_query("SELECT * FROM waarschuwingen WHERE member_id='".$mid."' ORDER BY datum DESC");
				echo "<br><Br><br>Hieronder zie je al je <b>waarschuwingen</b>:";
if(mysql_num_rows($sql) > 0) {
while($row = mysql_fetch_assoc($sql)) {
				echo "<br><br><b>Waarschuwing gegeven door:</b> ".$row['door']."<br><b>Datum:</b> ".$row['datum']."<br><b>Rede:</b> ".$row['reden']."";
				}
				}else{
					echo "<br><br>Je hebt (nog) geen waarschuwingen.";
				}
				echo "<br><Br><br>Hieronder zie je al je <b>infracties</b>:";
								$midd = mysql_real_escape_string(substr($_GET['mid'],0,30));
				$sqll = mysql_query("SELECT * FROM infracties WHERE member_id='".$midd."' ORDER BY datum DESC");
if(mysql_num_rows($sqll) > 0) {
while($roww = mysql_fetch_assoc($sqll)) {
				echo "<br><br><b>Infractie gegeven door:</b> ".$roww['door']."<br><b>Datum:</b> ".$roww['datum']."<br><b>Rede:</b> ".$roww['reden']."";
				}
			}else{
			echo "<br><br>Je hebt (nog) geen infracties.";
			}
		}else{
	echo "Sorry, je kan alleen je eigen infracties en waarschuwingen bekijken.";
}
?>