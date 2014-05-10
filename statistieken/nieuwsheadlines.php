<?php

$sql = mysql_query("
                        SELECT n.nieuws_id, n.titel, n.datum, l.gebruikersnaam, l.member_id, COUNT(r.reactie_id) AS reacties
                                FROM nieuws_berichten AS n
                                LEFT JOIN leden AS l ON n.member_id = l.member_id
                                LEFT JOIN nieuws_reacties AS r ON n.nieuws_id = r.nieuws_id
                                GROUP BY n.nid
                                ORDER BY n.datum DESC
                                LIMIT 5
                      ");

if(mysql_num_rows($sql) > 0) {
while($row = mysql_fetch_assoc($sql)) {
    echo "
<tr><td></td><td>".$row['datum']."</td><td><a href='?p=nieuws&nid=".$row['nieuws_id']."'>".stripslashes($row['titel'])."</a></td><td>Door: <a href='index.php?p=profiel&mid=".$row['member_id']."'>".stripslashes($row_member['gebruikersnaam'])."</a></td></tr>
";
}
}
else {
    echo "Er zijn geen nieuws berichten gevonden.<br />";
}

?>