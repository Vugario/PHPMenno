<?php
	if(isset($_SESSION['id'])) {
		if(isset($_POST['toevoegen']) && !empty($_POST['bericht'])) {
			$bericht = htmlentities($_POST['bericht']);
			
			// Spam beveiliging start //
			$timeoutseconds = 300;
			$timestamp = time();
			$timeout = $timestamp-$timeoutseconds;
			mysql_query("DELETE FROM berichten_balk_ip WHERE moment<$timeout AND ip='".$_SERVER['REMOTE_ADDR']."'");
			
			$sql_spam = mysql_query("SELECT * FROM berichten_balk_ip WHERE ip='".$_SERVER['REMOTE_ADDR']."'");
			if(mysql_num_rows($sql_spam) == 1) {
				$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Je mag maar 1 keer in de 5 minuten een bericht posten in de berichtenbalk.</div>';
				header('Location:berichtenbalk');
			}else{
				/// spam beveiliging einde //
				mysql_query("INSERT INTO berichten_balk_ip (ip,moment) VALUES ('".$_SERVER['REMOTE_ADDR']."','".$timestamp."')");				
				mysql_query("INSERT INTO berichten_balk (bericht,member_id) VALUES ('".$bericht."','".$_SESSION['id']."')");
				if(mysql_error() == "") {
					$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Je bericht is succesvol gepost. Je kan hem nu bekijken.</div>';
					header('Location:berichtenbalk');
				}else{
					echo "Dit bericht is al een keer gepost.<br />
					Het kan ook zijn dat er een andere fout is opgetreden.<br><a href=\"javascript:history.go(-1)\">Ga terug</a>";
				}
			}
		}else{
			?>
			<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
				<table class="data">
					<tr>
						<td>Bericht - Maximaal <?php echo $maxberichtenbalk ?> tekens</td>
						<td><input type="text" name="bericht"/></td>
					</tr>
					<tr>
						<th colspan="2"><input type="submit" name="toevoegen" value="Toevoegen" /></th>
					</tr>
				</table>
			</form>
<?php
		}
	}
?>