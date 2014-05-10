<?php

$aantal = 200; // aantal muntjes dat erbij komt
$aantalclublid = 300; // aantal muntjes dat erbij komt als je clublid bent

if(isset($_SESSION['id'])) {
	$dag = date("Y-m-d");
	mysql_query("INSERT INTO muntjesperdag (member_id,dag) VALUES ('".$_SESSION['id']."',NOW())");
	if(mysql_error() != "") {
		echo "Je hebt vandaag al je muntjes gehad, je moet wachten tot morgen.";
	}else{
		$sql_club = mysql_query("SELECT * FROM clublid WHERE member_id='".$_SESSION['id']."'");
		$row_club = mysql_fetch_assoc($sql_club);
		if(mysql_num_rows($sql_club) == 1) {
			mysql_query("UPDATE leden SET muntjes=muntjes+".$aantal." WHERE member_id='".$_SESSION['id']."'");
			echo "Je hebt ".$aantalclublid." muntjes erbij gekregen.";
		}else{
			mysql_query("UPDATE leden SET muntjes=muntjes+".$aantalclublid." WHERE member_id='".$_SESSION['id']."'");
			echo "Je hebt ".$aantalclublid." muntjes erbij gekregen.";
		}
	}
}

?>