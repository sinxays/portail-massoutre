<?php

include  "../../include.php";

$result = getAllAgencesGroupSecteurDistrict();

$html = "";
$html .= "<select class='form-select' id='afficherQuoi_select_district'>";
$html .=  "<option value='0'> </option>";
foreach ($result as $array_district) {
    $html .= "<option  value=" . $array_district['ID'] . ">" . $array_district['district'] . "</option>";
}
$html .= "</select >";


echo $html;