<?php 
	if(isset($url[1])) {

		if($url[1] == "habbo") {
			$sql_badges = mysql_query("SELECT * FROM shop_badges");
?>
			<table class="data">
				<tr>
					<th width="50px;">Badge</th>
					<th>Titel & beschrijving</th>
					<th>Koop</th>
				</tr>
				
				<?php while($row = mysql_fetch_assoc($sql_badges)) { ?>
				<tr>
					<td><center><img src="<?php echo $row['plaatje']; ?>"/></center></td>
					<td><strong><?php echo $row['titel']; ?></strong><br /><?php echo $row['beschrijving']; ?></td>
					<td></td>
				</tr>
				<?php } ?>
			</table><br /><br />
			
			
			
			<?php $sql_meubi = mysql_query("SELECT * FROM shop_meubi"); ?>
			<table class="data">
				<tr>
					<th width="50px;">Meubel</th>
					<th>Titel & beschrijving</th>
					<th>Koop</th>
				</tr>
				
				<?php while($row = mysql_fetch_assoc($sql_meubi)) { ?>
				<tr>
					<td><center><img src="<?php echo $row['plaatje']; ?>"/></center></td>
					<td><strong><?php echo $row['titel']; ?></strong><br /><?php echo $row['beschrijving']; ?></td>
					<td></td>
				</tr>
				<?php } ?>
			</table><br /><br />
			
			
			<?php $sql_rangen = mysql_query("SELECT * FROM shop_rangen"); ?>
			<table class="data">
				<tr>
					<th>Titel & beschrijving</th>
					<th>Koop</th>
				</tr>
				
				<?php while($row = mysql_fetch_assoc($sql_rangen)) { ?>
				<tr>
					<td><strong><?php echo $row['titel']; ?></strong><br /><?php echo $row['beschrijving']; ?></td>
					<td></td>
				</tr>
				<?php } ?>
			</table>
<?php 
		}
	}
?>			
<?php	
//if(isset($_POST['kopen']) && isset($_POST['item_id']) && isset($_POST['soort'])) {
                //echo $shop->kopen($_POST['soort'],$_POST['item_id'] ?>