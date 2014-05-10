<?php
$sql_laatste_nieuws = mysql_query("SELECT titel,datum,nieuws_id FROM nieuws_berichten WHERE actief='aan' ORDER BY datum DESC LIMIT 5");
while($row = mysql_fetch_assoc($sql_laatste_nieuws)) {
echo "&raquo; <a href='?p=nieuws&nid=".$row['nieuws_id']."'>".stripslashes(substr($row['titel'],0,25))."</a><br>";
}
?>