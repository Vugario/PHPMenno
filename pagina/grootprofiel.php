<?php
	$mid = addslashes(substr($_GET['mid'],0,30));
	$sql = mysql_query("SELECT grootprofiel FROM profiel WHERE member_id='".$mid."'");
	$row = mysql_fetch_assoc($sql);
	if($row['grootprofiel'] != "") {
		echo "<strong>Dit is een grootprofiel van een gebruiker :</strong><br /><br />";
		echo $row['grootprofiel'];
	}else{
		echo "Deze gebruiker heeft geen grootprofiel.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
	}
?>