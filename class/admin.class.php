<?php

class admin {
	
	function wijzigAccount($gebruikersnaam,$email,$member_id,$level,$punten) {
		if(isset($_SESSION['admin'])) {
			
			$gebruikersnaam = mysql_real_escape_string(substr($gebruikersnaam,0,255));
			$punten = mysql_real_escape_string(substr($punten,0,255));
			$email = mysql_real_escape_string(substr($email,0,255));
			$member_id = mysql_real_escape_string(substr($member_id,0,255));
			$level = mysql_real_escape_string(substr($level,0,1));
			
			mysql_query("UPDATE leden SET punten='".$punten."',gebruikersnaam='".$gebruikersnaam."',email='".$email."',level='".$level."' WHERE member_id='".$member_id."'");
			if(mysql_error() == "") {
				return "Je hebt het lid aangepast.<br />
			<a href='javascript:history.go(-2)'>Ga terug</a>";
			}else{
				echo "Er is iets fout gegaan.<br /><a href='#' onclick='history.go(-1)'>Ga terug</a>".mysql_error();
			}
		}else{
			return "Je bent geen admin.";
		}
	}
	function verwijderAccount($member_id) {
		if(isset($_SESSION['admin'])) {
			
			$member_id = mysql_real_escape_string($member_id);
			mysql_query("DELETE FROM leden WHERE member_id='".$member_id."'");
			return "Het account is verwijderd<br>
			<a href='javascript:history.go(-2)'>Ga terug</a>";
		}else{
			return "Je bent geen admin.";
		}
	}
	function ipban($ip,$reden) {
		$ip = mysql_real_escape_string(substr($ip,0,255));
		$reden = mysql_real_escape_string(nl2br($reden));
		$sql = mysql_query("SELECT * FROM ipban WHERE ip='".$ip."'");
		if(mysql_num_rows($sql) < 1) {
			mysql_query("INSERT INTO ipban (ip,reden) VALUES ('".$ip."','".$reden."')");
			return "De ip: ".$ip." is succesvol verbannen met de reden:<br />".$reden."<br /><br /><a href='javascript:history.go(-2)'>Ga terug</a>";
		}else{
			return "Dit ip is al geblokkeerd.<br /><a href='javascript:history.go(-2)'>Ga terug</a>";
		}
	}
	function unban($ip,$id) {
		$ip = mysql_real_escape_string(substr($ip,0,255));
		$id = mysql_real_escape_string(substr($id,0,255));
		mysql_query("DELETE FROM ipban WHERE ip='".$ip."' AND ipban_id='".$id."'");
		return "Het ip is ge-unbanned.<br /><a href='javascript:history.go(-1)'>Ga terug</a>.";
	}
	
	function badgeGeven($member_id,$badge_id) {
		$member_id = mysql_real_escape_string(substr($member_id,0,30));
		$badge_id = mysql_real_escape_string(substr($badge_id,0,30));
		
		$sql = mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id='".$member_id."'");
		if(mysql_num_rows($sql) == 1 && !empty($member_id) && !empty($badge_id)) {
			mysql_query("INSERT INTO speciale_badges_members (member_id,badge_id) VALUES ('".$member_id."','".$badge_id."')");
			if(mysql_error() == "") {
				echo "De badge is succesvol toegevoegd aan deze member.<br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
			}else{
				echo "Er is iets fout gegaan.<br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
				echo mysql_error();
			}
		}else{
			echo "Deze member lijkt niet te bestaan, of iets is leeggelaten.<br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
		}
	}
	
	function badgeAanmaken($titel,$plaatje) {
		$titel = mysql_real_escape_string(substr($titel,0,25));
		$plaatje = mysql_real_escape_string(substr($plaatje,0,5000));
		
		if(!empty($titel) && !empty($plaatje)) {
			mysql_query("INSERT INTO speciale_badges (titel,plaatje) VALUES ('".$titel."','".$plaatje."')");
			if(mysql_error() == "") {
				return "<img src='".$plaatje."' align='left' style='display:block' />
				De speciale badge is succesvol aangemaakt.<br />
				<a href=\"javascript:history.go(-1)\">Ga terug</a>";
			}else{
				echo "Er is iets fout gegaan tijdens het aanmaken van de speciale badge.<br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
			}
		}else{
			echo "Er is een veld leeggelaten.<br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
		}
	}
	
	function lidVerbannen($member_id) {
		$member_id = mysql_real_escape_string($member_id);
		
		mysql_query("UPDATE leden SET rang='verbannen' WHERE member_id='".$member_id."'");
		if(mysql_error() == "") {
			echo "Dit account is succesvol verbannen.<br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
		}else{
			echo "Er is iets fout gegaan.<br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
		}
	}
}
$admin = new admin();
