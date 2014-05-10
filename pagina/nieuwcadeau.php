<?php
$select_data = mysql_query("SELECT * FROM leden WHERE member_id = '".mysql_real_escape_string($_SESSION['id'])."'");
$get_userdata = mysql_fetch_assoc($select_data);
$sql = mysql_query("SELECT * FROM cadeau WHERE naar='".$get_userdata['gebruikersnaam']."' AND geopend='Nee'");
if(mysql_num_rows($sql) >= 1) {
$row = mysql_fetch_assoc($sql);
mysql_query("UPDATE cadeau SET geopend='Ja' WHERE naar='".$get_userdata['gebruikersnaam']."'");
?>
<img src='images/cadeau.gif' /><br>Je hebt een troffee ontvangen van: <b><?php echo $row['van']; ?></b><br>
Je cadeau is geopend, er zat een troffee in. Je kunt hem <a href="?p=cadeau&act=bekijken&id=<?php echo $row['id'];?>">hier</a> bekijken.
	<?php
	die();
	}
?>