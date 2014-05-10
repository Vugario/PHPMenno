<?php

if(isset($_POST['submit']) && !empty($_POST['vraag'])) {
	$vraag = mysql_real_escape_string(htmlspecialchars($_POST['vraag']));
	
	mysql_query("INSERT INTO askamod (vraag,member_id,ip,gelezen) VALUES ('".$vraag."','".$_SESSION['id']."','".$_SERVER['REMOTE_ADDR']."','nee')");
	if(mysql_error() == "") {
		echo "Je vraag is opgeslagen en zal binnenkort behandeld worden.<br /><a href='#' onclick='history.go(-2)'>Ga terug</a>";
	}else{
		echo "Er is iets mis gegaan, <a href='#' onclick='history.go(-1)'>Ga terug</a>";
	}
}else{
	?>
	<form action="<?php echo $_SERVER['PHP_SELF'] ?>?p=askamod" method="post">
		<table>
			<tr>
				<td>Vraag/Opmerking</td>
			</tr>
			<tr>
				<td>
					<textarea name="vraag" cols="40" rows="6"><?php if(isset($_POST['submit'])) { echo $_POST['vraag']; } ?></textarea>
				</td>
			</tr>
			<tr>
				<th><input type="submit" name="submit" value="Ask a mod"></th>
			</tr>
		</table>
	</form>
	<?php
}
?>