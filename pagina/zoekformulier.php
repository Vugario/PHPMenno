<center><form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=profiel&a=zoeken" method="post">
	<table class="body" width="300">
		<tr>
			<td>Zoeken</td>
			<td><input type="text" <?php if(isset($_POST['string'])) { echo "value='".$_POST['string']."'"; } ?> name="string" /></td>
		</tr>
	<?php
	if(isset($_POST['zoeken']) && empty($_POST['string'])) {
		echo "
		<tr>
			<th colspan=\"2\">De string is leeg, Hier kan ik toch niet mee werken!</th>
		</tr>";
	}elseif(isset($_POST['zoeken']) && strlen($_POST['string']) <= 3) {
		echo "
		<tr>
			<th colspan=\"2\">Je woord moet meer dan 3 tekens bevatten.</th>
		</tr>";
	}
	?>
		<tr>
			<th colspan="2"><input type="submit" name="zoeken" value="Zoeken" /></th>
		</tr>
	</table>
</form></center>