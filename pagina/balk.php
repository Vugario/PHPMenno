<marquee onMouseover="this.stop()" loop="-1" OnMouseout="this.start()">
	<?php
		$sql = mysql_query("SELECT bericht,member_id FROM berichten_balk ORDER BY bericht_id DESC");
		if(isset($_SESSION['id'])) {
		echo "<a href='".$root."berichtenbalk'>Plaats Bericht</a> || ";
		}
		$html = '';
		while($row = mysql_fetch_assoc($sql)) {
			$row_leden = mysql_fetch_assoc(mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id='".$row['member_id']."'"));
			$html .= "<strong><a href='".$root."profiel/gebruiker/".$row_leden['gebruikersnaam']."'>".$row_leden['gebruikersnaam']."</a></strong> - ".$row['bericht']." || ";
		}
		echo substr($html, 0, -4);
		if(mysql_num_rows($sql) == 0) {
			echo "Er zijn geen berichten in de berichtenbalk.";
		}
	?>
</marquee>