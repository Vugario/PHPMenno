<?php
require ('class/nummers.class.php');

if(isset($_POST['submit']) && !empty($_POST['zoeken'])) {
	$zoeken = mysql_real_escape_string($_POST['zoeken']);

	$query = "SELECT count(id) FROM guild WHERE naam LIKE '%".$zoeken."%' OR beschrijving LIKE '%".$zoeken."%'";
	$result = mysql_query($query);
	$total = mysql_result($result, 0);


	$results_per_page = 10;
	
	if(isset($_GET['page'])) {
		$current_page = $_GET['page'];
	}else{
		$current_page = 1;
	}

	$off = ($current_page*$results_per_page)-$results_per_page;
	$limit  = $off.','.$results_per_page;

	$query = "SELECT * FROM guild ORDER BY naam ASC LIMIT ".$limit;
	$result = mysql_query($query)or die (mysql_error());
	echo "<table width='100%'>
		<tr>
			<td style='border-bottom: 1px solid #000000;'><strong>Guildnaam</strong></td>
			<td style='border-bottom: 1px solid #000000;'><strong>Eigenaar</strong></td>
			<td style='border-bottom: 1px solid #000000;'><strong>Guildpunten</strong></td>
			<td style='border-bottom: 1px solid #000000;'><strong>Opgericht</strong></td>
			<td style='border-bottom: 1px solid #000000;'><strong>Leden</strong></td>
		</tr>";
	while($row = mysql_fetch_assoc($result)) {
		$sql_leden = mysql_query("SELECT id FROM guild_leden WHERE guild_id='".$row['id']."'");
		$row_leden = mysql_num_rows($sql_leden);
		$sql_eigenaar = mysql_query("SELECT gebruikersnaam,member_id FROM leden WHERE member_id='".$row['member_id']."'");
		$row_eigenaar = mysql_fetch_assoc($sql_eigenaar);
		?>
		<tr>
			<td><a href='?p=guildoverzicht&id=<?php echo $row['id']; ?>'><strong><?php echo $row['naam']; ?></strong></a></td>
			<td><a href='?p=profiel&mid=<?php echo $row['member_id']; ?>'><strong><?php echo $row_eigenaar['gebruikersnaam']; ?></strong></a></td>
			<td><?php echo $row['guildpunten']; ?></td>
			<td><?php echo $row['datum']; ?></td>
			<td><?php echo $row_leden."/".$row['maxleden']; ?></td>
		</tr>
		<?php
	}
	echo "</table>";
	$paginator = new Pagination();
	$paginator->setNumberOfPages($total,$results_per_page);
	$url = 'index.php?p=youtube&a=lijst';
	$paginator->draw($current_page,$url);
	echo $paginator->pagination;
}else{
	?>
	<form action="" method="POST">
	Zoek een guild<br>
	<input type="text" name="zoeken"><br>
	<br>
	<input type="submit" name="submit" value="Zoeken"><br>
	</form>
	<?php
	$query = "SELECT count(id) FROM guild";
	$result = mysql_query($query);
	$total = mysql_result($result, 0);


	$results_per_page = 10;
	
	if(isset($_GET['page'])) {
		$current_page = $_GET['page'];
	}else{
		$current_page = 1;
	}

	$off = ($current_page*$results_per_page)-$results_per_page;
	$limit  = $off.','.$results_per_page;

	$query = "SELECT * FROM guild ORDER BY naam ASC LIMIT ".$limit;
	$result = mysql_query($query)or die (mysql_error());
	echo "<table width='100%'>
		<tr>
			<td style='border-bottom: 1px solid #000000;'><strong>Guildnaam</strong></td>
			<td style='border-bottom: 1px solid #000000;'><strong>Eigenaar</strong></td>
			<td style='border-bottom: 1px solid #000000;'><strong>Guildpunten</strong></td>
			<td style='border-bottom: 1px solid #000000;'><strong>Opgericht</strong></td>
			<td style='border-bottom: 1px solid #000000;'><strong>Leden</strong></td>
		</tr>";
	while($row = mysql_fetch_assoc($result)) {
		$sql_leden = mysql_query("SELECT id FROM guild_leden WHERE guild_id='".$row['id']."'");
		$row_leden = mysql_num_rows($sql_leden);
		$sql_eigenaar = mysql_query("SELECT gebruikersnaam,member_id FROM leden WHERE member_id='".$row['member_id']."'");
		$row_eigenaar = mysql_fetch_assoc($sql_eigenaar);
		?>
		<tr>
			<td><a href='?p=guildoverzicht&id=<?php echo $row['id']; ?>'><strong><?php echo $row['naam']; ?></strong></a></td>
			<td><a href='?p=profiel&mid=<?php echo $row['member_id']; ?>'><strong><?php echo $row_eigenaar['gebruikersnaam']; ?></strong></a></td>
			<td><?php echo $row['guildpunten']; ?></td>
			<td><?php echo $row['datum']; ?></td>
			<td><?php echo $row_leden."/".$row['maxleden']; ?></td>
		</tr>
		<?php
	}
	echo "</table>";
	$paginator = new Pagination();
	$paginator->setNumberOfPages($total,$results_per_page);
	$url = 'index.php?p=youtube&a=lijst';
	$paginator->draw($current_page,$url);
	echo $paginator->pagination;
}
?>