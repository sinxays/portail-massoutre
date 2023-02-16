<?php

use App\Connection;

function create_table_collaborateurs_payplan($header, $array_collaborateurs)
{

    $table_collaborateurs_payplan = "";

    $table_collaborateurs_payplan .= create_header_row($header);

    foreach ($array_collaborateurs as $collaborateur) {


        $table_collaborateurs_payplan .= "<tr>";
        $table_collaborateurs_payplan .= "<td>" . $collaborateur["nom_complet"] . " </td>";
        $table_collaborateurs_payplan .= "<td> <a href='/payplan/payplan_detail_collaborateur.php?id_collaborateur_payplan=" . $collaborateur['ID'] . "'>" . $collaborateur['nb_reprise'] . "</a></td>";
        $table_collaborateurs_payplan .= "</tr>";
    }

    return $table_collaborateurs_payplan;
}


function create_table_stats_loc_agence_type($header, $liste_agence, $type, $date)
{

    $table_stats_loc = "";

    $table_stats_loc .= "<table class='my_tab_perso'>";

    //header
    $table_stats_loc .= create_header_row($header);
    //fin header

    $tableau_stats = get_stats_journalieres($liste_agence, $type, $date);


    //contenu
    foreach ($tableau_stats["tableau"] as $agence) {
        $table_stats_loc .= "<tr>";
        $table_stats_loc .= "<td class='td_n' style='width: 150px;'>" . $agence['nom_agence'] . " </td>";
        $table_stats_loc .= "<td class='td_n'>" . $agence['ca_tmi_n'] . "</td>";
        $table_stats_loc .= "<td class='td_n1'>0</td>";
        $table_stats_loc .= "<td class='td_n'>0</td>";
        $table_stats_loc .= "<td class='td_n1'>0</td>";
        $table_stats_loc .= "<td class='td_n'>0</td>";
        $table_stats_loc .= "<td class='td_n1'>0</td>";
        $table_stats_loc .= "<td class='td_n'>0</td>";
        $table_stats_loc .= "<td class='td_n'>0</td>";
        $table_stats_loc .= "<td class='td_n'>" . $agence['used'] . " %</td>";
        $table_stats_loc .= "<td class='td_n'>" . $agence['ro_n'] . "</td>";
        $table_stats_loc .= "<td class='td_n1'>0</td>";
        $table_stats_loc .= "<td class='td_n'>" . $agence['ri_n'] . "</td>";
        $table_stats_loc .= "<td class='td_n1'>0</td>";
        $table_stats_loc .= "<td class='td_n'>" . $agence['duree'] . "</td>";
        $table_stats_loc .= "<td class='td_n'>" . $agence['rev_ra'] . "</td>";
        $table_stats_loc .= "<td class='td_n'>0</td>";
        $table_stats_loc .= "<td class='td_n'>" . $agence['nb_jour'] . "</td>";
        $table_stats_loc .= "<td class='td_n1'>0</td>";
        $table_stats_loc .= "<td class='td_n'>0</td>";

        $table_stats_loc .= "</tr>";
    }
    //fin contenu

    $table_stats_loc .= "</table> ";

    $return["tableau"] = $table_stats_loc;
    $return["requete"] = $tableau_stats["requete"];

    return $return;
}

function create_table_stats_loc_date($header, $requete, $date)
{
    $requete_array = explode(" ", $requete);
    //la date sera toujours au 18
    $requete_array[26] = "'" . $date . "'";
    $requete  = implode(" ", $requete_array);

    $pdo = Connection::getPDO();
    $request = $pdo->query("$requete");
    $result = $request->fetchAll(PDO::FETCH_ASSOC);

    $table_stats_loc = "";
    $table_stats_loc .= "<table class='my_tab_perso'>";

    //header
    $table_stats_loc .= create_header_row($header);
    //fin header


    //contenu
    foreach ($result as $agence) {
        $table_stats_loc .= "<tr>";
        $table_stats_loc .= "<td class='td_n' style='width: 150px;'>" . $agence['nom_agence'] . " </td>";
        $table_stats_loc .= "<td class='td_n'>" . $agence['ca_tmi_n'] . "</td>";
        $table_stats_loc .= "<td class='td_n1'>0</td>";
        $table_stats_loc .= "<td class='td_n'>0</td>";
        $table_stats_loc .= "<td class='td_n1'>0</td>";
        $table_stats_loc .= "<td class='td_n'>0</td>";
        $table_stats_loc .= "<td class='td_n1'>0</td>";
        $table_stats_loc .= "<td class='td_n'>0</td>";
        $table_stats_loc .= "<td class='td_n'>0</td>";
        $table_stats_loc .= "<td class='td_n'>" . $agence['used'] . " %</td>";
        $table_stats_loc .= "<td class='td_n'>" . $agence['ro_n'] . "</td>";
        $table_stats_loc .= "<td class='td_n1'>0</td>";
        $table_stats_loc .= "<td class='td_n'>" . $agence['ri_n'] . "</td>";
        $table_stats_loc .= "<td class='td_n1'>0</td>";
        $table_stats_loc .= "<td class='td_n'>" . $agence['duree'] . "</td>";
        $table_stats_loc .= "<td class='td_n'>" . $agence['rev_ra'] . "</td>";
        $table_stats_loc .= "<td class='td_n'>0</td>";
        $table_stats_loc .= "<td class='td_n'>" . $agence['nb_jour'] . "</td>";
        $table_stats_loc .= "<td class='td_n1'>0</td>";
        $table_stats_loc .= "<td class='td_n'>0</td>";

        $table_stats_loc .= "</tr>";
    }
    //fin contenu

    $table_stats_loc .= "</table> ";


    $return["tableau"] = $table_stats_loc;
    $return["requete"] = $requete;

    return $return;
}

function create_table_agences($header, $liste_agence)
{

    $table_agences = "";

    //header
    $table_agences .= create_header_row($header);
    //fin header

    //contenu
    foreach ($liste_agence as $agence) {
        $table_agences .= "<tr>";
        $table_agences .= "<td class='td_n' style='width: 150px;'>" . $agence['nom_agence'] . " </td>";
        $table_agences .= "<td class='td_n' style='width: 150px;'>" . $agence['num_tel_agence'] . "</td>";
        $table_agences .= "<td class='td_n' style='width: 250px;'>" . $agence['adresse'] . "</td>";
        $table_agences .= "<td class='td_n' style='width: 80px;'>" . $agence['cp'] . "</td>";
        $table_agences .= "<td class='td_n' style='width: 300px;'>" . $agence['mail_agence'] . "</td>";
        $table_agences .= "<td class='td_n' style='width: 100px;'>" . $agence['code_district'] . "</td>";
        $table_agences .= "<td class='td_n' style='width: 100px;'>" . $agence['code_vp'] . " (" . $agence['code_vp_alpha'] . ")</td>";
        $table_agences .= "<td class='td_n' style='width: 100px;'>" . $agence['code_vu'] . " (" . $agence['code_vu_alpha'] . ")</td>";
        if ($agence['code_gare_alpha']) {
            $table_agences .= "<td class='td_n' style='width: 100px;'>" . $agence['code_gare'] . " (" . $agence['code_gare_alpha'] . ")</td>";
        } else {
            $table_agences .= "<td class='td_n' style='width: 100px;'>" . $agence['code_gare'] . "</td>";
        }
        $table_agences .= "<td class='td_n' style='width: 100px;'>
        <button class='btn btn-success' onclick='modifier_agence(" . $agence["ID"] . ")'>Modifier</button> </td>";
        $table_agences .= "</tr>";
    }
    //fin contenu


    $return = $table_agences;
    // $return["requete"] = $tableau_stats["requete"];

    return $return;
}

function create_table_liste_telephonique($header, $liste_telephonique, $type)
{

    $table_liste_tel = "";

    switch ($type) {
        case "agence":
            //contenu 
            //header
            $table_liste_tel .= create_header_row($header);
            //fin header
            foreach ($liste_telephonique as $collaborateur) {
                $table_liste_tel .= "<tr>";
                $table_liste_tel .= "<td class='td_n' style='width: 150px;'>" . utf8_encode($collaborateur['nom_infrastructure']) . "</td>";
                $table_liste_tel .= "<td class='td_n' style='width: 150px;'>" . $collaborateur['ndi'] . "</td>";
                if ($collaborateur['prefixe_toip'] !== '') {
                    $table_liste_tel .= "<td class='td_n' style='width: 150px;'>" . "(" . $collaborateur['prefixe_toip'] . ")" . $collaborateur['numero_court'] . "</td>";
                } else {
                    $table_liste_tel .= "<td class='td_n' style='width: 150px;'> </td>";
                }
                $table_liste_tel .= "<td class='td_n' style='width: 40px;'> <a href ='\Liste_telephonique\liste_telephonique.php' id='show-option' title='voir plus'> <i class='bx bx-buildings'></i> </a> </td>";
                $table_liste_tel .= "</tr>";
            }
            //fin contenu
            break;

        case "agent":
            break;

        case "cvo":
            break;

        case "siege":
            break;
    }
    //contenu
    // foreach ($liste_telephonique as $collaborateur) {

    //     $table_liste_tel .= "<tr>";
    //     $table_liste_tel .= "<td class='td_n' style='width: 150px;'>" . utf8_encode($collaborateur['nom']) . " </td>";
    //     $table_liste_tel .= "<td class='td_n' style='width: 150px;'>" . utf8_encode($collaborateur['prenom']) . "</td>";
    //     $table_liste_tel .= "<td class='td_n' style='width: 150px;'>" . $collaborateur['ligne_directe'] . "</td>";
    //     $table_liste_tel .= "<td class='td_n' style='width: 100px;'>" . $collaborateur['interne'] . "</td>";
    //     $table_liste_tel .= "<td class='td_n' style='width: 150px;'>" . utf8_encode($collaborateur['nom_infrastructure']) . "</td>";
    //     $table_liste_tel .= "<td class='td_n' style='width: 150px;'>" . $collaborateur['ndi'] . "</td>";
    //     $table_liste_tel .= "<td class='td_n' style='width: 150px;'>" . "(" . $collaborateur['prefixe_toip'] . ")" . $collaborateur['numero_court'] . "</td>";

    //     // $table_liste_tel .= "<td class='td_n' style='width: 100px;'>
    //     // <button class='btn btn-success' onclick='modifier_imprimante(" . $collaborateur["ID"] . ")'>Modifier</button> </td>";
    //     $table_liste_tel .= "</tr>";
    // }
    //fin contenu


    $return = $table_liste_tel;
    // $return["requete"] = $tableau_stats["requete"];

    return $return;
}

function create_table_imprimantes($header, $liste_imprimantes)
{

    $table_imprimantes = "";

    //header
    $table_imprimantes .= create_header_row($header);
    //fin header

    //contenu
    foreach ($liste_imprimantes as $imprimante) {
        $table_imprimantes .= "<tr>";
        $table_imprimantes .= "<td class='td_n' style='width: 150px;'>" . $imprimante['num_serie'] . " </td>";
        $table_imprimantes .= "<td class='td_n' style='width: 150px;'>" . utf8_encode($imprimante['nom_infrastructure']) . "</td>";
        // $table_imprimantes .= "<td class='td_n' style='width: 250px;'>" . $imprimante['nom_district'] . "</td>";
        $table_imprimantes .= "<td class='td_n' style='width: 150px;'>" . utf8_encode($imprimante['emplacement']) . "</td>";
        $table_imprimantes .= "<td class='td_n' style='width: 100px;'>" . $imprimante['prestataire'] . "</td>";
        $table_imprimantes .= "<td class='td_n' style='width: 150px;'>" . $imprimante['marque'] . "</td>";
        $table_imprimantes .= "<td class='td_n' style='width: 150px;'>" . $imprimante['modele'] . "</td>";
        $table_imprimantes .= "<td class='td_n' style='width: 150px;'>" . $imprimante['ip_vpn'] . "</td>";
        $table_imprimantes .= "<td class='td_n' style='width: 150px;'>" . $imprimante['ip_locale'] . "</td>";
        // $table_imprimantes .= "<td class='td_n' style='width: 100px;'>
        // <button class='btn btn-success' onclick='modifier_imprimante(" . $imprimante["ID"] . ")'>Modifier</button> </td>";
        $table_imprimantes .= "</tr>";
    }
    //fin contenu


    $return = $table_imprimantes;
    // $return["requete"] = $tableau_stats["requete"];

    return $return;
}

function create_table_cvo($header, $liste_cvos)
{

    $table_cvo = "";

    //header
    $table_cvo .= create_header_row($header);
    //fin header

    //contenu
    foreach ($liste_cvos as $cvo) {
        $table_cvo .= "<tr>";
        $table_cvo .= "<td class='td_n' style='width: 150px;'>" . $cvo['nom_cvo'] . " </td>";
        $table_cvo .= "<td class='td_n' style='width: 150px;'>" . $cvo['numero_cvo'] . "</td>";
        $table_cvo .= "<td class='td_n' style='width: 250px;'>" . $cvo['adresse'] . "</td>";
        $table_cvo .= "<td class='td_n' style='width: 80px;'>" . $cvo['cp'] . "</td>";
        $table_cvo .= "<td class='td_n' style='width: 300px;'>" . $cvo['mail_cvo'] . "</td>";
        $table_cvo .= "<td class='td_n' style='width: 100px;'> <button class='btn btn-success' onclick='modifier_cvo(" . $cvo["ID"] . ")'>Modifier</button> </td>";
        $table_cvo .= "</tr>";
    }
    //fin contenu

    return $table_cvo;
}



function create_table_marges($header, $liste_agence)
{
    $table_marges = "";

    $table_marges .= create_header_row($header);

    foreach ($liste_agence as $agence) {
        $table_marges .= "<tr>";
        $table_marges .= "<td class='td_n' style='width: 150px;'>" . $agence["nom_agence"] . " </td>";
        $table_marges .= "<td class='td_n1'>0</td>";
        $table_marges .= "<td class='td_n'>0</td>";
        $table_marges .= "<td class='td_n'>0</td>";
        $table_marges .= "<td class='td_n1'>0</td>";
        $table_marges .= "<td class='td_n'>0</td>";
        $table_marges .= "<td class='td_n'>0</td>";
        $table_marges .= "<td class='td_n1'>0</td>";
        $table_marges .= "<td class='td_n'>0</td>";
        $table_marges .= "<td class='td_n'>0</td>";
        $table_marges .= "<td class='td_n1'>0</td>";
        $table_marges .= "<td class='td_n'>0</td>";
        $table_marges .= "<td class='td_n'>0</td>";
        $table_marges .= "<td class='td_n1'>0</td>";
        $table_marges .= "<td class='td_n'>0</td>";
        $table_marges .= "<td class='td_n'>0</td>";
        $table_marges .= "<td class='td_n'>0</td>";
        $table_marges .= "</tr>";
    }
    $table_marges .= "</table> ";
    return $table_marges;
}

function create_table_commission($header, $array)
{

    $commisionable = 1;
    $table_payplan = "";

    //header
    $table_payplan .= create_header_row($header);
    //fin header

    //contenu
    foreach ($array as $payplan) {

        $type_de_com = define_type_com($payplan['Type_Achat'], $payplan['Type_Vehicule'], $payplan['Categorie_VU']);
        $frais_financier = define_frais_financier($payplan['Prix_achat_net_remise'], $payplan['Duree_stock'], $commisionable);
        $marge = define_marge($payplan, $commisionable);
        $commission = define_commission($type_de_com);
        $taux_com_reprise = define_taux_com_reprise($type_de_com, $payplan['Nom_Acheteur'], $payplan['Vendeur']);
        $com_reprise = define_com_reprise($type_de_com, $taux_com_reprise, $marge, $commisionable);
        $controle_marge_negoce = define_controle_marge_negoce($marge, $payplan['Marge_nette']);
        $controle_date = define_controle_date($payplan['Date_facturation'], $payplan['Date_Vente']);
        $frais_remise_etat = define_frais_remise_etat($payplan['Montant_Revision'], $payplan['Montant_Carrosserie'], $payplan['Montant_Preparation'], $payplan['Montant_Ct']);
        $pdtcomplementaire = define_pdt_complementaire_total($payplan['Marge_Financement'], $payplan['Montant_Garantie'], $payplan['Marge_Pack'], $payplan['Montant_Pack_Livraison'], $payplan['Marges_diverses']);
        $date_facturation = strtotime($payplan['Date_facturation']);
        $mois_vente = date("m", $date_facturation);



        $table_payplan .= "<tr>";
        $table_payplan .= "<td  style='width: 50px;'>" . $payplan['Immatriculation'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Destination'] . "</td>";
        $table_payplan .= "<td>" . $payplan['Type_Vehicule'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Type_Achat'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Categorie_VU'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Modele'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Reference_lot'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Finition'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Parc_Achat'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Nom_Acheteur'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Date_Vente'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Date_Achat'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Prix_achat_net_remise'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Duree_stock'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Date_premiere_location'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Date_derniere_location'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Date_stock'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Prix_carte_grise'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Prix_transport'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Montant_Bonus_Malus'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Commission_GCA'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Commission_Achat'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Marge_nette'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Vendeur'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Destination_sortie'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Prix_reserve'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Montant'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Client'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Marge_Financement'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Montant_Garantie'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Marge_Pack'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Montant_Pack_Livraison'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Marges_diverses'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Commissions_Massoutre'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Montant_Publicite'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Montant_Revision'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Montant_Carrosserie'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Montant_Preparation'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Montant_Ct'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Prix_Transport_CVO'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Date_facturation'] . " </td>";
        if ($payplan['Type_Achat'] == 'Reprise') {
            $table_payplan .= "<td class='td_options'><strong style='font-size: 12px;'>" . $payplan['Options'] . " </strong></td>";
        } else {
            $table_payplan .= "<td></td>";
        }
        $table_payplan .= "<td>" . $type_de_com . " </td>";
        $table_payplan .= "<td>" . $frais_financier  . " </td>";
        $table_payplan .= "<td>" . $marge . " </td>";
        $table_payplan .= "<td>" . $commission . " </td>";
        $table_payplan .= "<td>" . $taux_com_reprise . " </td>";
        $table_payplan .= "<td style='min-width:80px;'>" . $com_reprise . " € </td>";
        $table_payplan .= "<td>" . $controle_marge_negoce . " </td>";
        $table_payplan .= "<td>" . $controle_date . " </td>";
        $table_payplan .= "<td>" . $frais_remise_etat . " </td>";
        $table_payplan .= "<td>" . $pdtcomplementaire . " </td>";
        $table_payplan .= "<td>" . $mois_vente . " </td>";
        $table_payplan .= "</tr>";
    }
    //fin contenu
    return $table_payplan;
}



function create_table_reseaux($header, $liste_reseaux)
{

    $table_reseau = "";

    //header
    $table_reseau .= create_header_row($header);


    //contenu
    foreach ($liste_reseaux as $reseau) {
        $table_reseau .= "<tr>";
        $table_reseau .= "<td class='td_n' style='width: 150px;'>" . $reseau['nom_infrastructure'] . " </td>";
        $table_reseau .= "<td class='td_n' style='width: 300px;'>" . $reseau['ip_lan_local'] . "</td>";
        $table_reseau .= "<td class='td_n' style='width: 100px;'>" . $reseau['passerelle'] . "</td>";
        $table_reseau .= "<td class='td_n' style='width: 100px;'>" . $reseau['ip_vpn'] . "</td>";
        // $table_reseau .= "<td class='td_n' style='width: 100px;'>
        // <button class='btn btn-success' onclick='modifier_reseau(" . $reseau["ID"] . ")'>Modifier</button> </td>";
        $table_reseau .= "</tr>";
    }
    //fin contenu


    $return = $table_reseau;
    // $return["requete"] = $tableau_stats["requete"];

    return $return;
}

function create_table_payplan_reprise_by_collaborateur($header, $array_collaborateur)
{
    $table_collaborateur_payplan = "";

    $table_collaborateur_payplan .= create_header_row($header);

    $table_collaborateur_payplan .= "<tr>";
    $table_collaborateur_payplan .= "<td>" . $array_collaborateur["nom_collaborateur"] . " </td>";
    $table_collaborateur_payplan .= "<td> <a href='/payplan/payplan_detail_collaborateur.php?id_collaborateur_payplan=" . $array_collaborateur['id_collaborateur'] . "'>" . $array_collaborateur['nb_reprise'] . " </a> </td>";
    $table_collaborateur_payplan .= "</tr>";

    return $table_collaborateur_payplan;
}

function create_table_payplan_achat_by_collaborateur($header, $array_collaborateur)
{
    $table_collaborateur_payplan = "";

    $table_collaborateur_payplan .= create_header_row($header);

    $table_collaborateur_payplan .= "<tr>";
    $table_collaborateur_payplan .= "<td>" . $array_collaborateur["nom_collaborateur"] . " </td>";
    $table_collaborateur_payplan .= "<td> <a href='/payplan/payplan_detail_collaborateur.php?id_collaborateur_payplan=" . $array_collaborateur['id_collaborateur'] . "'>" . $array_collaborateur['nb_reprise'] . " </a> </td>";
    $table_collaborateur_payplan .= "</tr>";

    return $table_collaborateur_payplan;
}

function create_table_payplan_detail_reprise_collaborateur($header, $array_detail_payplan)
{
    $table_collaborateur_payplan_detail = "";

    $table_collaborateur_payplan_detail .= create_header_row($header);

    //contenu
    foreach ($array_detail_payplan as $detail_payplan) {
        $table_collaborateur_payplan_detail .= "<tr>";
        $table_collaborateur_payplan_detail .= "<td>" . $detail_payplan['immatriculation'] . " </td>";
        $table_collaborateur_payplan_detail .= "<td>" . $detail_payplan['parc_achat'] . " </td>";
        $table_collaborateur_payplan_detail .= "<td>" . $detail_payplan['date_achat'] . " </td>";
        $table_collaborateur_payplan_detail .= "</tr>";
    }
    //fin contenu
    return $table_collaborateur_payplan_detail;
}

function create_table_payplan_detail_achat_collaborateur($header, $array_detail_payplan)
{
    $table_collaborateur_payplan_detail = "";

    $table_collaborateur_payplan_detail .= create_header_row($header);

    //contenu
    foreach ($array_detail_payplan as $detail_payplan) {
        $table_collaborateur_payplan_detail .= "<tr>";
        $table_collaborateur_payplan_detail .= "<td>" . $detail_payplan['immatriculation'] . " </td>";
        $table_collaborateur_payplan_detail .= "<td>" . $detail_payplan['parc_achat'] . " </td>";
        $table_collaborateur_payplan_detail .= "<td>" . $detail_payplan['date_achat'] . " </td>";
        $table_collaborateur_payplan_detail .= "</tr>";
    }
    //fin contenu
    return $table_collaborateur_payplan_detail;
}



function create_table_payplan_reprise_achat($header, $array_collaborateurs, $all = '', $filtre = '')
{
    $table_collaborateurs_payplan = "";

    $filtre_initial = "";

    if (isset($filtre)) {
        if (isset($filtre['mois_precedent'])) {
            $filtre_date = "&filtre=date&value=mois_precedent";
        } elseif (isset($filtre['date_personnalisees'])) {
            $filtre_date = "&filtre=date&value=" . $filtre['date_personnalisees']['debut'] . "_" . $filtre['date_personnalisees']['fin'];
        }
    }

    $filtre = (isset($filtre_date) && $filtre_date !== '') ? $filtre_date : $filtre_initial;

    $table_collaborateurs_payplan .= create_header_row($header);

    $nb_repreneur_total = 0;
    $nb_achat_total = 0;

    if (isset($all) && $all == true) {
        foreach ($array_collaborateurs as $collaborateur) {

            $nb_repreneur_total =  $nb_repreneur_total + $collaborateur['nb_reprise'];
            $nb_achat_total = $nb_achat_total + $collaborateur['nb_achat'];

            $table_collaborateurs_payplan .= "<tr>";
            $table_collaborateurs_payplan .= "<td>" . $collaborateur["nom_complet_collaborateur"] . " </td>";
            $table_collaborateurs_payplan .= "<td> <a href='/payplan/payplan_detail_collaborateur.php?id_detail_collaborateur_payplan_reprise_achat=" . $collaborateur['id_collaborateur'] . "&type=reprise" . $filtre . "'>" . $collaborateur['nb_reprise'] . "</a></td>";
            $table_collaborateurs_payplan .= "<td> <a href='/payplan/payplan_detail_collaborateur.php?id_detail_collaborateur_payplan_reprise_achat=" . $collaborateur['id_collaborateur'] . "&type=achat" . $filtre . "'>" . $collaborateur['nb_achat'] . "</a></td>";
            $table_collaborateurs_payplan .= "</tr>";
        }

        //afficher le total
        $table_collaborateurs_payplan .= "<tr>";
        $table_collaborateurs_payplan .= "<td class='td_label_total'> TOTAL </td>";
        $table_collaborateurs_payplan .= "<td class='td_total_payplan'> " . $nb_repreneur_total . "</a></td>";
        $table_collaborateurs_payplan .= "<td class='td_total_payplan'> " . $nb_achat_total . "</a></td>";
        $table_collaborateurs_payplan .= "</tr>";
    }
    //si on affiche que un seul collaborateur
    else {
        $table_collaborateurs_payplan .= "<tr>";
        $table_collaborateurs_payplan .= "<td>" . $array_collaborateurs["nom_complet_collaborateur"] . " </td>";
        $table_collaborateurs_payplan .= "<td> <a href='/payplan/payplan_detail_collaborateur.php?id_detail_collaborateur_payplan_reprise_achat=" . $array_collaborateurs['id_collaborateur'] . "&type=reprise" . $filtre . "'>" . $array_collaborateurs['nb_reprise'] . "</a></td>";
        $table_collaborateurs_payplan .= "<td> <a href='/payplan/payplan_detail_collaborateur.php?id_detail_collaborateur_payplan_reprise_achat=" . $array_collaborateurs['id_collaborateur'] . "&type=achat" . $filtre . "'>" . $array_collaborateurs['nb_achat'] . "</a></td>";
        $table_collaborateurs_payplan .= "</tr>";
    }

    return $table_collaborateurs_payplan;
}


function create_table_payplan($payplan, $header_payplan)
{
    $table_payplan = "";

    $table_payplan .= create_header_row($header_payplan);

    $total_com_acheteur = 0;
    $total_com_vendeur = 0;
    $total_marge = 0;

    foreach ($payplan as $line_payplan) {

        $immatriculation = get_immatriculation_by_id_vehicule(intval($line_payplan['vehicule_id']));
        $nom_acheteur = get_nom_complet_collaborateur_by_id($line_payplan['acheteur_collaborateur_id']);
        $nom_repreneur = get_nom_complet_collaborateur_by_id($line_payplan['repreneur_final_collaborateur_id']);
        $nom_vendeur = get_nom_complet_collaborateur_by_id($line_payplan['vendeur_collaborateur_id']);

        $total_com_acheteur = $total_com_acheteur + $line_payplan['valeur_com_acheteur'];
        $total_com_vendeur = $total_com_vendeur + $line_payplan['valeur_com_vendeur'];
        $total_marge = $total_marge + $line_payplan['marge'];

        $table_payplan .= "<tr>";
        $table_payplan .= "<td>" . $immatriculation . " </td>";
        $table_payplan .= "<td>" . $line_payplan['parc_achat'] . " </td>";
        $table_payplan .= "<td>" . $line_payplan['marge'] . " </td>";
        $table_payplan .= "<td>" . $nom_acheteur . " </td>";
        $table_payplan .= "<td>" . $line_payplan['valeur_com_acheteur'] . " </td>";
        $table_payplan .= "<td>" . $nom_repreneur . " </td>";
        // $table_payplan .= "<td>" . $line_payplan['valeur_com_repreneur_final'] . " </td>";
        $table_payplan .= "<td>" . $nom_vendeur . " </td>";
        $table_payplan .= "<td>" . $line_payplan['valeur_com_vendeur'] . " </td>";
        $table_payplan .= "<td>" . $line_payplan['date_achat'] . " </td>";
        $table_payplan .= "<td>" . $line_payplan['date_facturation'] . " </td>";
        $table_payplan .= "</tr>";
    }

    // derniere ligne pout les totaux
    $table_payplan .= "<tr>";
    $table_payplan .= "<td style='border:none;'> </td>";
    $table_payplan .= "<td class='td_label_total_payplan'> TOTAL MARGE </td>";
    $table_payplan .= "<td class='td_total_payplan'>" . $total_marge . " </td>";
    $table_payplan .= "<td class='td_label_total_payplan'> TOTAL COM ACHETEUR </td>";
    $table_payplan .= "<td class='td_total_payplan'>" . $total_com_acheteur . " </td>";
    $table_payplan .= "<td style='border:none;'> </td>";
    // $table_payplan .= "<td>" . $line_payplan['valeur_com_repreneur_final'] . " </td>";
    $table_payplan .= "<td class='td_label_total_payplan'> TOTAL COM VENDEUR </td>";
    $table_payplan .= "<td class='td_total_payplan'>" . $total_com_vendeur . " </td>";
    $table_payplan .= "<td style='border:none;'> </td>";
    $table_payplan .= "<td style='border:none;'> </td>";
    $table_payplan .= "</tr>";

    return $table_payplan;
}


function create_header_row($header)
{
    $return = "";
    $return .= "<tr class='tr_sticky'>";
    foreach ($header as $title_header) {
        $return .= "<th class='th1'> $title_header </th>";
    }
    $return .= "</tr>";
    return $return;
}
