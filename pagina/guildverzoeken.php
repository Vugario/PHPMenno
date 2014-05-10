<?php

if(isset($_SESSION['id'])) {
	if(isset($_GET['a']) && $_GET['a'] == "verzoeken") {
		if(isset($_GET['id']) && is_numeric($_GET['id'])) {
			$id = mysql_real_escape_string(substr($_GET['id'],0,30));
			$sql = mysql_query("SELECT * FROM guild_leden WHERE member_id='".$id."'");
			if(mysql_num_rows($sql) == 1) {
				echo "Deze gebruiker zit al in een guild, je kan pas een verzoek sturen wanneer hij niet in een guild zit.<br><a href='javascript:history.go(-1)'>Ga terug</a>";
			}else{
				$sql = mysql_query("SELECT * FROM leden WHERE member_id='".$id."'");
				if(mysql_num_rows($sql) == 0) {
					echo "Deze gebruiker bestaat helaas niet.<br><a href='javascript:history.go(-1)'>Ga terug</a>";
				}else{
					$sql = mysql_query("SELECT * FROM guild WHERE member_id='".$_SESSION['id']."'");
					if(mysql_num_rows($sql) ==  1) {
						$row = mysql_fetch_assoc($sql);
						$sql_leden = mysql_query("SELECT * FROM guild_leden WHERE guild_id='".$row['id']."'");
						if(mysql_num_rows($sql_leden) >= $row['maxleden']) {
							echo "Het maximum aantal leden van ".$row['maxleden']." is bereikt.<br><a href='javascript:history.go(-1)'>Ga terug</a>";
						}else{
							mysql_query("INSERT INTO guild_verzoeken (guild_id,member_id) VALUES ('".$row['guild_id']."','".$id."')");
							echo "Je hebt deze gebruiker uitgenodigd voor je guild.<br><a href='javascript:history.go(-1)'>Ga terug</a>";
						}
					}else{
						echo "Deze guild is niet van jou.<br><a href='javascript:history.go(-1)'>Ga terug</a>";
					}
				}
			}
		}else{
			echo "Er is geen member ID opgegeven.<br><a href='javascript:history.go(-1)'>Ga terug</a>";
		}
	}else{
				
		$sql = mysql_query("SELECT * FROM guild_leden WHERE member_id='".$_SESSION['id']."'");
		if(mysql_num_rows($sql) ==  1) {
			echo "Je zit al in een guild.<br>Je kan helaas maar in 1 guild tegelijk zitten.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
		}else{
			if(isset($_POST['id']) && is_numeric($_POST['id'])) {
				$id = mysql_real_escape_string(substr($_POST['id'],0,30));
				$sql = mysql_query("SELECT * FROM guild_verzoeken WHERE id='".$id."'");
				if(mysql_num_rows($sql) == 1) {
					$row = mysql_fetch_assoc($sql);
					if($row['member_id'] == $_SESSION['id']) {
						$sql_rangen = mysql_query("SELECT * FROM guild_rangen WHERE guild_id='".$row['guild_id']."' ORDER BY id DESC LIMIT 1");
						$row_rangen = mysql_fetch_assoc($sql_rangen);
						mysql_query("INSERT INTO guild_leden (guild_id,member_id,datum,rang_id) VALUES ('".$row['guild_id']."','".$_SESSION['id']."',NOW(),'".$row_rangen['id']."')");
						mysql_query("DELETE FROM guild_verzoeken WHERE id='".$id."'");
						echo "Je bent succesvol toegetreden tot deze guild.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
					}else{
						echo "Dit verzoek is niet voor jou bedoeldt.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
					}
				}else{
					echo "Dit verzoek bestaat helaas niet.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
				}
			}else{
				echo "Hieronder staan al jou verzoeken die guilds jou hebben gestuurd.<br />
				Je kan maar in 1 guild tegelijk zitten, dus bekijk een guild eerst goed voordat je erin gaat.<br /><br />";
				$sql = mysql_query("SELECT * FROM guild_verzoeken WHERE member_id='".$_SESSION['id']."'");
				while($row = mysql_fetch_assoc($sql)) {
					$row_guild = mysql_fetch_assoc(mysql_query("SELECT * FROM guild WHERE id='".$row['guild_id']."'"));
					?>
					<form action="" method="POST">
					<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
					<strong><?php echo $row_guild['naam']; ?></strong>
					&nbsp;&nbsp;<input type="submit" value="Verzoek accepteren" /><br />
					</form>
					<br />
					<?php
				}
				if(mysql_num_rows($sql) == 0) {
					echo "<strong> Je hebt op dit moment geen verzoeken.<br /></strong>";
				}
			}
		}
	}
}else{
	echo "Je bent helaas niet ingelogd.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
}
?>