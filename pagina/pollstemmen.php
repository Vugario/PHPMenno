<?php
if(isset($_SESSION['id'])) {
if (empty($_POST)){
    echo "Er is iets fout gegaan.";
}else{
    $ip = $_SERVER['REMOTE_ADDR'];
    $poll = $_POST["poll"];
    $query = "INSERT INTO poll_ip (ip,poll_id) VALUES ('$ip','$poll')";
    mysql_query($query);
    if(mysql_error() != "") {
        echo "Je drukt toch niet op F5 he? Je hebt namelijk al gestemd";
    }else{
        $query = "UPDATE leden SET muntjes=muntjes+10 WHERE member_id='".$_SESSION['id']."'";
        mysql_query($query);
        echo "Je hebt succesvol gestemd, Je hebt er 10 muntjes bij";
    }
}
}else{
   echo "Je bent niet ingelogd, Log eerst in om te stemmen.";
}
?>