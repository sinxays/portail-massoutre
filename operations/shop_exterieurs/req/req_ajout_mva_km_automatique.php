<?php

include "../../../include.php";

if (isset($_POST)) {
    $data_mva_and_km = get_mva_and_km_from_immatriculation($_POST['immatriculation']);
    //todo 12/09


    echo json_encode(array("mva" => $data_mva_and_km['numero'], "km" => $data_mva_and_km["km_wizard"]));

}




