<?php

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

?>