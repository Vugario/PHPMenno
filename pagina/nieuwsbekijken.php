<?php

if(isset($_GET['nid']) && !empty($_GET['nid']) && is_numeric($_GET['nid'])) {

	$nid = mysql_real_escape_string(substr($_GET['nid'],0,30));

	// Toevoegen van reacties //
	if(isset($_POST['submit']) && !empty($_POST['bericht'])) {
	
		if(isset($_SESSION['id'])) {
			$timeoutseconds = 300;
			$timestamp = time();
			$timeout = $timestamp-$timeoutseconds;
			mysql_query("DELETE FROM nieuws_reacties_ip WHERE moment<$timeout AND ip='".$_SERVER['REMOTE_ADDR']."'");
			
			$sql_spam = mysql_query("SELECT * FROM nieuws_reacties_ip WHERE ip='".$_SERVER['REMOTE_ADDR']."'");
	
			if(mysql_num_rows($sql_spam) == 1) {
				echo "<span style='color: red; font-weight: bold;'>Je mag maar 1 keer in de 5 minuten een reactie posten.<br /><a href='javascript:history.go(-1)'>Ga terug</a></span>";
			}else{
				$bericht = mysql_real_escape_string(substr($_POST['bericht'],0,200));
				mysql_query("INSERT INTO nieuws_reacties (nieuws_id,ip,member_id,bericht,datum) 
							VALUES ('".$nid."','".$_SERVER['REMOTE_ADDR']."','".$_SESSION['id']."','".$bericht."',NOW())");
				mysql_query("INSERT INTO nieuws_reacties_ip (ip,moment) VALUES ('".$_SERVER['REMOTE_ADDR']."','".$timestamp."')");
				mysql_query("UPDATE leden SET muntjes=muntjes + ".$bedragperreactie." WHERE member_id='".$_SESSION['id']."'");	
							
				if(mysql_error() == "") {
					echo "<span style='color: green; font-weight: bold;'>Reactie is succesvol toegevoegd.<br>Je hebt hiermee ".$bedragperreactie." muntjes verdient.</span>";
				}else{
					echo "<span style='color: red; font-weight: bold;'>Reactie is niet toegevoegd, er is iets fout gegaan.<br>Misschien heeft iemand hetzelfde bericht gepost<br></span>";
				}
			}
		}else{
			echo "Je moet ingelogd zijn om een reactie te posten.<br /><a href='#' onclick='history.go(-1)'>Ga terug</a>";
		}
	}
	
	// Eind van reacties //
	
	$sql = mysql_query("SELECT * FROM nieuws_berichten WHERE nieuws_id = '".$nid."'");
	
	$row = mysql_fetch_assoc($sql);	
	
	if($row['actief'] == "aan") {
		
		$sql_member = mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id = '".$row['member_id']."'");
		$row_member = mysql_fetch_assoc($sql_member);
		
		//// Laat nieuws bericht zien ////
		
		?>
		<table>
			<tr>
				<td><h2><?php echo stripslashes($row['titel']); ?></h2></td>
			</tr>
			<tr>
				<td><i>Gepost door <strong><?php echo $row_member['gebruikersnaam']; ?></strong> op <strong><?php echo $row['datum']; ?></strong></i><br><hr></td>
			</tr>
			<tr>
				<td><?php echo stripslashes(htmlspecialchars($row['bericht'])); ?></td>
			</tr>
		</table>
		<hr>
		<strong>Reactie's</strong><br><br>
		<?php
		
		/// Reacties ///
		
		$sql_reacties = mysql_query("SELECT * FROM nieuws_reacties WHERE nieuws_id = '".$nid."'");
		while($row = mysql_fetch_assoc($sql_reacties)) {
			if($row['member_id'] != "") {
	
				$sql_member = mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id = '".$row['member_id']."'");
				$row_member = mysql_fetch_assoc($sql_member);
				?><br>
	
				<table>
					<tr>
						<td><strong>Reactie van <a href='?p=profiel&mid=<?php echo $row['member_id']; ?>'><?php echo $row_member['gebruikersnaam']; ?></a></strong></td>
					</tr>
					<tr>
						<td><?php echo stripslashes(htmlspecialchars(substr(wordwrap($row['bericht'],60,"\n",1),0,60))); ?></td>
					</tr>
					<tr>
						<td><i>Geplaatst op <?php echo $row['datum']; ?></i></td>
					</tr>
				</table>
				<?php
			}
		}
		
		// Toevoegen van reactie //
		
		?><br><br>
		<?php 
		if(isset($_SESSION['id'])) { ?>
			<form action="<?php echo $_SERVER['PHP_SELF'] ?>?p=nieuws&nid=<?php echo $nid; ?>" method="post">
				<strong> Post jou reactie hier</strong><br>
				<textarea cols="30" style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size:11px;" name="bericht" rows="8"></textarea><br>
				<input type="submit" name="submit" value="Reageren">
			</form>
			<?php
		}else{
			echo "<strong>Log in om een reactie te plaatsen.</strong>";
		}
	}else{
		echo "Dit nieuwsbericht staat momenteel uit.<br>";
	}
}else{
	echo "Je heb geen ID opgegeven.<br><a href='#' onclick='history.go(-1)'>Ga terug</a>";
}

?>