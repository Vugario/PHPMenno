<?php

//--- Nieuwe Kode Maken ---\\
function maakkode(){
    $aLetters = range('A', 'Z');
    
    $_SESSION['kode'][0] = $aLetters[rand(0,25)];
    $_SESSION['kode'][1] = $aLetters[rand(0,25)];
    $_SESSION['kode'][2] = $aLetters[rand(0,25)];
    $_SESSION['kode'][3] = $aLetters[rand(0,25)];
    $_SESSION['kode'][4] = rand(0,9);
    $_SESSION['kode'][5] = rand(0,9);
}

//--- Kijken of een Kode Goed is ---\\
function checkkode($aKode){

    if(empty($aKode[0]) || is_numeric($aKode[0]) || empty($aKode[1]) || is_numeric($aKode[1]) || empty($aKode[2]) || is_numeric($aKode[2]) || empty($aKode[3]) || is_numeric($aKode[3]) || !is_numeric($aKode[4]) || !is_numeric($aKode[5])){
        return array(-1);
    }

    foreach($aKode as $iKey => $sValue){
        if($_SESSION['kode'][$iKey] == strtoupper($sValue)){
            $aReturn[$iKey] = 2;
        }elseif(in_array(strtoupper($sValue), $_SESSION['kode'])){
            $aReturn[$iKey] = 1;
        }else{
            $aReturn[$iKey] = 0;
        }
    }
    
    return $aReturn;
}

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    # Eerste keer dat deze pagina bezocht word een nieuwe Kode maken:
    maakkode();
}else{
    # Ingevulde Kode Checken:
    $check = checkkode($_POST['kode']);
    if(array_sum($check) == 12){
        # In dit geval klopt de Kode 100% dus een nieuwe Kode maken:
        maakkode();
        echo "Kode: <strong>".implode('', $_POST['kode'])."</strong> was juist geraden!<br />";
		echo "Je hebt <b>$kraakdekluis</b> muntjes ontvangen door de code goed te raden!<br>";
		echo "De muntjes zijn nu bij geschreven!<br>";
		//== Muntjes bijschrijven hier ==\\
		
		    }elseif(array_sum($check) == -1){
        # In dit geval is er een Kode ingevuld die nergens op slaat:
        echo "Je moet een Kode invullen die bestaat uit 4 letters en 2 cijfers bijvoorbeeld: ABCD12<br />";
    }else{
        # De Kode Klopt niet, deze weergeven:
        echo "Laatst geraden: ";
        foreach($check as $key => $value){
            switch($value){
                case 2:
                    echo "<span style=\"color: #0f0;\">".$_POST['kode'][$key]."</span>";
                    break;
                case 1:
                    echo "<span style=\"color: #00f;\">".$_POST['kode'][$key]."</span>";
                    break;
                default:
                    echo "<span style=\"color: #f00;\">".$_POST['kode'][$key]."</span>";
            }
        }
        
        echo "<br /><span style=\"color: #f00;\">Rood</span> = Fout<br /><span style=\"color: #00f;\">Blauw</span> = Andere positie<br /><span style=\"color: #0f0;\">Groen</span> = Goed<br />";
    }
}

echo "<form method=\"post\" action=\"#\">";
echo "Letter 1: <input type=\"text\" name=\"kode[]\" size=\"5\" maxlength=\"1\" /><br />";
echo "Letter 2: <input type=\"text\" name=\"kode[]\" size=\"5\" maxlength=\"1\" /><br />";
echo "Letter 3: <input type=\"text\" name=\"kode[]\" size=\"5\" maxlength=\"1\" /><br />";
echo "Letter 4: <input type=\"text\" name=\"kode[]\" size=\"5\" maxlength=\"1\" /><br />";
echo "Cijfer 1: <input type=\"text\" name=\"kode[]\" size=\"5\" maxlength=\"1\" /><br />";
echo "Cijfer 2: <input type=\"text\" name=\"kode[]\" size=\"5\" maxlength=\"1\" /><br />";
echo "<input type=\"submit\" name=\"submit\" value=\"Kraak\" />";
echo "</form>";
?>
<br> 
