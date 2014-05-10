<?php
ob_start();
session_start();

// Badge weergeven
		$sql = mysql_query("SELECT * FROM leden WHERE member_id = '".$_GET['mid']."'")or die(mysql_error()); 
		$fetch = mysql_fetch_assoc($sql); 
	// Admin
        if($fetch['level'] == 6){
		echo'<img src="images/badges/badge_admin.gif" border="0"></a> ';
    }	
    // nieuwsreporter
        if($fetch['level'] == 2){
		echo'<img src="images/badges/badge_nieuwsreporter.gif" border="0"></a> ';
	}
	// Forum beheerder
	if($fetch['level'] == 3){
		echo'<img src="images/badges/badge_forum.gif" border="0"></a> ';
	}
	// Nieuwe aanmaken?
	if($fetch['naam'] == waarde){
		echo'<img src="images/badges/...." border="0"></a> ';
	}
?>
