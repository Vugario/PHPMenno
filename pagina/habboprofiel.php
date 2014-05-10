<?php

$habbo = new habboClass($_SESSION['gebruikersnaam'],"nl");

if($habbo->normal() == true) {
	?>
	<table width="300">
		<tr>
			<td width="180"><strong>Habbo Online</strong></td>
			<td width="240"><?php if($habbo->online() == true) { echo "Online"; } else { echo "Offline"; } ?></td>
		</tr>
		<tr>
			<td width="180"><strong>Habbo Missie</strong></td>
			<td width="240"><?php echo $habbo->motto(); ?></td>
		</tr>
		<tr>
			<td width="180"><strong>Habbo Sinds</strong></td>
			<td width="240"><?php echo $habbo->birthdate(); ?></td>
		</tr>
		<?php } ?>
		<tr>
			<td width="180"><img align="Habbo" src="pagina/habbo.php?habbo=<?php echo $_SESSION['gebruikersnaam']; ?>" /></td>
			<td width="240"><?php
			$habbo_badge = $habbo->badge();
			if(!empty($habbo_badge)) { echo "<img src=\"".$habbo->badge()."\" alt=\"Habbo Badge\" />"; } ?></td>
		</tr>
	</table>