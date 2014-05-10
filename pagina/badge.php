<?php

if(isset($_GET['bid'])) {
	$bid = mysql_real_escape_string(substr($_GET['bid'],0,20));
	$sql = mysql_query("SELECT langebeschrijving,plaatje,prijs,titel,badge_id FROM shop_badges WHERE badge_id='".$bid."'");
	
	$row = mysql_fetch_assoc($sql);
	
	?>
	<table>
		<tr>
			<td colspan=""><h3><?php echo $row['titel']; ?></h3></td>
		</tr>
		<tr>
			<td><img src="<?php echo $row['plaatje']; ?>" /></td>
			<td><?php echo $row['langebeschrijving']; ?></td>
		</tr>
		<tr>
			<td colspan="2"><strong>Prijs: </strong> <?php echo $row['prijs']; ?></td>
		</tr>
	</table>
	<?php
}else{
	echo "Zou je een badge id kunnen opgeven?";
}
?>