<?php

if(isset($_SESSION['admin'])) {
	echo "
		<a href='?p=admin_shop&a=badge&s=toevoegen'>Badge Toevoegen</a> | 
		<a href='?p=admin_shop&a=rang&s=lijst'>Badge/Rangen/Meubi's Wijzigen</a> | 
		<a href='?p=admin_shop&a=meubi&s=toevoegen'>Meubi Toevoegen</a> | 
		<a href='?p=admin_shop&a=rang&s=toevoegen'>Rang Toevoegen</a> | 
		<br><br><br>";
	if(isset($_GET['a'])) {
		if($_GET['a'] == "badge") {
			if($_GET['s'] == "toevoegen") {
				if(isset($_POST['toevoegen']) && !empty($_POST['titel']) && !empty($_POST['beschrijving']) && !empty($_POST['langebeschrijving']) && !empty($_POST['prijs'])) {		
					copy($_FILES['file']['tmp_name'], "uploads/shopbadges/" . $_FILES['file']['name']) or die("Er is iets fout gegaan tijdens het uploaden van het plaatje.");
					$plaatje = "uploads/shopbadges/" . $_FILES['file']['name'];
					echo $shop->badgeToevoegen($_POST['titel'],$_POST['beschrijving'],$_POST['langebeschrijving'],$plaatje,$_POST['prijs']);
					
				}else{
					?>
					<form action="<?= $_SERVER['PHP_SELF'] ?>?p=admin_shop&a=badge&s=toevoegen" enctype="multipart/form-data" method="post">
						<table width="300">
							<tr>
								<td>Titel van badge</td>
								<td><input type="text" name="titel" maxlength="255" /></td>
							</tr>
							<tr>
								<td>Beschrijving van 10 woorden</td>
								<td><input type="text" name="beschrijving" maxlength="255" /></td>
							</tr>
							<tr>
								<td>Lange Beschrijving</td>
								<td><textarea name="langebeschrijving" style="width:200px; height:200px;"></textarea></td>
							</tr>
							<tr>
								<td>URL : Plaatje van badge</td>
								<td><input type="file" name="file" /></td>
							</tr>
							<tr>
								<td>Prijs</td>
								<td><input type="text" name="prijs" style="width:30px;" maxlength="10" /></td>
							</tr>
							<tr>
								<th colspan="2"><input type="submit" name="toevoegen" value="Toevoegen"></th>
							</tr>
						</table>
					</form>
					<?php
				}
			}elseif($_GET['s'] == "wijzigen") {
				if(isset($_POST['wijzigen']) && !empty($_POST['badge_id']) && !empty($_POST['titel']) && !empty($_POST['beschrijving']) && !empty($_POST['langebeschrijving']) && !empty($_POST['prijs'])) {
				
					echo $shop->badgeWijzigen($_POST['badge_id'],$_POST['titel'],$_POST['beschrijving'],$_POST['langebeschrijving'],$_POST['plaatje'],$_POST['prijs']);
					
				}else{
					$sql = mysql_query("SELECT * FROM shop_badges WHERE badge_id='".$_POST['badge_id']."'");
					$row = mysql_fetch_assoc($sql);
					?>
					<form action="<?= $_SERVER['PHP_SELF'] ?>?p=admin_shop&a=badge&s=wijzigen" method="post">
						<input type="hidden" name="badge_id" value="<?= $_POST['badge_id'] ?>">
						<table width="300">
							<tr>
								<td>Titel van badge</td>
								<td><input type="text" name="titel" value="<?= $row['titel'] ?>" maxlength="255" /></td>
							</tr>
							<tr>
								<td>Beschrijving van 10 woorden</td>
								<td><input type="text" name="beschrijving" value="<?= $row['beschrijving'] ?>" maxlength="255" /></td>
							</tr>
							<tr>
								<td>Lange Beschrijving</td>
								<td><textarea name="langebeschrijving" style="width:200px; height:200px;"><?= $row['langebeschrijving'] ?></textarea></td>
							</tr>
							<tr>
								<td>URL : Plaatje van badge</td>
								<td><input type="text" style="width:400px;" name="plaatje" value="<?= $row['plaatje'] ?>" /></td>
							</tr>
							<tr>
								<td>Prijs</td>
								<td><input type="text" name="prijs" value="<?= $row['prijs'] ?>" style="width:30px;" maxlength="10" /></td>
							</tr>
							<tr>
								<th colspan="2"><input type="submit" name="wijzigen" value="Wijzigen"></th>
							</tr>
						</table>
					</form>
					<?
				}
			}elseif($_GET['s'] == "verwijderen") {
				if(isset($_POST['JAverwijderen']) && isset($_POST['badge_id'])) {
					echo $shop->badgeVerwijderen($_POST['badge_id']);
				}else{
					?>
					<form action="<?= $_SERVER['PHP_SELF'] ?>?p=admin_shop&a=badge&s=verwijderen" method="post">
						<input type="hidden" name="badge_id" value="<?= $_POST['badge_id'] ?>">
						Weet je zeker dat je hem wilt verwijderen?<br>
						<input type="submit" name="JAverwijderen" value="JA, verwijderen">
					</form>
					<?
				}
			}elseif($_GET['s'] == "uitzetten") {
				echo $shop->badgeUitzetten($_POST['badge_id']);				
			}elseif($_GET['s'] == "aanzetten") {
				echo $shop->badgeAanzetten($_POST['badge_id']);
			}
		}elseif($_GET['a'] == "meubi") {
			/////////////// MEUBI GEDEELTE //////////////////
			if($_GET['s'] == "toevoegen") {
				if(isset($_POST['toevoegen']) && !empty($_POST['titel']) && !empty($_POST['beschrijving']) && !empty($_POST['langebeschrijving']) && !empty($_POST['prijs'])) {		
					copy($_FILES['file']['tmp_name'], "uploads/shopbadges/" . $_FILES['file']['name']) or die("Er is iets fout gegaan tijdens het uploaden van het plaatje.");
					$plaatje = "uploads/shopbadges/" . $_FILES['file']['name'];
					echo $shop->meubiToevoegen($_POST['titel'],$_POST['beschrijving'],$_POST['langebeschrijving'],$plaatje,$_POST['prijs']);
					
				}else{
					?>
					<form action="<?= $_SERVER['PHP_SELF'] ?>?p=admin_shop&a=meubi&s=toevoegen" enctype="multipart/form-data" method="post">
						<table width="300">
							<tr>
								<td>Titel van meubi</td>
								<td><input type="text" name="titel" maxlength="255" /></td>
							</tr>
							<tr>
								<td>Beschrijving van 10 woorden</td>
								<td><input type="text" name="beschrijving" maxlength="255" /></td>
							</tr>
							<tr>
								<td>Lange Beschrijving</td>
								<td><textarea name="langebeschrijving" style="width:200px; height:200px;"></textarea></td>
							</tr>
							<tr>
								<td>URL : Plaatje van meubi</td>
								<td><input type="file" name="file" /></td>
							</tr>
							<tr>
								<td>Prijs</td>
								<td><input type="text" name="prijs" style="width:30px;" maxlength="10" /></td>
							</tr>
							<tr>
								<th colspan="2"><input type="submit" name="toevoegen" value="Toevoegen"></th>
							</tr>
						</table>
					</form>
					<?php
				}
			}elseif($_GET['s'] == "wijzigen") {
				if(isset($_POST['wijzigen']) && !empty($_POST['meubi_id']) && !empty($_POST['titel']) && !empty($_POST['beschrijving']) && !empty($_POST['langebeschrijving']) && !empty($_POST['prijs'])) {
				
					echo $shop->meubiWijzigen($_POST['meubi_id'],$_POST['titel'],$_POST['beschrijving'],$_POST['langebeschrijving'],$_POST['plaatje'],$_POST['prijs']);
					
				}else{
					$sql = mysql_query("SELECT * FROM shop_meubi WHERE meubi_id='".$_POST['meubi_id']."'");
					$row = mysql_fetch_assoc($sql);
					?>
					<form action="<?= $_SERVER['PHP_SELF'] ?>?p=admin_shop&a=meubi&s=wijzigen" method="post">
						<input type="hidden" name="meubi_id" value="<?= $_POST['meubi_id'] ?>">
						<table width="300">
							<tr>
								<td>Titel van meubi</td>
								<td><input type="text" name="titel" value="<?= $row['titel'] ?>" maxlength="255" /></td>
							</tr>
							<tr>
								<td>Beschrijving van 10 woorden</td>
								<td><input type="text" name="beschrijving" value="<?= $row['beschrijving'] ?>" maxlength="255" /></td>
							</tr>
							<tr>
								<td>Lange Beschrijving</td>
								<td><textarea name="langebeschrijving" style="width:200px; height:200px;"><?= $row['langebeschrijving'] ?></textarea></td>
							</tr>
							<tr>
								<td>URL : Plaatje van meubi</td>
								<td><input type="text" style="width:400px;" name="plaatje" value="<?= $row['plaatje'] ?>" /></td>
							</tr>
							<tr>
								<td>Prijs</td>
								<td><input type="text" name="prijs" value="<?= $row['prijs'] ?>" style="width:30px;" maxlength="10" /></td>
							</tr>
							<tr>
								<th colspan="2"><input type="submit" name="wijzigen" value="Wijzigen"></th>
							</tr>
						</table>
					</form>
					<?
				}
			}elseif($_GET['s'] == "verwijderen") {
				if(isset($_POST['JAverwijderen']) && isset($_POST['meubi_id'])) {
					echo $shop->meubiVerwijderen($_POST['meubi_id']);
				}else{
					?>
					<form action="<?= $_SERVER['PHP_SELF'] ?>?p=admin_shop&a=meubi&s=verwijderen" method="post">
						<input type="hidden" name="meubi_id" value="<?= $_POST['meubi_id'] ?>">
						Weet je zeker dat je hem wilt verwijderen?<br>
						<input type="submit" name="JAverwijderen" value="JA, verwijderen">
					</form>
					<?
				}
			}elseif($_GET['s'] == "uitzetten") {
				echo $shop->meubiUitzetten($_POST['meubi_id']);				
			}elseif($_GET['s'] == "aanzetten") {
				echo $shop->meubiAanzetten($_POST['meubi_id']);
			}
		}elseif($_GET['a'] == "rang") {
			////////////////// RANGEN GEDEELTE //////////////////
			if(isset($_GET['s'])) {
				if($_GET['s'] == "toevoegen") {
					if(isset($_POST['toevoegen']) && !empty($_POST['titel']) && !empty($_POST['beschrijving']) && !empty($_POST['prijs'])) {
						
						echo $shop->rangToevoegen($_POST['titel'],$_POST['prijs'],$_POST['beschrijving']);
					}else{
						?>
						<form action="<?= $_SERVER['PHP_SELF'] ?>?p=admin_shop&a=rang&s=toevoegen" method="post">
							<input type="hidden" name="rang_id" value="<?= $_POST['rang_id'] ?>">
							<table width="300">
								<tr>
									<td>Titel van rang</td>
									<td><input type="text" name="titel" maxlength="255" /></td>
								</tr>
								<tr>
									<td>Beschrijving</td>
									<td><input type="text" name="beschrijving" maxlength="255" /></td>
								</tr>
								<tr>
									<td>Prijs</td>
									<td><input type="text" name="prijs" style="width:30px;" maxlength="10" /></td>
								</tr>
								<tr>
									<th colspan="2"><input type="submit" name="toevoegen" value="Toevoegen"></th>
								</tr>
							</table>
						</form>
						<?
					}
				}elseif($_GET['s'] == "wijzigen") {
					if(isset($_POST['wijzigen']) && !empty($_POST['rang_id']) && !empty($_POST['titel']) && !empty($_POST['beschrijving']) && !empty($_POST['prijs'])) {
					
						echo $shop->rangWijzigen($_POST['rang_id'],$_POST['beschrijving'],$_POST['titel'],$_POST['prijs']);
						
					}else{
						$sql = mysql_query("SELECT * FROM shop_rangen WHERE rang_id='".$_POST['rang_id']."'");
						$row = mysql_fetch_assoc($sql);
						?>
						<form action="<?= $_SERVER['PHP_SELF'] ?>?p=admin_shop&a=rang&s=wijzigen" method="post">
							<input type="hidden" name="rang_id" value="<?php echo $_POST['rang_id'] ?>" />
							<table width="300">
								<tr>
									<td>Titel van rang</td>
									<td><input type="text" name="titel" value="<?= $row['titel'] ?>" maxlength="255" /></td>
								</tr>
								<tr>
									<td>Beschrijving van 10 woorden</td>
									<td><input type="text" name="beschrijving" value="<?= $row['beschrijving'] ?>" maxlength="255" /></td>
								</tr>
								<tr>
									<td>Plaatje van badge</td>
									<td><input type="file" name="userfile" value="<?= $row['plaatje'] ?>" /></td>
								</tr>
								<tr>
									<td>Prijs</td>
									<td><input type="text" name="prijs" value="<?= $row['prijs'] ?>" style="width:30px;" maxlength="10" /></td>
								</tr>
								<tr>
									<th colspan="2"><input type="submit" name="wijzigen" value="Wijzigen"></th>
								</tr>
							</table>
						</form>
						<?
					}
				}elseif($_GET['s'] == "lijst") {
					$sql = mysql_query("SELECT * FROM shop_badges");
					echo "
						<table>
							<tr>
								<td><strong>Plaatje</strong></td>
								<td><strong>Titel</strong></td>
								<td><strong>Beschrijving</strong></td>
								<td><strong>Wijzigen</strong></td>
							</tr>
							<tr>
								<th>Badges</th>
							</tr>";
					while($row_badges = mysql_fetch_assoc($sql)) {
						?>
						<tr>
							<td><img src="<?= $row_badges['plaatje'] ?>"></td>
							<td><strong><?= $row_badges['titel'] ?></strong></td>
							<td><?= $row_badges['beschrijving'] ?></td>
							<td>
								<form action="<?= $_SERVER['PHP_SELF'] ?>?p=admin_shop&a=badge&s=wijzigen" method="post">
									<input type="hidden" name="badge_id" value="<?= $row_badges['badge_id'] ?>">
									<input type="submit" value="Wijzigen" name="wijzigen">
								</form>
								<form action="<?= $_SERVER['PHP_SELF'] ?>?p=admin_shop&a=badge&s=verwijderen" method="post">
									<input type="hidden" name="badge_id" value="<?= $row_badges['badge_id'] ?>">
									<input type="submit" value="verwijderen" name="verwijderen">
								</form>
								<?php
								if($row_badges['actief'] == "aan") {
								
									?>
									<form action="<?= $_SERVER['PHP_SELF'] ?>?p=admin_shop&a=badge&s=uitzetten" method="post">
										<input type="hidden" name="badge_id" value="<?= $row_badges['badge_id'] ?>">
										<input type="submit" value="Uitzetten" name="uitzetten">
									</form>
									
									<?php
								}elseif($row_badges['actief'] == "uit") {
								
									?>
									<form action="<?= $_SERVER['PHP_SELF'] ?>?p=admin_shop&a=badge&s=aanzetten" method="post">
										<input type="hidden" name="badge_id" value="<?= $row_badges['badge_id'] ?>">
										<input type="submit" value="Aanzetten" name="aanzetten">
									</form>
									
									<?php
								}
								?>
							</td>
						</tr>
						<?
					}
					$sql = mysql_query("SELECT * FROM shop_rangen");
						echo "
						<tr>
							<th>Rangen</th>
						</tr>";
					while($row_rangen = mysql_fetch_assoc($sql)) {
						?>
						<tr>
							<td></td>
							<td><strong><?= $row_rangen['titel'] ?></strong></td>
							<td><?= $row_rangen['beschrijving'] ?></td>
							<td>
								<form action="<?= $_SERVER['PHP_SELF'] ?>?p=admin_shop&a=rang&s=wijzigen" method="post">
									<input type="hidden" name="rang_id" value="<?= $row_rangen['rang_id'] ?>">
									<input type="submit" value="Wijzigen" name="wijzigen">
								</form>
								<form action="<?= $_SERVER['PHP_SELF'] ?>?p=admin_shop&a=rang&s=verwijderen" method="post">
									<input type="hidden" name="rang_id" value="<?= $row_rangen['rang_id'] ?>">
									<input type="submit" value="verwijderen" name="verwijderen">
								</form>
								<?php
								if($row_rangen['actief'] == "aan") {
								
									?>
									<form action="<?= $_SERVER['PHP_SELF'] ?>?p=admin_shop&a=rang&s=uitzetten" method="post">
										<input type="hidden" name="rang_id" value="<?= $row_rangen['rang_id'] ?>">
										<input type="submit" value="Uitzetten" name="uitzetten">
									</form>
									
									<?php
								}elseif($row_rangen['actief'] == "uit") {
								
									?>
									<form action="<?= $_SERVER['PHP_SELF'] ?>?p=admin_shop&a=rang&s=aanzetten" method="post">
										<input type="hidden" name="rang_id" value="<?= $row_rangen['rang_id'] ?>">
										<input type="submit" value="Aanzetten" name="aanzetten">
									</form>
									
									<?php
								}
								?>
							</td>
						</tr>
						<?
					}
					$sql = mysql_query("SELECT * FROM shop_meubi");
						echo "
						<tr>
							<th><strong>Meubi's</strong></th>
						</tr>";
					while($row_rangen = mysql_fetch_assoc($sql)) {
						?>
						<tr>
							<td><img src="<?= $row_rangen['plaatje'] ?>"></td>
							<td><strong><?= $row_rangen['titel'] ?></strong></td>
							<td><?= $row_rangen['beschrijving'] ?></td>
							<td>
								<form action="<?= $_SERVER['PHP_SELF'] ?>?p=admin_shop&a=meubi&s=wijzigen" method="post">
									<input type="hidden" name="meubi_id" value="<?= $row_rangen['meubi_id'] ?>">
									<input type="submit" value="Wijzigen" name="wijzigen">
								</form>
								<form action="<?= $_SERVER['PHP_SELF'] ?>?p=admin_shop&a=meubi&s=verwijderen" method="post">
									<input type="hidden" name="meubi_id" value="<?= $row_rangen['meubi_id'] ?>">
									<input type="submit" value="verwijderen" name="verwijderen">
								</form>
								<?php
								if($row_rangen['actief'] == "aan") {
								
									?>
									<form action="<?= $_SERVER['PHP_SELF'] ?>?p=admin_shop&a=meubi&s=uitzetten" method="post">
										<input type="hidden" name="meubi_id" value="<?= $row_rangen['meubi_id'] ?>">
										<input type="submit" value="Uitzetten" name="uitzetten">
									</form>
									
									<?php
								}elseif($row_rangen['actief'] == "uit") {
								
									?>
									<form action="<?= $_SERVER['PHP_SELF'] ?>?p=admin_shop&a=meubi&s=aanzetten" method="post">
										<input type="hidden" name="meubi_id" value="<?= $row_rangen['meubi_id'] ?>">
										<input type="submit" value="Aanzetten" name="aanzetten">
									</form>
									
									<?php
								}
								?>
							</td>
						</tr>
						<?
					}
					echo "</table>";

				}elseif($_GET['s'] == "verwijderen") {
					if(isset($_POST['JAverwijderen']) && isset($_POST['rang_id'])) {
						echo $shop->rangVerwijderen($_POST['rang_id']);
					}else{
						?>
						<form action="<?= $_SERVER['PHP_SELF'] ?>?p=admin_shop&a=rang&s=verwijderen" method="post">
							<input type="hidden" name="rang_id" value="<?= $_POST['rang_id'] ?>">
							Weet je zeker dat je hem wilt verwijderen?<br>
							<input type="submit" name="JAverwijderen" value="JA, verwijderen">
						</form>
						<?
					}
				}elseif($_GET['s'] == "uitzetten") {
					echo $shop->rangUitzetten($_POST['rang_id']);				
				}elseif($_GET['s'] == "aanzetten") {
					echo $shop->rangAanzetten($_POST['rang_id']);
				}else{
					echo "De s opdracht is niet bekend.";
				}
			}else{
				echo "Er is geen s opdracht.";
			}
		}else{
			echo "actie is niet bekend.";
		}
	}else{
		echo "Er is geen actie opgegeven.";
	}
}else{
	echo "je bent geen admin";
}
?>