<?php
$sql_check = mysql_query("SELECT * FROM guild WHERE member_id='".$_SESSION['id']."'");
if(mysql_num_rows($sql_check) == 1) {
	$row_check = mysql_fetch_assoc($sql_check);
	if(isset($_POST['submit'])) {

		$row = mysql_fetch_assoc($sql_check);
		if($row['maxleden'] >= GUILDMAXLEDEN) {
			if($get['muntjes'] - GUILDMEERLEDEN >= 0) {
				mysql_query("UPDATE guild SET maxleden=maxleden+20 WHERE member_id='".$_SESSION['id']."'");
				$leden = $row['maxleden'] + 20;
				if(mysql_error() == "") {
					echo "Je hebt plaats voor 20 nieuwe leden in je guild.<br />
					Je hebt nu plaats voor <strong>".$leden."</strong> leden.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
				}else{
					echo "Er is een onbekende fout opgetreden.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
				}
			}else{
				echo "Je hebt niet genoeg munten om meer leden te kopen.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
			}
		}else{
			echo "Je guild heeft al het maximale aantal leden bereikt, je kan helaas maar <strong>".GUILDMAXLEDEN."</strong> leden in totaal kopen.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
		}
	}else{
		?>
		<form action="" method="POST">
			Je kan hier 20 meer ledenplaatsen kopen.<br />
			Je kan nu <?php echo $row_check['maxleden']; ?> aannemen in je guild.<br />
			<br />
			20 Meer leden kopen kost <?php echo GUILDMEERLEDEN; ?> munten.<br />
			<input type="submit" name="submit" value="Kopen" />
		</form>
		<?php
	}
}else{
	echo "Je hebt geen eigen guild.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
}
?>