<?php

if(isset($_SESSION['admin'])) {
	echo "
		<a href='?p=admin_banners&a=banner&s=toevoegen'>Banner Toevoegen</a> | 
		<a href='?p=admin_banners&a=banner&s=lijst'>Banners Wijzigen</a> | 
		<br><br><br>";
	if(isset($_GET['a'])) {
		if($_GET['a'] == "banner") {
			if($_GET['s'] == "toevoegen") {
						if(isset($_POST['toevoegen']) && !empty($_POST['bannerurl']) && !empty($_POST['url'])) {
		mysql_query("INSERT INTO banners (banner,url) VALUES ('".$_POST['bannerurl']."','".$_POST['url']."')");
		echo "Succesvol toegevoegd!";
					
				}else{
					?>
					 	<form enctype="multipart/form-data" method="post">
						<table width="300">
							<tr>
								<td>Url van het banner-plaatje</td>
								<td><input type="text" name="bannerurl" maxlength="255" /></td>
							</tr>
							<tr>
								<td>Url van het banner-url</td>
								<td><input type="text" name="url" maxlength="255" /></td>
							</tr>
							<tr>
								<th colspan="2"><input type="submit" name="toevoegen" value="Toevoegen"></th>
							</tr>
						</table>
					</form>
					<?php
				}
			}elseif($_GET['s'] == "wijzigen") {
		if(isset($_POST['wijzigen']) && isset($_POST['bannerurl'])) {
				mysql_query("UPDATE banners SET banner='".$_POST['bannerurl']."',url='".$_POST['url']."'");
				echo "Succesvol gewijzigd!";
				}else{
					$sql = mysql_query("SELECT * FROM banners WHERE banner_id='".$_POST['banner_id']."'");
					$row = mysql_fetch_assoc($sql);
					?>
					 	<form enctype="multipart/form-data" method="post">
						<table width="300">
							<tr>
								<td>Url van het banner-plaatje</td>
								<td><input type="text" name="bannerurl" maxlength="255" value="<?php echo "".$row['banner'].""; ?>" /></td>
							</tr>
							<tr>
								<td>Url van het banner-url</td>
								<td><input type="text" name="url" maxlength="255" value="<?php echo "".$row['url'].""; ?>" /></td>
							</tr>
							<tr>
								<th colspan="2"><input type="submit" name="wijzigen" value="Wijzigen"></th>
							</tr>
						
					</form>
				</table>
					<?
				}
			}elseif($_GET['s'] == "verwijderen") {
				if(isset($_POST['JAverwijderen']) && isset($_POST['banner_id'])) {
					mysql_query("DELETE FROM banners WHERE banner_id='".$_POST['banner_id']."'");
				echo "Succesvol verwijderd!";
				}else{
					?>
					<form method="post">
						<input type="hidden" name="banner_id" value="<?= $_POST['banner_id'] ?>">
						Weet je zeker dat je hem wilt verwijderen?<br>
						<input type="submit" name="JAverwijderen" value="JA, verwijderen">
					</form>
					<?
				}
			}elseif($_GET['s'] == "uitzetten") {
				mysql_query("UPDATE banners SET actief='uit' WHERE banner_id='".$_POST['banner_id']."'");
echo "Uitgezet!";				
			}elseif($_GET['s'] == "aanzetten") {
				mysql_query("UPDATE banners SET actief='aan' WHERE banner_id='".$_POST['banner_id']."'");
				echo "Aangezet!";
				}elseif($_GET['s'] == "lijst") {
					$sql = mysql_query("SELECT * FROM banners");
					echo "
						<table>
							<tr>
								<td><strong>Bannerplaatje-url</strong></td>
								<td><strong>Banner-url</strong></td>
								<td><strong>Wijzigen</strong></td>
							</tr>";
					while($row_badges = mysql_fetch_assoc($sql)) {
						?>
						<tr>
							<td><strong><?= $row_badges['banner'] ?></strong></td>
							<td><strong><?= $row_badges['url'] ?></strong></td>
							<td>
								<form action="<?= $_SERVER['PHP_SELF'] ?>?p=admin_banners&a=banner&s=wijzigen" method="post">
									<input type="hidden" name="banner_id" value="<?= $row_badges['banner_id'] ?>">
									<input type="submit" value="Wijzigen" name="wijzigen">
								</form>
								<form action="<?= $_SERVER['PHP_SELF'] ?>?p=admin_banners&a=banner&s=verwijderen" method="post">
									<input type="hidden" name="banner_id" value="<?= $row_badges['banner_id'] ?>">
									<input type="submit" value="verwijderen" name="verwijderen">
								</form>
								<?php
								if($row_badges['actief'] == "aan") {
								
									?>
									<form action="<?= $_SERVER['PHP_SELF'] ?>?p=admin_banners&a=banner&s=uitzetten" method="post">
										<input type="hidden" name="banner_id" value="<?= $row_badges['banner_id'] ?>">
										<input type="submit" value="Uitzetten" name="uitzetten">
									</form>
									
									<?php
								}elseif($row_badges['actief'] == "uit") {
								
									?>
									<form action="<?= $_SERVER['PHP_SELF'] ?>?p=admin_banners&a=banner&s=aanzetten" method="post">
										<input type="hidden" name="banner_id" value="<?= $row_badges['banner_id'] ?>">
										<input type="submit" value="Aanzetten" name="aanzetten">
									</form>
									
									<?php
								}
							}
						}
								?>
								</td>
								</tr>
								</table>
						<?
				}else{
					echo "De s opdracht is niet bekend.";
				}
			}else{
				echo "Er is geen s opdracht.";
			}
		}
?>