<?php

if(isset($_POST['zoeken']) && !empty($_POST['string']) && strlen($_POST['string']) > 3) {
	$string = mysql_real_escape_string($_POST['string']);
	
	
	
	
	$sql = "SELECT profiel.*,leden.gebruikersnaam FROM profiel LEFT JOIN leden ON (profiel.member_id = leden.member_id) WHERE profiel.naam LIKE '%$string%' OR profiel.achternaam LIKE '%$string%' OR profiel.woonplaats LIKE '%$string%' OR profiel.website LIKE '%$string%' OR profiel.grootprofiel LIKE '%$string%' OR profiel.favo_fansite LIKE '%$string%' OR profiel.favo_kamer LIKE '%$string%' OR leden.gebruikersnaam LIKE '%$string%'";		
	
	$result = mysql_query($sql)or die (mysql_error());
	if(mysql_num_rows($result) == 0) {
		echo "Er zijn geen profielen gevonden met deze zoekwoorden.<br />";
		echo "<br /><br />Zoek nog een keer:<br>";
		include_once('pagina/zoekformulier.php');
	}else{
		echo "
		<table>
			<tr>
				<td><strong>Gebruikersnaam</strong></td>
			</tr>";
		$i = 0;
	
		while($row = mysql_fetch_assoc($result)) {
			echo "
				<tr>
					<td><a href='?p=profiel&mid=".$row['member_id']."'>".$row['gebruikersnaam']."</a></td>
				</tr>";
		}
		echo "</table>";
		echo "<br />Zoek nog een keer :";
		include('pagina/zoekformulier.php');	
	}
	

}else{
?><center>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=profiel&a=zoeken" method="post">
	<table class="body" width="300">
		<tr>
			<td>Zoeken</td>
			<td><input type="text" name="string" /></td>
		</tr>
	<?php
	if(isset($_POST['zoeken']) && empty($_POST['string'])) {
		echo "
		<tr>
			<th colspan=\"2\">De string is leeg, Hier kan ik toch niet mee werken!</th>
		</tr>";
	}elseif(isset($_POST['zoeken']) && strlen($_POST['string']) <= 3) {
		echo "
		<tr>
			<th colspan=\"2\">Je woord moet meer dan 3 tekens bevatten.</th>
		</tr>";
	}
	?>
		<tr>
			<th colspan="2"><input type="submit" name="zoeken" value="Zoeken" /></th>
		</tr>
	</table>
</form></center>
<?php
}

?>