<?php

if(isset($_SESSION['admin'])) {
	echo "
		<a href='?p=admin_shop&a=badge&s=toevoegen'>Badge Toevoegen</a> | 
		<a href='?p=admin_shop&a=rang&s=lijst'>Badge/Rangen/Meubi's Wijzigen</a> | 
		<a href='?p=admin_shop&a=meubi&s=toevoegen'>Meubi Toevoegen</a> | 
		<a href='?p=admin_shop&a=rang&s=toevoegen'>Rang Toevoegen</a> | 
		<br><br><br>";
		
		
		
		class shop {
	/// ADMIN TOEVOEGEN
	function badgeToevoegen ($titel,$beschrijving,$langebeschrijving,$plaatje,$prijs) {
		$titel = mysql_real_escape_string(substr($titel,0,255));
		$beschrijving = mysql_real_escape_string($beschrijving);
		$plaatje = mysql_real_escape_string($plaatje);
		$prijs = mysql_real_escape_string(substr($prijs,0,30));
		$langebeschrijving = mysql_real_escape_string(nl2br($langebeschrijving));
		
		mysql_query("INSERT INTO shop_badges (titel,beschrijving,langebeschrijving,plaatje,prijs) VALUES ('".$titel."','".$beschrijving."','".$langebeschrijving."','".$plaatje."','".$prijs."')");
		if(mysql_error() == "") {
			return "De badge is toegevoegd.<br /><a href='javascript:history.go(-2)'>Ga terug</a>";
		}else{
			return "Er is iets fout gegaan , De volgende error komt naar boven:<br />".mysql_error();
		}
	}
	function meubiToevoegen ($titel,$beschrijving,$langebeschrijving,$plaatje,$prijs) {
		$titel = mysql_real_escape_string(substr($titel,0,255));
		$beschrijving = mysql_real_escape_string($beschrijving);
		$plaatje = mysql_real_escape_string($plaatje);
		$prijs = mysql_real_escape_string(substr($prijs,0,30));
		$langebeschrijving = mysql_real_escape_string(nl2br($langebeschrijving));
		
		mysql_query("INSERT INTO shop_meubi (titel,beschrijving,langebeschrijving,plaatje,prijs) VALUES ('".$titel."','".$beschrijving."','".$langebeschrijving."','".$plaatje."','".$prijs."')");
		if(mysql_error() == "") {
			return "De meubi is toegevoegd.<br /><a href='javascript:history.go(-2)'>Ga terug</a>";
		}else{
			return "Er is iets fout gegaan , De volgende error komt naar boven:<br />".mysql_error();
		}
	}
	function rangToevoegen($titel,$prijs,$beschrijving) {
		$titel = mysql_real_escape_string(substr($titel,0,255));
		$prijs = mysql_real_escape_string(substr($prijs,0,30));
		$beschrijving = mysql_real_escape_string($beschrijving);
		
		mysql_query("INSERT INTO shop_rangen (titel,prijs,beschrijving) VALUES ('".$titel."','".$prijs."','".$beschrijving."')");
		if(mysql_error() == "") {
			return "De rang is toegevoegd.<br /><a href='javascript:history.go(-2)'>Ga terug</a>";
		}else{
			return "Er is iets fout gegaan , De volgende error komt naar boven:<br />".mysql_error();
		}
	}
	function badgeWijzigen ($badge_id,$titel,$beschrijving,$langebeschrijving,$plaatje,$prijs) {
		$titel = mysql_real_escape_string(substr($titel,0,255));
		$beschrijving = mysql_real_escape_string($beschrijving);
		$plaatje = mysql_real_escape_string($plaatje);
		$prijs = mysql_real_escape_string(substr($prijs,0,30));
		$badge_id = mysql_real_escape_string(substr($badge_id,0,30));
		$langebeschrijving = mysql_real_escape_string(nl2br($langebeschrijving));
		
		mysql_query("UPDATE shop_badges SET titel='".$titel."',beschrijving='".$beschrijving."',plaatje='".$plaatje."',prijs='".$prijs."',langebeschrijving='".$langebeschrijving."' WHERE badge_id='".$badge_id."'");
		if(mysql_error() == "") {
			return "De badge is gewijzigd.<br /><a href='javascript:history.go(-2)'>Ga terug</a>";
		}else{
			return "Er is iets fout gegaan , De volgende error komt naar boven:<br />".mysql_error();
		}
	}
	function meubiWijzigen ($meubi_id,$titel,$beschrijving,$langebeschrijving,$plaatje,$prijs) {
		$titel = mysql_real_escape_string(substr($titel,0,255));
		$beschrijving = mysql_real_escape_string($beschrijving);
		$plaatje = mysql_real_escape_string($plaatje);
		$prijs = mysql_real_escape_string(substr($prijs,0,30));
		$meubi_id = mysql_real_escape_string(substr($meubi_id,0,30));
		$langebeschrijving = mysql_real_escape_string(nl2br($langebeschrijving));
		
		mysql_query("UPDATE shop_meubi SET titel='".$titel."',beschrijving='".$beschrijving."',plaatje='".$plaatje."',prijs='".$prijs."',langebeschrijving='".$langebeschrijving."' WHERE meubi_id='".$meubi_id."'");
		if(mysql_error() == "") {
			return "De meubi is gewijzigd.<br /><a href='javascript:history.go(-2)'>Ga terug</a>";
		}else{
			return "Er is iets fout gegaan , De volgende error komt naar boven:<br />".mysql_error();
		}
	}
	function rangWijzigen($rang_id,$beschrijving,$titel,$prijs) {
		$titel = mysql_real_escape_string(substr($titel,0,255));
		$beschrijving = mysql_real_escape_string($beschrijving);
		$prijs = mysql_real_escape_string(substr($prijs,0,30));
		$rang_id = mysql_real_escape_string(substr($rang_id,0,30));
		
		mysql_query("UPDATE shop_rangen SET beschrijving = '".$beschrijving."',titel = '".$titel."',prijs = '".$prijs."' WHERE rang_id='".$rang_id."'");
		if(mysql_error() == "") {
			return "De rang is gewijzigd.<br /><a href='javascript:history.go(-2)'>Ga terug</a>";
		}else{
			return "Er is iets fout gegaan , De volgende error komt naar boven:<br />".mysql_error();
		}
	}
	function badgeVerwijderen($badge_id) {
		$badge_id = mysql_real_escape_string(substr($badge_id,0,30));
		mysql_query("DELETE FROM shop_badges WHERE badge_id='".$badge_id."'");
		if(mysql_error() == "") {
			return "Hij is succesvol verwijderd.<br>Wil je er nog meer verwijderen?<br><a href='javascript:history.go(-2)'>Ga terug</a>";
		}else{
			return mysql_error();
		}
	}
	function meubiVerwijderen($meubi_id) {
		$meubi_id = mysql_real_escape_string(substr($meubi_id,0,30));
		mysql_query("DELETE FROM shop_meubi WHERE meubi_id='".$meubi_id."'");
		if(mysql_error() == "") {
			return "Hij is succesvol verwijderd.<br>Wil je er nog meer verwijderen?<br><a href='javascript:history.go(-2)'>Ga terug</a>";
		}else{
			return mysql_error();
		}
	}
	function rangVerwijderen($rang_id) {
		$rang_id = mysql_real_escape_string(substr($rang_id,0,30));
		mysql_query("DELETE FROM shop_rangen WHERE rang_id='".$rang_id."'");
		if(mysql_error() == "") {
			return "Hij is succesvol verwijderd.<br>Wil je er nog meer verwijderen?<br><a href='javascript:history.go(-2)'>Ga terug</a>";
		}else{
			return mysql_error();
		}
	}
	
	
	/// KOPEN ////
	function kopen ($soort,$item_id) {
		$soort = mysql_real_escape_string(substr($soort,0,255));
		$item_id = mysql_real_escape_string(substr($item_id,0,30));
		if($soort == "badge") {
			$sql = mysql_query("SELECT * FROM shop_badges WHERE badge_id = '".$item_id."'");
			$row = mysql_fetch_assoc($sql);
			$sql_leden = mysql_query("SELECT muntjes FROM leden WHERE member_id='".$_SESSION['id']."'");
			$row_leden = mysql_fetch_assoc($sql_leden);
			$sql_check = mysql_query("SELECT * FROM gekochte_badges WHERE badge_id='".$item_id."' AND member_id='".$_SESSION['id']."'");
									if($row['actief'] == "uit") {
				echo "Dit item staat niet (meer) in de shop, je kan het dus niet kopen.<br />";
			}elseif(mysql_num_rows($sql_check) == 1) {
				echo "Je hebt deze badge al gekocht.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
			}elseif($row_leden['muntjes'] - $row['prijs'] < 0) {
				return "Je hebt niet genoeg muntjes om dit item te kopen.<br><a href='javascript:history.go(-1)'>Ga terug</a>";
			}else{
				mysql_query("INSERT INTO gekochte_badges (badge_id,member_id) VALUES ('".$row['badge_id']."','".$_SESSION['id']."')");
				mysql_query("UPDATE leden SET muntjes=muntjes-".$row['prijs']." WHERE member_id='".$_SESSION['id']."'");
				if(mysql_error() == "") {
					return "Je hebt succesvol <strong>".$row['titel']."</strong> gekocht.<br />
					Je kan deze <a href='?p=profiel&mid=".$_SESSION['id']."'>Hier</a> bekijken.";
				}else{
					return mysql_error();
					}
				}
		}elseif($soort == "rang") {
			$sql = mysql_query("SELECT * FROM shop_rangen WHERE rang_id = '".$item_id."'");
			$row = mysql_fetch_assoc($sql);
			$sql_leden = mysql_query("SELECT muntjes FROM leden WHERE member_id='".$_SESSION['id']."'");
			$row_leden = mysql_fetch_assoc($sql_leden);
			$sql_check = mysql_query("SELECT * FROM gekochte_rangen WHERE rang_id='".$item_id."' AND member_id='".$_SESSION['id']."'");
						if($row['actief'] == "uit") {
				echo "Dit item staat niet (meer) in de shop, je kan het dus niet kopen.<br />";
			}elseif(mysql_num_rows($sql_check) == 1) {
				echo "Je hebt deze rang al gekocht.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
			}elseif($row_leden['muntjes'] - $row['prijs'] < 0) {
				return "Je hebt niet genoeg muntjes om dit item te kopen.";
			}else{
				mysql_query("INSERT INTO gekochte_rangen (rang_id,member_id) VALUES ('".$row['rang_id']."','".$_SESSION['id']."')");
				mysql_query("UPDATE leden SET muntjes=muntjes-".$row['prijs']." WHERE member_id='".$_SESSION['id']."'");
				if(mysql_error() == "") {
					return "Je hebt succesvol <strong>".$row['titel']."</strong> gekocht.<br />
					<a href='javascript:history.go(-1)'>Ga terug</a>.";
				}else{
					return mysql_error();
					}
				}
		}elseif($soort == "meubi") {
			$sql = mysql_query("SELECT * FROM shop_meubi WHERE meubi_id = '".$item_id."'");
			$row = mysql_fetch_assoc($sql);
			if($row['actief'] == "uit") {
				echo "Dit item staat niet (meer) in de shop, je kan het dus niet kopen.<br />";
			}elseif(mysql_num_rows($sql) == 0) {
				echo "Dit item bestaat helemaal niet, je kan dit dus niet kopen.<br />";
			}else{
				$sql_leden = mysql_query("SELECT muntjes FROM leden WHERE member_id='".$_SESSION['id']."'");
				$row_leden = mysql_fetch_assoc($sql_leden);
				$sql_check = mysql_query("SELECT * FROM gekochte_meubi WHERE meubi_id='".$item_id."' AND member_id='".$_SESSION['id']."'");
				if(mysql_num_rows($sql_check) == 1) {
					echo "Je hebt deze meubi al gekocht.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
				}elseif($row_leden['muntjes'] < 0) {
					return "Je hebt niet genoeg muntjes om dit item te kopen.";
				}else{
					mysql_query("INSERT INTO gekochte_meubi (meubi_id,member_id) VALUES ('".$row['meubi_id']."','".$_SESSION['id']."')");
					mysql_query("UPDATE leden SET muntjes=muntjes-".$row['prijs']." WHERE member_id='".$_SESSION['id']."'");
					if(mysql_error() == "") {
						return "Je hebt succesvol <strong>".$row['titel']."</strong> gekocht.<br />
						<a href='javascript:history.go(-1)'>Ga terug</a>.";
					}else{
						return mysql_error();
					}
				}
			}
		}else{
			return "Er is iets fout gegaan.<br />Deze soort item is niet bekend.";
		}
	}
	
	function rangUitzetten($rang_id) {
		$rang_id = mysql_real_escape_string($rang_id);
		
		mysql_query("UPDATE shop_rangen SET actief='uit' WHERE rang_id='".$rang_id."'");
		if(mysql_error() == "") {
			echo "Deze rang is nu uitgeschakeld.<br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
		}else{
			echo "Deze rang bestaat niet of er is iets anders mis gegaan.<br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
		}
	}
	
	function badgeUitzetten($badge_id) {
		$badge_id = mysql_real_escape_string($badge_id);
		
		mysql_query("UPDATE shop_badges SET actief='uit' WHERE badge_id='".$badge_id."'");
		if(mysql_error() == "") {
			echo "Deze badge is nu uitgeschakeld.<br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
		}else{
			echo "Deze badge bestaat niet of er is iets anders mis gegaan.<br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
		}
	}
	
	function meubiUitzetten($meubi_id) {
		$meubi_id = mysql_real_escape_string($meubi_id);
		
		mysql_query("UPDATE shop_meubi SET actief='uit' WHERE meubi_id='".$meubi_id."'");
		if(mysql_error() == "") {
			echo "Deze meubi is nu uitgeschakeld.<br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
		}else{
			echo "Deze meubi bestaat niet of er is iets anders mis gegaan.<br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
		}
	}
	
	function rangAanzetten($rang_id) {
		$rang_id = mysql_real_escape_string($rang_id);
		
		mysql_query("UPDATE shop_rangen SET actief='aan' WHERE rang_id='".$rang_id."'");
		if(mysql_error() == "") {
			echo "Deze rang is nu aangezet.<br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
		}else{
			echo "Deze rang bestaat niet of er is iets anders mis gegaan.<br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
		}
	}
	
	function badgeAanzetten($badge_id) {
		$badge_id = mysql_real_escape_string($badge_id);
		
		mysql_query("UPDATE shop_badges SET actief='aan' WHERE badge_id='".$badge_id."'");
		if(mysql_error() == "") {
			echo "Deze badge is nu aangezet.<br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
		}else{
			echo "Deze badge bestaat niet of er is iets anders mis gegaan.<br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
		}
	}
	
	function meubiAanzetten($meubi_id) {
		$meubi_id = mysql_real_escape_string($meubi_id);
		
		mysql_query("UPDATE shop_meubi SET actief='aan' WHERE meubi_id='".$meubi_id."'");
		if(mysql_error() == "") {
			echo "Deze meubi is nu aangezet.<br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
		}else{
			echo "Deze meubi bestaat niet of er is iets anders mis gegaan.<br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
		}
	}
	// andere functie hier
}

$shop = new shop();
		
		
		
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