<?php

    $sql = mysql_query("SELECT * FROM faq");
    while($row = mysql_fetch_assoc($sql)) {
    	echo "<strong>".$row['vraag']."</strong><br />
    	".$row['antwoord']."<br /><br />";
    }

?>