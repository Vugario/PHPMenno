<?php
	if(isset($_POST['zoeken']) && !empty($_POST['string'])) {
		$string = mysql_real_escape_string($_POST['string']);
		$sql = "SELECT profiel.*,leden.gebruikersnaam FROM profiel LEFT JOIN leden ON (profiel.member_id = leden.member_id) WHERE profiel.naam LIKE '%$string%' OR profiel.achternaam LIKE '%$string%' OR profiel.woonplaats LIKE '%$string%' OR profiel.website LIKE '%$string%' OR profiel.grootprofiel LIKE '%$string%' OR profiel.favo_fansite LIKE '%$string%' OR profiel.favo_kamer LIKE '%$string%' OR leden.gebruikersnaam LIKE '%$string%'";		
		
		$result = mysql_query($sql)or die (mysql_error());
		if(mysql_num_rows($result) == 0) {
			$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Helaas, maar we hebben niks gevonden.</div>';
			header('Location:zoeken');
		}else{
			echo '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Je zoek opdracht is compleet!</div>';
			echo '<table class="data"><th>Gebruikersnaam</th><th>Profiel</th>';
			$sql_profiel = mysql_query("SELECT profiel_id FROM profiel WHERE member_id='".$row['member_id']."'");
			if(mysql_num_rows($sql_profiel) == 1) {
				$profiel = "Ja";
			}else{
				$profiel = "Nee";
			}
			while($row = mysql_fetch_assoc($result)) {
				echo "
					<tr class='row'>
						<td><a href='profiel/gebruiker/".$row['gebruikersnaam']."'>".ucfirst(stripslashes(substr($row['gebruikersnaam'],0,25)))."</a></td>
						<td>".$profiel."</td>
					</tr>";
			}
			echo '</table>';
		}
	}else{
?>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
	<table class="data">
		<tr>
			<td>Zoekwoord (gebruiker)</td>
			<td><input type="text" name="string" /></td>
		</tr>
		<th colspan="2"><input type="submit" name="zoeken" value="Zoeken" /></th>
	</table>
	
	<?php
		if(isset($_POST['zoeken']) && empty($_POST['string'])) {
			$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Je hebt het zoek vak leeg gelaten.</div>';
			header('Location:zoeken');
		}
	?>
</form>
<?php } ?>