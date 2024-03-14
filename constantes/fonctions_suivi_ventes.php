<?php


use app\Connection;

function alimenter_suivi_ventes($date_bdc_selected)
{


    /******************************************  CODE MAIN ******************************************/

    ini_set('xdebug.var_display_max_depth', 10);
    ini_set('xdebug.var_display_max_children', 256);
    ini_set('xdebug.var_display_max_data', 1024);


    set_time_limit(0);

    // recup valeur token seulement
    $url_token = "https://www.kepler-soft.net/api/v3.0/auth-token/";
    //$valeur_token_first = $valeur_token;

    // recup données

    $request_bon_de_commande = "v3.1/order-form/";
    $request_vehicule = "v3.7/vehicles/";

    $url = "https://www.kepler-soft.net/api/";

    $req_url_BC = $url . "" . $request_bon_de_commande;
    $req_url_vehicule = $url . "" . $request_vehicule;


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
        $valeur_token = goCurlToken($url_token);
        $obj = GoCurl_Recup_BDC($valeur_token, $req_url_BC, $j, $num_BDC, $date_bdc);

        //a ce niveau obj est un object

        //on prends le tableau datas dans obj et ce qui nous fait un array sur obj_final
        if (!empty($obj)) {
            $obj_final = $obj->datas;
        } else {
            $obj_final = '';
        }

        // var_dump($obj_final);
        // die();

        $infos_bdc = array();

        if (!empty($obj_final)) {


            /*****************    BOUCLE du tableau de données récupérés *****************/
            $i++;

            //on boucle par rapport au nombre de bon de commande dans le tableau datas[]
            foreach ($obj_final as $keydatas => $keyvalue) {

                // on récupere le state du bon de commande 
                if (isset($keyvalue->state)) {
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
                    if (isset($keyvalue->owner->firstname)) {
                        $nom_acheteur_tmp = $keyvalue->owner->firstname . " " . $keyvalue->owner->lastname;
                    } else if (isset($keyvalue->customer->firstname)) {
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
                    if (empty($keyvalue->destination)) {
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
                        if (isset($keyvalue->items)) {

                            //ON BOUCLE DANS LES ITEMS
                            foreach ($keyvalue->items as $key_item => $value_item) {
                                //si c'est un vehicule_selling
                                if ($value_item->type == 'vehicle_selling') {

                                    $reference_item = $value_item->reference;

                                    //  recup infos du véhicule
                                    $valeur_token = goCurlToken($url_token);
                                    $state_vh = '';
                                    //on prend le vehicule qu'il soit sorti ou non
                                    $obj_vehicule = getvehiculeInfo($reference_item, $valeur_token, $req_url_vehicule, $state_vh);

                                    $type = gettype($obj_vehicule);

                                    sautdeligne();

                                    // var_dump($type);
                                    // die();

                                    // si c'est bien un objet comme prévu
                                    if ($type == 'object') {

                                        // si le résultat n'est pas vide
                                        if (!empty($obj_vehicule)) {

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
                        if (isset($keyvalue->items)) {

                            //on boucle dans les items
                            foreach ($keyvalue->items as $key_item => $value_item) {
                                $comptabilisation_ligne = false;
                                //on crée une variable qui contiendra le numéro de bdc initial

                                //si c'est un vehicule_selling
                                if ($value_item->type == 'vehicle_selling') {

                                    $reference_item = $value_item->reference;

                                    //  recup infos du véhicule
                                    $valeur_token = goCurlToken($url_token);
                                    $state_vh = '';
                                    $obj_vehicule = getvehiculeInfo($reference_item, $valeur_token, $req_url_vehicule, $state_vh);

                                    $type = gettype($obj_vehicule);

                                    //si on obtient un object.
                                    if ($type == 'object') {

                                        // si le résultat n'est pas vide
                                        if (!empty($obj_vehicule)) {

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


    sautdeligne();


    /*************************************  FIN CODE MAIN ************************************************************/


}


function goCurlToken($url)
{
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



function GoCurl_Recup_BDC($token, $url, $page, $num_bdc = '', $date_bdc = '')
{

    $ch = curl_init();

    // le token
    $header = array();
    $header[] = 'X-Auth-Token:' . $token;
    $header[] = 'Content-Type:text/html;charset=utf-8';

    // choper un BC spécifique
    if (isset($num_bdc) && $num_bdc != '') {
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

        if (isset($date_bdc) && $date_bdc != '') {

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


    $getURL = $url . '?' . http_build_query($dataArray);

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

    if (!isset($num_bdc) && $num_bdc == '') {
        echo '<pre> nombre total de BDC : ' . $obj->total . '</pre>';
        echo '<pre> page actuelle :' . $obj->currentPage . '</pre>';
        echo '<pre> BDC par page :' . $obj->perPage . '</pre>';
    }

    return $obj;
}

function getvehiculeInfo($reference, $token, $url_vehicule, $state, $is_not_available_for_sell = '')
{

    $ch = curl_init();

    // le token
    $header = array();
    $header[] = 'X-Auth-Token:' . $token;
    $header[] = 'Content-Type:text/html;charset=utf-8';

    switch ($is_not_available_for_sell) {
        case TRUE:

            if (isset($state) && $state == 'arrivage_or_parc') {
                $dataArray = array(
                    "reference" => $reference,
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

        case '':
            if (isset($state) && $state == 'arrivage_or_parc') {
                $dataArray = array(
                    "reference" => $reference
                );
            }
            // !!!! si le vh est vendu, vendu AR, en cours, sorti, sorti AR ou annulé alors il faudra mettre l'état obligatoirement si tu veux un retour 
            else {
                $dataArray = array(
                    "reference" => $reference,
                    "state" => 'vehicle.state.sold,vehicle.state.sold_ar,vehicle.state.pending,vehicle.state.out,vehicle.state.out_ar,vehicle.state.canceled'
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

    if (empty($obj_vehicule)) {
        $result = getvehiculeInfo($reference, $token, $url_vehicule, $state, true);
        $obj_vehicule = json_decode($result);
    }

    // var_dump($obj_vehicule);

    // la on a un array
    //si on a l'erreur de token authentification alors on relance un token
    if (isset($obj_vehicule->code) && $obj_vehicule->code == 401) {
        $url = "https://www.kepler-soft.net/api/v3.0/auth-token/";
        $valeur_token = goCurlToken($url);

        $obj = getvehiculeInfo($reference, $valeur_token, $url_vehicule, $state);

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
                'bdc_id' => $bdc_check['id']
            ];
            $sql = "INSERT INTO vehicules_suivi_ventes (immatriculation,provenance_vo_vn,vin,marque,modele,version,bdc_id) 
            VALUES (:immatriculation, :provenance,:VIN, :marque,:modele, :version_vh,:bdc_id)";
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
            'bdc_id' => $id_bdc_last_inserted
        ];
        $sql = "INSERT INTO vehicules_suivi_ventes (immatriculation,provenance_vo_vn,vin,marque,modele,version,bdc_id) 
        VALUES (:immatriculation, :provenance,:VIN, :marque,:modele, :version_vh,:bdc_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data_vh);

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
    if (isset($obj->vin) || !empty($obj->vin)) {
        $infos_vh['vin'] = $obj->vin;
    } else {
        $infos_vh['vin'] = "";
    }

    //get IMMATRICULATION
    if (empty($obj->licenseNumber)) {
        $immat_tmp = 'N/C';
    } else {
        $immat_tmp = $obj->licenseNumber;
    }

    $infos_vh['immatriculation'] = str_replace("-", "", $immat_tmp);

    return $infos_vh;
}
