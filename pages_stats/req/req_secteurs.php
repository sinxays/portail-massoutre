<?php

include  "../../include.php";

$result = getAllSecteurs();

$html = "";
$html .= "<select class='form-select' id='afficherSecteurs_select'>";
$html .=  "<option selected value='0'> </option>";
foreach ($result as $array_secteur) {
    $html .= "<option value=" . $array_secteur['ID'] . ">".$array_secteur['nom_secteur']."</option>";
}
$html .= "</select >";


echo $html;
