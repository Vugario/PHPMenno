<?php

$sql = mysql_query("SELECT * FROM faq");
while($row = mysql_fetch_assoc($sql)) {
	echo "<strong>".$row['vraag']."</strong><br />
	".$row['antwoord']."<br /><br />";
}
if(mysql_num_rows($sql) == 0) {
	echo "Er zijn helaas geen vragen.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
}

?>