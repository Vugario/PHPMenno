<?php
if(isset($_SESSION['id'])) {
	$sql = mysql_query("SELECT member_id FROM profiel WHERE member_id='".$_SESSION['id']."'");
	
	echo "<center>";
	echo "<a href='?p=profiel&a=zoeken'>Zoek Profielen</a> | ";
	if(mysql_num_rows($sql) == 0) {
		echo "<a href='?p=profiel&a=aanmaken'>Aanmaken</a> | ";
	}else{
	echo "
		<a href='?p=profiel&a=wijzigen'>Wijzigen</a> | 
		<a href='?p=profiel&a=wijzigen_grootprofiel'>Groot Profiel Wijzigen</a> | 
		<a href='?p=profiel&a=rang'>Rang aanpassen</a> | 
		<a href='?p=profiel&a=avatar'>Avatar aanpassen</a> | 
		<a href='?p=profiel&mid=".$_SESSION['id']."'>Bekijk Mijn Profiel</a> | ";
	}
	echo "</center><br /><br /><br />";
	
	
	
	if(isset($_GET['a'])) {
		if($_GET['a'] == "aanmaken") {
			if(isset($_POST['aanmaken'])) {
				echo $profiel->nieuwProfiel($_POST['naam'],$_POST['achternaam'],$_POST['woonplaats'],$_POST['hobby'],$_POST['website'],$_POST['favo_fansite'],$_POST['favo_kamer'],$_POST['land']);
			}else{
				?>
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=profiel&a=aanmaken" method="post">
					Alle velden zijn niet verplicht in te vullen.
					<table width="300">
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
		}elseif($_GET['a'] == "wijzigen") {
			if(isset($_POST['wijzigen'])) {
				
				echo $profiel->wijzigenProfiel($_POST['naam'],$_POST['achternaam'],$_POST['woonplaats'],$_POST['hobby'],$_POST['website'],$_POST['favo_fansite'],$_POST['favo_kamer'],$_POST['land']);
			}else{
				$sql = mysql_query("SELECT * FROM profiel WHERE member_id='".$_SESSION['id']."'");
				$row = mysql_fetch_assoc($sql);
				?>
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=profiel&a=wijzigen" method="post">
					<table width="300">
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
		}elseif($_GET['a'] == "wijzigen_grootprofiel") {
			if(isset($_POST['wijzigen'])) {
				
				echo $profiel->wijzigGrootprofiel($_POST['grootprofiel']);
			}else{
				$sql = mysql_query("SELECT grootprofiel FROM profiel WHERE member_id='".$_SESSION['id']."'");
				$row = mysql_fetch_assoc($sql);
				?>
				<script language="JavaScript" type="text/javascript" src="wysiwyg/wysiwyg.js"></script>
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=profiel&a=wijzigen_grootprofiel" method="post">
					<table width="300">
						<tr>
							<td><textarea id="grootprofiel" name="grootprofiel" style="background:#FFFFFF;"><?php echo $row['grootprofiel']; ?></textarea></td>
						</tr>
						<tr>
							<th colspan="2"><input type="submit" name="wijzigen" value="Wijzigen" /></th>
						</tr>
					</table>
				</form>
				<script language="javascript1.2">
				generate_wysiwyg('grootprofiel');
				</script>
				<?php
			}
		}elseif($_GET['a'] == "zoeken") {
			include('pagina/zoeken.php');
		}elseif($_GET['a'] == "stemmen") {
			if($instellingen['stemmen'] == "uit") {
				echo "Stemmen staat uit.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
			}else{
				if(isset($_POST['member_id']) && isset($_POST['cijfer'])) {
					if($_POST['member_id'] == $_SESSION['id']) {
						echo "Je kan niet op jezelf stemmen.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
					}else{
						echo $doe->stemmen($_POST['member_id'],$_POST['cijfer']);
					}
				}else{
					echo "De member id of cijfer is niet aanwezig.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
					echo "<br />".$_POST['member_id']."<br />".$_POST['cijfer'];
				}
			}
		}elseif($_GET['a'] == "rang") {
			if(isset($_POST['aanpassen']) && !empty($_POST['rang_id'])) {
				if($_POST['rang_id'] == "habbo") {
					mysql_query("UPDATE leden SET rang='Habbo' WHERE member_id='".$_SESSION['id']."'");
					if(mysql_error() == "") {
						echo "Je rang is succesvol aangepast.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
					}else{
						return mysql_error();
					}
				}else{
					echo $doe->rangAanpassen($_POST['rang_id']);
				}
			}else{
				$sql = mysql_query("SELECT * FROM gekochte_rangen WHERE member_id='".$_SESSION['id']."'");
				if(mysql_num_rows($sql) < 1) {
					echo "Je hebt nog geen rangen gekocht in de shop<br />
					<a href='?p=shop&a=shop'>Koop hier rangen</a>";
				}else{
					?>
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=profiel&a=rang" method="post">
						Pas hier je profiel rank aan.<br />
						Deze rang kan je zien op je profiel pagina.<br /><br />
						<select name="rang_id">
							<option value="habbo">Habbo</option>
							<?php
							while($row = mysql_fetch_assoc($sql)) {
								$sql_rang = mysql_query("SELECT titel FROM shop_rangen WHERE rang_id='".$row['rang_id']."'");
								$row_rang = mysql_fetch_assoc($sql_rang);
								?>
								<option value="<?php echo $row['rang_id']; ?>"><?php echo $row_rang['titel']; ?></option>
								<?php
							}
							?>
						</select><br />
						<br />
						<input type="submit" name="aanpassen" value="Aanpassen" />
					</form>
					<?php
				}
			}
		}elseif($_GET['a'] == "avatar") {
			if(isset($_POST['aanpassen'])) {
			
				$avatar = mysql_real_escape_string($_POST['avatar']);
				list($width, $height, $type, $attr) = getimagesize($avatar);
				if(!empty($width) && !empty($height) && $width <= 100 && $height <= 100) {
					mysql_query("UPDATE leden SET avatar='".$avatar."' WHERE member_id='".$_SESSION['id']."'");
					echo "Je avatar is aangepast.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
				}else{
					echo "Het plaatje is te groot.<br />Hij mag maar 100px bij 100px zijn.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
				}
			}else{
				$sql = mysql_query("SELECT avatar FROM leden WHERE member_id='".$_SESSION['id']."'");
				$row = mysql_fetch_assoc($sql);
				?>
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=profiel&a=avatar" method="post">
					<img src="<?php echo $row['avatar']; ?>" /><br />
					<table width="300">
						<tr>
							<td>Avatar link</td>
							<td><input type="text" name="avatar" style="width:250px;" value="<?php echo $row['avatar']; ?>" /></td>
						</tr>
						<tr>
							<th colspan="2"><input type="submit" name="aanpassen" value="Aanpassen" /></th>
						</tr>
					</table>
				</form>
				<?php
			}
		}
	}elseif(isset($_GET['mid'])) {
		$mid = mysql_real_escape_string(substr($_GET['mid'],0,30));
		$sql_bannen = mysql_query("SELECT ip FROM leden WHERE member_id='".$mid."'");
		$row_bannen = mysql_fetch_assoc($sql_bannen);
		$sql_ip = mysql_query("SELECT ip FROM ipban WHERE ip = '".$row_bannen['ip']."'");
		if(mysql_num_rows($sql_ip) != 0) {
			echo "Dit account is helaas verbannen, Omdat de gebruiker de regels heeft overtreden.<br />";
		}else{
			$sql = mysql_query("SELECT * FROM profiel WHERE member_id='".$mid."'");
			$sql_leden = mysql_query("SELECT * FROM leden WHERE member_id='".$mid."'");
			if(mysql_num_rows($sql) == 1) {
				$row = mysql_fetch_assoc($sql);
				$row_leden = mysql_fetch_assoc($sql_leden);
				?>
				<table>
					<?php if($row['naam'] != "") { ?>
					<tr>
						<td><strong>Naam</strong></td>
						<td><?php echo stripslashes(htmlspecialchars($row['naam'])); ?></td>
					</tr>
					<?php }  if($row['achternaam'] != "") { ?>
					<tr>
						<td><strong>Achternaam</strong></td>
						<td><?php echo stripslashes(htmlspecialchars($row['achternaam'])); ?></td>
					</tr>
					<?php }  if($row['woonplaats'] != "") { ?>
					<tr>
						<td><strong>Woonplaats</strong></td>
						<td><?php echo stripslashes(htmlspecialchars($row['woonplaats'])); ?></td>
					</tr>
					<?php }  if($row['hobby'] != "") { ?>
					<tr>
						<td><strong>Hobby</strong></td>
						<td><?php echo stripslashes(htmlspecialchars($row['hobby'])); ?></td>
					</tr>
					<?php }  if($row['website'] != "") { ?>
					<tr>
						<td><strong>Homepage</strong></td>
						<td><a target="_blank" href='<?php echo stripslashes(htmlspecialchars($row['website'])); ?>'><?php echo stripslashes(htmlspecialchars($row['website'])); ?></a></td>
					</tr>
					<?php }  if($row['favo_fansite'] != "") { ?>
					<tr>
						<td><strong>Favoriete Habbo Fansite</strong></td>
						<td><a target="_blank" href='<?php echo stripslashes(htmlspecialchars($row['favo_fansite'])); ?>'><?php echo stripslashes(htmlspecialchars($row['favo_fansite'])); ?></a></td>
					</tr>
					<?php }  if($row['favo_kamer'] != "") { ?>
					<tr>
						<td><strong>Favoriete Habbo Kamer</strong></td>
						<td><?php echo stripslashes(htmlspecialchars($row['favo_kamer'])); ?></td>
					</tr>
					<?php } ?>
					<tr>
						<td><strong>Gebruikersnaam</strong></td>
						<td><?php echo htmlspecialchars($row_leden['gebruikersnaam']); ?></td>
					</tr>
					<tr>
						<td><strong>Stem Punten</strong></td>
						<td><?php echo htmlspecialchars($row_leden['punten']); ?></td>
					</tr>
					<tr>
						<td><strong>Muntjes</strong></td>
						<td><?php echo htmlspecialchars($row_leden['muntjes']); ?></td>
					</tr>
					<tr>
						<td><strong>Rang</strong></td>
						<td><?php echo htmlspecialchars($row_leden['rang']); ?></td>
					</tr>
					<tr>
						<td><strong>Vrienden</strong></td>
						<td><a href="?p=vriend_toevoegen&vid=<?php echo $_GET['mid'] ?>">Verzoek Sturen</a></td>
					</tr>
				</table><br><br>
	<br />
	
				<?php
				if($instellingen['habbo_gegevens'] == "aan") {
				if($row['land'] != "") {
					$land = $row['land'];
				}else{
					$land = "nl";
				}
				$habbo = new habboClass($row_leden['gebruikersnaam'],$land);
				
				if($habbo->normal() == true) {
					?>
					<table width="300">
						<tr>
							<td width="180"><strong>Habbo Online</strong></td>
							<td width="240"><?php if($habbo->online() == true) { echo "Online"; } else { echo "Offline"; } ?></td>
						</tr>
						<tr>
							<td width="180"><strong>Habbo Missie</strong></td>
							<td width="240"><?php if(strlen($habbo->motto()) != "") { echo htmlspecialchars($habbo->motto()); } ?></td>
						</tr>
						<tr>
							<td width="180"><strong>Habbo Sinds</strong></td>
							<td width="240"><?php echo htmlspecialchars($habbo->birthdate()); ?></td>
						</tr>
						<?php } ?>
						<tr>
							<td width="180"></td>
							<td width="240"><?php
							$habbo_badge = $habbo->badge();
							if(!empty($habbo_badge)) { echo "<img src=\"".$habbo->badge()."\" alt=\"Habbo Badge\" />"; } ?></td>
						</tr>
					</table><br />
					<?php } if($instellingen['avatar_habbo'] == "habbo") { ?>
						<img alt="Habbo" src="http://www.habbo.<?php echo $land; ?>/habbo-imaging/avatarimage?user=<?php echo htmlspecialchars($row_leden['gebruikersnaam']); ?>&action=none&direction=2&head_direction=2&gesture=smile&size=l" />
					<?php } if($instellingen['avatar_habbo'] == "avatar") {
						$sql = mysql_query("SELECT avatar FROM leden WHERE member_id='".$_SESSION['id']."'");
						$row = mysql_fetch_assoc($sql);
						if($row['avatar'] != "") {
							?>
							<img alt="Avatar" src="<?php echo $row['avatar']; ?>" />
							<?php
						}else{
							?>
							<img alt="Avatar" src="images/noavatar.gif" />
							<?php
						}
					}
					?>
	<br />
					<?php
					if($instellingen['stemmen'] == "aan") {
						/////// STEMMEN GEDEELTE /////////
						?>
						<table width="300">
							<tr>
								<td>
									<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=profiel&a=stemmen" method="post">
									<input type="hidden" name="member_id" value="<?php echo $mid; ?>" />
									<input type="submit" name="cijfer" style="background: url('http://habsterdam.nl/Images/stickeys/stikey1.gif'); border: 0px; height: 48px; width: 48px; font-size:0px;" value="1" />
									<input type="submit" name="cijfer" style="background: url('http://habsterdam.nl/Images/stickeys/stikey2.gif'); border: 0px; height: 48px; width: 48px; font-size:0px;" value="2" />
									<input type="submit" name="cijfer" style="background: url('http://habsterdam.nl/Images/stickeys/stikey3.gif'); border: 0px; height: 48px; width: 48px; font-size:0px;" value="3" />
									<input type="submit" name="cijfer" style="background: url('http://habsterdam.nl/Images/stickeys/stikey4.gif'); border: 0px; height: 48px; width: 48px; font-size:0px;" value="4" />
									<input type="submit" name="cijfer" style="background: url('http://habsterdam.nl/Images/stickeys/stikey5.gif'); border: 0px; height: 48px; width: 48px; font-size:0px;" value="5" />
									<input type="submit" name="cijfer" style="background: url('http://habsterdam.nl/Images/stickeys/stikey6.gif'); border: 0px; height: 48px; width: 48px; font-size:0px;" value="6" />
									<input type="submit" name="cijfer" style="background: url('http://habsterdam.nl/Images/stickeys/stikey7.gif'); border: 0px; height: 48px; width: 48px; font-size:0px;" value="7" />
									<input type="submit" name="cijfer" style="background: url('http://habsterdam.nl/Images/stickeys/stikey8.gif'); border: 0px; height: 48px; width: 48px; font-size:0px;" value="8" />
									<input type="submit" name="cijfer" style="background: url('http://habsterdam.nl/Images/stickeys/stikey9.gif'); border: 0px; height: 48px; width: 48px; font-size:0px;" value="9" />
									<input type="submit" name="cijfer" style="background: url('http://habsterdam.nl/Images/stickeys/stikey10.gif'); border: 0px; height: 48px; width: 48px; font-size:0px;" value="10" />
									</form>
								</td>
							</tr>
						</table>
						<?php
						///////// EINDE STEMMEN GEDEELTE //////////
					}
					?>
	<br />
	<?php 				if($instellingen['shop'] == "aan") { ?>
	
					<?php
						//////// 	BADGES GEDEELTE //////
						
						$sql = mysql_query("SELECT * FROM gekochte_badges WHERE member_id='".$mid."'");
						$sql_speciale = mysql_query("SELECT * FROM speciale_badges_members WHERE member_id='".$mid."'");
						if(mysql_num_rows($sql) >= 1 || mysql_num_rows($sql_speciale) >= 1) {
							echo "<strong>Badges</strong><br />";
							
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
						echo "<br /><br />";
						///////// EINDE BADGES GEDEELTE /////////
					?>
					
					<?php
					if($instellingen['meubi'] == "aan") {
						//////// 	MEUBI GEDEELTE //////
						
						$sql = mysql_query("SELECT * FROM gekochte_meubi WHERE member_id='".$mid."'");
						if(mysql_num_rows($sql) >= 1) {
							echo "<br /><br /><strong>Meubels</strong><br />";
							
							while($row = mysql_fetch_assoc($sql)) {
								$sql_badge = mysql_query("SELECT * FROM shop_meubi WHERE meubi_id='".$row['meubi_id']."'");
								if(mysql_num_rows($sql_badge) >= 1) {
									$row_badge = mysql_fetch_assoc($sql_badge);
									echo "<img border=\"0\" src='".$row_badge['plaatje']."' />";
								}
							}
						}
						///////// EINDE MEUBI GEDEELTE /////////
					}
					?>
	
	<?php } if($instellingen['gastenboek'] == "aan") { ?>
	
					<?php
						function br2nl($tekst) {
							$tekst = str_replace("<br>","\n",$tekst);
							return $tekst;
						}
						//////////// GASTENBOEK //////////////////
					$sql_gastenboek = mysql_query("SELECT * FROM gastenboek WHERE member_id='".$mid."'");
					if(mysql_num_rows($sql_gastenboek) == 1) {
						echo "<strong>Gastenboek</strong>";
						$row_gastenboek = mysql_fetch_assoc($sql_gastenboek);
						$sql_berichten = mysql_query("SELECT * FROM gastenboek_berichten WHERE gastenboek_id='".$row_gastenboek['gastenboek_id']."' ORDER BY datum DESC LIMIT 4");
						echo '<table width="300">';
						while($row_berichten = mysql_fetch_assoc($sql_berichten)) {
							?>
								<tr>
									<td valign="top" rowspan="5">
									<?php
									if($row_berichten['habbonaam'] == "Systeem") {
										echo "<img src='https://www.habbo.nl/deliver/images.habbohotel.nl/c_images/album1358/frank_thumbup.gif?h=3bf5998d019ae5e63b3eec53a20bc20f' align='left' />";
									}else{
										echo '<img src="http://www.habbo.nl/habbo-imaging/avatarimage?user='.htmlspecialchars($row_berichten['habbonaam']).'&action=hallo&frame=1&direction=4&head_direction=3&gesture=smile&size=b&img_format=gif" align="left" />';
									}
									?></td>
								</tr>
								<tr>
									<td><strong>Habbonaam</strong></td>
								</tr>
								<tr>
									<td valign="top"><?php echo htmlspecialchars($row_berichten['habbonaam']); ?></td>
								</tr>
								<tr>
									<td colspan="2"><strong>Bericht</strong></td>
								</tr>
								<tr>
									<td colspan="2" valign="top"><?php echo htmlspecialchars(wordwrap(br2nl($row_berichten['bericht'],60,"\n",1))); ?></td>
								</tr>
								<tr>
									<td colspan="2"><hr /></td>
								</tr>
							<?php
						}
						echo "</table>";
						if(mysql_num_rows($sql_berichten) == 0) {
							echo "Er staan geen berichten in dit gastenboek.";
						}
						?>
						<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=gastenboek&a=posten" method="post">
							<input type="hidden" name="gastenboek_id" value="<?php echo $row_gastenboek['gastenboek_id']; ?>" />
							<table width="300">
								<tr>
									<td>Bericht</td>
									<td><textarea name="bericht" style="width:160px; height:100px;"></textarea></td>
								</tr>
								<tr>
									<th colspan="2"><input type="submit" name="posten" value="Posten" /></th>
								</tr>
							</table>
						</form>
					<?php
					}
					//// EINDE GASTENBOEK GEDEELTE ////
				?>
	
	<?php } if($instellingen['poll'] == "aan") { ?>
				<?php
				
					//////////////// POLL //////////////////////////
					$mid = mysql_real_escape_string(substr($_GET['mid'],0,30));
					$sql_poll = mysql_query("SELECT * FROM poll WHERE member_id='".$mid."'")or die (mysql_error());
					if(mysql_num_rows($sql_poll) == 1) {
						echo "<strong>Poll</strong>";
						$row_poll = mysql_fetch_assoc($sql_poll);
						$sql_ip = mysql_query("SELECT * FROM poll_ip WHERE ip='".$_SERVER['REMOTE_ADDR']."' AND poll_id='".$row_poll['poll_id']."'");
						if(mysql_num_rows($sql_ip) == 0) {
							?>
							<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=poll&a=stemmen" method="post">
								<input type="hidden" name="poll_id" value="<?php echo $row_poll['poll_id']; ?>" />
								<table width="300">
									<tr>
										<td colspan="2">Vraag : <strong><?php echo stripslashes(htmlspecialchars($row_poll['vraag'])); ?></strong></td>
									</tr>
									<tr>
										<td width="4%"><input type="radio" name="ant" value="aantal1" /></td>
										<td><?php echo stripslashes(htmlspecialchars($row_poll['ant1'])); ?></td>
									</tr>
									<tr>
										<td><input type="radio" name="ant" value="aantal2" /></td>
										<td><?php echo stripslashes(htmlspecialchars($row_poll['ant2'])); ?></td>
									</tr>
									<tr>
										<td><input type="radio" name="ant" value="aantal3" /></td>
										<td><?php echo stripslashes(htmlspecialchars($row_poll['ant3'])); ?></td>
									</tr>
									<tr>
										<td><input type="radio" name="ant" value="aantal4" /></td>
										<td><?php echo stripslashes(htmlspecialchars($row_poll['ant4'])); ?></td>
									</tr>
									<tr>
										<th colspan="2"><input type="submit" name="stemmen" value="Stemmen" /></th>
									</tr>
								</table>
							</form>
							<?php
						}else{
							?>
							<table width="300">
								<tr>
									<td colspan="2"><?php echo stripslashes(htmlspecialchars($row_poll['vraag'])); ?></td>
								</tr>
								<tr>
									<td width="70%"><?php echo $row_poll['ant1']; ?></td>
									<td><?php echo stripslashes(htmlspecialchars($row_poll['aantal1'])); ?>X gestemd</td>
								</tr>
								<tr>
									<td width="70%"><?php echo $row_poll['ant2']; ?></td>
									<td><?php echo stripslashes(htmlspecialchars($row_poll['aantal2'])); ?>X gestemd</td>
								</tr>
								<tr>
									<td width="70%"><?php echo $row_poll['ant3']; ?></td>
									<td><?php echo stripslashes(htmlspecialchars($row_poll['aantal3'])); ?>X gestemd</td>
								</tr>
								<tr>
									<td width="70%"><?php echo $row_poll['ant4']; ?></td>
									<td><?php echo stripslashes(htmlspecialchars($row_poll['aantal4'])); ?>X gestemd</td>
								</tr>
							</table>
							<?php
						}
					//// EINDE POLL GEDEELTE ////
					?>
	
	<?php } ?>
	<?php
					
					/// Begin van vrienden gedeelte ////
					$sql_vrienden = mysql_query("SELECT * FROM vrienden WHERE member_id='".$mid."' AND actief='actief'");
					$sql_vv = mysql_query("SELECT * FROM vrienden WHERE member_id='".$mid."' AND actief='dood'");
					
					echo "<h3 style='margin: 0px;'>Vrienden</h3>";
					echo "<table width='200'>";
					while($row_vrienden = mysql_fetch_assoc($sql_vrienden)) {
						$row_vrienden_naam = mysql_fetch_assoc(mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id='".$row_vrienden['vriend_id']."'"));
						echo "
							<tr>
								<td><a href='?p=profiel&mid=".$row_vrienden['vriend_id']."'>".stripslashes(htmlspecialchars($row_vrienden_naam['gebruikersnaam']))."</a></td>
							</tr>";
					}
					echo "</table>";
					if(mysql_num_rows($sql_vrienden) == 0) {
						echo "Deze gebruiker heeft nog geen vrienden.<br />";
					}
					
					echo "<h3 style='margin: 0px;'>Vrienden Verzoeken</h3>";
					echo "<table width='200'>";
					while($row_vv = mysql_fetch_assoc($sql_vv)) {
						$row_vv_naam = mysql_fetch_assoc(mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id='".$row_vv['vriend_id']."'"));
						echo "
							<tr>
								<td><a href='?p=profiel&mid=".$row_vv['vriend_id']."'>".stripslashes(htmlspecialchars($row_vv_naam['gebruikersnaam']))."</a></td>
							</tr>";
					}
					echo "</table>";
					if(mysql_num_rows($sql_vv) == 0) {
						echo "Deze gebruiker heeft nog geen vrienden verzoeken.<br />";
					}
					/// Einde van vrienden gedeelte ///
				} 
				$sql = mysql_query("SELECT grootprofiel FROM profiel WHERE member_id='".$mid."'");
				$row = mysql_fetch_assoc($sql);
				if($row['grootprofiel'] != "") {
					echo "<strong>Grootprofiel</strong><br>
					".wordwrap($row['grootprofiel'],40,"\n",1);
				}
			}else{
				echo "Dit persoon heeft geen profiel gemaakt.";
			}
		}
	}else{
		echo "Selecteer een optie in het submenu hierboven.";
	}
}else{
	echo "Je bent helemaal niet ingelogd.<br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
}
?>
