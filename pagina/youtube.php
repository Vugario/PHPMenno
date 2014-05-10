<script src="js/vote.js"></script>
<?php

if(isset($_SESSION['id'])) {

	echo "<a href='?p=youtube&a=mijnlijst'>Mijn video's</a> | <a href='?p=youtube&a=lijst'>Alle video's</a> | <a href='?p=youtube&a=toevoegen'>Video toevoegen</a> | ";
	
	if(isset($_GET['a']) && $_GET['a'] == "toevoegen") {
		if(isset($_POST['submit']) && !empty($_POST['titel']) && !empty($_POST['beschrijving']) && !empty($_POST['link'])) {
		
			$titel = mysql_real_escape_string(htmlspecialchars($_POST['titel']));
			$beschrijving = mysql_real_escape_string(htmlspecialchars($_POST['beschrijving']));
			$link = explode("=",mysql_real_escape_string(htmlspecialchars($_POST['link'])));
			$link = $link[1];
			
			if($link != "") {
				mysql_query("INSERT INTO youtube (titel,link,beschrijving,member_id,datum,score) VALUES ('".$titel."','".$link."','".$beschrijving."','".$_SESSION['id']."',NOW(),'1')");
				echo mysql_error();
				if(mysql_error() == "") {
					echo "Je filmpje is succesvol toegevoegd.<br /><a href='?p=youtube&a=mijnlijst'>Bekijk hier al jou filmpjes</a>";
				}else{
					echo "De titel of het filmpje bestaat al, je kan een filmpje geen 2x toevoegen.<br />";
				}
			}else{
				echo "De opgegeven youtube link is ongelig.<br>Vul een nieuwe link in, Een voorbeeld is 
				<strong>http://www.youtube.com/watch?v=BtNv1ZSQlQk</strong><br><a href='javascript:history.go(-1)'>Ga terug</a>";
			}
		}else{
			?>
			<form action="" method="POST">
			Voorbeeld van een youtube link : <strong>http://www.youtube.com/watch?v=BtNv1ZSQlQk</strong><br /><br>
			<table width="100%">
				<tr>
					<td><strong>Titel</strong></td>
					<td><input type="text" name="titel" value="<?php echo $_POST['titel']; ?>" /></td>
				</tr>
				<tr>
					<td><strong>Youtube link</strong></td>
					<td><input type="text" name="link" style="width: 300px;" value="<?php echo $_POST['link']; ?>" /></td>
				</tr>
				<tr>
					<td colspan="2"><strong>Beschrijving</strong></td>
				</tr>
				<tr>
					<td colspan="2"><textarea name="beschrijving" style="width: 100%; height:200px;"><?php echo $_POST['titel']; ?></textarea></td>
				</tr>
				<tr>
					<th colspan="2"><input type="submit" name="submit" value="Toevoegen" />&nbsp;&nbsp;<input type="reset" name="reset" value="Reset"></th>
				</tr>
			</table>
			</form>
			<?php
		}
	}elseif(isset($_GET['a']) && $_GET['a'] == "mijnlijst") {
		$sql = mysql_query("SELECT * FROM youtube WHERE member_id='".$_SESSION['id']."'");
		echo "<table width='100%'>";
		while($row = mysql_fetch_assoc($sql)) {
			$sql_leden = mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id='".$row['member_id']."'");
			$row_leden = mysql_fetch_assoc($sql_leden);
			?>
			<tr>
				<td width="150"><img src="http://i.ytimg.com/vi/<?php echo $row['link']; ?>/default.jpg" /></td>
				<td><a href='?p=youtube&a=kijken&id=<?php echo $row['id']; ?>'><strong><?php echo $row['titel']; ?></strong></a></td>
				<td><?php echo $row_leden['gebruikersnaam']; ?></td>
				<td><?php echo $row['datum']; ?></td>
			</tr>
			<?php
		}
		echo "</table>";
		if(mysql_num_rows($sql) == 0) {
			echo "Er zijn nog geen filmpjes toegevoegd.<br><a href='?p=youtube&a=toevoegen'>Voeg er hier 1 toe</a>";
		}
	}elseif(isset($_GET['a']) && $_GET['a'] == "kijken" && isset($_GET['id']) && is_numeric($_GET['id'])) {
		$id = mysql_real_escape_string($_GET['id']);
		$sql = mysql_query("SELECT * FROM youtube WHERE id='".$id."'");
		
		if(mysql_num_rows($sql) == 1) {
			$row = mysql_fetch_assoc($sql);
			$sql_leden = mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id='".$row['member_id']."'");
			$row_leden = mysql_fetch_assoc($sql_leden);
			
			// SCORE //
			$score = explode(",",$row['score']);
			$gestemd = count($score);
			$opgeteld = array_sum($score);
			$gemiddeld = $opgeteld / $gestemd;
			$gemiddeld = ceil($gemiddeld);
			// SCORE //
			
			echo "<h2>".$row['titel']."</h2>
			<strong>Gepost door</strong> : ".$row_leden['gebruikersnaam']."<br>
			<strong>Score</strong> : <strong>".$gemiddeld."/5</strong> ".$gestemd."x gestemd<br>
			<strong>Stemmen:</strong><br>";
			?>
			<a href="?p=youtubevote&id=<?php echo $_GET['id']; ?>&a=1&s=vote">1</a>&nbsp;<a href="?p=youtubevote&id=<?php echo $_GET['id']; ?>&a=2&s=vote">2</a>&nbsp;<a href="?p=youtubevote&id=<?php echo $_GET['id']; ?>&a=3&s=vote">3</a>&nbsp;<a href="?p=youtubevote&id=<?php echo $_GET['id']; ?>&a=4&s=vote">4</a>&nbsp;<a href="?p=youtubevote&id=<?php echo $_GET['id']; ?>&a=5&s=vote">5</a>&nbsp;
			<?php
			echo "<br>
			<strong>Beschrijving</strong> :<br>".$row['beschrijving']."<br><br>
			<object width='425' height='355'><param name='movie' value='http://www.youtube.com/v/".$row['link']."&hl=en'></param><param name='wmode' value='transparent'></param><embed src='http://www.youtube.com/v/".$row['link']."&hl=en' type='application/x-shockwave-flash' wmode='transparent' width='425' height='355'></embed></object><br>
			<img src='http://i.ytimg.com/vi/".$row['link']."/1.jpg' />
			<img src='http://i.ytimg.com/vi/".$row['link']."/2.jpg' />
			<img src='http://i.ytimg.com/vi/".$row['link']."/3.jpg' /><br><br>";
		}else{
			echo "Het opgegeven filmpje is helaas niet vindbaar.<br><a href='javascript:history.go(-1)'>Ga terug</a>";
		}
	}elseif(isset($_GET['a']) && $_GET['a'] == "lijst"){
		require ('class/nummers.class.php');
		$query = "SELECT count(id) FROM youtube";
		$result = mysql_query($query);
		$total = mysql_result($result, 0);
	
	
		$results_per_page = 10;
		
		if(isset($_GET['page'])) {
			$current_page = $_GET['page'];
		}else{
			$current_page = 1;
		}
	
		$off = ($current_page*$results_per_page)-$results_per_page;
		$limit  = $off.','.$results_per_page;
	
		$query = "SELECT * FROM youtube ORDER BY titel ASC LIMIT ".$limit;
		$result = mysql_query($query)or die (mysql_error());
		echo "<table width='100%'>
			<tr>
				<td style='border-bottom: 1px solid #000000;'><strong>Voorbeeld</strong></td>
				<td style='border-bottom: 1px solid #000000;'><strong>Titel</strong></td>
				<td style='border-bottom: 1px solid #000000;'><strong>Eigenaar</strong></td>
				<td style='border-bottom: 1px solid #000000;'><strong>Gepost op</strong></td>
			</tr>";
		while($row = mysql_fetch_assoc($result)) {
			$sql_leden = mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id='".$row['member_id']."'");
			$row_leden = mysql_fetch_assoc($sql_leden);
			?>
			<tr>
				<td width="150">
					<a href='?p=youtube&a=kijken&id=<?php echo $row['id']; ?>'>
						<img border="0" src="http://i.ytimg.com/vi/<?php echo $row['link']; ?>/default.jpg" />
					</a>
				</td>
				<td><a href='?p=youtube&a=kijken&id=<?php echo $row['id']; ?>'><strong><?php echo $row['titel']; ?></strong></a></td>
				<td><?php echo $row_leden['gebruikersnaam']; ?></td>
				<td><?php echo $row['datum']; ?></td>
			</tr>
			<?php
		}
		echo "</table>";
		$paginator = new Pagination();
		$paginator->setNumberOfPages($total,$results_per_page);
		$url = 'index.php?p=youtube&a=lijst';
		$paginator->draw($current_page,$url);
		echo $paginator->pagination;
	}elseif(isset($_GET['a']) && $_GET['a'] == "gebruikerslijst" && isset($_GET['id']) && is_numeric($_GET['id'])) {
		$id = mysql_real_escape_string($_GET['id']);
		require ('class/nummers.class.php');
		$query = "SELECT count(id) FROM youtube WHERE member_id='".$id."'";
		$result = mysql_query($query);
		$total = mysql_result($result, 0);
	
	
		$results_per_page = 10;
		
		if(isset($_GET['page'])) {
			$current_page = $_GET['page'];
		}else{
			$current_page = 1;
		}
	
		$off = ($current_page*$results_per_page)-$results_per_page;
		$limit  = $off.','.$results_per_page;
	
		$query = "SELECT * FROM youtube WHERE member_id='".$id."' ORDER BY titel ASC LIMIT ".$limit;
		$result = mysql_query($query)or die (mysql_error());
		echo "<table width='100%'>
			<tr>
				<td style='border-bottom: 1px solid #000000;'><strong>Voorbeeld</strong></td>
				<td style='border-bottom: 1px solid #000000;'><strong>Titel</strong></td>
				<td style='border-bottom: 1px solid #000000;'><strong>Eigenaar</strong></td>
				<td style='border-bottom: 1px solid #000000;'><strong>Gepost op</strong></td>
			</tr>";
		while($row = mysql_fetch_assoc($result)) {
			$sql_leden = mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id='".$row['member_id']."'");
			$row_leden = mysql_fetch_assoc($sql_leden);
			?>
			<tr>
				<td width="150">
					<a href='?p=youtube&a=kijken&id=<?php echo $row['id']; ?>'>
						<img border="0" src="http://i.ytimg.com/vi/<?php echo $row['link']; ?>/default.jpg" />
					</a>
				</td>
				<td><a href='?p=youtube&a=kijken&id=<?php echo $row['id']; ?>'><strong><?php echo $row['titel']; ?></strong></a></td>
				<td><?php echo $row_leden['gebruikersnaam']; ?></td>
				<td><?php echo $row['datum']; ?></td>
			</tr>
			<?php
		}
		echo "</table>";
		if(mysql_num_rows($result) == 0) {
			echo "Deze gebruiker heeft nog geen filmpjes gepost.<br><a href='javascript:history.go(-1)'>Ga terug</a>";
		}
		$paginator = new Pagination();
		$paginator->setNumberOfPages($total,$results_per_page);
		$url = 'index.php?p=youtube&a=gebruikerslijst&id='.$_GET['id'];
		$paginator->draw($current_page,$url);
		echo $paginator->pagination;
	}

}
?>