<?php 

if(isset($_SESSION['admin'])) {
	echo "<h2>Admin Panel</h2>";
	
	if(isset($_GET['a'])) {
		if($_GET['a'] == "wijzigen" && isset($_GET['mid'])) {
			if(isset($_POST['wijzigen']) && !empty($_POST['gebruikersnaam']) && !empty($_POST['email'])) {
				
				echo $admin->wijzigAccount($_POST['gebruikersnaam'],$_POST['email'],$_GET['mid'],$_POST['level'],$_POST['punten']);
				
			}else{
				$mid = mysql_real_escape_string(substr($_GET['mid'],0,255));
				$sql = mysql_query("SELECT gebruikersnaam,email,level,punten FROM leden WHERE member_id='".$mid."'");
				$row = mysql_fetch_assoc($sql);
				?>
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=admin_gebruikers&a=wijzigen&mid=<?php echo $_GET['mid']; ?>" method="post">
					<table width="300">
						<tr>
							<td>Gebruikersnaam</td>
							<td><input type="text" name="gebruikersnaam" maxlength="255" value="<?php echo $row['gebruikersnaam']; ?>" /></td>
						</tr>
						<tr>
							<td>Email</td>
							<td><input type="text" name="email" maxlength="255" value="<?php echo $row['email']; ?>" /></td>
						</tr>
						<tr>
							<td>Stem Punten</td>
							<td><input type="text" name="punten" maxlength="255" value="<?php echo $row['punten']; ?>" /></td>
						</tr>
						<tr>
							<td>Level</td>
						  <td><input type="text" name="level" style="width:20px;" maxlength="1" value="<?php echo $row['level']; ?>" /> <br />						    0 = normal<br /> 2 = nieuwsreporter<br />
3 = forum beheerder<br />
5 = moderator<br />
 6 = administrator</td>
						</tr>
						<tr>
							<th colspan="2"><input type="submit" name="wijzigen" value="Wijzigen" /></th>
						</tr>
					</table>
				</form>
				<?php 
			}
		}elseif($_GET['a'] == "verwijderen" && isset($_GET['mid'])) {
			if(isset($_POST['verwijderen'])) {
			
				echo $admin->verwijderAccount($_GET['mid']);
			
			}else{
				$mid = mysql_real_escape_string(substr($_GET['mid'],0,255));
				$sql = mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id='".$mid."'");
				$row = mysql_fetch_assoc($sql);
				?>
				<form action="<?php  echo $_SERVER['PHP_SELF']; ?>?p=admin_gebruikers&a=verwijderen&mid=<?php  echo $_GET['mid']; ?>" method="post">
					<table width="300">
						<tr>
							<td>Weet je zeker dat je <strong><?php  echo $row['gebruikersnaam']; ?></strong> wilt verwijderen?</td>
						</tr>
						<tr>
							<th><input type="submit" name="verwijderen" value="Verwijderen" /></th>
						</tr>
					</table>
				</form>
				<?php  
			}
		}elseif($_GET['a'] == "ipban" && isset($_POST['ip'])) {
			if(isset($_POST['bannen']) && !empty($_POST['reden'])) {
				$ip = mysql_real_escape_string(substr($_POST['ip'],0,15));
				$reden = mysql_real_escape_string($_POST['reden']);
				echo $admin->ipban($ip,$reden);
			}else{
				?>
				<form action="<?php  echo $_SERVER['PHP_SELF']; ?>?p=admin_gebruikers&a=ipban" method="post">
					<input type="hidden" name="ip" value="<?php echo $_POST['ip']; ?>" />
					Weet je zeker dat je ip: <?php  echo $_POST['ip']; ?> wilt verbannen van de site?<br />
					Deze reden voor verbanning:<br />
					<textarea name="reden" style="width:200px; height:200px;"></textarea><br />
					<input type="submit" name="bannen" value="Ja, zeker weten" />
				</form>
				<?php 
			}
		}// HIER KAN EEN ANDERE $_GET['A'] KOMEN
	}else{
		$sql = mysql_query("SELECT gebruikersnaam,email,member_id,ip FROM leden");
		echo "
			<table width='100%'>
				<tr>
					<td><strong>Gebruikersnaam</strong></td>
					<td><strong>Email</strong></td>
					<td><strong>IP</strong></td>
					<td><strong>Wijzigen</strong></td>
					<td><strong>Verwijderen</strong></td>
					<td><strong>IP Bannen</strong></td>
				</tr>";
		while($row = mysql_fetch_assoc($sql)) {
			echo "
				<tr>
					<td>".$row['gebruikersnaam']."</td>
					<td>".$row['email']."</td>
					<td>".$row['ip']."</td>
					<td><a href='".$_SERVER['PHP_SELF']."?p=admin_gebruikers&a=wijzigen&mid=".$row['member_id']."'>Wijzigen</a></td>
					<td><a href='".$_SERVER['PHP_SELF']."?p=admin_gebruikers&a=verwijderen&mid=".$row['member_id']."'>Verwijderen</a></td>
					<td>
						<form action='".$_SERVER['PHP_SELF']."?p=admin_gebruikers&a=ipban' method='POST'>
							<input type='hidden' name='ip' value='".$row['ip']."' />
							<input type='submit' name='ipban' value='IP Bannen' />
						</form>
					</td>
				</tr>";
		}
		echo "</table>";
	}
}else{
	echo "Je bent geen admin.";
}
?>