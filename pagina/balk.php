<marquee onMouseover="this.stop()" loop="-1" OnMouseout="this.start()"><?php

$sql = mysql_query("SELECT bericht,member_id FROM berichten_balk ORDER BY bericht_id DESC");
echo "<a href=\"?p=berichtenbalk&a=toevoegen\">Plaats Bericht</a> || ";
while($row = mysql_fetch_assoc($sql)) {
	$row_leden = mysql_fetch_assoc(mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id='".$row['member_id']."'"));
	echo "<strong><a href=\"?p=profiel&mid=".$row['member_id']."\">".$row_leden['gebruikersnaam']."</a></strong> - ".htmlspecialchars(substr($row['bericht'],0,MAXTEKSTINBERICHTENBALK))." || ";
}
if(mysql_num_rows($sql) == 0) {
	echo "Er zijn geen berichten in de berichtenbalk.";
}

?>
</marquee>