<?php
if(isset($_SESSION['admin'])) {
	if(isset($_GET['a'])) {
		if($_GET['a'] == "wijzigen") {
			if(isset($_POST['wijzigen']) && !empty($_POST['bid']) && !empty($_POST['bericht'])) {
				$bericht = mysql_real_escape_string(substr($_POST['bericht'],0,MAXTEKSTINBERICHTENBALK));
				$bid = mysql_real_escape_string($_POST['bid']);
				
				mysql_query("UPDATE berichten_balk SET bericht='".$bericht."' WHERE bericht_id='".$bid."'");
				
				if(mysql_error() == "") {
					echo "Het bericht is succesvol gewijzigd.<br /><a href=\"javascript:history.go(-2)\">Ga terug</a>";
				}else{
					echo "Er is iets fout gegaan.<br /><a href=\"javascript:history.go(-2)\">Ga terug</a>";
				}
			}else{
				$bid = mysql_real_escape_string($_GET['bid']);
				$row = mysql_fetch_assoc(mysql_query("SELECT * FROM berichten_balk WHERE bericht_id='".$bid."'"));
				?>
				<form action="<?php echo $_SERVER['PHP_SELF'] ?>?p=admin_berichtenbalk&a=wijzigen" method="post">
				<input type="hidden" name="bid" value="<?php echo $_GET['bid'] ?>" />
				<textarea name="bericht" cols="30" rows="10"><?php echo $row['bericht'] ?></textarea><br />
				<input type="submit" name="wijzigen" value="Wijzigen" />
				</form>
				<?php
			}
		}elseif($_GET['a'] == "verwijderen") {
			if(isset($_POST['verwijderen']) && !empty($_POST['bid'])) {
				$bid = mysql_real_escape_string($_POST['bid']);
				mysql_query("DELETE FROM berichten_balk WHERE bericht_id='".$bid."'");
				if(mysql_error() == "") {
					echo "Het bericht is succesvol verwijderd.<br /><a href=\"javascript:history.go(-2)\">Ga terug</a>";
				}else{
					echo "er is iets foutgegaan.<br /><a href=\"javascript:history.go(-2)\">Ga terug</a>";
				}
			}else{
				?>
				<form action="<?php echo $_SERVER['PHP_SELF'] ?>?p=admin_berichtenbalk&a=verwijderen" method="post">
				<input type="hidden" name="bid" value="<?php echo $_GET['bid'] ?>" />
				<input type="submit" name="verwijderen" value="Verwijderen" />
				</form>
				<?php
			}
		}
	}else{
		$sql = mysql_query("SELECT * FROM berichten_balk LIMIT 30");
		while($row = mysql_fetch_assoc($sql)) {
			echo "<a href='?p=admin_berichtenbalk&a=verwijderen&bid=".$row['bericht_id']."'>Verwijderen</a> | <a href='?p=admin_berichtenbalk&a=wijzigen&bid=".$row['bericht_id']."'>Wijzigen</a> | ".$row['bericht']."<br />";
		}
		if(mysql_num_rows($sql) == 0) {
			echo "Er zijn geen berichten gepost in de berichtenbalk.<br /><a href='#' onclick='history.go(-1)'>Ga terug</a>";
		}
	}
}
?>