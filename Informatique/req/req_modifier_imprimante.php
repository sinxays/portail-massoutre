<?php

include  "../../include.php";


if ($_POST["num_serie"] && $_POST["num_serie"] !== "") {


    $imprimante = array(
        "id" => $_POST['id_imprimante'],
        "num_serie" => $_POST["num_serie"],
        "agence" => $_POST["agence"],
        "emplacement" => $_POST["emplacement"],
        "prestataire" => $_POST["prestataire"],
        "marque" => $_POST["marque"],
        "modele" => $_POST["modele"],
        "ip_vpn" => $_POST["ip_vpn"],
        "ip_locale" => $_POST["ip_locale"]
    );

    modifier_imprimante($imprimante);
}
