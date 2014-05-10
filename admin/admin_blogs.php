<script language="JavaScript">
      function confirmAction() {
        var menno = confirm("Weet je zeker dat je de blog wilt verwijderen?");
		if(menno) {
			return true;
		}else{
			return false;
		}
      }
   
</script>
<?php

if(isset($_SESSION['admin']) || isset($_SESSION['nieuwsreporter']) || isset($_SESSION['moderator'])) {
	if(isset($_GET['a'])) {
		if($_GET['a'] == "blogs" && isset($_GET['s']) && is_numeric($_GET['nid'])) {
			if($_GET['s'] == "verwijderen") {
					echo $blogs->blogsVerwijderen($_GET['nid']);
			}
		}
	}
	$sql = mysql_query("SELECT * FROM blogs_berichten ORDER BY blogs_id ASC");
	echo "<table cellpadding='0' cellspacing='0' width=\"700\">
			<tr>
				<td style='border-bottom: 1px solid #000000;'><strong>#</strong></td>
				<td style='border-bottom: 1px solid #000000;'><strong>Titel</strong></td>
				<td style='border-bottom: 1px solid #000000;'><strong>Bericht</strong></td>
				<td style='border-bottom: 1px solid #000000;'><strong>Actief</strong></td>
				<td style='border-bottom: 1px solid #000000;'><strong>verwijderen</strong></td>
			</tr>";
	while($row = mysql_fetch_assoc($sql)) {
		echo "<tr>
				<td>".$row['blogs_id']."</td>
				<td>".$row['titel']."</td>
				<td>".substr($row['bericht'],0,15)."</td>
				<td>".$row['actief']."</td>
				<td><a href='?p=admin_blogs&a=blogs&s=verwijderen&nid=".$row['blogs_id']."' onclick='return confirmAction()'>Verwijderen</a></td>
			</tr>";
	}
	echo "</table>";
	if(mysql_num_rows($sql) == 0) {
		echo "Er zijn geen blogs gevonden.<br><a href='javascript:history.go(-1)'>Ga terug</a>";
	}
}else{
	echo "Zou wel leuk zijn als je admin was.<br /><a href='#' onclick='history.go(-1)'>Ga terug</a>";
}
?>