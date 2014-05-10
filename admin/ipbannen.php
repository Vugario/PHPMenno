<?php
if(isset($_SESSION['admin']) || isset($_SESSION['moderator'])) {
	if(isset($_GET['a'])) {
		if($_GET['a'] == "unbannen" && isset($_GET['ip']) && isset($_GET['id'])) {
			echo $admin->unban($_GET['ip'],$_GET['id']);
		}elseif($_GET['a'] == "ipban" && isset($_POST['bannen']) && isset($_POST['ip']) && isset($_POST['reden'])) {
			
			echo $admin->ipban($_POST['ip'],$_POST['reden']);
			
		}
	}else{
		echo "<strong>Unban een ip</strong><br>";
		$sql = mysql_query("SELECT ip,reden,ipban_id FROM ipban");
		echo "<table>";
		while($row = mysql_fetch_assoc($sql)) {
			echo "
				<tr>
					<td>".$row['ip']."</td>
					<td>".$row['reden']."</td>
					<td><a href='?p=ipban&a=unbannen&ip=".$row['ip']."&id=".$row['ipban_id']."'>Unban</a></td>
				</tr>";
		}
		if(mysql_num_rows($sql) == 0) {
			echo "Er zijn geen verbannen ip's<br><br>";
		}
		echo "</table><br>";
		?>
		<strong>Of ban een nieuw ip</strong><br>
		<form action="<?= $_SERVER['PHP_SELF'] ?>?p=ipban&a=ipban" method="post">
			<table>
				<tr>
					<td>Ip:</td>
					<td><input type="text" name="ip" /></td>
				</tr>
				<tr>
					<td>Reden:</td>
					<td><textarea style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;width:200px; height:200px;" name="reden"></textarea></td>
				</tr>
				<tr>
					<th colspan="2"><input type="submit" name="bannen" value="Ip Bannen" /></th>
				</tr>
			</table>
		</form>
		<?
	}
}
?>