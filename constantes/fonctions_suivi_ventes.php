<?php


use app\Connection;


ini_set('xdebug.var_display_max_depth', 10);
ini_set('xdebug.var_display_max_children', 256);
ini_set('xdebug.var_display_max_data', 1024);
set_time_limit(0);


function alimenter_suivi_ventes_bdc_via_portail($date)
{
    //base portail
    $pdo2 = Connection::getPDO_2();
    //base portail_massoutre
    $pdo = Connection::getPDO();

    // on commence par aller chercher dans la base portail tous les bdc d'une date
    $request = $pdo2->query("SELECT * FROM bdcventes 
    WHERE date_dernier_bdc = '$date'");
    // $request = $pdo2->query("SELECT * FROM bdcventes 
    // WHERE date_dernier_bdc BETWEEN $date");
    $result_list_bdc = $request->fetchAll(PDO::FETCH_ASSOC);

    // TO DO : FAIRE UN APPEL BDC À KEPLER SUR LA MÊME DATE POUR AVOIR UNE LISTE DE BDC DE LA MÊME DATE ( NORMALEMENT ON DEVRAIT AVOIR LES MÊMES BDC ) 
    // STOCKER ENSUITE DANS UN ARRAY LE NUM ET SON UUID POUR POUVOIR L'UTILISER PLUS BAS
    $array_bdc = get_array_bdc_from_kepler($date);

    //on boucle sur la liste des BDC récupérés
    foreach ($result_list_bdc as $bdc) {

        //on va d'abord chercher les données véhicules du portail dans la table vehicules
        $request = $pdo2->query("SELECT vh.immatriculation,vh.destination_id,vh.numero_chassis,marques.libelle AS marque,
         modelescommerciaux.libelle AS modele,
         finitions.libelle AS version_vh,
         vh.prix_achat_ht FROM vehicules AS vh
         LEFT JOIN marques ON marques.ID = vh.marque_id
         LEFT JOIN modelescommerciaux ON modelescommerciaux.ID = vh.modelecommercial_id
         LEFT JOIN finitions ON finitions.ID = vh.finition_id
         WHERE vh.ID = " . intval($bdc['vehicule_id']) . "");
        $result_vh = $request->fetch(PDO::FETCH_ASSOC);

        //on check déja si le bdc existe ou pas
        $request = $pdo->query("SELECT numero_bdc FROM suivi_ventes_bdc AS bdc
        WHERE bdc.numero_bdc = " . intval($bdc['numero']) . "");
        $result_check_bdc_num = $request->fetch(PDO::FETCH_COLUMN);

        //si pas de BDC alors on le crée
        if (empty($result_check_bdc_num)) {

            $vendeur_id = get_id_collaborateur_payplan_by_name($bdc['nom_vendeur']);
            $destination_sortie = get_destination_sortie($bdc['destination_sortie']);

            /**** REFERENCE VH KEPLER ( pas vraiment utile mais à garder au cas ou ) ****/
            // $infos_bdc_kepler = get_bdc_from_kepler_by_number($bdc['numero']);
            // $uuid_bdc = $infos_bdc_kepler->uuid;
            // $reference_vh_kepler = $infos_bdc_kepler->items[0]->reference;
            $reference_vh_kepler = NULL;

            //uuid
            $uuid_bdc = get_uuid_bdc_from_array($array_bdc, $bdc['numero']);


            //insert du bdc dans suivi_ventes_bdc
            $data_bdc = [
                'num_bdc' => $bdc['numero'],
                'nom_acheteur' => $bdc['nom_client'],
                'prixTotalHT' => $bdc['montant_ht'],
                'prixTTC' => $bdc['montant_ttc'],
                'nom_vendeur' => $vendeur_id,
                'dateBC' => $bdc['date_dernier_bdc'],
                'destination_sortie' => $destination_sortie,
                'uuid' => $uuid_bdc
            ];
            $sql = "INSERT INTO suivi_ventes_bdc (numero_bdc,nom_acheteur,prix_vente_ht,prix_vente_ttc,vendeur_id,date_bdc,destination_vente,uuid) 
            VALUES (:num_bdc, :nom_acheteur,:prixTotalHT, :prixTTC,:nom_vendeur, :dateBC,:destination_sortie, :uuid)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($data_bdc);
            $id_bdc_last_inserted = $pdo->lastInsertId();

            /******* On ajoute ensuite le 1er véhicule ( il peut y avoir plusieurs véhicule dans un BDC ) *******/
            $provenance = get_provenance_from_destination_id_portail($result_vh['destination_id']);

            //insert du vh dans suivi_ventes_vh
            $data_vh = [
                'immatriculation' => $result_vh['immatriculation'],
                'provenance' => $provenance,
                'VIN' => strtoupper($result_vh['numero_chassis']),
                'marque' => $result_vh['marque'],
                'modele' => $result_vh['modele'],
                'version_vh' => $result_vh['version_vh'],
                'bdc_id' => $id_bdc_last_inserted,
                'reference_kepler' => $reference_vh_kepler,
                'prix_achat_ht' => $result_vh['prix_achat_ht']
            ];

            $sql = "INSERT INTO suivi_ventes_vehicules (immatriculation,provenance_vo_vn,vin,marque,modele,version,bdc_id,reference_kepler,prix_achat_ht) 
            VALUES (:immatriculation, :provenance,:VIN, :marque,:modele, :version_vh,:bdc_id,:reference_kepler,:prix_achat_ht)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($data_vh);

        }

        //sinon si il existe déja le BDC alors c'est surement un BDC avec plusieurs véhicule.
        // Alors on ajoute juste la ligne véhicule dans suivi_ventes_vehicules
        else {

            // on vérifie quand même si le vh n'existe déja pas dans la base
            //on va chercher l'immat
            $request = $pdo->query("SELECT * FROM suivi_ventes_vehicules       
               WHERE immatriculation = '" . $result_vh['immatriculation'] . "'");
            $result_check_vh = $request->fetch(PDO::FETCH_ASSOC);

            //si on trouve pas de véhicule
            if (!$result_check_vh) {

                // on récupere l'id du bon de commande lié au vh 
                $id_bdc = get_id_bdc_liee(intval($result_check_bdc_num));

                //insert du vh dans suivi_ventes_vh
                $data_vh = [
                    'immatriculation' => $result_vh['immatriculation'],
                    'provenance' => $provenance,
                    'VIN' => strtoupper($result_vh['numero_chassis']),
                    'marque' => strtoupper($result_vh['marque']),
                    'modele' => strtoupper($result_vh['modele']),
                    'version_vh' => $result_vh['version_vh'],
                    'bdc_id' => $id_bdc,
                    'reference_kepler' => $reference_vh_kepler,
                    'prix_achat_ht' => $result_vh['prix_achat_ht']
                ];
                $sql = "INSERT INTO suivi_ventes_vehicules (immatriculation,provenance_vo_vn,vin,marque,modele,version,bdc_id,reference_kepler,prix_achat_ht) 
                VALUES (:immatriculation, :provenance,:VIN, :marque,:modele, :version_vh,:bdc_id,:reference_kepler,:prix_achat_ht)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute($data_vh);

                /** on update ensuite les prix ht et TTC du BDC **/

                //on prend les prix déja dans la base pour ensuite y ajouter les prix du second bdc qui est le même.
                $request = $pdo->query("SELECT prix_vente_ht,prix_vente_ttc FROM suivi_ventes_bdc WHERE ID = $id_bdc");
                $result_get_prix = $request->fetch(PDO::FETCH_ASSOC);

                $montant_total_ht = $result_get_prix['prix_vente_ht'] + $bdc['montant_ht'];
                $montant_total_ttc = $result_get_prix['prix_vente_ttc'] + $bdc['montant_ttc'];

                $data_update_bdc = [
                    'montant_total_ht' => $montant_total_ht,
                    'montant_total_ttc' => $montant_total_ttc
                ];

                $sql = "UPDATE suivi_ventes_bdc SET prix_vente_ht =:montant_total_ht ,  prix_vente_ttc=:montant_total_ttc
                WHERE ID = $id_bdc";
                $stmt = $pdo->prepare($sql);
                $stmt->execute($data_update_bdc);

            }
        }
    }
}

function alimenter_suivi_ventes_factures_via_portail($date)
{

    //base portail
    $pdo2 = Connection::getPDO_2();
    //base portail_massoutre
    $pdo = Connection::getPDO();

    // $request = $pdo2->query("SELECT * FROM bdcventes 
    // WHERE date_dernier_bdc = '$date_bdc_selected'");

    //ON RECUPERE LES FACTURES DU PORTAIL 
    $request = $pdo2->query("SELECT factventes.dernier_numero_facture,factventes.vehicule_id ,
    factventes.date_facturation,factventes.montant ,factventes.nom_client,factventes.email_client,factventes.telephone1_client,factventes.vendeur_id,factventes.site_id,factventes.destination_sortie,factventes.total_produit,factventes.marge_brute,factventes.marge_nette,
    adresse.adresse1,adresse.codepostal,adresse.ville,
    pays.libelle as libelle_pays,
    utilisateurs.identification as nom_complet_vendeur
    FROM factureventes AS factventes
    LEFT JOIN adresses AS adresse ON adresse.ID = factventes.adresse_id
    LEFT JOIN pays ON pays.id = adresse.pays_id
    LEFT JOIN utilisateurs ON utilisateurs.id = factventes.vendeur_id
    WHERE factventes.date_facturation = '$date'");
    // WHERE factventes.date_facturation BETWEEN $date");
    $result_list_factures = $request->fetchAll(PDO::FETCH_ASSOC);

    // var_dump($result_list_factures);
    // die();

    // TO DO : FAIRE UN APPEL FACTURE À KEPLER SUR LA MÊME DATE POUR AVOIR UNE LISTE DE FACTURES DE LA MÊME DATE ( NORMALEMENT ON DEVRAIT AVOIR LES MÊMES FACTURES ) 
    // STOCKER ENSUITE DANS UN ARRAY LE NUM ET SON UUID POUR POUVOIR L'UTILISER PLUS BAS
    $array_factures = get_array_factures_from_kepler($date);

    // vérifier tout d'abord si il n'existe pas déja la facture dans ma base suivi_ventes_factures
    foreach ($result_list_factures as $facture) {

        //tout dabord on check si la facture existe deja 
        // on check si on a le vh chez nous ? 
        $request = $pdo->query("SELECT * FROM  suivi_ventes_factures
          WHERE numero_facture = '" . $facture['dernier_numero_facture'] . "'");
        $check_facture = $request->fetch(PDO::FETCH_ASSOC);


        //si la facture n'existe pas
        if (!$check_facture) {

            //on va chercher d'abord si on connait le véhicule dans ma base suivi_ventes_vehicules
            //on prend le vehicule de la base massoutre et on check si on l'a aussi dans ma base
            $request = $pdo2->query("SELECT vh.ID,vh.immatriculation,vh.destination_id,vh.numero_chassis,
            marques.libelle AS marque,
            modelescommerciaux.libelle AS modele,
            finitions.libelle AS version_vh,
            vh.numero_bdc,
            vh.prix_achat_ht 
            FROM vehicules as vh
            LEFT JOIN marques ON marques.ID = vh.marque_id
            LEFT JOIN modelescommerciaux ON modelescommerciaux.ID = vh.modelecommercial_id
            LEFT JOIN factureventes AS fact on fact.vehicule_id = vh.ID
            LEFT JOIN finitions ON finitions.ID = vh.finition_id
            WHERE fact.vehicule_id = " . $facture['vehicule_id']);
            $vh_portail = $request->fetch(PDO::FETCH_ASSOC);

            // on check si on a le vh chez nous ? 
            $request = $pdo->query("SELECT * FROM  suivi_ventes_vehicules
            WHERE immatriculation = '" . $vh_portail['immatriculation'] . "'");
            $check_vh = $request->fetch(PDO::FETCH_ASSOC);


            //données
            $id_vendeur = get_id_collaborateur_payplan_by_name($facture['nom_complet_vendeur']);
            $id_cvo = get_id_cvo_by_id_collaborateur($id_vendeur);
            $id_destination_vente = get_id_destination_vente_by_libelle($facture['destination_sortie']);
            $id_bdc = get_id_bdc_from_suivi_ventes_vh($vh_portail['immatriculation']);
            $id_vehicule = get_id_vh_suivi_bdc_by_immat($vh_portail['immatriculation']);
            //uuid
            $uuid_facture = get_uuid_facture_from_array($array_factures, $facture['dernier_numero_facture']);

            $marge_ttc = $facture['marge_nette'] * 1.2;



            //si le vh n'existe pas
            if (empty($check_vh)) {

                //on crée la facture
                $data_facture = [
                    'numero_facture' => $facture['dernier_numero_facture'],
                    'date_facture' => $facture['date_facturation'],
                    'prix_total_ht' => NULL,
                    'prix_vh_ht' => $facture['montant'],
                    'marge_ht' => $facture['marge_nette'],
                    'marge_ttc' => $marge_ttc,
                    'nom_acheteur' => $facture['nom_client'],
                    'adresse_acheteur' => $facture['adresse1'],
                    'cp_acheteur' => $facture['codepostal'],
                    'ville_acheteur' => $facture['ville'],
                    'pays_acheteur' => $facture['libelle_pays'],
                    'email_acheteur' => $facture['email_client'],
                    'tel_acheteur' => $facture['telephone1_client'],
                    'id_vendeur' => $id_vendeur,
                    'id_cvo' => $id_cvo,
                    'id_destination_vente' => $id_destination_vente,
                    'id_bdc' => $id_bdc,
                    'id_vehicule' => $id_vehicule,
                    'uuid' => $uuid_facture,

                ];
                $sql = "INSERT INTO suivi_ventes_factures (numero_facture,date_facture,prix_vente_total_ht,prix_vente_vehicule_HT,marge_ht,marge_ttc,nom_acheteur,adresse_acheteur,cp_acheteur,ville_acheteur,pays_acheteur,email_acheteur,tel_acheteur,id_vendeur,id_cvo_vente,id_destination_vente,id_bdc,id_vehicule,uuid) 
                    VALUES (:numero_facture, :date_facture,:prix_total_ht, :prix_vh_ht,:marge_ht, :marge_ttc,:nom_acheteur,:adresse_acheteur,:cp_acheteur,:ville_acheteur,:pays_acheteur,:email_acheteur,:tel_acheteur,:id_vendeur,:id_cvo,:id_destination_vente,:id_bdc,:id_vehicule,:uuid)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute($data_facture);
                $id_facture_inserted = $pdo->lastInsertId();


                //on get id facture pour le relier au vh
                // $id_facture = get_id_facture_by_num_facture($facture['dernier_numero_facture']);

                //insert du vh dans suivi_ventes_vh
                $provenance = get_provenance_from_destination_id_portail($vh_portail['destination_id']);
                $data_vh = [
                    'immatriculation' => $vh_portail['immatriculation'],
                    'provenance' => $provenance,
                    'VIN' => strtoupper($vh_portail['numero_chassis']),
                    'marque' => strtoupper($vh_portail['marque']),
                    'modele' => strtoupper($vh_portail['modele']),
                    'version_vh' => $vh_portail['version_vh'],
                    'bdc_id' => NULL,
                    'reference_kepler' => NULL,
                    'prix_achat_ht' => $vh_portail['prix_achat_ht'],
                    'id_facture' => intval($id_facture_inserted),
                ];
                $sql = "INSERT INTO suivi_ventes_vehicules (immatriculation,provenance_vo_vn,vin,marque,modele,version,bdc_id,facture_id,reference_kepler,prix_achat_ht) 
                    VALUES (:immatriculation, :provenance,:VIN, :marque,:modele, :version_vh,:bdc_id,:id_facture,:reference_kepler,:prix_achat_ht)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute($data_vh);
                $id_vh_cree = $pdo->lastInsertId();

                //on récupere l'id du vh tout juste crée pour le remettre à la facture
                $data_update_fact = [
                    'id_vh' => intval($id_vh_cree),
                    'ID' => intval($id_facture_inserted)
                ];
                $sql = "UPDATE suivi_ventes_factures SET id_vehicule =:id_vh WHERE ID = :ID";
                $stmt = $pdo->prepare($sql);
                $stmt->execute($data_update_fact);

            }
            //si le vh existe déja 
            else {
                //normalement le vh existe déja, donc on va créer la facture et relier le vh à la facture
                $data_facture = [
                    'numero_facture' => $facture['dernier_numero_facture'],
                    'date_facture' => $facture['date_facturation'],
                    'prix_total_ht' => NULL,
                    'prix_vh_ht' => $facture['montant'],
                    'marge_ht' => $facture['marge_nette'],
                    'marge_ttc' => $marge_ttc,
                    'nom_acheteur' => $facture['nom_client'],
                    'adresse_acheteur' => $facture['adresse1'],
                    'cp_acheteur' => $facture['codepostal'],
                    'ville_acheteur' => $facture['ville'],
                    'pays_acheteur' => $facture['libelle_pays'],
                    'email_acheteur' => $facture['email_client'],
                    'tel_acheteur' => $facture['telephone1_client'],
                    'id_vendeur' => $id_vendeur,
                    'id_cvo' => $id_cvo,
                    'id_destination_vente' => $id_destination_vente,
                    'id_bdc' => $id_bdc,
                    'id_vehicule' => $id_vehicule,
                    'uuid' => $uuid_facture

                ];
                $sql = "INSERT INTO suivi_ventes_factures (numero_facture,date_facture,prix_vente_total_ht,prix_vente_vehicule_HT,marge_ht,marge_ttc,nom_acheteur,adresse_acheteur,cp_acheteur,ville_acheteur,pays_acheteur,email_acheteur,tel_acheteur,id_vendeur,id_cvo_vente,id_destination_vente,id_bdc,id_vehicule,uuid) 
                VALUES (:numero_facture, :date_facture,:prix_total_ht, :prix_vh_ht,:marge_ht, :marge_ttc,:nom_acheteur,:adresse_acheteur,:cp_acheteur,:ville_acheteur,:pays_acheteur,:email_acheteur,:tel_acheteur,:id_vendeur,:id_cvo,:id_destination_vente,:id_bdc,:id_vehicule,:uuid)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute($data_facture);
                $id_facture = $pdo->lastInsertId();

                //on update aussi le vh pour relier la facture
                $data = [
                    'facture_id' => intval($id_facture),
                    'ID' => $id_vehicule
                ];
                $sql = "UPDATE suivi_ventes_vehicules SET facture_id =:facture_id WHERE ID = :ID";
                $stmt = $pdo->prepare($sql);
                $stmt->execute($data);

                //il faut ensuite check si le vh facturé était le seul du bdc dans ce cas on passe le bdc a facturé
                $request = $pdo->query("SELECT bdc_id FROM suivi_ventes_vehicules WHERE ID = $id_vehicule");
                $bdc_id = $request->fetch(PDO::FETCH_ASSOC);
                check_and_update_if_bdc_invoiced_by_id_bdc(intval($bdc_id['ID']));

            }
        }
    }
}



function alimenter_suivi_ventes_bdc($date_bdc_selected)
{
    /******************************************  CODE MAIN ******************************************/
    // recup données
    $j = 1;

    $array_datas = array();

    $i = 0;

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
                                    $valeur_token = goCurlToken();
                                    $state_vh = '';
                                    //on prend le vehicule qu'il soit sorti ou non
                                    $obj_vehicule = getvehiculeInfo($reference_item, $valeur_token, $state_vh, FALSE);

                                    if (empty($obj_vehicule)) {
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
                        if (isset($keyvalue->items)) {

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

                                    if (empty($obj_vehicule)) {
                                        $result = getvehiculeInfo($reference_item, $valeur_token, $state_vh, TRUE);
                                        $obj_vehicule = json_decode($result);
                                    }

                                    $type = gettype($obj);

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

        // var_dump($obj_final);

        if (!empty($obj_final)) {
            $datas_find = true;

            $i++;

            /*****************    BOUCLE du tableau de données récupérés *****************/
            foreach ($obj_final as $keydatas => $keyvalue) {

                $infos_facture = get_infos_facture($keyvalue);

                if (isset($keyvalue->items)) {
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
                                $array_datas[$i]['uuid_facture'] = $infos_facture['uuid_facture'];
                                ;

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

    $url = "https://www.kepler-soft.net/api/";
    $request_bon_de_commande = "v3.1/order-form/";

    $url_bdc = $url . "" . $request_bon_de_commande;

    $getURL = $url_bdc . '?' . http_build_query($dataArray);

    // print_r($getURL);

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

    $obj = json_decode($result);

    return $obj->datas;
}



function GoCurl_Recup_Factures($token, $page, $date = '', $num_facture = '')
{

    $ch = curl_init();

    // le token
    //$token = '7MLGvf689hlSPeWXYGwZUi\/t2mpcKrvVr\/fKORXMc+9BFxmYPqq4vOZtcRjVes9DBLM=';
    $header = array();
    $header[] = 'X-Auth-Token:' . $token;
    $header[] = 'Content-Type:text/html;charset=utf-8';

    if (isset($date) && $date !== '') {
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

    // URL factures API
    $request_facture = "v3.1/invoice/";
    $url = "https://www.kepler-soft.net/api/";
    $req_url = $url . "" . $request_facture;

    $data = http_build_query($dataArray);

    $getURL = $req_url . '?' . $data;

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

    $obj = json_decode($result);

    return $obj->datas;

}

function GoCurl_Recup_Factures_Canceled($token, $page, $date = '')
{

    $ch = curl_init();

    // le token
    //$token = '7MLGvf689hlSPeWXYGwZUi\/t2mpcKrvVr\/fKORXMc+9BFxmYPqq4vOZtcRjVes9DBLM=';
    $header = array();
    $header[] = 'X-Auth-Token:' . $token;
    $header[] = 'Content-Type:text/html;charset=utf-8';

    if (isset($date) && $date !== '') {
        //sur une date
        $dataArray = array(
            "state" => 'invoice.state.canceled',
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

    // URL factures API
    $request_facture = "v3.1/invoice/";
    $url = "https://www.kepler-soft.net/api/";
    $req_url = $url . "" . $request_facture;

    $data = http_build_query($dataArray);

    $getURL = $req_url . '?' . $data;

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

    $obj = json_decode($result);
    return $obj->datas;
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

            if (isset($state) && $state == 'arrivage_or_parc') {
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
            if (isset($state) && $state == 'arrivage_or_parc') {
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
    if (isset($obj_vehicule->code) && $obj_vehicule->code == 401) {
        $valeur_token = goCurlToken();

        $obj = getvehiculeInfo($reference, $valeur_token, $state, TRUE);

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

            if (isset($state) && $state == 'arrivage_or_parc') {
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
            if (isset($state) && $state == 'arrivage_or_parc') {
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
    if (isset($obj_vehicule->code) && $obj_vehicule->code == 401) {
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
            //on va chercher son prix d'achat dabord
            $prix_achat_ht = get_prix_achat_ht($bdc['immatriculation']);
            // $frais_vo = get_frais_vo_by_immat($bdc['immatriculation']);
            $data_vh = [
                'immatriculation' => $bdc['immatriculation'],
                'provenance' => $bdc['provenance_vh'],
                'VIN' => $bdc['VIN'],
                'marque' => $bdc['marque'],
                'modele' => $bdc['modele'],
                'version_vh' => $bdc['version_vh'],
                'bdc_id' => $bdc_check['id'],
                'reference_kepler' => $bdc['reference_kepler'],
                'prix_achat_ht' => $prix_achat_ht
            ];
            $sql = "INSERT INTO suivi_ventes_vehicules (immatriculation,provenance_vo_vn,vin,marque,modele,version,bdc_id,reference_kepler,prix_achat_ht) 
            VALUES (:immatriculation, :provenance,:VIN, :marque,:modele, :version_vh,:bdc_id,:reference_kepler,:prix_achat_ht)";
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

        // on va chercher dans le portail son prix d'achat
        $prix_achat_ht = get_prix_achat_ht($bdc['immatriculation']);
        $frais_maintenance_estime =

            //insert du vh dans suivi_ventes_vh
            $data_vh = [
                'immatriculation' => $bdc['immatriculation'],
                'provenance' => $bdc['provenance_vh'],
                'VIN' => $bdc['VIN'],
                'marque' => $bdc['marque'],
                'modele' => $bdc['modele'],
                'version_vh' => $bdc['version_vh'],
                'bdc_id' => intval($id_bdc_last_inserted),
                'reference_kepler' => $bdc['reference_kepler'],
                'prix_achat_ht' => $prix_achat_ht
            ];
        $sql = "INSERT INTO suivi_ventes_vehicules (immatriculation,provenance_vo_vn,vin,marque,modele,version,bdc_id,reference_kepler,prix_achat_ht) 
        VALUES (:immatriculation, :provenance,:VIN, :marque,:modele, :version_vh,:bdc_id,:reference_kepler,:prix_achat_ht)";
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
            'uuid' => $facture['uuid_facture']
        ];

        var_dump($data_facture);

        $sql = "INSERT INTO suivi_ventes_factures (numero_facture,date_facture,prix_vente_total_ht,prix_vente_vehicule_HT,nom_acheteur,adresse_acheteur,cp_acheteur,ville_acheteur,pays_acheteur,email_acheteur,tel_acheteur,id_vendeur,id_cvo_vente,id_destination_vente,source,id_bdc,uuid) 
            VALUES (:numero_facture, :date_facture,:prix_vente_total_ht, :prix_vente_vehicule_HT,:nom_acheteur, :adresse_acheteur,:cp_acheteur, :ville_acheteur,:pays_acheteur,:email_acheteur,:tel_acheteur,:id_vendeur,:id_cvo_vente,:id_destination_vente,:source,:id_bdc,:uuid)";
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
        $sql = "UPDATE suivi_ventes_vehicules SET facture_id = :facture_id WHERE reference_kepler = :reference_kepler";
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
    $bdc_num = $request->fetch(PDO::FETCH_COLUMN);
    return intval($bdc_num);
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
        default:
            $destination = 0;
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
    if (isset($obj_facture->owner)) {
        if (isset($obj_facture->owner->firstname)) {
            $return['nom_acheteur'] = $obj_facture->owner->firstname . " " . $obj_facture->owner->lastname;
        } else {
            $return['nom_acheteur'] = $obj_facture->owner->corporateNameContact;
        }
    } else {
        $return['nom_acheteur'] = "";
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
    if (isset($obj_facture->customer->email) && !empty($obj_facture->customer->email)) {
        $return['email_client'] = $obj_facture->customer->email;
    } else {
        $return['email_client'] = '';
    }

    //tel fixe du client
    if (isset($obj_facture->customer->phoneNumber) && !empty($obj_facture->customer->phoneNumber)) {
        $return['telfixe_client'] = $obj_facture->customer->phoneNumber;
    } else {
        $return['telfixe_client'] = '';
    }

    //tel mobile du client
    if (isset($obj_facture->customer->cellPhoneNumber) && !empty($obj_facture->customer->cellPhoneNumber)) {
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
    if (isset($obj_facture->destination) && !empty($obj_facture->destination)) {
        $return['destination_sortie'] = $obj_facture->destination;
    } else {
        $return['destination_sortie'] = '';
    }


    // source du client
    if (isset($obj_facture->customer->knownFrom) && !empty($obj_facture->customer->knownFrom)) {
        $return['source_client'] = $obj_facture->customer->knownFrom;
    } else {
        $return['source_client'] = '';
    }

    // prix total facture
    $return['montant_total_facture_HT'] = $obj_facture->sellPriceWithoutTax;

    //recup BDC lié
    if (isset($obj_facture->orderForm->number) && !empty($obj_facture->orderForm->number)) {
        $return['bdc_liee'] = $obj_facture->orderForm->number;
    }


    //get uuid facture
    if (isset($obj_facture->uuid) && !empty($obj_facture->uuid)) {
        $return['uuid_facture'] = $obj_facture->uuid;
    }

    return $return;

}

function get_vh_from_suivi_ventes($limite)
{
    $pdo = Connection::getPDO();

    // on check deja si il existe un numéro de facture identique pour éviter les doublons
    $request = $pdo->query("SELECT immatriculation FROM suivi_ventes_vehicules WHERE reference_kepler IS NULL LIMIT $limite ");
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
        if (empty($obj_vehicule)) {
            $result = get_reference_vehiculeInfo_by_immatriculation($immatriculation, $valeur_token, $req_url_vehicule, $state_vh, TRUE);
            $obj_vehicule = json_decode($result);
        }

        if (!empty($obj_vehicule)) {

            $reference_kepler = $obj_vehicule->reference;

            //retransformer l'immat en format XX123XX
            $immat_format_xx123xx = str_replace("-", "", $immatriculation);

            $pdo = Connection::getPDO();

            $data = [
                'reference_kepler' => $reference_kepler,
                'immatriculation' => $immat_format_xx123xx

            ];
            $sql = "UPDATE suivi_ventes_vehicules SET reference_kepler = :reference_kepler WHERE immatriculation = :immatriculation";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);
        }


    }

}

function filtre_date_bdc_encours($filtre_date)
{
    $filtre_date_selected = intval($filtre_date['value_selected']);

    switch ($filtre_date_selected) {
        //mois en cours
        case 0:
            $date['date_debut'] = date('Y-01-01');
            $date['date_fin'] = date('Y-m-d');
            break;
        //mois précédent
        case 1:
            $date['date_debut'] = date('Y-01-01');
            $date['date_fin'] = date('Y-m-d', strtotime("last day of last month"));
            break;
        //mois personnalisé
        case 2:
            $date['date_debut'] = $filtre_date['date']['date_personnalise_debut'];
            $date['date_fin'] = $filtre_date['date']['date_personnalise_fin'];
            break;
    }

    $sql_date = " AND bdc.date_bdc BETWEEN '" . $date['date_debut'] . "' AND '" . $date['date_fin'] . "'";

    return $sql_date;
}



function filtre_date_bdc_factures($filtre_date, $type)
{
    $filtre_date_selected = intval($filtre_date['value_selected']);

    switch ($filtre_date_selected) {
        //mois en cours
        case 0:
            $date['date_debut'] = date('Y-m-01');
            $date['date_fin'] = date('Y-m-d');
            break;
        //mois précédent
        case 1:
            $date['date_debut'] = date('Y-m-d', strtotime("first day of last month"));
            $date['date_fin'] = date('Y-m-d', strtotime("last day of last month"));
            break;
        //mois personnalisé
        case 2:
            $date['date_debut'] = $filtre_date['date']['date_personnalise_debut'];
            $date['date_fin'] = $filtre_date['date']['date_personnalise_fin'];
            break;
    }

    switch ($type) {
        case 'bdc':
            $sql_date = " AND bdc.date_bdc BETWEEN '" . $date['date_debut'] . "' AND '" . $date['date_fin'] . "'";
            break;

        case 'factures':
            $sql_date = " AND factures.date_facture BETWEEN '" . $date['date_debut'] . "'AND '" . $date['date_fin'] . "'";
            break;

    }
    return $sql_date;
}


function filtre_date_bdc_factures_detail_suivi_ventes($date, $type)
{
    switch ($type) {
        case 'bdc':
            $sql_date = " AND bdc.date_bdc BETWEEN '" . $date['date']['date_debut'] . "' AND '" . $date['date']['date_fin'] . "'";
            break;

        case 'factures':
            $sql_date = " AND factures.date_facture BETWEEN '" . $date['date']['date_debut'] . "'AND '" . $date['date']['date_fin'] . "'";
            break;
    }
    return $sql_date;
}

function filtre_date_bdc_factures_N1($filtre_date, $type)
{
    $filtre_date_selected = intval($filtre_date['value_selected']);

    switch ($filtre_date_selected) {
        //mois en cours mais de l'année derniere
        case 0:
            $date_debut_n1 = new DateTime();
            $date_debut_n1->modify('first day of this month');
            $date_debut_n1->modify('-1 year');
            $date['date_debut'] = $date_debut_n1->format('Y-m-d');

            $date_fin_n1 = new DateTime();
            $date_fin_n1->modify('last day of this month');
            $date_fin_n1->modify('-1 year');
            $date['date_fin'] = $date_fin_n1->format('Y-m-d');

            break;
        //mois précédent
        case 1:

            $date_debut_n1 = new DateTime();
            $date_debut_n1->modify('first day of last month');
            $date_debut_n1->modify('-1 year');
            $date['date_debut'] = $date_debut_n1->format('Y-m-d');

            $date_fin_n1 = new DateTime();
            $date_fin_n1->modify('last day of last month');
            $date_fin_n1->modify('-1 year');
            $date['date_fin'] = $date_fin_n1->format('Y-m-d');

            break;
        //mois personnalisé
        case 2:
            $date['date_debut'] = $filtre_date['date']['date_personnalise_debut'];
            $date['date_fin'] = $filtre_date['date']['date_personnalise_fin'];
            break;
    }

    switch ($type) {
        case 'bdc':
            $sql_date = " AND bdc.date_bdc BETWEEN '" . $date['date_debut'] . "' AND '" . $date['date_fin'] . "'";
            break;

        case 'factures':
            $sql_date = " AND factures.date_facture BETWEEN '" . $date['date_debut'] . "'AND '" . $date['date_fin'] . "'";
            break;

    }
    return $sql_date;
}

function filtre_date_bdc_factures_cumul($filtre_date, $type)
{

    $filtre_date_selected = intval($filtre_date['value_selected']);

    switch ($filtre_date_selected) {
        //mois en cours
        case 0:
            $date_debut = new DateTime();
            $date_debut->modify('first day of January this year');
            $date['date_debut'] = $date_debut->format('Y-m-d');

            $date_fin = new DateTime();
            $date_fin->modify('last day of this month');
            $date['date_fin'] = $date_fin->format('Y-m-d');

            break;
        //mois précédent
        case 1:

            $date_debut = new DateTime();
            $date_debut->modify('first day of January this year');
            $date['date_debut'] = $date_debut->format('Y-m-d');

            $date_fin = new DateTime();
            $date_fin->modify('last day of last month');
            $date['date_fin'] = $date_fin->format('Y-m-d');

            break;
        //mois personnalisé
        case 2:
            $date['date_debut'] = $filtre_date['date']['date_personnalise_debut'];
            $date['date_fin'] = $filtre_date['date']['date_personnalise_fin'];
            break;
    }

    switch ($type) {
        case 'bdc':
            $sql_date = " AND bdc.date_bdc BETWEEN '" . $date['date_debut'] . "' AND '" . $date['date_fin'] . "'";
            break;

        case 'factures':
            $sql_date = " AND factures.date_facture BETWEEN '" . $date['date_debut'] . "'AND '" . $date['date_fin'] . "'";
            break;

    }
    return $sql_date;

}

function filtre_date_bdc_factures_cumul_N1($filtre_date, $type)
{

    $filtre_date_selected = intval($filtre_date['value_selected']);

    switch ($filtre_date_selected) {
        //mois en cours
        case 0:
            $date_debut = new DateTime();
            $date_debut->modify('first day of January this year');
            $date_debut->modify('-1 year');
            $date['date_debut'] = $date_debut->format('Y-m-d');

            $date_fin = new DateTime();
            $date_fin->modify('last day of this month');
            $date_fin->modify('-1 year');
            $date['date_fin'] = $date_fin->format('Y-m-d');

            break;
        //mois précédent
        case 1:

            $date_debut = new DateTime();
            $date_debut->modify('first day of January this year');
            $date_debut->modify('-1 year');
            $date['date_debut'] = $date_debut->format('Y-m-d');

            $date_fin = new DateTime();
            $date_fin->modify('last day of last month');
            $date_fin->modify('-1 year');
            $date['date_fin'] = $date_fin->format('Y-m-d');

            break;
        //mois personnalisé
        case 2:
            $date_debut = new DateTime($filtre_date['date']['date_personnalise_debut']);
            $date_debut->modify('-1 year');
            $date_fin = new DateTime($filtre_date['date']['date_personnalise_fin']);
            $date_fin->modify('-1 year');

            // $date['date_debut'] = $filtre_date['date']['date_personnalise_debut'];
            // $date['date_fin'] = $filtre_date['date']['date_personnalise_fin'];
            $date['date_debut'] = $date_debut->format('Y-m-d');
            $date['date_fin'] = $date_fin->format('Y-m-d');
            break;
    }

    switch ($type) {
        case 'bdc':
            $sql_date = " AND bdc.date_bdc BETWEEN '" . $date['date_debut'] . "' AND '" . $date['date_fin'] . "'";
            break;

        case 'factures':
            $sql_date = " AND factures.date_facture BETWEEN '" . $date['date_debut'] . "'AND '" . $date['date_fin'] . "'";
            break;

    }
    return $sql_date;

}

function calcul_marge($provenance, $destination_vente, $bdc, $frais_vo)
{
    switch ($provenance) {
        //provenance locations
        case 1:
            $marge = get_holding_cost_total($bdc['immatriculation']);
            break;
        //provenance Négoce
        case 2:
            switch ($destination_vente) {
                // destination particulier
                case 1:
                    $marge = round($bdc['prix_vente_vehicule_HT'] - ($bdc['prix_achat_ht'] + $frais_vo), 2);
                    break;
                //destination marchands
                case 2:
                    $marge = round(($bdc['prix_vente_vehicule_HT'] - $bdc['prix_achat_ht']), 2);
                    break;

            }
            break;
    }


    return $marge;

}

function get_holding_cost_total($immatriculation)
{
    //base portail
    $pdo2 = Connection::getPDO_2();

    $request = $pdo2->query("SELECT factureventes.holding_cost_total FROM factureventes 
    LEFT JOIN vehicules ON vehicules.id = factureventes.vehicule_id
    WHERE vehicules.immatriculation = '$immatriculation' AND vehicules.deleted = 0");
    $result = $request->fetch(PDO::FETCH_ASSOC);
    $holding_cost_total = floatval($result['holding_cost_total']);
    return $holding_cost_total;
}

function get_header_details($cvo, $destination_vente, $type_provenance, $type)
{
    $pdo = Connection::getPDO();
    $return = array();

    $request = $pdo->query("SELECT nom_cvo FROM cvo 
    WHERE ID = $cvo");
    $result = $request->fetch(PDO::FETCH_ASSOC);
    $return['nom_cvo'] = $result['nom_cvo'];

    $request = $pdo->query("SELECT libelle FROM destination_vente 
    WHERE ID = $destination_vente");
    $result = $request->fetch(PDO::FETCH_ASSOC);
    $return['destination_vente'] = $result['libelle'];

    $request = $pdo->query("SELECT libelle FROM provenance_vo_vn 
    WHERE ID = $type_provenance");
    $result = $request->fetch(PDO::FETCH_ASSOC);
    $return['type_provenance'] = $result['libelle'];

    if ($type == 'facture') {
        $return['type'] = "FACTURE";
    } else {
        $return['type'] = "BDC";
    }

    return $return;

}

function get_nb_vh_et_marge_totale_et_moyenne_factures_n1($id_cvo, $destination_vente, $type_provenance, $filtre_date)
{

    switch ($filtre_date['value_selected']) {
        //mois en cours
        case '0':
            // Obtenir la date du début du mois en cours
            $startOfMonth = new DateTime('first day of this month last year');
            $startOfMonthFormatted_n1 = $startOfMonth->format('Y-m-d');
            // On démarre au 15 mars 2023, car j'ai commencé ma récup factures à cette date en 2024
            $startOfMonthFormatted_n1 = new DateTime("2023-03-15");
            $date_debut_perso = $startOfMonthFormatted_n1->format("Y-m-d");

            // Obtenir la date du dernier jour du mois en cours
            $endOfMonth = new DateTime('last day of this month last year');
            $endOfMonthFormatted_n1 = $endOfMonth->format('Y-m-d');
            break;
        //mois précédent
        case '1':
            $currentDate = new DateTime();
            $currentDate->modify('-1 year');
            $currentDate->modify('-1 month');
            $currentDate->modify('first day of this month');
            $startOfMonthFormatted_n1 = $currentDate->format('Y-m-d');
            // On démarre au 15 mars 2023, car j'ai commencé ma récup factures à cette date en 2024
            $startOfMonthFormatted_n1 = new DateTime("2023-03-15");
            $date_debut_perso = $startOfMonthFormatted_n1->format("Y-m-d");
            $currentDate = new DateTime();
            $currentDate->modify('-1 year');
            $currentDate->modify('-1 month');
            $currentDate->modify('last day of this month');
            $endOfMonthFormatted_n1 = $currentDate->format('Y-m-d');
            break;
    }

    $pdo = Connection::getPDO_2();


    $id_cvo_portail = get_id_cvo_portail($id_cvo);
    $destination_vente_portail = get_destination_vente_portail($destination_vente);
    $provenance_portail = get_provenance_portail($type_provenance);

    $request = $pdo->query("SELECT factventes.dernier_numero_facture,factventes.marge_brute,factventes.site_id 
    FROM factureventes as factventes
    LEFT JOIN vehicules ON vehicules.id = factventes.vehicule_id
    LEFT JOIN destinations ON destinations.id = vehicules.destination_id
    WHERE factventes.site_id = $id_cvo_portail 
    AND factventes.destination_sortie = '$destination_vente_portail'
    AND destinations.id = $provenance_portail 
    AND factventes.date_facturation BETWEEN '$date_debut_perso' AND '$endOfMonthFormatted_n1' ");
    $result_req_factures = $request->fetchAll(PDO::FETCH_ASSOC);
    // $query = $request->queryString;
    // var_dump($query);

    $nb_vh_factures_total = $request->rowCount();
    $marge_totale_n1_factures = calcul_marge_total_factures($result_req_factures);
    if ($nb_vh_factures_total !== 0) {
        $moyenne_totale_n1 = $marge_totale_n1_factures / $nb_vh_factures_total;
    } else {
        $moyenne_totale_n1 = "pas de vente";
    }

    // var_dump($moyenne_totale_n1);

    $array_result['nb_vh_factures_total_n1'] = $nb_vh_factures_total;
    $array_result['marge_totale_n1'] = $marge_totale_n1_factures;
    $array_result['moyenne_totale_n1'] = round($moyenne_totale_n1);


    return $array_result;
}

function get_id_cvo_portail($id)
{
    $pdo = Connection::getPDO();
    $request = $pdo->query("SELECT id_cvo_portail FROM cvo WHERE ID = $id");
    $result = $request->fetch(PDO::FETCH_COLUMN);

    return intval($result);
}

function get_destination_vente_portail($id)
{
    $pdo = Connection::getPDO();
    $request = $pdo->query("SELECT libelle FROM destination_vente WHERE id = $id");
    $result = $request->fetch(PDO::FETCH_COLUMN);
    return $result;
}

function get_id_destination_vente_by_libelle($libelle)
{
    $pdo = Connection::getPDO();
    $request = $pdo->query("SELECT id FROM destination_vente WHERE libelle LIKE '" . trim($libelle) . "'");
    $result = $request->fetch(PDO::FETCH_COLUMN);
    return intval($result);
}

function get_provenance_portail($id)
{
    $pdo = Connection::getPDO();
    $request = $pdo->query("SELECT id_provenance_portail FROM provenance_vo_vn WHERE ID = $id");
    $result = $request->fetch(PDO::FETCH_COLUMN);
    return intval($result);
}
function get_provenance_from_destination_id_portail($id)
{
    $pdo = Connection::getPDO();
    $request = $pdo->query("SELECT ID FROM provenance_vo_vn WHERE id_provenance_portail = $id");
    $result = $request->fetch(PDO::FETCH_COLUMN);
    return intval($result);
}



function calcul_marge_total_factures($array_factures)
{
    $marge_totale = 0;
    foreach ($array_factures as $facture) {
        $marge_totale = $marge_totale + $facture['marge_ht'];
    }
    return intval(round($marge_totale));
}


function calcul_variation($type, $data_calcul_n1, $data_n)
{
    switch ($type) {
        case "vehicule":
            //on vérifie qu'on ait des ventes quand même sinon le calcul ne se fera pas et une erreur sera retournée.
            if ($data_n !== 0 && $data_calcul_n1['nb_vh_factures_total_n1'] !== 0) {
                $variation = (($data_n - $data_calcul_n1['nb_vh_factures_total_n1']) / $data_calcul_n1['nb_vh_factures_total_n1']) * 100;
            } else {
                $variation = 0;
            }
            break;
        case "marge":
            break;
        case "moyenne":
            break;
    }

    return round($variation, 2);

}

function snapshot_suivi_ventes_pour_histo()
{

}


function get_uuid_from_num_bdc($num_bdc)
{
    $pdo = Connection::getPDO();
    $request = $pdo->query("SELECT uuid FROM bdc_ventes WHERE numero_bdc = $num_bdc");
    $result = $request->fetch(PDO::FETCH_COLUMN);
    if ($result) {
        return $result;
    } else {
        return NUll;
    }
}

function get_id_bdc_from_suivi_ventes_vh($immatriculation)
{
    $pdo = Connection::getPDO();
    $request = $pdo->query("SELECT bdc_id FROM suivi_ventes_vehicules
    WHERE immatriculation = '" . $immatriculation . "'");
    $bdc_id = $request->fetch(PDO::FETCH_COLUMN);
    return intval($bdc_id);
}

function get_id_facture_by_num_facture($num_facture)
{
    $pdo = Connection::getPDO();
    $request = $pdo->query("SELECT ID FROM suivi_ventes_factures
    WHERE numero_facture = '" . $num_facture . "'");
    $facture_id = $request->fetch(PDO::FETCH_COLUMN);
    return intval($facture_id);
}

function get_id_vh_suivi_bdc_by_immat($immat)
{
    $pdo = Connection::getPDO();
    $request = $pdo->query("SELECT ID FROM suivi_ventes_vehicules
    WHERE immatriculation = '" . $immat . "'");
    $id_vh = $request->fetch(PDO::FETCH_COLUMN);
    return intval($id_vh);
}


function get_facture_from_kepler_by_number($num_facture)
{
    $page = 1;

    $token = goCurlToken();
    $ch = curl_init();

    // le token
    $header = array();
    $header[] = 'X-Auth-Token:' . $token;
    $header[] = 'Content-Type:text/html;charset=utf-8';

    //sur une date
    if ($num_facture && $num_facture !== '') {
        $dataArray = array(
            "number" => $num_facture,
            "page" => $page
        );
    }

    $req_url = get_url_recup_kepler("facture");
    $data = http_build_query($dataArray);
    $getURL = $req_url . '?' . $data;

    print_r($getURL);

    saut_de_ligne();

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

    $obj = json_decode($result);
    $result = $obj->datas;
    return $result[0];
}

function get_bdc_from_kepler_by_number($num_bdc)
{
    $page = 1;

    $token = goCurlToken();
    $ch = curl_init();

    // le token
    $header = array();
    $header[] = 'X-Auth-Token:' . $token;
    $header[] = 'Content-Type:text/html;charset=utf-8';

    //sur une date
    if ($num_bdc && $num_bdc !== '') {
        $dataArray = array(
            "number" => $num_bdc,
            "page" => $page
        );
    }

    $req_url = get_url_recup_kepler("bdc");
    $data = http_build_query($dataArray);
    $getURL = $req_url . '?' . $data;

    print_r($getURL);

    saut_de_ligne();

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

    $obj = json_decode($result);
    $result = $obj->datas;
    return $result[0];
}

function get_url_recup_kepler($type)
{
    switch ($type) {
        case "facture":
            // URL factures API
            $request_facture = "v3.1/invoice/";
            $url = "https://www.kepler-soft.net/api/";
            $req_url = $url . "" . $request_facture;
            break;

        case "bdc":
            // URL BDC API
            $request_bdc = "v3.1/order-form/";
            $url = "https://www.kepler-soft.net/api/";
            $req_url = $url . "" . $request_bdc;
            break;

        case "vehicule":
            break;
    }

    return $req_url;
}

function GoCurl_Recup_BDC_canceled($token, $page, $date_bdc = '')
{

    $ch = curl_init();

    // le token
    $header = array();
    $header[] = 'X-Auth-Token:' . $token;
    $header[] = 'Content-Type:text/html;charset=utf-8';

    if (isset($date_bdc) && $date_bdc != '') {

        $dataArray = array(
            "state" => 'administrative_selling.state.canceled',
            "updateDateFrom" => "$date_bdc",
            "updateDateTo" => "$date_bdc",
            "count" => 100,
            "page" => $page
        );
    }
    //si pas de date alors on prend de début avril à hier
    else {
        $date = date('Y-m-d', strtotime('-1 day'));
        $dataArray = array(
            "state" => "administrative_selling.state.canceled",
            // "orderFormDateFrom" => "$date_from",
            // "orderFormDateTo" => "$date_to",
            "updateDateFrom" => "$date",
            "updateDateTo" => "$date",
            "count" => 100,
            "page" => $page
        );
    }


    $request_bon_de_commande = "v3.1/order-form/";
    $url = "https://www.kepler-soft.net/api/";
    $req_url_BDC = $url . "" . $request_bon_de_commande;


    $getURL = $req_url_BDC . '?' . http_build_query($dataArray);

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

    $obj = json_decode($result);
    return $obj->datas;

}

function calcul_variation_factures($factures_N, $factures_N1)
{
    if ($factures_N !== 0 && $factures_N1 !== 0) {
        $variation_factures = (($factures_N - $factures_N1) / ($factures_N1)) * 100;
    } else {
        $variation_factures = 0;
    }
    return round($variation_factures);
}

function calcul_variation_marge($marge_N, $marge_N1)
{
    if ($marge_N !== 0 && $marge_N1 !== 0) {
        $variation_marge = (($marge_N - $marge_N1) / abs($marge_N1)) * 100;
    } else {
        $variation_marge = 0;
    }
    return round($variation_marge);
}

function calcul_moyenne_marge($marge, $nbre)
{
    if ($marge !== 0 && $nbre !== 0) {
        $moyenne_marge = $marge / $nbre;
    } else {
        $moyenne_marge = 0;
    }
    return intval(round($moyenne_marge));
}

function calcul_variation_moyenne($moyenne_N, $moyenne_N1)
{
    if ($moyenne_N !== 0 && $moyenne_N1 !== 0) {
        $variation_moyenne = (($moyenne_N - $moyenne_N1) / abs($moyenne_N1)) * 100;
    } else {
        $variation_moyenne = 0;
    }
    return round($variation_moyenne);
}


function update_marge_factures()
{
    //prendre toutes les factures de ma base

    //base portail
    $pdo2 = Connection::getPDO_2();
    //base portail_massoutre
    $pdo = Connection::getPDO();


    $request = $pdo->query("SELECT numero_facture FROM suivi_ventes_factures");
    $result_list_num_facture = $request->fetchAll(PDO::FETCH_ASSOC);

    // on boucle pour aller chercher la marge brut et nette dans la base portail
    foreach ($result_list_num_facture as $facture) {
        //dans le cas ou il ya plusieurs retour, on ne prend que le dernier ID en faisant order by id desc limit 1
        $request = $pdo2->query("SELECT marge_brute,marge_nette FROM factureventes WHERE dernier_numero_facture = '" . $facture['numero_facture'] . "' ORDER BY id DESC LIMIT 1");
        $result_marge = $request->fetch(PDO::FETCH_ASSOC);

        var_dump($result_marge);

        $data_marge = [
            'marge_ht' => $result_marge['marge_brute'],
            'marge_ttc' => $result_marge['marge_nette'],
            'numero_facture' => $facture['numero_facture']
        ];

        $sql = "UPDATE suivi_ventes_factures SET marge_ht=:marge_ht, marge_ttc=:marge_ttc WHERE numero_facture=:numero_facture";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data_marge);
    }


}

function get_factures_by_site_by_destination_vente($cvo_id, $destination_vente, $type_provenance, $date_factures = '')
{
    $pdo = Connection::getPDO();

    $sql_date = filtre_date_bdc_factures($date_factures, "factures");

    switch ($destination_vente) {
        //tableau particulier 
        case 1:
            $request = $pdo->query("SELECT factures.ID,factures.numero_facture,factures.date_facture,factures.marge_ht FROM suivi_ventes_factures as factures 
            LEFT JOIN suivi_ventes_vehicules as vsv ON vsv.id = factures.id_vehicule
            LEFT JOIN collaborateurs_payplan as cp ON cp.ID = factures.id_vendeur 
            LEFT JOIN cvo on cvo.ID = cp.id_site 
            WHERE cvo.ID = $cvo_id AND factures.id_destination_vente = $destination_vente AND vsv.provenance_vo_vn = $type_provenance  $sql_date");
            $factures = $request->fetchAll(PDO::FETCH_ASSOC);
            break;
        //tableau marchands : on prend pas le nbre de BDC mais le nombre de VH car cela fait plus sens
        case 2:
            $request = $pdo->query("SELECT factures.ID,factures.numero_facture,factures.date_facture,factures.marge_ht FROM suivi_ventes_vehicules as vsv 
            LEFT JOIN suivi_ventes_factures as factures ON factures.id_vehicule = vsv.ID 
            LEFT JOIN collaborateurs_payplan as cp ON cp.ID = factures.id_vendeur
            LEFT JOIN cvo on cvo.ID = cp.id_site
            WHERE cvo.ID = $cvo_id AND factures.id_destination_vente = $destination_vente AND vsv.provenance_vo_vn = $type_provenance  $sql_date");
            $factures = $request->fetchAll(PDO::FETCH_ASSOC);
            break;
    }

    return $factures;
}

function get_factures_by_site_by_destination_vente_N1($cvo_id, $destination_vente, $type_provenance, $date_factures = '')
{
    $pdo = Connection::getPDO();

    $sql_date = filtre_date_bdc_factures_N1($date_factures, "factures");

    switch ($destination_vente) {
        //tableau particulier 
        case 1:
            $request = $pdo->query("SELECT factures.ID,factures.numero_facture,factures.date_facture,factures.marge_ht FROM suivi_ventes_factures as factures 
            LEFT JOIN suivi_ventes_vehicules as vsv ON vsv.ID = factures.id_vehicule
            LEFT JOIN collaborateurs_payplan as cp ON cp.ID = factures.id_vendeur 
            LEFT JOIN cvo on cvo.ID = cp.id_site 
            WHERE cvo.ID = $cvo_id AND factures.id_destination_vente = $destination_vente AND vsv.provenance_vo_vn = $type_provenance  $sql_date");
            $factures_N1 = $request->fetchAll(PDO::FETCH_ASSOC);
            break;
        //tableau marchands : on prend pas le nbre de BDC mais le nombre de VH car cela fait plus sens
        case 2:
            $request = $pdo->query("SELECT factures.ID,factures.numero_facture,factures.date_facture,factures.marge_ht FROM suivi_ventes_vehicules as vsv 
            LEFT JOIN suivi_ventes_factures as factures ON factures.id_vehicule = vsv.ID 
            LEFT JOIN collaborateurs_payplan as cp ON cp.ID = factures.id_vendeur
            LEFT JOIN cvo on cvo.ID = cp.id_site
            WHERE cvo.ID = $cvo_id AND factures.id_destination_vente = $destination_vente AND vsv.provenance_vo_vn = $type_provenance  $sql_date");
            $factures_N1 = $request->fetchAll(PDO::FETCH_ASSOC);
            break;
    }

    return $factures_N1;
}

function calcul_nbre_factures($factures)
{
    $nbre_facture = 0;
    foreach ($factures as $facture) {
        $nbre_facture++;
    }
    return $nbre_facture;
}


// fonction pour relier le id_vehicule à la facture
function update_vh_factures_OS()
{

    $pdo_portail = Connection::getPDO();
    $pdo_base = Connection::getPDO_2();

    //on commence par récupérer tous les numéros de facture de ma base 
    $request = $pdo_portail->query("SELECT ID,numero_facture FROM suivi_ventes_factures
    WHERE id_vehicule IS NULL");
    $liste_num_factures = $request->fetchAll(PDO::FETCH_ASSOC);

    //on boucle pour chaque num facture
    foreach ($liste_num_factures as $facture) {
        $num_facture = $facture['numero_facture'];
        $id_facture = $facture['ID'];

        // on va chercher l'immat du vh dans la base massoutre
        $request = $pdo_base->query("SELECT vh.immatriculation FROM factureventes as facture
        LEFT JOIN vehicules AS vh ON vh.ID = facture.vehicule_id
        WHERE facture.dernier_numero_facture = '$num_facture'");
        $immatriculation = $request->fetch(PDO::FETCH_COLUMN);

        //une fois l'immat on va récupérer l'id du vh de suivi vente vh pour le rattacher à la facture. 
        $request = $pdo_portail->query("SELECT ID FROM suivi_ventes_vehicules
        WHERE immatriculation = '$immatriculation'");
        $result = $request->fetch(PDO::FETCH_COLUMN);
        $id_vehicule = intval($result);

        //on va update la facture
        $data = [
            'id_vehicule' => $id_vehicule,
            'id' => $id_facture
        ];
        $sql = "UPDATE suivi_ventes_factures SET id_vehicule=:id_vehicule WHERE ID=:id";
        $stmt = $pdo_portail->prepare($sql);
        $stmt->execute($data);
    }

}


function update_vh_bdc_OS()
{

    $pdo_portail = Connection::getPDO();
    $pdo_base = Connection::getPDO_2();

    //on commence par récupérer tous les immat de ma base 
    $request = $pdo_portail->query("SELECT ID,immatriculation FROM suivi_ventes_vehicules WHERE bdc_id IS NULL");
    $liste_vh = $request->fetchAll(PDO::FETCH_ASSOC);

    //on boucle pour chaque num facture
    // foreach ($liste_vh as $vh) {
    //     $vh_immat = $vh['immatriculation'];
    //     $vh_id = $vh['ID'];

    //     // on va chercher le num bdc dans la base massoutre
    //     $request = $pdo_base->query("SELECT bdc.numero FROM bdcventes as bdc
    //     LEFT JOIN vehicules AS vh ON vh.ID = bdc.vehicule_id
    //     WHERE vh.immatriculation = '$vh_immat'");
    //     $num_bdc = $request->fetch(PDO::FETCH_COLUMN);

    //     //une fois l'immat on va récupérer l'id du vh de suivi vente vh pour le rattacher à la facture. 
    //     $request = $pdo_portail->query("SELECT ID FROM suivi_ventes_vehicules
    //     WHERE immatriculation = '$immatriculation'");
    //     $result = $request->fetch(PDO::FETCH_COLUMN);
    //     $id_vehicule = intval($result);

    //     //on va update la facture
    //     $data = [
    //         'id_vehicule' => $id_vehicule,
    //         'id' => $id_facture
    //     ];
    //     $sql = "UPDATE suivi_ventes_factures SET id_vehicule=:id_vehicule WHERE ID=:id";
    //     $stmt = $pdo_portail->prepare($sql);
    //     $stmt->execute($data);
    // }

}

//fonction pour passer le bdc à facturé si tous les vh de ce bdc sont facturés
function update_bdc_invoice()
{

    $pdo_portail = Connection::getPDO();
    $pdo_base = Connection::getPDO_2();

    //on commence par récupérer tous les BDC de ma base 
    $request = $pdo_portail->query("SELECT ID,numero_bdc FROM suivi_ventes_bdc WHERE is_invoiced IS NULL");
    $liste_bdc_no_invoiced = $request->fetchAll(PDO::FETCH_ASSOC);

    foreach ($liste_bdc_no_invoiced as $bdc) {

        $id_bdc = $bdc['ID'];

        // on recupere tous les vh qui sont sur ce bdc
        $request = $pdo_portail->query("SELECT ID,immatriculation,facture_id FROM suivi_ventes_vehicules WHERE bdc_id = $id_bdc");
        $liste_vh_du_bdc = $request->fetchAll(PDO::FETCH_ASSOC);

        foreach ($liste_vh_du_bdc as $vh) {
            if (is_null($vh['facture_id'])) {
                $is_invoiced = FALSE;
            } else {
                $is_invoiced = TRUE;
            }
        }

        //si on doit passer le bdc a l'etat facturé
        if ($is_invoiced) {
            $data = [
                'etat' => 1,
                'ID' => $id_bdc
            ];

            $sql = "UPDATE suivi_ventes_bdc SET is_invoiced =:etat WHERE ID = :ID";
            $stmt = $pdo_portail->prepare($sql);
            $stmt->execute($data);
        }
    }
}

//fonction pour relier l'id_facture au vh si il est facturé 
function update_vh_invoice()
{

    $pdo_portail = Connection::getPDO();
    $pdo_base = Connection::getPDO_2();

    //on commence par récupérer tous les VH de ma base qui sont pas facturés
    $request = $pdo_portail->query("SELECT ID,immatriculation FROM suivi_ventes_vehicules WHERE facture_id IS NULL");
    $liste_vh_no_invoiced = $request->fetchAll(PDO::FETCH_ASSOC);

    foreach ($liste_vh_no_invoiced as $vh) {
        $id_vh = $vh['ID'];

        // on recupere tous les vh qui sont sur ce bdc
        $request = $pdo_portail->query("SELECT ID,numero_facture FROM suivi_ventes_factures WHERE id_vehicule = $id_vh");
        $facture_du_vh = $request->fetch(PDO::FETCH_ASSOC);

        //si on trouve une facture associée
        if ($facture_du_vh) {
            $data = [
                'facture_id' => $facture_du_vh['ID'],
                'ID' => $id_vh
            ];
            $sql = "UPDATE suivi_ventes_vehicules SET facture_id =:facture_id WHERE ID = :ID";
            $stmt = $pdo_portail->prepare($sql);
            $stmt->execute($data);
        }

    }

}


function check_and_update_if_bdc_invoiced_by_id_bdc($id_bdc)
{
    $pdo_portail = Connection::getPDO();
    //on commence par récupérer le BDC de ma base 
    $request = $pdo_portail->query("SELECT ID,numero_bdc FROM suivi_ventes_bdc WHERE ID = $id_bdc");
    $bdc = $request->fetch(PDO::FETCH_ASSOC);

    $id_bdc = intval($bdc['ID']);

    // on recupere tous les vh qui sont sur ce bdc
    $request = $pdo_portail->query("SELECT ID,immatriculation,facture_id FROM suivi_ventes_vehicules WHERE bdc_id = $id_bdc");
    $liste_vh_du_bdc = $request->fetchAll(PDO::FETCH_ASSOC);

    foreach ($liste_vh_du_bdc as $vh) {
        if (is_null($vh['facture_id'])) {
            $is_invoiced = FALSE;
        } else {
            $is_invoiced = TRUE;
        }
    }

    //si is_invoiced = true on doit passer le bdc a l'etat facturé
    if ($is_invoiced) {
        $data = [
            'etat' => 1,
            'ID' => $id_bdc
        ];

        $sql = "UPDATE suivi_ventes_bdc SET is_invoiced =:etat WHERE ID = :ID";
        $stmt = $pdo_portail->prepare($sql);
        $stmt->execute($data);
    }
}

function get_array_factures_from_kepler($date)
{
    $j = 1;
    $token = goCurlToken();
    $liste_factures = GoCurl_Recup_Factures($token, $j, $date);

    $i = 0;
    $array_factures = array();
    foreach ($liste_factures as $facture) {
        $array_factures[$i]['num_facture'] = $facture->number;
        $array_factures[$i]['uuid_facture'] = $facture->uuid;
        $date_facture = new datetime($facture->invoiceDate);
        $formatted_date = $date_facture->format("Y-m-d");
        $array_factures[$i]['date_facture'] = $formatted_date;
        $i++;
    }
    return $array_factures;
}

function get_array_bdc_from_kepler($date)
{
    $j = 1;
    $token = goCurlToken();
    $liste_bdc = GoCurl_Recup_BDC($token, $j, '', $date);
    $j = 0;
    $array_bdc = array();
    foreach ($liste_bdc as $bdc) {
        $array_bdc[$j]['num_bdc'] = $bdc->number;
        $array_bdc[$j]['uuid_bdc'] = $bdc->uuid;
        $date_bdc = new datetime($bdc->date);
        $formatted_date = $date_bdc->format("Y-m-d");
        $array_bdc[$j]['date_bdc'] = $formatted_date;
        $j++;
    }
    return $array_bdc;
}



function get_uuid_bdc_from_array($array_bdc, $num_bdc)
{

    $bdc_finded = FALSE;

    foreach ($array_bdc as $num_array => $bdc) {
        if ($bdc['num_bdc'] == $num_bdc) {
            $uuid_bdc = $bdc['uuid_bdc'];
            $bdc_finded = TRUE;
            break;
        }
    }
    if ($bdc_finded) {
        return $uuid_bdc;
    } else {
        return NULL;
    }

}

function get_uuid_facture_from_array($array_factures, $num_facture)
{
    $facture_finded = FALSE;

    foreach ($array_factures as $num_array => $facture) {
        if ($facture['num_facture'] == $num_facture) {
            $uuid_facture = $facture['uuid_facture'];
            $facture_finded = TRUE;
            break;
        }
    }
    if ($facture_finded) {
        return $uuid_facture;
    } else {
        return NULL;
    }
}





function update_factures_canceled($date)
{
    $j = 1;
    $token = goCurlToken();
    $liste_facture_canceled = GoCurl_Recup_Factures_canceled($token, $j, $date);
    if ($liste_facture_canceled) {
        delete_facture($liste_facture_canceled);
    }
}

function delete_facture($array_facture_to_delete)
{
    foreach ($array_facture_to_delete as $facture) {
        $facture_id_and_num = get_id_and_num_facture_by_uuid_facture($facture->uuid);
        $num_facture = $facture_id_and_num['numero_facture'];
        $id_facture = intval($facture_id_and_num['ID']);

        $pdo_portail = Connection::getPDO();

        $data_facture_to_delete = [
            'id' => $id_facture
        ];

        $sql = "DELETE FROM suivi_ventes_factures WHERE ID=:id";
        $stmt = $pdo_portail->prepare($sql);
        $stmt->execute($data_facture_to_delete);
    }
}

function get_id_and_num_facture_by_uuid_facture($facture_uuid)
{
    $pdo_portail = Connection::getPDO();
    $request = $pdo_portail->query("SELECT ID,numero_facture FROM suivi_ventes_factures WHERE uuid = '" . $facture_uuid . "'");
    $result = $request->fetch(PDO::FETCH_ASSOC);
    return $result;
}





function update_bdc_canceled($date)
{
    $j = 1;
    $token = goCurlToken();
    $liste_bdc_canceled = GoCurl_Recup_BDC_canceled($token, $j, $date);
    if ($liste_bdc_canceled) {
        delete_bdc($liste_bdc_canceled);
    }
}

function delete_bdc($array_bdc_to_delete)
{
    foreach ($array_bdc_to_delete as $bdc) {
        $bdc_id_and_num = get_id_and_num_bdc_by_uuid_bdc($bdc->uuid);
        $num_bdc = $bdc_id_and_num['numero_bdc'];
        $id_bdc = intval($bdc_id_and_num['ID']);

        $pdo_portail = Connection::getPDO();

        $data_bdc_to_delete = [
            'id' => $id_bdc
        ];

        $sql = "DELETE FROM suivi_ventes_bdc WHERE ID=:id";
        $stmt = $pdo_portail->prepare($sql);
        $stmt->execute($data_bdc_to_delete);

        //il faut aussi supprimer tous les vh du BDC
        $data_vh_liee_bdc_to_delete = [
            'id' => $id_bdc
        ];
        $sql = "DELETE FROM suivi_ventes_vehicules WHERE bdc_id=:id";
        $stmt = $pdo_portail->prepare($sql);
        $stmt->execute($data_vh_liee_bdc_to_delete);
    }
}

function get_id_and_num_bdc_by_uuid_bdc($bdc_uuid)
{
    $pdo_portail = Connection::getPDO();
    $request = $pdo_portail->query("SELECT ID,numero_bdc FROM suivi_ventes_bdc WHERE uuid = '" . $bdc_uuid . "'");
    $result = $request->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function update_marge_nette()
{
    $pdo = Connection::getPDO();

    // on commence par aller chercher dans la base  toutes les factures 
    $request = $pdo->query("SELECT ID,marge_ht,marge_ttc FROM suivi_ventes_factures ");
    $result_list_factures = $request->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result_list_factures as $facture) {

        $marge_ttc = $facture['marge_ttc'] * 1.2;

        $data_update_facture = [
            'ID' => $facture['ID'],
            'marge_ht' => $facture['marge_ttc']
        ];

        $sql = "UPDATE suivi_ventes_factures SET marge_ht =:marge_ht WHERE ID =:ID";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data_update_facture);


        $data_update_facture_2 = [
            'ID' => $facture['ID'],
            'marge_ttc' => $marge_ttc
        ];

        $sql = "UPDATE suivi_ventes_factures SET marge_ttc =:marge_ttc WHERE ID =:ID";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data_update_facture_2);

    }
}


function update_factures_sans_vh()
{
    //base portail_massoutre
    $pdo = Connection::getPDO();

    //récupérer toutes les factures ou le vh est à 0 
    $request = $pdo->query("SELECT ID FROM suivi_ventes_factures WHERE id_vehicule = 0");
    $result_list_factures = $request->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result_list_factures as $facture) {

        //pour chaque facure recupérer le vh via le numéro de facture dans la base bleue
        $request = $pdo->query("SELECT vh.ID FROM suivi_ventes_vehicules as vh
            WHERE vh.facture_id = " . $facture['ID'] . "");
        $result_vh_id = $request->fetch(PDO::FETCH_ASSOC);

        $data_update_fact = [
            'id_vehicule' => $result_vh_id['ID'],
            'id_facture' => $facture['ID']
        ];

        $sql = "UPDATE suivi_ventes_factures SET id_vehicule =:id_vehicule WHERE ID = :id_facture";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data_update_fact);


    }

}




