<?php 
	if(isset($url[1])) {
	
		if($url[1] == "aanmaken") {
			$sql = mysql_query("SELECT member_id FROM profiel WHERE member_id='".$_SESSION['id']."'");
			if(mysql_num_rows($sql) == 0) {
				if(isset($_POST['aanmaken'])) {
					echo nieuwProfiel($_POST['naam'],$_POST['achternaam'],$_POST['woonplaats'],$_POST['hobby'],$_POST['website'],$_POST['favo_fansite'],$_POST['favo_kamer'],$_POST['land']);
				}else{
?>
					<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
						<table class="data">
							<tr>
								<td>Naam</td>
								<td><input type="text" name="naam" maxlength="255" /></td>
							</tr>
							<tr>
								<td>Achternaam</td>
								<td><input type="text" name="achternaam" maxlength="255" /></td>
							</tr>
							<tr>
								<td>Woonplaats</td>
								<td><input type="text" name="woonplaats" maxlength="255" /></td>
							</tr>
							<tr>
								<td>Hobby</td>
								<td><input type="text" name="hobby" maxlength="255" /></td>
							</tr>
							<tr>
								<td>Homepage</td>
								<td><input type="text" name="website" maxlength="255" /></td>
							</tr>
							<tr>
								<td>Favoriete Habbo Fansite</td>
								<td><input type="text" name="favo_fansite" maxlength="255" /></td>
							</tr>
							<tr>
								<td>Favoriete Habbo Kamer</td>
								<td><input type="text" name="favo_kamer" maxlength="255" /></td>
							</tr>
							<tr>
								<td>Habbo Land</td>
								<td>
									<select name="land">
										<option value="nl">Nederland</option>
										<option value="co.uk">Engeland</option>
										<option value="com">Amerika</option>
										<option value="be">Belgie</option>
										<option value="com.au">Australie</option>
										<option value="ca">Canada</option>
										<option value="dk">Denemarken</option>
										<option value="de">Duitsland</option>
										<option value="fi">Finland</option>
										<option value="fr">Frankrijk</option>
										<option value="it">Italie</option>
										<option value="jp">Japan</option>
										<option value="no">Noorwegen</option>
										<option value="es">Spanje</option>
										<option value="se">Zweden</option>
										<option value="ch">Zwitserland</option>
									</select>
								</td>
							</tr>
							<tr>
								<th colspan="2"><input type="submit" name="aanmaken" value="Aanmaken" /></th>
							</tr>
						</table>
					</form>
<?php
				}
			}else{
				$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Je hebt al een profiel!</div>';
				header('Location:aanpassen');
			}
		}

		if($url[1] == "aanpassen") {
			if(isset($_POST['wijzigen'])) {
				echo aanpassenProfiel($_POST['naam'],$_POST['achternaam'],$_POST['woonplaats'],$_POST['hobby'],$_POST['website'],$_POST['favo_fansite'],$_POST['favo_kamer'],$_POST['land']);
			}else{
				$sql = mysql_query("SELECT * FROM profiel WHERE member_id='".$_SESSION['id']."'");
				$row = mysql_fetch_assoc($sql);
?>
				<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
					<table class="data">
						<tr>
							<td>Naam</td>
							<td><input type="text" name="naam" value="<?php echo $row['naam']; ?>" maxlength="255" /></td>
						</tr>
						<tr>
							<td>Achternaam</td>
							<td><input type="text" name="achternaam" value="<?php echo $row['achternaam']; ?>" maxlength="255" /></td>
						</tr>
						<tr>
							<td>Woonplaats</td>
							<td><input type="text" name="woonplaats" value="<?php echo $row['woonplaats']; ?>" maxlength="255" /></td>
						</tr>
						<tr>
							<td>Hobby</td>
							<td><input type="text" name="hobby" value="<?php echo $row['hobby']; ?>" maxlength="255" /></td>
						</tr>
						<tr>
							<td>Homepage</td>
							<td><input type="text" name="website" value="<?php echo $row['website']; ?>" maxlength="255" /></td>
						</tr>
						<tr>
							<td>Favoriete Habbo Fansite</td>
							<td><input type="text" name="favo_fansite" value="<?php echo $row['favo_fansite']; ?>" maxlength="255" /></td>
						</tr>
						<tr>
							<td>Favoriete Habbo Kamer</td>
							<td><input type="text" name="favo_kamer" value="<?php echo $row['favo_kamer']; ?>" maxlength="255" /></td>
						</tr>
						<tr>
							<td>Habbo Land</td>
							<td>
								<select name="land">
									<option <?php if($row['land'] == "nl") { echo 'selected="selected"'; } ?> value="nl">Nederland</option>
									<option <?php if($row['land'] == "co.uk") { echo 'selected="selected"'; } ?> value="co.uk">Engeland</option>
									<option <?php if($row['land'] == "com") { echo 'selected="selected"'; } ?> value="com">Amerika</option>
									<option <?php if($row['land'] == "be") { echo 'selected="selected"'; } ?> value="be">Belgie</option>
									<option <?php if($row['land'] == "com.au") { echo 'selected="selected"'; } ?> value="com.au">Australie</option>
									<option <?php if($row['land'] == "ca") { echo 'selected="selected"'; } ?> value="ca">Canada</option>
									<option <?php if($row['land'] == "dk") { echo 'selected="selected"'; } ?> value="dk">Denemarken</option>
									<option <?php if($row['land'] == "de") { echo 'selected="selected"'; } ?> value="de">Duitsland</option>
									<option <?php if($row['land'] == "fi") { echo 'selected="selected"'; } ?> value="fi">Finland</option>
									<option <?php if($row['land'] == "fr") { echo 'selected="selected"'; } ?> value="fr">Frankrijk</option>
									<option <?php if($row['land'] == "it") { echo 'selected="selected"'; } ?> value="it">Italie</option>
									<option <?php if($row['land'] == "jp") { echo 'selected="selected"'; } ?> value="jp">Japan</option>
									<option <?php if($row['land'] == "no") { echo 'selected="selected"'; } ?> value="no">Noorwegen</option>
									<option <?php if($row['land'] == "es") { echo 'selected="selected"'; } ?> value="es">Spanje</option>
									<option <?php if($row['land'] == "se") { echo 'selected="selected"'; } ?> value="se">Zweden</option>
									<option <?php if($row['land'] == "ch") { echo 'selected="selected"'; } ?> value="ch">Zwitserland</option>
								</select>
							</td>
						</tr>
						<tr>
							<th colspan="2"><input type="submit" name="wijzigen" value="Wijzigen" /></th>
						</tr>
					</table>
				</form>
<?php
			}
		}
	
		if($url[1] == "gebruiker") {
			$mid = mysql_real_escape_string(substr($url[2],0,30));
			$sql_bannen = mysql_query("SELECT ip FROM leden WHERE gebruikersnaam='".$mid."'");
			$row_bannen = mysql_fetch_assoc($sql_bannen);
			$sql_ip = mysql_query("SELECT ip FROM ipban WHERE ip = '".$row_bannen['ip']."'");
            $sql_bezoekers = mysql_query("UPDATE leden SET bezoekers = bezoekers + 1 WHERE gebruikersnaam ='".$mid."'");            
			if(mysql_num_rows($sql_ip) != 0) {
				echo "Dit account is helaas verbannen, Omdat de gebruiker de regels heeft overtreden.<br />";
			}else{
				$sql = mysql_query("SELECT * FROM profiel WHERE gebruikersnaam='".$mid."'");
				$sql_leden = mysql_query("SELECT * FROM leden WHERE gebruikersnaam='".$mid."'");
				if(mysql_num_rows($sql) == 1) {
					$row = mysql_fetch_assoc($sql);
					$row_leden = mysql_fetch_assoc($sql_leden);
				if(isset($_SESSION['id'])) {
					if ($url[2] == $row_leden['gebruikersnaam']){
						echo "<a href='".$root."profiel/aanpassen'>Bewerk profiel</a>";
					}
				}
?>
<center>				
<div id="profiel_geel"><?php echo $row_leden['gebruikersnaam']; ?></div>
<div id="profiel_bg" class="profiel_info">
	<p><label>Voornaam:</label><?php echo $row['naam']; ?></p>
	<p><label>Achternaam:</label><?php echo $row['achternaam']; ?></p>
    <p><label>Bezoekers:</label><?php echo $row_leden['bezoekers']; ?></p>
	<p><label>Woonplaats:</label><?php echo $row['woonplaats']; ?></p>
	<p><label>Muntjes:</label><?php echo $row_leden['muntjes']; ?></p>
	<p><label>Hobby:</label><?php echo $row['hobby']; ?></p>
	<p><label>Website:</label><?php echo $row['website']; ?></p>
	<p><label>Favo fansite:</label><?php echo $row['favo_fansite']; ?></p>
	<p><label>Favo kamer:</label><?php echo $row['favo_kamer']; ?></p>
</div>
<div id="profiel_bottom"></div>
</center>

<?php
	if($row['land'] != "") {
		$land = $row['land'];
	}else{
		$land = "nl";
	}
	$habbo = new habboClass($row_leden['gebruikersnaam'],$land);

	if($habbo->normal() == true) {
?>

<center>				
<div id="profiel_geel">Habbo info</div>
<div id="profiel_bg" class="profiel_info">
	<p><label>Online:</label><?php echo $row_leden['gebruikersnaam']; if($habbo->online() == true) { echo " is ingelogd!"; } else { echo " is niet ingelogd."; } ?></p>
	<p><label>Missie:</label><?php if(strlen($habbo->motto()) != "") { echo str_replace('<div class="clear">',' ',$habbo->motto()); }else{ echo'Geen missie gevonden.'; } ?></p>
	<p><label>Habbo sinds:</label><?php if(strlen($habbo->motto()) != "") { echo htmlspecialchars($habbo->birthdate()); }else{ echo'Geen datum gevonden.'; } ?></p>
	<p><label>Badge(s):</label><?php $habbo_badge = $habbo->groupbadge(); if(!empty($habbo_badge)) { echo "<img src=\"".$habbo->groupbadge()."\" alt=\"Habbo Badge\" />"; } ?><?php $habbo_badge = $habbo->badge(); if(!empty($habbo_badge)) { echo "<img src=\"".$habbo->badge()."\" alt=\"Habbo Badge\" />"; } ?></p>
</div>
<div id="profiel_bottom"></div>
</center>

<?php 
	}
	if($winkel == "aan") {	
?>
 
<center>				
<div id="profiel_geel">Mijn badge's</div>
<div id="profiel_bg" class="profiel_info">
<?php 
	$memid = $row_leden['member_id'];
	$sql = mysql_query("SELECT * FROM gekochte_badges WHERE member_id='".$memid."'");
	$sql_speciale = mysql_query("SELECT * FROM speciale_badges_members WHERE member_id='".$memid."'");
	if(mysql_num_rows($sql) >= 1 || mysql_num_rows($sql_speciale) >= 1 ) {
		
		while($row = mysql_fetch_assoc($sql)) {
			$sql_badge = mysql_query("SELECT * FROM shop_badges WHERE badge_id='".$row['badge_id']."'");
			if(mysql_num_rows($sql_badge) >= 1) {
				$row_badge = mysql_fetch_assoc($sql_badge);
				echo "<a href='?p=badges&bid=".$row['badge_id']."'><img border=\"0\" src='".$row_badge['plaatje']."' /></a> ";
	 }
		}
		
		while($row = mysql_fetch_assoc($sql_speciale)) {
			$sql_badge = mysql_query("SELECT * FROM speciale_badges WHERE badge_id='".$row['badge_id']."'");
			if(mysql_num_rows($sql_badge) >= 1) {
				$row_badge = mysql_fetch_assoc($sql_badge);
				echo "<img src='".$row_badge['plaatje']."' /> ";
			}
		}
			
	}
?>
</div>
<div id="profiel_bottom"></div>
</center>


<center>				
<div id="profiel_geel">Mijn meubels</div>
<div id="profiel_bg" class="profiel_info">

<?php
	$sql = mysql_query("SELECT * FROM gekochte_meubi WHERE member_id='".$mid."'");
	if(mysql_num_rows($sql) >= 1) {		
		while($row = mysql_fetch_assoc($sql)) {
			$sql_badge = mysql_query("SELECT * FROM shop_meubi WHERE meubi_id='".$row['meubi_id']."'");
			if(mysql_num_rows($sql_badge) >= 1) {
						
				$row_badge = mysql_fetch_assoc($sql_badge);
				echo "<img border=\"0\" src='".$row_badge['plaatje']."' />";				
			}
		}
	}
?>

</div>
<div id="profiel_bottom"></div>
</center>

<?php 
	}			
	$sql = mysql_query("SELECT grootprofiel FROM profiel WHERE gebruikersnaam='".$mid."'");
	$row = mysql_fetch_assoc($sql);
	if($row['grootprofiel'] != "") {
?>
<center>				
<div id="profiel_geel">Groot profiel</div>
<div id="profiel_bg" class="profiel_info">
<?php echo wordwrap($row['grootprofiel'],40,"\n",1); ?>
</div>
<div id="profiel_bottom"></div>
</center>
<?php	
					}
				}
			}
		}
	}

?>