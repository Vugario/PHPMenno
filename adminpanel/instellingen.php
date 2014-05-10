<?php
	if(isset($url[2])) {
	
		if($url[2] == "instellingen") {
			$sql = mysql_query("SELECT * FROM shop_badges");
			echo "
				<table class='data'>
					<tr>
						<th><strong>Plaatje</strong></th>
						<th><strong>Titel</strong></th>
						<th><strong>Beschrijving</strong></th>
						<th><strong>Aanpassen</strong></th>
					</tr>";
			while($row_badges = mysql_fetch_assoc($sql)) {
?>
					<tr>
						<td style="text-align: center;">
							<img src="<?php echo $row_badges['plaatje'] ?>">
						</td>
						
						<td>
							<strong><?php echo $row_badges['titel'] ?></strong>
						</td>
						
						<td>
							<?php echo $row_badges['beschrijving'] ?>
						</td>
						
						<td>
							<a>Wijzigen</a> <a>Verwijderen</a> <a>Uitzetten</a>
						</td>
					</tr>
						
<?php
			}
		}
	}
?>