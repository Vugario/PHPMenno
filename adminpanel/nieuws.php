<?php 

	/*
	PHPMenno V6 - Simpel, Snel en Beter
	---------------------------------------------------
	Copyright (c) 2009, Menno Wolvers 'Menno'
	Copyright (c) 2010, Jeroen van de Weerd 'Jeroen262'
	http://www.jeroenvdweerd.nl
	---------------------------------------------------
	This program is free software: you can redistribute 
	it and/or modify it under the terms of the 
	GNU General Public License as published by the Free 
	Software Foundation, either version 6 of the 
	License, or	(at your option) any later version.
	*/    
	if(isset($url[2])) {
	
		if($url[2] == "toevoegen") {
			if(isset($_POST['toevoegen'])) {
				echo nieuwsToevoegen($_POST['titel'],$_POST['kortbericht'],$_POST['bericht'],$_POST['actief']);
			}else{
				echo "<form action='".$_SERVER['REQUEST_URI']."' method='post'>
						<table class='data'>
							<tr>
								<td>Titel</td>
								<td><input type='text' name='titel' maxlength='60' /></td>
							</tr>
							<tr>
								<td>Kort bericht</td>
								<td>
									<textarea class='ckeditor' id='kortbericht' name='kortbericht' style='background:#FFFFFF;'></textarea>
									<script type='text/javascript'>
										CKEDITOR.replace( 'kortbericht',
											{
												height : '100px',
												extraPlugins : 'uicolor',
												toolbar :
												[
													[ 'Preview', 'Image', 'Smiley', '-', 'Link', 'Unlink' ]
												]
											});
									</script>
								</td>
							</tr>
							<tr>
								<td>Volledig bericht</td>
								<td>
									<textarea class='ckeditor' id='bericht' name='bericht' style='background:#FFFFFF;'></textarea>
									<script type='text/javascript'>
										CKEDITOR.replace( 'bericht',
											{
												height : '150px',
												extraPlugins : 'uicolor',
												toolbar :
												[
													[ 'Preview', '-', 'Font', 'Size', 'Bold', 'Italic', 'Underline', 'TextColor', '-', 'Image', 'Flash', 'Smiley', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink' ]
												]
											});
									</script>
								</td>
							</tr>
							<tr>
								<td>Status</td>
								<td>
									<input type='radio' checked='checked' name='actief' value='aan' /> Aan 
									<input type='radio' name='actief' value='uit' /> Uit
								</td>
							</tr>
							<tr>
								<th colspan='2'><input type='submit' value='Voeg toe' name='toevoegen' /></th>
							</tr>
						</table>
					</form>";
			}
		}
		
		if($url[2] == "overzicht") {
			$sql = mysql_query("SELECT * FROM nieuws_berichten");
			echo "<table class='data'>
					<tr>
						<th>Titel</th>
						<th>Status</th>
						<th>Wijzigen/verwijderen</th>
					</tr>";
				$i = 0;
				while($row = mysql_fetch_assoc($sql)) {
				$i ^= 1;//laten staan: nodig voor rij-om-rij kleur :)
				echo "<tr class='row" . $i . "'>
						<td>".$row['titel']."</td>
						<td>".$row['actief']."</td>
						<td><a href='" . $root . "admin/nieuws/aanpassen/".$row['nieuws_id']."'>Wijzigen</a> / <a href='" . $root . "admin/nieuws/verwijder/" . $row['nieuws_id']."' onclick=\"return confirm('Weet je zeker dat dit nieuwsbericht verwijderd moet worden?');\">Verwijderen</a>
						</td>
					</tr>";
			}
			echo "</table>";
		}
	
		if($url[2] == "verwijder") {
			echo nieuwsVerwijderen($url[3]);
		}
	
		if($url[2] == "aanpassen") {
			if(isset($_POST['wijzigen'])) {
				echo nieuwsWijzigen($_POST['titel'],$_POST['kortbericht'],$_POST['bericht'],$_POST['actief'],$_POST['nieuws_id']);
			}elseif(isset($url[3])) {
				$nid = mysql_real_escape_string(substr($url[3],0,30));
				$sql = mysql_query("SELECT * FROM  nieuws_berichten WHERE nieuws_id='".$nid."'");
				$row = mysql_fetch_assoc($sql);
?>
				<form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
					<input type="hidden" name="nieuws_id" value="<?php echo $url[3]; ?>" />
					<table class="data">
						<tr>
							<td>Titel</td>
							<td><input type="text" name="titel" <?php echo "value=\"".stripslashes($row['titel'])."\""; ?> maxlength="25" /></td>
						</tr>
						<tr>
							<td>Kort bericht</td>
							<td><textarea class="ckeditor" id="kortbericht" name="kortbericht"><?php echo $row['kortbericht']; ?></textarea></td>
							<script type='text/javascript'>
								CKEDITOR.replace( 'kortbericht',
									{
										height : '100px',
										extraPlugins : 'uicolor',
										toolbar :
										[
											[ 'Preview', 'Image', 'Smiley', '-', 'Link', 'Unlink' ]
										]
									});
							</script>
						</tr>
						<tr>
							<td>Volledig bericht</td>
							<td><textarea class="ckeditor" id="bericht" name="bericht"><?php echo stripslashes($row['bericht']); ?></textarea></td>
							<script type='text/javascript'>
								CKEDITOR.replace( 'bericht',
									{
										height : '150px',
										extraPlugins : 'uicolor',
										toolbar :
										[
											[ 'Preview', '-', 'Font', 'Size', 'Bold', 'Italic', 'Underline', 'TextColor', '-', 'Image', 'Flash', 'Smiley', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink' ]
										]
									});
							</script>
						</tr>						
						<tr>
							<td>Status</td>
							<td>
								<input type="radio" <?php if($row['actief'] == "aan") echo "checked=\"checked\""; ?> name="actief" value="aan" /> Aan
								<input type="radio" <?php if($row['actief'] == "uit") echo "checked=\"checked\""; ?> name="actief" value="uit" /> Uit
							</td>
						</tr>
						<tr>
							<th colspan="2"><input type="submit" value="Wijzigen" name="wijzigen" /></th>
						</tr>
					</table>
				</form>
<?php
			}
		}
	}
?>

<center><a href="<?php echo $root ?>admin/nieuws/toevoegen">Nieuw nieuwsbericht</a> | <a href="<?php echo $root ?>admin/nieuws/overzicht">Nieuws overzicht</a></center>