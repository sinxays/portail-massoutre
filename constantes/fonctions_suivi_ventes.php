<?php


use app\Connection;

function alimenter_suivi_ventes_bdc($date_bdc_selected)
{


    /******************************************  CODE MAIN ******************************************/

    ini_set('xdebug.var_display_max_depth', 10);
    ini_set('xdebug.var_display_max_children', 256);
    ini_set('xdebug.var_display_max_data', 1024);


    set_time_limit(0);
    // recup données

    $request_bon_de_commande = "v3.1/order-form/";

    $url = "https://www.kepler-soft.net/api/";

    $req_url_BC = $url . "" . $request_bon_de_commande;


    $j = 1;

    $array_datas = array();

    $nb_BC = 0;
    $nb_lignes = 0;
    $i = 0;
    $nb_total_vehicules_selling = 0;

    $datas_find = true;

    $state_array = array();

    $array_datas[$i] = ["N Bon Commande", "Immatriculation", "RS/Nom Acheteur", "Prix Vente HT", "Prix de vente TTC", "Vendeur Vente", "Dernier n° de facture", "date du dernier BC", "Destination de sortie", "VIN"];

    while ($datas_find == true) {



        $num_BDC = '';
        // $date_bdc = '';
        $date_bdc = $date_bdc_selected;
        $uuid = '';


        // on reboucle pas si on met une valeur spécifique de bdc afin de récupérer qu'une seule page de l'API
        if ($num_BDC !== '') {
            $datas_find = false;
        }
        //recupere la requete !!!!
        $valeur_token = goCurlToken();
        $obj = GoCurl_Recup_BDC($valeur_token, $j, $num_BDC, $date_bdc);

        //a ce niveau obj est un object

        //on prends le tableau datas dans obj et ce qui nous fait un array sur obj_final
        if (!empty ($obj)) {
            $obj_final = $obj->datas;
        } else {
            $obj_final = '';
        }

        // var_dump($obj_final);
        // die();

        $infos_bdc = array();

        if (!empty ($obj_final)) {


            /*****************    BOUCLE du tableau de données récupérés *****************/
            $i++;

            //on boucle par rapport au nombre de bon de commande dans le tableau datas[]
            foreach ($obj_final as $keydatas => $keyvalue) {

                // on récupere le state du bon de commande 
                if (isset ($keyvalue->state)) {
                    $state_bdc = html_entity_decode($keyvalue->state);

                    $infos_bdc['uuid'] = $keyvalue->uuid;
                    // $state = utf8_decode($keyvalue->state);
                    saut_de_ligne();
                    saut_de_ligne();
                    echo "ETAT ==>" . $state_bdc;
                }


                //$test = utf8_decode($state);

                //echo $test.'<br/><br/>';

                // si validé , Facturé ou Facturé édité
                if ($state_bdc == "Validé" or $state_bdc == "Facturé" or $state_bdc == "Facturé édité") {

                    //get ID
                    $infos_bdc['bdc'] = $keyvalue->uniqueId;

                    echo "bon de commande numéro :" . $infos_bdc['bdc'];

                    //get nom acheteur
                    if (isset ($keyvalue->owner->firstname)) {
                        $nom_acheteur_tmp = $keyvalue->owner->firstname . " " . $keyvalue->owner->lastname;
                    } else if (isset ($keyvalue->customer->firstname)) {
                        $nom_acheteur_tmp = $keyvalue->customer->firstname . " " . $keyvalue->customer->lastname;
                    } else {
                        $nom_acheteur_tmp = $keyvalue->customer->corporateName;
                    }

                    $infos_bdc['nom_acheteur'] = $nom_acheteur_tmp;

                    //get nom vendeur
                    $infos_bdc['nom_vendeur'] = trim($keyvalue->seller);
                    /**  MAJ ils mettent "prenom nom mail" maintenant, il faut garder "prenom nom" uniquement **/
                    $array_nom_vendeur_tmp = explode(" ", $infos_bdc['nom_vendeur']);
                    $infos_bdc['nom_vendeur'] = $array_nom_vendeur_tmp[0] . " " . $array_nom_vendeur_tmp[1];

                    //get CVO Vente
                    $infos_bdc['nom_cvo'] = get_CVO_by_vendeur($infos_bdc['nom_vendeur']);

                    //GET DATE BC
                    $date_BC_tmp = substr($keyvalue->date, 0, 10);
                    $date_BC_tmp2 = str_replace("-", "/", $date_BC_tmp);
                    $date_BC = date('d/m/Y', strtotime($date_BC_tmp2));

                    $infos_bdc['date_BDC'] = $date_BC;


                    //get destination sortie
                    if (empty ($keyvalue->destination)) {
                        $destination_sortie = '';
                    } else {
                        $destination_sortie = $keyvalue->destination;
                    }

                    $infos_bdc['destination_sortie'] = $destination_sortie;


                    //déterminer si c'est une vente particvulier ou vente marchand ( particulier ou pro )

                    //si c'est particulier 
                    if ($destination_sortie == "VENTE PARTICULIER") {

                        $erreur_vehicule_sorti = false;

                        // echo "<span style='color:red'>" . $erreur_vehicule_sorti . "</span>";

                        //Si il y a des items
                        if (isset ($keyvalue->items)) {

                            //ON BOUCLE DANS LES ITEMS
                            foreach ($keyvalue->items as $key_item => $value_item) {
                                //si c'est un vehicule_selling
                                if ($value_item->type == 'vehicle_selling') {

                                    $reference_item = $value_item->reference;

                                    //  recup infos du véhicule
                                    $valeur_token = goCurlToken();
                                    $state_vh = '';
                                    //on prend le vehicule qu'il soit sorti ou non
                                    $obj_vehicule = getvehiculeInfo($reference_item, $valeur_token, $state_vh, FALSE);

                                    if (empty ($obj_vehicule)) {
                                        $result = getvehiculeInfo($reference_item, $valeur_token, $state_vh, TRUE);
                                        $obj_vehicule = json_decode($result);
                                    }

                                    $type = gettype($obj);

                                    sautdeligne();

                                    // var_dump($type);
                                    // die();

                                    // si c'est bien un objet comme prévu
                                    if ($type == 'object') {

                                        // si le résultat n'est pas vide
                                        if (!empty ($obj_vehicule)) {

                                            //on recupère les infos du vehicule
                                            $infos_vh = get_infos_vehicule_for_suivi_ventes($obj_vehicule);

                                            $vehicule_seul_HT = $value_item->sellPriceWithoutTaxWithoutDiscount;
                                            $vehicule_seul_TTC = $value_item->sellPriceWithTax;

                                        }
                                        //si le résultat est vide
                                        else {
                                            echo "véhicule sorti";
                                            sautdeligne();
                                            $erreur_vehicule_sorti = true;
                                        }
                                    }
                                    //sinon si on ne trouve rien sur le vh
                                    else {
                                        echo "pas un objet";
                                    }
                                }
                                // si $erreur_vehicule_sorti == false
                                if (!$erreur_vehicule_sorti) {

                                    $i++;

                                    echo "+1 ligne </br>";

                                    $total_HT = $vehicule_seul_HT;
                                    $total_TTC = $vehicule_seul_TTC;

                                    // On place les valeurs dans les cellules
                                    $array_datas[$i]['uniqueId'] = $infos_bdc['bdc'];
                                    $array_datas[$i]['immatriculation'] = $infos_vh['immatriculation'];
                                    $array_datas[$i]['name'] = $infos_bdc['nom_acheteur'];
                                    $array_datas[$i]['prixTotalHT'] = $total_HT;
                                    $array_datas[$i]['prixTTC'] = $total_TTC;
                                    $array_datas[$i]['nomVendeur'] = $infos_bdc['nom_vendeur'];
                                    $array_datas[$i]['num_last_facture'] = '';
                                    $array_datas[$i]['dateBC'] = $date_BC;
                                    $array_datas[$i]['Destination_sortie'] = $destination_sortie;
                                    $array_datas[$i]['VIN'] = $infos_vh['vin'];
                                    $array_datas[$i]['reference_kepler'] = $infos_vh['reference_kepler'];
                                    $array_datas[$i]['provenance_vh'] = $infos_vh['provenance'];
                                    $array_datas[$i]['marque'] = $infos_vh['marque'];
                                    $array_datas[$i]['modele'] = $infos_vh['modele'];
                                    $array_datas[$i]['version_vh'] = $infos_vh['version'];

                                    // var_dump($array_datas[$i]);

                                    //SUIVI VENTES BDC : insertion dans la base
                                    upload_suivi_ventes_bdc($array_datas[$i], $infos_bdc['uuid']);
                                }
                            }
                        }
                    }


                    /****************************************** si c'est une VENTE A MARCHAND BUYS BACK OU VENTE EXPORT CE  ***********************************/
                    // else {
                    elseif ($destination_sortie == "VENTE MARCHAND" || $destination_sortie == "BUY BACK" || $destination_sortie == "VENTE EXPORT CE" || $destination_sortie == "VENTE EXPORT HORS CE" || $destination_sortie == "EPAVE") {

                        $erreur_vehicule_sorti = false;

                        //Si il y a des items
                        if (isset ($keyvalue->items)) {

                            //on boucle dans les items
                            foreach ($keyvalue->items as $key_item => $value_item) {
                                $comptabilisation_ligne = false;
                                //on crée une variable qui contiendra le numéro de bdc initial

                                //si c'est un vehicule_selling
                                if ($value_item->type == 'vehicle_selling') {

                                    $reference_item = $value_item->reference;

                                    //  recup infos du véhicule
                                    $valeur_token = goCurlToken();
                                    $state_vh = '';
                                    $obj_vehicule = getvehiculeInfo($reference_item, $valeur_token, $state_vh, FALSE);

                                    if (empty ($obj_vehicule)) {
                                        $result = getvehiculeInfo($reference_item, $valeur_token, $state_vh, TRUE);
                                        $obj_vehicule = json_decode($result);
                                    }

                                    $type = gettype($obj);

                                    //si on obtient un object.
                                    if ($type == 'object') {

                                        // si le résultat n'est pas vide
                                        if (!empty ($obj_vehicule)) {

                                            //on recupère les infos du vehicule
                                            $infos_vh = get_infos_vehicule_for_suivi_ventes($obj_vehicule);

                                            $vehicule_seul_HT = $value_item->sellPriceWithoutTaxWithoutDiscount;
                                            $vehicule_seul_TTC = $value_item->sellPriceWithTax;

                                            $comptabilisation_ligne = true;



                                            if ($comptabilisation_ligne == true) {

                                                //total vehicule 
                                                $total_HT = $vehicule_seul_HT;
                                                $total_TTC = $vehicule_seul_TTC;

                                                $i++;

                                                // On place les valeurs dans les cellules
                                                $array_datas[$i]['uniqueId'] = $infos_bdc['bdc'];
                                                $array_datas[$i]['immatriculation'] = $infos_vh['immatriculation'];
                                                $array_datas[$i]['name'] = $infos_bdc['nom_acheteur'];
                                                $array_datas[$i]['prixTotalHT'] = $total_HT;
                                                $array_datas[$i]['prixTTC'] = $total_TTC;
                                                $array_datas[$i]['nomVendeur'] = $infos_bdc['nom_vendeur'];
                                                $array_datas[$i]['num_last_facture'] = '';
                                                $array_datas[$i]['dateBC'] = $date_BC;
                                                //demande mickael : si c'est une epave on transforme en vente marchand
                                                if ($destination_sortie == 'EPAVE') {
                                                    $destination_sortie = 'VENTE MARCHAND';
                                                }
                                                $array_datas[$i]['Destination_sortie'] = $destination_sortie;
                                                $array_datas[$i]['VIN'] = $infos_vh['vin'];
                                                $array_datas[$i]['reference_kepler'] = $infos_vh['reference_kepler'];
                                                $array_datas[$i]['provenance_vh'] = $infos_vh['provenance'];
                                                $array_datas[$i]['marque'] = $infos_vh['marque'];
                                                $array_datas[$i]['modele'] = $infos_vh['modele'];
                                                $array_datas[$i]['version_vh'] = $infos_vh['version'];

                                                //SUIVI VENTES BDC : insertion dans la base
                                                upload_suivi_ventes_bdc($array_datas[$i], $infos_bdc['uuid']);
                                            }
                                        }
                                        //si le résultat est vide
                                        else {
                                            echo "véhicule sorti";
                                            sautdeligne();
                                        }
                                    } else {
                                        echo "pas un objet";
                                    }
                                }
                            }
                        }
                    }
                    // si pas vente marchand NI vente PARTICULIER
                    // else {
                    //     echo "erreur ni vente particulier ni vente marchand<br/>";
                    // }

                }
                //si c'est ni validé ni facturé ni facturé édité 
                else {
                    $state_array[] = $state_bdc;
                }
                //on insere dans la base de donnée temporaire pour identifier les bdc avec leur uuid 
                if (!is_null($infos_bdc['bdc']) && !is_null($infos_bdc['uuid'])) {
                    insert_bdc_ventes_uuid($infos_bdc['bdc'], $infos_bdc['uuid']);
                }
            }

        }
        //si il n'y a pas de données
        else {
            $datas_find = false;
        }
        $j++;
    }



}

function alimenter_suivi_ventes_factures($date_recup_facture)
{

    // recup valeur token seulement
    $valeur_token = goCurlToken();

    // recup données
    $request_facture = "v3.1/invoice/";
    $request_vehicule = "v3.7/vehicles/";

    $url = "https://www.kepler-soft.net/api/";

    $req_url = $url . "" . $request_facture;
    $req_url_vehicule = $url . "" . $request_vehicule;


    $datas_find = true;
    $array_datas = array();
    $nb_factures = 0;
    $nb_lignes = 0;
    $i = 0;
    $j = 1;

    while ($datas_find == true) {

        //recupere la requete !!!!
        $obj = GoCurl_Facture($valeur_token, $req_url, $j, $date_recup_facture);
        $obj_final = $obj->datas;

        if (!empty ($obj_final)) {
            $datas_find = true;

            $i++;

            /*****************    BOUCLE du tableau de données récupérés *****************/
            foreach ($obj_final as $keydatas => $keyvalue) {

                $infos_facture = get_infos_facture($keyvalue);

                if (isset ($keyvalue->items)) {
                    foreach ($keyvalue->items as $key_item => $value_item) {
                        if ($value_item->type == 'vehicle_selling') {

                            $reference_kepler = $value_item->reference;

                            // on ne prend que les facture VO, car il peut y avoir des AV ( avoir )
                            if (strpos($infos_facture['numero_facture'], 'VO') !== FALSE) {

                                $prix_vehicule_HT = $value_item->sellPriceWithoutTaxWithoutDiscount;

                                $array_datas[$i]['date_facture'] = $infos_facture['date_facture'];
                                $array_datas[$i]['numero_facture'] = $infos_facture['numero_facture'];
                                $array_datas[$i]['montant_total_facture_HT'] = $infos_facture['montant_total_facture_HT'];
                                $array_datas[$i]['prix_vente_vehicule_HT'] = $prix_vehicule_HT;
                                $array_datas[$i]['nom_acheteur'] = $infos_facture['nom_acheteur'];
                                $array_datas[$i]['adresse_client'] = $infos_facture['adresse_client'];
                                $array_datas[$i]['cp_client'] = $infos_facture['cp_client'];
                                $array_datas[$i]['ville_client'] = $infos_facture['ville_client'];
                                $array_datas[$i]['pays_client'] = $infos_facture['pays_client'];
                                $array_datas[$i]['email_client'] = $infos_facture['email_client'];
                                $array_datas[$i]['telmobile_client'] = $infos_facture['telmobile_client'];
                                $array_datas[$i]['vendeur'] = $infos_facture['nom_vendeur'];
                                $array_datas[$i]['parc'] = get_CVO_by_vendeur($infos_facture['nom_vendeur']);
                                $array_datas[$i]['destination_sortie'] = get_destination_sortie($infos_facture['destination_sortie']);
                                $array_datas[$i]['source_client'] = $infos_facture['source_client'];
                                $array_datas[$i]['bdc_liee'] = $infos_facture['bdc_liee'];
                                $array_datas[$i]['reference_kepler'] = $reference_kepler;

                                upload_suivi_ventes_factures($array_datas[$i]);

                                $nb_lignes++;
                                $i++;

                            }
                        }
                    }
                }

                $nb_factures++;
            }
        } else {
            $datas_find = false;
        }
        $j++;
    }


    sautdeligne();

    echo 'nombre de Factures : ' . $nb_factures;

    sautdeligne();

    echo 'nombre de lignes : ' . $nb_lignes;


}


function goCurlToken()
{

    $url = "https://www.kepler-soft.net/api/v3.0/auth-token/";

    $ch2 = curl_init();

    curl_setopt($ch2, CURLOPT_URL, $url);
    curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch2, CURLOPT_POST, true);
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch2, CURLOPT_POSTFIELDS, "apiKey=54c4fbe3ee0ed3683a17488371d5e762b9c5f4db6a7bc0507d3518c40bedfe300fbece014e3eac21acd380a142e874c460931659fe922bc1ef170d1f325e499c");

    $result = curl_exec($ch2);

    curl_close($ch2);

    $data = json_decode($result, true);


    return $data['value'];
}



function GoCurl_Recup_BDC($token, $page, $num_bdc = '', $date_bdc = '')
{

    $ch = curl_init();

    // le token
    $header = array();
    $header[] = 'X-Auth-Token:' . $token;
    $header[] = 'Content-Type:text/html;charset=utf-8';

    // choper un BC spécifique
    if (isset ($num_bdc) && $num_bdc != '') {
        $dataArray = array(
            /* 'state' => array(
            //     'administrative_selling.state.invoiced_edit',
            //     'administrative_selling.state.valid',
            //     'administrative_selling.state.invoiced',
            // ),*/
            "uniqueId" => $num_bdc,
            "page" => $page
        );
    }
    //sinon par date
    else {

        if (isset ($date_bdc) && $date_bdc != '') {

            $dataArray = array(
                // "state" => array(
                //     'administrative_selling.state.invoiced_edit',
                //     'administrative_selling.state.valid',
                //     'administrative_selling.state.invoiced',
                // ),
                "orderFormDateFrom" => "$date_bdc",
                "orderFormDateTo" => "$date_bdc",
                "count" => 100,
                "page" => $page
            );
        }
        //si pas de date alors on prend ceux d'hier
        else {
            $date_hier = date('Y-m-d', strtotime('-1 day'));
            $dataArray = array(
                "state" => array(
                    'administrative_selling.state.invoiced_edit',
                    'administrative_selling.state.valid',
                    'administrative_selling.state.invoiced',
                ),
                // "state" => "administrative_selling.state.invoiced",
                "orderFormDateFrom" => "$date_hier",
                "orderFormDateTo" => "$date_hier",
                // "updateDateFrom" => "$date_hier",
                // "updateDateTo" => "$date_hier",
                "count" => 100,
                "page" => $page
            );
        }
    }

    $url = "https://www.kepler-soft.net/api/";
    $request_bon_de_commande = "v3.1/order-form/";

    $url_bdc = $url . "" . $request_bon_de_commande;

    $getURL = $url_bdc . '?' . http_build_query($dataArray);

    print_r($getURL);

    // die();

    sautdeligne();

    curl_setopt($ch, CURLOPT_URL, $getURL);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);


    $result = curl_exec($ch);

    if (curl_error($ch)) {
        $result = curl_error($ch);
        print_r($result);
        echo "<br/> erreur";
    }

    curl_close($ch);

    echo gettype($result);
    echo $result;

    $obj = json_decode($result);

    // sautdeligne();
    // echo gettype($obj);
    // die();



    // echo gettype($obj);
    // var_dump($obj);


    // echo '<pre>' . print_r($obj) . '</pre>';

    if (!isset ($num_bdc) && $num_bdc == '') {
        echo '<pre> nombre total de BDC : ' . $obj->total . '</pre>';
        echo '<pre> page actuelle :' . $obj->currentPage . '</pre>';
        echo '<pre> BDC par page :' . $obj->perPage . '</pre>';
    }

    return $obj;
}



function GoCurl_Facture($token, $url, $page, $date = '')
{

    $ch = curl_init();

    // le token
    //$token = '7MLGvf689hlSPeWXYGwZUi\/t2mpcKrvVr\/fKORXMc+9BFxmYPqq4vOZtcRjVes9DBLM=';
    $header = array();
    $header[] = 'X-Auth-Token:' . $token;
    $header[] = 'Content-Type:text/html;charset=utf-8';

    if (isset ($date) && $date !== '') {
        //sur une date
        $dataArray = array(
            "state" => 'invoice.state.edit',
            "invoiceDateFrom" => $date,
            "invoiceDateTo" => $date,
            "count" => "100",
            "page" => $page
        );
    } else {
        //sinon on prend à J-1
        $date = date('Y-m-d', strtotime('-1 day'));
        $dataArray = array(
            "state" => 'invoice.state.edit',
            "invoiceDateFrom" => $date,
            "invoiceDateTo" => $date,
            "count" => "100",
            "page" => $page
        );
    }

    $data = http_build_query($dataArray);

    $getURL = $url . '?' . $data;

    print_r($getURL);

    sautdeligne();

    curl_setopt($ch, CURLOPT_URL, $getURL);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

    $result = curl_exec($ch);

    if (curl_error($ch)) {
        $result = curl_error($ch);
        print_r($result);
        echo "<br/> erreur";
    }

    curl_close($ch);

    echo "<pre>";
    print_r($result);
    echo "</pre>";

    $obj = json_decode($result);

    return $obj;

}

function getvehiculeInfo($reference, $token, $state, $is_not_available_for_sell = '')
{

    $ch = curl_init();

    // le token
    $header = array();
    $header[] = 'X-Auth-Token:' . $token;
    $header[] = 'Content-Type:text/html;charset=utf-8';

    switch ($is_not_available_for_sell) {
        case TRUE:

            if (isset ($state) && $state == 'arrivage_or_parc') {
                $dataArray = array(
                    "reference" => $reference,
                    "state" => 'vehicle.state.on_arrival,vehicle.state.parc',
                    "isNotAvailableForSelling" => TRUE
                );
            }
            // !!!! si le vh est vendu, vendu AR, en cours, sorti, sorti AR ou annulé alors il faudra mettre l'état obligatoirement si tu veux un retour 
            else {
                $dataArray = array(
                    "reference" => $reference,
                    "state" => 'vehicle.state.sold,vehicle.state.sold_ar,vehicle.state.pending,vehicle.state.out,vehicle.state.out_ar,vehicle.state.canceled',
                    "isNotAvailableForSelling" => TRUE
                );
            }

            break;

        case FALSE:
            if (isset ($state) && $state == 'arrivage_or_parc') {
                $dataArray = array(
                    "reference" => $reference,
                    "state" => 'vehicle.state.on_arrival,vehicle.state.parc',
                    "isNotAvailableForSelling" => FALSE
                );
            }
            // !!!! si le vh est vendu, vendu AR, en cours, sorti, sorti AR ou annulé alors il faudra mettre l'état obligatoirement si tu veux un retour 
            else {
                $dataArray = array(
                    "reference" => $reference,
                    "state" => 'vehicle.state.sold,vehicle.state.sold_ar,vehicle.state.pending,vehicle.state.out,vehicle.state.out_ar,vehicle.state.canceled',
                    "isNotAvailableForSelling" => FALSE
                );
            }
            break;

    }

    $data = http_build_query($dataArray);

    $url = "https://www.kepler-soft.net/api/";
    $request_vehicule = "v3.7/vehicles/";

    $url_vehicule = $url . "" . $request_vehicule;

    $getURL = $url_vehicule . '?' . $data;

    print_r($getURL);

    sautdeligne();

    curl_setopt($ch, CURLOPT_URL, $getURL);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

    $result = curl_exec($ch);




    if (curl_error($ch)) {
        $result = curl_error($ch);
        print_r($result);
        echo "<br/> erreur";
    }

    curl_close($ch);

    // créer un objet à partir du retour qui est un string
    $obj_vehicule = json_decode($result);

    // var_dump($obj_vehicule);

    // la on a un array
    //si on a l'erreur de token authentification alors on relance un token
    if (isset ($obj_vehicule->code) && $obj_vehicule->code == 401) {
        $valeur_token = goCurlToken();

        $obj = getvehiculeInfo($reference, $valeur_token, $state,TRUE);

        $return = $obj;

    }
    //sinon on continue normal
    else {

        //on prend l'object qui est dans l'array
        $return = $obj_vehicule[0];

        // on retourne un objet

    }
    // var_dump($return);
    return $return;



}

function get_reference_vehiculeInfo_by_immatriculation($immatriculation, $token, $url_vehicule, $state, $is_not_available_for_sell = '')
{

    $ch = curl_init();

    // le token
    $header = array();
    $header[] = 'X-Auth-Token:' . $token;
    $header[] = 'Content-Type:text/html;charset=utf-8';

    switch ($is_not_available_for_sell) {
        case TRUE:

            if (isset ($state) && $state == 'arrivage_or_parc') {
                $dataArray = array(
                    "licenseeNumber" => $immatriculation,
                    "state" => 'vehicle.state.on_arrival,vehicle.state.parc',
                    "isNotAvailableForSelling" => TRUE
                );
            }
            // !!!! si le vh est vendu, vendu AR, en cours, sorti, sorti AR ou annulé alors il faudra mettre l'état obligatoirement si tu veux un retour 
            else {
                $dataArray = array(
                    "licenseeNumber" => $immatriculation,
                    "state" => 'vehicle.state.sold,vehicle.state.sold_ar,vehicle.state.pending,vehicle.state.out,vehicle.state.out_ar,vehicle.state.canceled',
                    "isNotAvailableForSelling" => TRUE
                );
            }

            break;

        case FALSE:
            if (isset ($state) && $state == 'arrivage_or_parc') {
                $dataArray = array(
                    "licenseeNumber" => $immatriculation,
                    "state" => 'vehicle.state.on_arrival,vehicle.state.parc',
                    "isNotAvailableForSelling" => FALSE
                );
            }
            // !!!! si le vh est vendu, vendu AR, en cours, sorti, sorti AR ou annulé alors il faudra mettre l'état obligatoirement si tu veux un retour 
            else {
                $dataArray = array(
                    "licenseeNumber" => $immatriculation,
                    "state" => 'vehicle.state.sold,vehicle.state.sold_ar,vehicle.state.pending,vehicle.state.out,vehicle.state.out_ar,vehicle.state.canceled',
                    "isNotAvailableForSelling" => FALSE
                );
            }
            break;

    }

    $data = http_build_query($dataArray);

    $getURL = $url_vehicule . '?' . $data;

    print_r($getURL);

    sautdeligne();

    curl_setopt($ch, CURLOPT_URL, $getURL);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

    $result = curl_exec($ch);

    if (curl_error($ch)) {
        $result = curl_error($ch);
        print_r($result);
        echo "<br/> erreur";
    }

    curl_close($ch);

    // créer un objet à partir du retour qui est un string
    $obj_vehicule = json_decode($result);

    // var_dump($obj_vehicule);

    // la on a un array
    //si on a l'erreur de token authentification alors on relance un token
    if (isset ($obj_vehicule->code) && $obj_vehicule->code == 401) {
        $valeur_token = goCurlToken();

        $obj = get_reference_vehiculeInfo_by_immatriculation($immatriculation, $valeur_token, $url_vehicule, $state);

        $return = $obj;

    }
    //sinon on continue normal
    else {

        //on prend l'object qui est dans l'array
        $return = $obj_vehicule[0];

        // on retourne un objet

    }
    // var_dump($return);
    return $return;



}


function upload_suivi_ventes_bdc($bdc, $uuid)
{
    $pdo = Connection::getPDO();

    $num_bdc = $bdc['uniqueId'];

    // on check deja si il existe un bdc identique car si marchand on peut avoir plusieurs vh sur un même bdc
    $request = $pdo->query("SELECT id,numero_bdc FROM suivi_ventes_bdc WHERE numero_bdc = $num_bdc");
    $bdc_check = $request->fetch(PDO::FETCH_ASSOC);
    // var_dump($bdc_check);

    //si c'est le même bdc mais un autre vh
    if ($bdc_check && ($num_bdc == $bdc_check['numero_bdc'])) {

        //insert du vh dans suivi_ventes_vh

        //si le vh n'existe pas déja bien entendu
        $immat_no_exist = check_if_immatriculation_exist_suivi_ventes($bdc['immatriculation']);
        if (!$immat_no_exist) {
            $data_vh = [
                'immatriculation' => $bdc['immatriculation'],
                'provenance' => $bdc['provenance_vh'],
                'VIN' => $bdc['VIN'],
                'marque' => $bdc['marque'],
                'modele' => $bdc['modele'],
                'version_vh' => $bdc['version_vh'],
                'bdc_id' => $bdc_check['id'],
                'reference_kepler' => $bdc['reference_kepler']
            ];
            $sql = "INSERT INTO vehicules_suivi_ventes (immatriculation,provenance_vo_vn,vin,marque,modele,version,bdc_id,reference_kepler) 
            VALUES (:immatriculation, :provenance,:VIN, :marque,:modele, :version_vh,:bdc_id,:reference_kepler)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($data_vh);
        }

    }
    //sinon ajout d'un nouveau bdc 
    else {
        var_dump($bdc['nomVendeur']);
        $vendeur_id = get_id_collaborateur_payplan_by_name($bdc['nomVendeur']);
        var_dump($vendeur_id);
        $date_bdc = format_date_FR_TO_US($bdc['dateBC']);
        $destination_sortie = get_destination_sortie($bdc['Destination_sortie']);

        //insert du bdc dans suivi_ventes_bdc
        $data_bdc = [
            'num_bdc' => $num_bdc,
            'nom_acheteur' => $bdc['name'],
            'prixTotalHT' => $bdc['prixTotalHT'],
            'prixTTC' => $bdc['prixTTC'],
            'nom_vendeur' => $vendeur_id,
            'dateBC' => $date_bdc,
            'destination_sortie' => $destination_sortie,
            'uuid' => $uuid
        ];
        $sql = "INSERT INTO suivi_ventes_bdc (numero_bdc,nom_acheteur,prix_vente_ht,prix_vente_ttc,vendeur_id,date_bdc,destination_vente,uuid) 
        VALUES (:num_bdc, :nom_acheteur,:prixTotalHT, :prixTTC,:nom_vendeur, :dateBC,:destination_sortie, :uuid)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data_bdc);
        $id_bdc_last_inserted = $pdo->lastInsertId();


        //insert du vh dans suivi_ventes_vh
        $data_vh = [
            'immatriculation' => $bdc['immatriculation'],
            'provenance' => $bdc['provenance_vh'],
            'VIN' => $bdc['VIN'],
            'marque' => $bdc['marque'],
            'modele' => $bdc['modele'],
            'version_vh' => $bdc['version_vh'],
            'bdc_id' => $id_bdc_last_inserted,
            'reference_kepler' => $bdc['reference_kepler']

        ];
        $sql = "INSERT INTO vehicules_suivi_ventes (immatriculation,provenance_vo_vn,vin,marque,modele,version,bdc_id,reference_kepler) 
        VALUES (:immatriculation, :provenance,:VIN, :marque,:modele, :version_vh,:bdc_id,:reference_kepler)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data_vh);

    }

}

function upload_suivi_ventes_factures($facture)
{
    $pdo = Connection::getPDO();

    $num_facture = $facture['numero_facture'];

    // on check deja si il existe un numéro de facture identique pour éviter les doublons
    $request = $pdo->query("SELECT numero_facture FROM suivi_ventes_factures WHERE numero_facture = '$num_facture'");
    $facture_check = $request->fetch(PDO::FETCH_ASSOC);

    //si il n'existe pas déja cette facture 
    if (!$facture_check) {

        $id_vendeur = get_id_collaborateur_payplan_by_name($facture['vendeur']);
        $id_cvo = get_id_cvo_by_id_collaborateur($id_vendeur);
        $id_bdc = get_id_bdc_liee($facture['bdc_liee']);


        //ajout facture dans base
        $data_facture = [
            'numero_facture' => $facture['numero_facture'],
            'date_facture' => format_date_FR_TO_US($facture['date_facture']),
            'prix_vente_total_ht' => $facture['montant_total_facture_HT'],
            'prix_vente_vehicule_HT' => $facture['prix_vente_vehicule_HT'],
            'nom_acheteur' => $facture['nom_acheteur'],
            'adresse_acheteur' => $facture['adresse_client'],
            'cp_acheteur' => $facture['cp_client'],
            'ville_acheteur' => $facture['ville_client'],
            'pays_acheteur' => $facture['pays_client'],
            'email_acheteur' => $facture['email_client'],
            'tel_acheteur' => $facture['telmobile_client'],
            'id_vendeur' => $id_vendeur,
            'id_cvo_vente' => $id_cvo,
            'id_destination_vente' => $facture['destination_sortie'],
            'source' => $facture['source_client'],
            'id_bdc' => $id_bdc,
        ];

        var_dump($data_facture);

        $sql = "INSERT INTO suivi_ventes_factures (numero_facture,date_facture,prix_vente_total_ht,prix_vente_vehicule_HT,nom_acheteur,adresse_acheteur,cp_acheteur,ville_acheteur,pays_acheteur,email_acheteur,tel_acheteur,id_vendeur,id_cvo_vente,id_destination_vente,source,id_bdc) 
            VALUES (:numero_facture, :date_facture,:prix_vente_total_ht, :prix_vente_vehicule_HT,:nom_acheteur, :adresse_acheteur,:cp_acheteur, :ville_acheteur,:pays_acheteur,:email_acheteur,:tel_acheteur,:id_vendeur,:id_cvo_vente,:id_destination_vente,:source,:id_bdc)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data_facture);
        $id_facture_last_inserted = intval($pdo->lastInsertId());

        // si la facture a un bdc lié
        if (!is_null($id_bdc)) {
            //upload du BDC pour le passer à facturé
            $data = [
                'id_facture' => $id_facture_last_inserted,
                'id_bdc' => $id_bdc
            ];
            $sql = "UPDATE suivi_ventes_bdc SET is_invoiced = 1 , id_facture = :id_facture WHERE ID = :id_bdc";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);
            $stmt->debugDumpParams();
        }

        //Upload le vehicule associé pour le passer à facturé
        $data = [
            'reference_kepler' => $facture['reference_kepler'],
            'facture_id' => $id_facture_last_inserted
        ];
        $sql = "UPDATE vehicules_suivi_ventes SET facture_id = :facture_id WHERE reference_kepler = :reference_kepler";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);
        $stmt->debugDumpParams();

    }



}

function get_provenance_vh($typeVoVn)
{

    $int_provenance = '';

    switch ($typeVoVn) {
        case "VO":
            $int_provenance = 1;
            break;
        case "VN":
        case "VN/NG":
        case "VN NG":
        case "VO REPRISE":
            $int_provenance = 2;
            break;
    }
    return $int_provenance;
}



function insert_bdc_ventes_uuid($bdc, $uuid)
{
    $pdo = Connection::getPDO();
    $data = [
        'bdc' => $bdc,
        'uuid' => $uuid
    ];
    $sql = "INSERT INTO bdc_ventes (numero_bdc, uuid) VALUES (:bdc, :uuid)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);

}

function get_bdc_from_uuid($uuid)
{
    $pdo = Connection::getPDO();
    $request = $pdo->query("SELECT numero_bdc FROM bdc_ventes WHERE uuid = '$uuid' ");
    $uuid = $request->fetch(PDO::FETCH_COLUMN);
    return $uuid;
}


function get_destination_sortie($destination_sortie)
{
    $destination = '';

    switch ($destination_sortie) {
        case "VENTE PARTICULIER":
            $destination = 1;
            break;
        case "VENTE MARCHAND":
            $destination = 2;
            break;
    }
    return $destination;
}

function get_infos_vehicule_for_suivi_ventes($obj)
{

    $infos_vh = array();

    //provenance
    $provenance_tmp = $obj->typeVoVn->name;
    $infos_vh['provenance'] = get_provenance_vh($provenance_tmp);

    //marque
    $infos_vh['marque'] = $obj->brand->name;

    //modele
    $infos_vh['modele'] = $obj->model->name;

    //version
    $infos_vh['version'] = $obj->version->name;

    // get VIN
    if (isset ($obj->vin) || !empty ($obj->vin)) {
        $infos_vh['vin'] = $obj->vin;
    } else {
        $infos_vh['vin'] = "";
    }

    //get IMMATRICULATION
    if (empty ($obj->licenseNumber)) {
        $immat_tmp = 'N/C';
    } else {
        $immat_tmp = $obj->licenseNumber;
    }

    $infos_vh['immatriculation'] = str_replace("-", "", $immat_tmp);

    $infos_vh['reference_kepler'] = $obj->reference;

    return $infos_vh;
}


function get_infos_facture($obj_facture)
{

    //get date facture
    $date_facture_tmp = substr($obj_facture->invoiceDate, 0, 10);
    $date_facture_tmp2 = str_replace("-", "/", $date_facture_tmp);
    $return['date_facture'] = date('d/m/Y', strtotime($date_facture_tmp2));

    //get numéro de facture
    $return['numero_facture'] = $obj_facture->number;

    //get nom acheteur
    if (isset ($obj_facture->owner->firstname)) {
        $return['nom_acheteur'] = $obj_facture->owner->firstname . " " . $obj_facture->owner->lastname;
    } else {
        $return['nom_acheteur'] = $obj_facture->owner->corporateNameContact;
    }

    //adresse du client
    $return['adresse_client'] = $obj_facture->customer->addressAddress;

    // Code postal du client
    $return['cp_client'] = $obj_facture->customer->addressPostalCode;

    // ville du client
    $return['ville_client'] = $obj_facture->customer->addressCity;

    // pays du client
    $return['pays_client'] = $obj_facture->customer->addressCountry;


    // email du client
    if (isset ($obj_facture->customer->email) && !empty ($obj_facture->customer->email)) {
        $return['email_client'] = $obj_facture->customer->email;
    } else {
        $return['email_client'] = '';
    }

    //tel fixe du client
    if (isset ($obj_facture->customer->phoneNumber) && !empty ($obj_facture->customer->phoneNumber)) {
        $return['telfixe_client'] = $obj_facture->customer->phoneNumber;
    } else {
        $return['telfixe_client'] = '';
    }

    //tel mobile du client
    if (isset ($obj_facture->customer->cellPhoneNumber) && !empty ($obj_facture->customer->cellPhoneNumber)) {
        $return['telmobile_client'] = $obj_facture->customer->cellPhoneNumber;
    } else {
        $return['telmobile_client'] = '';
    }

    //get nom vendeur
    $nom_vendeur = $obj_facture->seller;
    $nom_vendeur = explode("<", $nom_vendeur);
    $nom_vendeur = $nom_vendeur[0];
    $return['nom_vendeur'] = trim($nom_vendeur);


    //get destination sortie
    if (isset ($obj_facture->destination) && !empty ($obj_facture->destination)) {
        $return['destination_sortie'] = $obj_facture->destination;
    } else {
        $return['destination_sortie'] = '';
    }


    // source du client
    if (isset ($obj_facture->customer->knownFrom) && !empty ($obj_facture->customer->knownFrom)) {
        $return['source_client'] = $obj_facture->customer->knownFrom;
    } else {
        $return['source_client'] = '';
    }

    // prix total facture
    $return['montant_total_facture_HT'] = $obj_facture->sellPriceWithoutTax;

    //recup BDC lié
    if (isset ($obj_facture->orderForm->number) && !empty ($obj_facture->orderForm->number)) {
        $return['bdc_liee'] = $obj_facture->orderForm->number;
    }

    return $return;

}

function get_vh_from_suivi_ventes($limite)
{
    $pdo = Connection::getPDO();

    // on check deja si il existe un numéro de facture identique pour éviter les doublons
    $request = $pdo->query("SELECT immatriculation FROM vehicules_suivi_ventes WHERE reference_kepler IS NULL LIMIT $limite ");
    $liste_vhs = $request->fetchAll(PDO::FETCH_COLUMN);

    return $liste_vhs;

}

function update_reference_kepler($liste_immatriculation)
{

    $request_vehicule = "v3.7/vehicles/";
    $url = "https://www.kepler-soft.net/api/";
    $req_url_vehicule = $url . "" . $request_vehicule;

    $valeur_token = goCurlToken();

    $state_vh = '';

    foreach ($liste_immatriculation as $immatriculation) {
        $obj_vehicule = get_reference_vehiculeInfo_by_immatriculation($immatriculation, $valeur_token, $req_url_vehicule, $state_vh, FALSE);
        if (empty ($obj_vehicule)) {
            $result = get_reference_vehiculeInfo_by_immatriculation($immatriculation, $valeur_token, $req_url_vehicule, $state_vh, TRUE);
            $obj_vehicule = json_decode($result);
        }

        if (!empty ($obj_vehicule)) {

            $reference_kepler = $obj_vehicule->reference;

            //retransformer l'immat en format XX123XX
            $immat_format_xx123xx = str_replace("-", "", $immatriculation);

            $pdo = Connection::getPDO();

            $data = [
                'reference_kepler' => $reference_kepler,
                'immatriculation' => $immat_format_xx123xx

            ];
            $sql = "UPDATE vehicules_suivi_ventes SET reference_kepler = :reference_kepler WHERE immatriculation = :immatriculation";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);
        }


    }

}
