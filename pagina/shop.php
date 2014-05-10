<?php
if(!isset($_SESSION['id'])) {
	echo "Je bent niet ingelogd, <a href='index.php'>Ga terug</a>.";
	die();
}
?><?php

if($instellingen['shop'] == "uit") {
	echo "De shop staat uit.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
}else{
	if(isset($_GET['a'])) {
		if($_GET['a'] == "shop") {
			/////////// BADGES ////////////
			echo "<strong>Badges</strong>";
			echo "<table>";
			$sql_badges = mysql_query("SELECT * FROM shop_badges");
			while($row = mysql_fetch_assoc($sql_badges)) {
				if($row['actief'] == "aan") {
					?>
					<tr>
						<td rowspan="2"><img src="<?php echo $row['plaatje']; ?>" /></td>
						<td><strong><?php echo $row['titel']; ?></strong></td>
					</tr>
					<tr>
						<td><?php echo $row['beschrijving']; ?><br /><strong>Prijs : </strong><?php echo $row['prijs']; ?></td>
						<td>
							<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=shop&a=kopen" method="post">
								<input type="hidden" name="item_id" value="<?php echo $row['badge_id']; ?>">
								<input type="hidden" name="soort" value="badge">
								<input 
								<?php
								$sql_muntjes = mysql_query("SELECT muntjes FROM leden WHERE member_id='".$_SESSION['id']."'");
								$row_muntjes = mysql_fetch_assoc($sql_muntjes);
								$aantal = $row_muntjes['muntjes'] - $row['prijs'];
								if($aantal < 0) {
									echo " style=\"background:#FF0000;\" ";
								}else{
									echo " style=\"background:#009900;\" ";
								}
								?> type="submit" name="kopen" value="Kopen">
							</form>
						</td>
					</tr>
					<tr>
						<th height="20" colspan="2">&nbsp;</th>
					</tr>
					<?php
				}
			}
			////////// RANGEN ///////////
				echo"
				<tr>
					<td><strong>Rangen</strong></td>
				</tr>";
			$sql_badges = mysql_query("SELECT * FROM shop_rangen");
			while($row = mysql_fetch_assoc($sql_badges)) {
				if($row['actief'] == "aan") {
					?>
					<tr>
						<td rowspan="2"></td>
						<td><strong><?php echo $row['titel']; ?></strong></td>
					</tr>
					<tr>
						<td><?php echo $row['beschrijving']; ?><br /><strong>Prijs : </strong><?php echo $row['prijs']; ?></td>
						<td>
							<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=shop&a=kopen" method="post">
								<input type="hidden" name="item_id" value="<?php echo $row['rang_id']; ?>">
								<input type="hidden" name="soort" value="rang">
								<input 
								<?php
								$sql_muntjes = mysql_query("SELECT muntjes FROM leden WHERE member_id='".$_SESSION['id']."'");
								$row_muntjes = mysql_fetch_assoc($sql_muntjes);
								$aantal = $row_muntjes['muntjes'] - $row['prijs'];
								if($aantal < 0) {
									echo " style=\"background:#FF0000;\" ";
								}else{
									echo " style=\"background:#009900;\" ";
								}
								?> type="submit" name="kopen" value="Kopen">
							</form>
						</td>
					</tr>
					<?php
                }
            }
			if($instellingen['meubi'] == "aan") {
				////////// Meubi ///////////
				
					echo"
					<tr>
						<td><strong><br><br>Meubi<br></strong></td>
					</tr>";
				$sql_badges = mysql_query("SELECT * FROM shop_meubi");
				while($row = mysql_fetch_assoc($sql_badges)) {
					if($row['actief'] == "aan") {
						?>
						<tr><td rowspan="2"><img src="<?php echo $row['plaatje']; ?>" /></td>
							<td><strong><?php echo $row['titel']; ?></strong></td>
						</tr>
						<tr>
						  <td><?php echo $row['beschrijving']; ?><br /><strong>Prijs : </strong><?php echo $row['prijs']; ?></td>
							<td>
								<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=shop&a=kopen" method="post">
								  <input type="hidden" name="item_id" value="<?php echo $row['meubi_id']; ?>">
									<input type="hidden" name="soort" value="meubi">
								<input 
								<?php
								$sql_muntjes = mysql_query("SELECT muntjes FROM leden WHERE member_id='".$_SESSION['id']."'");
								$row_muntjes = mysql_fetch_assoc($sql_muntjes);
								$aantal = $row_muntjes['muntjes'] - $row['prijs'];
								if($aantal < 0) {
									echo " style=\"background:#FF0000;\" ";
								}else{
									echo " style=\"background:#009900;\" ";
								}
								?> type="submit" name="kopen" value="Kopen">
								</form>
							</td>
						</tr><?php
					}
				}
				
				//////// Einde meubi //////////
				
			}
            echo "</table>";
        }elseif($_GET['a'] == "kopen") {
            if(isset($_POST['kopen']) && isset($_POST['item_id']) && isset($_POST['soort'])) {
                echo $shop->kopen($_POST['soort'],$_POST['item_id']);
            }else{
                echo "Er is een fout opgetreden.<br><a href='java script:history.go(-1)'>Ga terug</a>";
            }
        }else{
            echo "Deze actie is niet bekend.<br><a href='java script:history.go(-1)'>Ga terug</a>";
        }
    }else{
        echo "&raquo; <a href='?p=shop&a=shop'>Habbo Shop</a>";
    }
}
?>