<?php

if(isset($_SESSION['id'])) {
	if(isset($_GET['id']) && is_numeric($_GET['id'])) {
		$id = mysql_real_escape_string($_GET['id']);
		$get = mysql_fetch_assoc(mysql_query("SELECT * FROM guild WHERE id='".$id."'"));
		$sql_e = mysql_query("SELECT * FROM guild_leden WHERE guild_id='".$get['id']."'");
		$aantal = mysql_num_rows($sql_e);
		$sql_eigenaar = mysql_query("SELECT * FROM leden WHERE member_id='".$get['member_id']."'");
		$row_eigenaar = mysql_fetch_assoc($sql_eigenaar);
		$punten = 0;
		while($row_leden = mysql_fetch_assoc($sql_e)) {
			$sql_punten = mysql_query("SELECT punten FROM leden WHERE member_id='".$row_leden['member_id']."'");
			$row_punten = mysql_fetch_assoc($sql_punten);
			$punten = $punten + $row_punten['punten'];
		}
		?><br /><br />
		<table width="100%">
			<tr>
				<td width="10%" valign="top" rowspan="50">
					<?php if($get['logo'] == NULL) { ?><img src="images/noavatar.gif" /><?php }else{ ?><img src="<?php echo $get['logo']; ?>" /><?php } ?>
				</td>
			</tr>
			<tr>
				<td width="30%"><strong>Guildnaam</strong></td>
				<td><?php echo stripslashes(htmlspecialchars($get['naam'])); ?></td>
			</tr>
			<tr>
				<td width="30%"><strong>Guild sinds</strong></td>
				<td><?php echo $get['datum']; ?></td>
			</tr>
			<tr>
				<td width="30%"><strong>Leden</strong></td>
				<td><?php echo $aantal."/".$get['maxleden']; ?></td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td width="30%"><strong>Eigenaar</strong></td>
				<td><?php echo $row_eigenaar['gebruikersnaam']; ?></td>
			</tr>
			<tr>
				<td width="30%"><strong>Guild Punten</strong></td>
				<td><?php echo $punten; ?> Punten</td>
			</tr>
			<tr>
				<td colspan="2"><strong>Beschrijving</strong></td>
			</tr>
			<tr>
				<td colspan="2"><?php echo stripslashes(nl2br(htmlspecialchars($get['beschrijving']))); ?></td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td><br />
			<?php if(isset($_GET['id'])) {
				?>
				<input type="button" name="button" value="Bericht sturen" onclick="window.location.href='?p=bericht&a=versturen&aan=<?php echo $row_eigenaar['gebruikersnaam']; ?>'" /></td>
			<?php } ?>
				</td>
			</tr>
		</table>
		<?php
	}
}

?>