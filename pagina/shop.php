<?php
if(!isset($_SESSION['id'])) {
	echo "Je bent niet ingelogd, <a href='index.php'>Ga terug</a>.";
	die();
}
?><?php

if($instellingen['shop'] == "uit") {
	echo "De shop staat uit.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
}else{


class shop {
	/// ADMIN TOEVOEGEN

	/// KOPEN ////
	function kopen ($soort,$item_id) {
		$soort = mysql_real_escape_string(substr($soort,0,255));
		$item_id = mysql_real_escape_string(substr($item_id,0,30));
		if($soort == "badge") {
			$sql = mysql_query("SELECT * FROM shop_badges WHERE badge_id = '".$item_id."'");
			$row = mysql_fetch_assoc($sql);
			$sql_leden = mysql_query("SELECT muntjes FROM leden WHERE member_id='".$_SESSION['id']."'");
			$row_leden = mysql_fetch_assoc($sql_leden);
			$sql_check = mysql_query("SELECT * FROM gekochte_badges WHERE badge_id='".$item_id."' AND member_id='".$_SESSION['id']."'");
									if($row['actief'] == "uit") {
				echo "Dit item staat niet (meer) in de shop, je kan het dus niet kopen.<br />";
			}elseif(mysql_num_rows($sql_check) == 1) {
				echo "Je hebt deze badge al gekocht.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
			}elseif($row_leden['muntjes'] - $row['prijs'] < 0) {
				return "Je hebt niet genoeg muntjes om dit item te kopen.<br><a href='javascript:history.go(-1)'>Ga terug</a>";
			}else{
				mysql_query("INSERT INTO gekochte_badges (badge_id,member_id) VALUES ('".$row['badge_id']."','".$_SESSION['id']."')");
				mysql_query("UPDATE leden SET muntjes=muntjes-".$row['prijs']." WHERE member_id='".$_SESSION['id']."'");
				if(mysql_error() == "") {
					return "Je hebt succesvol <strong>".$row['titel']."</strong> gekocht.<br />
					Je kan deze <a href='?p=profiel&mid=".$_SESSION['id']."'>Hier</a> bekijken.";
				}else{
					return mysql_error();
					}
				}
		}elseif($soort == "rang") {
			$sql = mysql_query("SELECT * FROM shop_rangen WHERE rang_id = '".$item_id."'");
			$row = mysql_fetch_assoc($sql);
			$sql_leden = mysql_query("SELECT muntjes FROM leden WHERE member_id='".$_SESSION['id']."'");
			$row_leden = mysql_fetch_assoc($sql_leden);
			$sql_check = mysql_query("SELECT * FROM gekochte_rangen WHERE rang_id='".$item_id."' AND member_id='".$_SESSION['id']."'");
						if($row['actief'] == "uit") {
				echo "Dit item staat niet (meer) in de shop, je kan het dus niet kopen.<br />";
			}elseif(mysql_num_rows($sql_check) == 1) {
				echo "Je hebt deze rang al gekocht.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
			}elseif($row_leden['muntjes'] - $row['prijs'] < 0) {
				return "Je hebt niet genoeg muntjes om dit item te kopen.";
			}else{
				mysql_query("INSERT INTO gekochte_rangen (rang_id,member_id) VALUES ('".$row['rang_id']."','".$_SESSION['id']."')");
				mysql_query("UPDATE leden SET muntjes=muntjes-".$row['prijs']." WHERE member_id='".$_SESSION['id']."'");
				if(mysql_error() == "") {
					return "Je hebt succesvol <strong>".$row['titel']."</strong> gekocht.<br />
					<a href='javascript:history.go(-1)'>Ga terug</a>.";
				}else{
					return mysql_error();
					}
				}
		}elseif($soort == "meubi") {
			$sql = mysql_query("SELECT * FROM shop_meubi WHERE meubi_id = '".$item_id."'");
			$row = mysql_fetch_assoc($sql);
			if($row['actief'] == "uit") {
				echo "Dit item staat niet (meer) in de shop, je kan het dus niet kopen.<br />";
			}elseif(mysql_num_rows($sql) == 0) {
				echo "Dit item bestaat helemaal niet, je kan dit dus niet kopen.<br />";
			}else{
				$sql_leden = mysql_query("SELECT muntjes FROM leden WHERE member_id='".$_SESSION['id']."'");
				$row_leden = mysql_fetch_assoc($sql_leden);
				$sql_check = mysql_query("SELECT * FROM gekochte_meubi WHERE meubi_id='".$item_id."' AND member_id='".$_SESSION['id']."'");
				if(mysql_num_rows($sql_check) == 1) {
					echo "Je hebt deze meubi al gekocht.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
				}elseif($row_leden['muntjes'] < 0) {
					return "Je hebt niet genoeg muntjes om dit item te kopen.";
				}else{
					mysql_query("INSERT INTO gekochte_meubi (meubi_id,member_id) VALUES ('".$row['meubi_id']."','".$_SESSION['id']."')");
					mysql_query("UPDATE leden SET muntjes=muntjes-".$row['prijs']." WHERE member_id='".$_SESSION['id']."'");
					if(mysql_error() == "") {
						return "Je hebt succesvol <strong>".$row['titel']."</strong> gekocht.<br />
						<a href='javascript:history.go(-1)'>Ga terug</a>.";
					}else{
						return mysql_error();
					}
				}
			}
		}else{
			return "Er is iets fout gegaan.<br />Deze soort item is niet bekend.";
		}
	}
	// andere functie hier
}

$shop = new shop();


	if(isset($_GET['a'])) {
		if($_GET['a'] == "shop") {
			/////////// BADGES ////////////
			echo "<strong>Badges</strong>";
			echo "<table>";
			$sql_badges = mysql_query("SELECT * FROM shop_badges");
			if(mysql_num_rows($sql_badges) == 0) {
				echo "<tr><td>Je hebt nog geen badges in de shop gezet.<br />Dit kan je doen via het admin-panel.<br />Vergeet niet om ze ook nog aan te zetten.<br /></td></tr>";			}
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
			if(mysql_num_rows($sql_badges) == 0) {
				echo "<tr><td>Je hebt nog geen rangen in de shop gezet.<br />Dit kan je doen via het admin-panel.<br />Vergeet niet om ze ook nog aan te zetten.<br /></td></tr>";			}
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
				if(mysql_num_rows($sql_badges) == 0) {
					echo "<tr><td>Je hebt nog geen meubels in de shop gezet.<br />Dit kan je doen via het admin-panel.<br />Vergeet niet om ze ook nog aan te zetten.<br /></td></tr>";
				}
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