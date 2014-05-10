<?php

$s_aantal = mysql_query("SELECT COUNT(id) FROM bezonline");  
$aantal = mysql_num_rows($s_aantal); 

if ($aantal > 1)  {
    echo "Er zijn <b>".$aantal."</b> bezoekers";  
}else {
    echo "Er is <b>1</b> bezoeker";  
}
?>