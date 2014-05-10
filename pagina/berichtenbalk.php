<?php

if(isset($_SESSION['id'])) {
	
	if(isset($_GET['a'])) {
		if($_GET['a'] == "toevoegen") {
			if(isset($_POST['toevoegen']) && !empty($_POST['bericht'])) {
				$bericht = mysql_real_escape_string(substr($_POST['bericht'],0,MAXTEKSTINBERICHTENBALK));
				
				// Spam beveiliging start //
				$timeoutseconds = 300;
				$timestamp = time();
				$timeout = $timestamp-$timeoutseconds;
				mysql_query("DELETE FROM berichten_balk_ip WHERE moment<$timeout AND ip='".$_SERVER['REMOTE_ADDR']."'");
				
				$sql_spam = mysql_query("SELECT * FROM berichten_balk_ip WHERE ip='".$_SERVER['REMOTE_ADDR']."'");
				if(mysql_num_rows($sql_spam) == 1) {
					echo "Je mag maar 1 keer in de 5 minuten een bericht posten in de berichtenbalk.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
				}else{
					/// spam beveiliging einde //
					mysql_query("INSERT INTO berichten_balk_ip (ip,moment) VALUES ('".$_SERVER['REMOTE_ADDR']."','".$timestamp."')");				
					mysql_query("INSERT INTO berichten_balk (bericht,member_id) VALUES ('".$bericht."','".$_SESSION['id']."')");
					if(mysql_error() == "") {
						echo "Je bericht is succesvol gepost, Je kan hem nu bekijken.<br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
					}else{
						echo "Dit bericht is al een keer gepost.<br />
						Het kan ook zijn dat er een andere fout is opgetreden.<br><a href=\"javascript:history.go(-1)\">Ga terug</a>";
					}
				}
			}else{
				?>
				<form action="<?php echo $_SERVER['PHP_SELF'] ?>?p=berichtenbalk&a=toevoegen" method="post">
				<table width="300">
					<tr>
						<td>Bericht - Maximaal <?php echo MAXTEKSTINBERICHTENBALK; ?> tekens</td>
					</tr>
					<tr>
						<td><textarea name="bericht" cols="30" rows="10"></textarea></td>
					</tr>
					<tr>
						<th colspan="2"><input type="submit" name="toevoegen" value="Toevoegen" /></th>
					</tr>
				</table>
				<?php
			}
		}
	}
}

?>