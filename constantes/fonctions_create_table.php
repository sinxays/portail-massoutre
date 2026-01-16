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
    $requete = implode(" ", $requete_array);

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
        $table_imprimantes .= "<td class='td_n' style='width: 100px;'>
        <button id='btn_modif_imprimante' class='btn btn-success' onclick='modifier_imprimante(" . $imprimante["ID"] . ")'>Modifier</button> </td>";
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
        $mois_vente = "";
        if ($date_facturation) {
            $mois_vente = date("m", $date_facturation);
        }



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
        $table_payplan .= "<td>" . $frais_financier . " </td>";
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
    $table_collaborateur_payplan .= "<td> <a href='/payplan/payplan_detail_collaborateur.php?id_collaborateur_payplan=" . $array_collaborateur['id_collaborateur'] . "'>" . $array_collaborateur['nb_achat'] . " </a> </td>";
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

function create_table_grille_de_gestion($header, $array_detail_payplan_v2)
{
    $table_collaborateur_payplan_detail = "";

    $table_collaborateur_payplan_detail .= create_header_row($header);

    //contenu
    foreach ($array_detail_payplan_v2 as $detail_payplan_v2) {
        $table_collaborateur_payplan_detail .= "<tr>";
        $table_collaborateur_payplan_detail .= "<td class='td_nom_complet_grille_gestion'>" . $detail_payplan_v2['prenom'] . " " . $detail_payplan_v2['nom'] . "  </td>";
        $table_collaborateur_payplan_detail .= "<td class='td-clickable-grille_gestion' data-id=" . $detail_payplan_v2['ID'] . " data-type='bdc'>" . $detail_payplan_v2['nb_bdc'] . " </td>";
        $table_collaborateur_payplan_detail .= "<td class='td-clickable-grille_gestion' data-id=" . $detail_payplan_v2['ID'] . " data-type='factures'>" . $detail_payplan_v2['nb_factures'] . " </td>";
        $table_collaborateur_payplan_detail .= "<td class='td-clickable-grille_gestion' data-id=" . $detail_payplan_v2['ID'] . " data-type='reprises'>" . $detail_payplan_v2['nb_reprises'] . " </td>";
        $table_collaborateur_payplan_detail .= "<td class='td-clickable-grille_gestion' data-id=" . $detail_payplan_v2['ID'] . "> 0 </td>";
        $table_collaborateur_payplan_detail .= "<td class='td-clickable-grille_gestion' data-id=" . $detail_payplan_v2['ID'] . " data-type='garanties'> " . $detail_payplan_v2['nb_garanties'] . " </td>";
        $table_collaborateur_payplan_detail .= "<td> " . $detail_payplan_v2['cumul_prix_ht_garanties'] . " </td>";
        $table_collaborateur_payplan_detail .= "<td class='td-clickable-grille_gestion' data-id=" . $detail_payplan_v2['ID'] . " data-type='packfirst' > " . $detail_payplan_v2['nb_pack_first'] . " </td>";

        $table_collaborateur_payplan_detail .= "</tr>";
    }
    //fin contenu
    return $table_collaborateur_payplan_detail;
}

function create_table_grille_de_gestion_detail_collaborateur($type, $data)
{
    $table = "";

    switch ($type) {
        case 'bdc':
            $header = get_header_from_type_grille_de_gestion_detail_collaborateur($type);
            $table .= create_header_row($header);

            //contenu
            foreach ($data as $bdc) {
                $table .= "<tr>";
                $table .= "<td>" . $bdc['numero_bdc'] . " </td>";
                $table .= "<td>" . $bdc['prix_vente_ht'] . " </td>";
                $table .= "<td>" . $bdc['prix_vente_ttc'] . " </td>";
                $table .= "<td>" . $bdc['date_bdc'] . " </td>";
                $table .= "</tr>";
            }
            break;

        case 'factures':
            $header = get_header_from_type_grille_de_gestion_detail_collaborateur($type);
            $table .= create_header_row($header);

            //contenu
            foreach ($data as $facture) {
                $table .= "<tr>";
                $table .= "<td>" . $facture['numero_facture'] . " </td>";
                $table .= "<td>" . $facture['date_facture'] . " </td>";
                $table .= "<td>" . $facture['prix_vente_total_ht'] . " </td>";
                $table .= "<td>" . $facture['prix_vente_vehicule_HT'] . " </td>";
                $table .= "<td>" . $facture['marge_ht'] . " </td>";
                $table .= "<td>" . $facture['marge_ttc'] . " </td>";
                $table .= "<td>" . $facture['nom_acheteur'] . " </td>";
                $table .= "</tr>";
            }
            break;

        case 'reprises':
            $header = get_header_from_type_grille_de_gestion_detail_collaborateur($type);
            $table .= create_header_row($header);

            //contenu
            foreach ($data as $facture) {
                $table .= "<tr>";
                $table .= "<td>" . $facture['immatriculation'] . " </td>";
                $table .= "<td>" . $facture['type_vehicule'] . " </td>";
                $table .= "<td>" . $facture['modele'] . " </td>";
                $table .= "<td>" . $facture['finition'] . " </td>";
                $table .= "<td>" . $facture['parc_achat'] . " </td>";
                $table .= "<td>" . $facture['libelle'] . " </td>";
                $table .= "</tr>";
            }
            break;

        case 'garanties':
            $header = get_header_from_type_grille_de_gestion_detail_collaborateur($type);
            $table .= create_header_row($header);

            //contenu
            foreach ($data as $facture) {
                $table .= "<tr>";
                $table .= "<td>" . $facture['num_facture'] . " </td>";
                $table .= "<td>" . $facture['date_facture'] . " </td>";
                $table .= "<td>" . $facture['prix_ht_garantie'] . " </td>";
                $table .= "</tr>";
            }
            break;

        case 'packfirst':
            $header = get_header_from_type_grille_de_gestion_detail_collaborateur($type);
            $table .= create_header_row($header);

            //contenu
            foreach ($data as $facture) {
                $table .= "<tr>";
                $table .= "<td>" . $facture['num_facture'] . " </td>";
                $table .= "<td>" . $facture['date_facture'] . " </td>";
                $table .= "<td>" . $facture['destination'] . " </td>";
                $table .= "</tr>";
            }
            break;




        default:
            # code...
            break;
    }
    //fin contenu
    return $table;
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

    if (isset($filtre) && $filtre !== '') {
        if (isset($filtre['mois_precedent'])) {
            $filtre_date = "&filtre=date&value=mois_precedent";
        } elseif (isset($filtre['date_personnalisee'])) {
            $filtre_date = "&filtre=date&value=" . $filtre['date_personnalisee']['debut'] . "_" . $filtre['date_personnalisee']['fin'];
        }
    } else {
        $filtre_date = "&filtre=date&value=mois_en_cours";
    }



    $filtre = (isset($filtre_date) && $filtre_date !== '') ? $filtre_date : $filtre_initial;

    $table_collaborateurs_payplan .= create_header_row($header);

    $nb_repreneur_total = 0;
    $nb_achat_total = 0;
    $nb_achat_mvc_total = 0;
    $nb_pack_first_total = 0;

    if (isset($all) && $all == true) {
        foreach ($array_collaborateurs as $collaborateur) {

            $nb_repreneur_total = $nb_repreneur_total + $collaborateur['nb_reprise'];
            $nb_achat_total = $nb_achat_total + $collaborateur['nb_achat'];
            $nb_achat_mvc_total = $nb_achat_mvc_total + $collaborateur['nb_achat_mvc'];
            $nb_pack_first_total = $nb_pack_first_total + $collaborateur['nb_pack_first'];


            $table_collaborateurs_payplan .= "<tr>";
            $table_collaborateurs_payplan .= "<td>" . $collaborateur["nom_complet_collaborateur"] . " </td>";
            $table_collaborateurs_payplan .= "<td> <a href='/payplan/payplan_detail_collaborateur.php?id_detail_collaborateur_payplan_reprise_achat=" . $collaborateur['id_collaborateur'] . "&type=reprise" . $filtre . "'>" . $collaborateur['nb_reprise'] . "</a></td>";
            $table_collaborateurs_payplan .= "<td> <a href='/payplan/payplan_detail_collaborateur.php?id_detail_collaborateur_payplan_reprise_achat=" . $collaborateur['id_collaborateur'] . "&type=achat" . $filtre . "'>" . $collaborateur['nb_achat'] . "</a></td>";
            $table_collaborateurs_payplan .= "<td> <a href='/payplan/payplan_detail_collaborateur.php?id_detail_collaborateur_payplan_reprise_achat=" . $collaborateur['id_collaborateur'] . "&type=achat_mvc" . $filtre . "'>" . $collaborateur['nb_achat_mvc'] . "</a></td>";
            $table_collaborateurs_payplan .= "<td> <a href='/payplan/payplan_detail_collaborateur.php?id_detail_collaborateur_payplan_reprise_achat=" . $collaborateur['id_collaborateur'] . "&type=pack_first" . $filtre . "'>" . $collaborateur['nb_pack_first'] . "</a></td>";
            $table_collaborateurs_payplan .= "</tr>";
        }

        $collaborateur = 0;
        //afficher le total
        $table_collaborateurs_payplan .= "<tr>";
        $table_collaborateurs_payplan .= "<td class='td_label_total'> TOTAL </td>";
        $table_collaborateurs_payplan .= "<td class='td_total_payplan'> <a href='/payplan/payplan_detail_collaborateur.php?id_detail_collaborateur_payplan_reprise_achat=" . $collaborateur . "&type=reprise" . $filtre . "'>" . $nb_repreneur_total . "</a></td>";
        $table_collaborateurs_payplan .= "<td class='td_total_payplan'> <a href='/payplan/payplan_detail_collaborateur.php?id_detail_collaborateur_payplan_reprise_achat=" . $collaborateur . "&type=achat" . $filtre . "'>" . $nb_achat_total . "</a></td>";
        $table_collaborateurs_payplan .= "<td class='td_total_payplan'> <a href='/payplan/payplan_detail_collaborateur.php?id_detail_collaborateur_payplan_reprise_achat=" . $collaborateur . "&type=achat_mvc" . $filtre . "'>" . $nb_achat_mvc_total . "</a></td>";
        $table_collaborateurs_payplan .= "<td class='td_total_payplan'> <a href='/payplan/payplan_detail_collaborateur.php?id_detail_collaborateur_payplan_reprise_achat=" . $collaborateur . "&type=pack_first" . $filtre . "'>" . $nb_pack_first_total . "</a></td>";
        $table_collaborateurs_payplan .= "</tr>";
    }
    //si on affiche que un seul collaborateur
    else {
        $table_collaborateurs_payplan .= "<tr>";
        $table_collaborateurs_payplan .= "<td>" . $array_collaborateurs["nom_complet_collaborateur"] . " </td>";
        $table_collaborateurs_payplan .= "<td> <a href='/payplan/payplan_detail_collaborateur.php?id_detail_collaborateur_payplan_reprise_achat=" . $array_collaborateurs['id_collaborateur'] . "&type=reprise" . $filtre . "'>" . $array_collaborateurs['nb_reprise'] . "</a></td>";
        $table_collaborateurs_payplan .= "<td> <a href='/payplan/payplan_detail_collaborateur.php?id_detail_collaborateur_payplan_reprise_achat=" . $array_collaborateurs['id_collaborateur'] . "&type=achat" . $filtre . "'>" . $array_collaborateurs['nb_achat'] . "</a></td>";
        $table_collaborateurs_payplan .= "<td> <a href='/payplan/payplan_detail_collaborateur.php?id_detail_collaborateur_payplan_reprise_achat=" . $array_collaborateurs['id_collaborateur'] . "&type=achat_mvc" . $filtre . "'>" . $array_collaborateurs['nb_achat_mvc'] . "</a></td>";
        $table_collaborateurs_payplan .= "<td> <a href='/payplan/payplan_detail_collaborateur.php?id_detail_collaborateur_payplan_reprise_achat=" . $array_collaborateurs['id_collaborateur'] . "&type=pack_first" . $filtre . "'>" . $array_collaborateurs['pack_first'] . "</a></td>";
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

function create_header_row_shop_ext($header)
{
    $return = "";
    $return .= "<tr class='tr_header_shop_ext'>";
    $return .= "<td colspan='7' id='td_info_vehicule'>Infos véhicule</td>";
    $return .= "<td colspan='4' id='td_info_panne'>Infos Panne</td>";
    $return .= "<td colspan='6' id='td_info_action'>Actions</td>";
    $return .= "</tr>";
    $return .= "<tr class='tr_sticky'>";
    foreach ($header as $title_header) {
        $return .= "<th class='th3'> $title_header </th>";
    }
    $return .= "</tr>";
    return $return;
}


function create_header_row_traqueurs($header)
{
    $return = "";
    $return .= "<tr class='tr_sticky'>";
    foreach ($header as $title_header) {
        $return .= "<th class='th5'> $title_header </th>";
    }
    $return .= "</tr>";
    return $return;
}


function create_table_suivi_bdc($header, $type_provenance, $destination_vente, $filtre_date)
{
    // var_dump($filtre_date);

    $table_suivi_bdc = "";
    $url_details = "details_suivi_ventes.php";

    switch ($filtre_date['value_selected']) {
        //mois en cours
        case 0:
            $dates = get_dates_mois_encours();
            $dates_N1 = get_dates_mois_encours_N1();
            $dates_cumul = get_dates_N_encours();
            $dates_cumul_N1 = get_dates_N1_encours();

            //pour N en cours
            $array_date = array(
                'date' => array(
                    'date_debut' => $dates['date_debut'],
                    'date_fin' => $dates['date_fin']
                )
            );
            $data_date = array(
                'filtre_date' => $array_date
            );
            $query_date = http_build_query($data_date);

            // pour N-1
            $array_date_N1 = array(
                'date' => array(
                    'date_debut' => $dates_N1['date_debut'],
                    'date_fin' => $dates_N1['date_fin']
                )
            );
            $data_date_N1 = array(
                'filtre_date' => $array_date_N1
            );
            $query_date_N1 = http_build_query($data_date_N1);


            //date cumul
            $array_date_cumul = array(
                'date' => array(
                    'date_debut' => $dates_cumul['date_debut'],
                    'date_fin' => $dates_cumul['date_fin']
                )
            );
            $data_date_cumul = array(
                'filtre_date' => $array_date_cumul
            );
            $query_date_cumul = http_build_query($data_date_cumul);

            //date cumul N-1
            $array_date_cumul_N1 = array(
                'date' => array(
                    'date_debut' => $dates_cumul_N1['date_debut'],
                    'date_fin' => $dates_cumul_N1['date_fin']
                )
            );
            $data_date_cumul_N1 = array(
                'filtre_date' => $array_date_cumul_N1
            );
            $query_date_cumul_N1 = http_build_query($data_date_cumul_N1);
            break;


        //mois précédent
        case 1:
            $dates_last_mois = get_dates_mois_precedent();
            $dates_last_mois_N1 = get_dates_mois_precedent_N1();
            $dates_last_mois_cumul = get_dates_N_mois_precedent();
            $dates_last_mois_cumul_N1 = get_dates_N1_mois_precedent();

            $array_date_last_mois = array(
                'date' => array(
                    'date_debut' => $dates_last_mois['date_debut'],
                    'date_fin' => $dates_last_mois['date_fin']
                )
            );
            $data_date_last_mois = array(
                'filtre_date' => $array_date_last_mois
            );
            $query_date = http_build_query($data_date_last_mois);


            $array_date_last_mois_N1 = array(
                'date' => array(
                    'date_debut' => $dates_last_mois_N1['date_debut'],
                    'date_fin' => $dates_last_mois_N1['date_fin']
                )
            );
            $data_date_last_mois_N1 = array(
                'filtre_date' => $array_date_last_mois_N1
            );
            $query_date_N1 = http_build_query($data_date_last_mois_N1);

            $array_date_cumul = array(
                'date' => array(
                    'date_debut' => $dates_last_mois_cumul['date_debut'],
                    'date_fin' => $dates_last_mois_cumul['date_fin']
                )
            );
            $data_date_cumul = array(
                'filtre_date' => $array_date_cumul
            );
            $query_date_cumul = http_build_query($data_date_cumul);

            $array_date_cumul_N1 = array(
                'date' => array(
                    'date_debut' => $dates_last_mois_cumul_N1['date_debut'],
                    'date_fin' => $dates_last_mois_cumul_N1['date_fin']
                )
            );
            $data_date_cumul_N1 = array(
                'filtre_date' => $array_date_cumul_N1
            );
            $query_date_cumul_N1 = http_build_query($data_date_cumul_N1);
            break;


        //mois personnalisé
        case 2:
            $dates = get_dates_personnalisees($filtre_date);
            $dates_N1 = get_dates_personnalisees_N1($filtre_date);
            $dates_cumul = get_dates_personnalisees($filtre_date);

            //pour N en cours
            $array_date = array(
                'date' => array(
                    'date_debut' => $dates['date_debut'],
                    'date_fin' => $dates['date_fin']
                )
            );
            $data_date = array(
                'filtre_date' => $array_date
            );
            $query_date = http_build_query($data_date);

            // pour N-1
            $array_date_N1 = array(
                'date' => array(
                    'date_debut' => $dates_N1['date_debut'],
                    'date_fin' => $dates_N1['date_fin']
                )
            );
            $data_date_N1 = array(
                'filtre_date' => $array_date_N1
            );
            $query_date_N1 = http_build_query($data_date_N1);


            //date cumul
            $array_date_cumul = array(
                'date' => array(
                    'date_debut' => $dates_cumul['date_debut'],
                    'date_fin' => $dates_cumul['date_fin']
                )
            );
            $data_date_cumul = array(
                'filtre_date' => $array_date_cumul
            );
            $query_date_cumul = http_build_query($data_date_cumul);

            $array_date_cumul_N1 = array(
                'date' => array(
                    'date_debut' => $dates_N1['date_debut'],
                    'date_fin' => $dates_N1['date_fin']
                )
            );
            $data_date_cumul_N1 = array(
                'filtre_date' => $array_date_cumul_N1
            );
            $query_date_cumul_N1 = http_build_query($data_date_cumul_N1);
            break;

    }



    $cvos = get_cvo_actif();

    switch ($type_provenance) {

        /******** TABLEAUX PROVENANCE LOCATIONS **************/
        case 1:

            $table_suivi_bdc .= "<table class='my_tab_perso'>";

            //header
            $table_suivi_bdc .= create_header_row($header);
            //fin header

            $total_bdc = 0;
            $total_factures = 0;
            $total_bdc_cumul = 0;
            $total_factures_cumul = 0;
            $total_factures_n1 = 0;

            //contenu
            foreach ($cvos as $cvo) {

                //données MOIS
                $nbre_bdc = get_nbre_bdc_by_site_by_destination_vente($cvo['ID'], $destination_vente, $type_provenance, $filtre_date);
                $total_bdc += $nbre_bdc;
                $nbre_factures = get_nbre_factures_by_site_by_destination_vente($cvo['ID'], $destination_vente, $type_provenance, $filtre_date);
                $total_factures += $nbre_factures;
                $nbre_factures_n1 = get_nbre_factures_by_site_by_destination_vente_N1($cvo['ID'], $destination_vente, $type_provenance, $filtre_date);
                $total_factures_n1 += $nbre_factures_n1;

                $variation_factures = calcul_variation_factures($nbre_factures, $nbre_factures_n1);

                //données CUMUL
                // $nbre_bdc_cumul = get_nbre_bdc_cumul_by_site_by_destination_vente($cvo['ID'], $destination_vente, $type_provenance,$filtre_date);
                // $total_bdc_cumul += $nbre_bdc_cumul;
                $nbre_factures_cumul = get_nbre_factures_cumul_by_site_by_destination_vente($cvo['ID'], $destination_vente, $type_provenance, $filtre_date);
                $total_factures_cumul += $nbre_factures_cumul;

                $nbre_factures_total_N1 = 0;

                //date N-1


                //remplissage tableau
                $table_suivi_bdc .= "<tr>";
                $table_suivi_bdc .= "<td class='td_n'> " . $cvo['nom_cvo'] . " </td>";
                $table_suivi_bdc .= "<td class='td_n'><a href='$url_details?cvo=" . $cvo['ID'] . "&destination_vente=$destination_vente&type_provenance=$type_provenance&type=bdc&$query_date_cumul'>" . $nbre_bdc . " </a></td>";
                $table_suivi_bdc .= "<td class='td_n'><a href='$url_details?cvo=" . $cvo['ID'] . "&destination_vente=$destination_vente&type_provenance=$type_provenance&type=facture&$query_date'>" . $nbre_factures . "</a></td>";
                $table_suivi_bdc .= "<td class='td_n1'><a href='$url_details?cvo=" . $cvo['ID'] . "&destination_vente=$destination_vente&type_provenance=$type_provenance&type=facture&$query_date_N1'>" . $nbre_factures_n1 . "</a></td>";
                $table_suivi_bdc .= "<td class='td_n'>" . $variation_factures . " % </td>";

                //CUMUL
                // $table_suivi_bdc .= "<td class='td_n'><a href='$url_details?cvo=" . $cvo['ID'] . "&destination_vente=$destination_vente&type_provenance=$type_provenance&type=bdc&$query_date_cumul'>" . $nbre_bdc_cumul . " </a></td>";
                $table_suivi_bdc .= "<td class='td_n'><a href='$url_details?cvo=" . $cvo['ID'] . "&destination_vente=$destination_vente&type_provenance=$type_provenance&type=facture&$query_date_cumul'>" . $nbre_factures_cumul . "</a></td>";
                $table_suivi_bdc .= "</tr>";
            }

            //ligne total
            $table_suivi_bdc .= "<tr style='background:#ECECEC;'>";
            $table_suivi_bdc .= "<td class='td_n'> TOTAL </td>";
            $table_suivi_bdc .= "<td class='td_n bold_total_16'>" . $total_bdc . "</td>";
            $table_suivi_bdc .= "<td class='td_n bold_total_16'> " . $total_factures . " </td>";
            $table_suivi_bdc .= "<td class='td_n bold_total_16'> " . $total_factures_n1 . " </td>";
            $table_suivi_bdc .= "<td class='td_n bold_total_16'> </td>";
            // $table_suivi_bdc .= "<td class='td_n bold_total_16'> " . $total_bdc_cumul . " </td>";
            $table_suivi_bdc .= "<td class='td_n bold_total_16'> " . $total_factures_cumul . " </td>";
            $table_suivi_bdc .= "</tr>";


            //fin contenu

            $table_suivi_bdc .= "</table> ";

            break;

        /******** TABLEAUX PROVENANCE NEGOCE **************/
        case 2:

            $table_suivi_bdc .= "<table class='my_tab_perso'>";

            //header
            $table_suivi_bdc .= create_header_row($header);
            //fin header

            $total_bdc = 0;
            $total_factures = 0;
            $total_bdc_cumul = 0;
            $total_factures_cumul = 0;
            $total_factures_N1 = 0;
            $total_factures_cumul_N1 = 0;
            $total_marge = 0;
            $total_marge_N1 = 0;

            //contenu
            foreach ($cvos as $cvo) {

                //BDC
                $nbre_bdc = get_nbre_bdc_by_site_by_destination_vente($cvo['ID'], $destination_vente, $type_provenance, $filtre_date);
                $total_bdc += $nbre_bdc;

                //FACTURES N
                $factures = get_factures_by_site_by_destination_vente($cvo['ID'], $destination_vente, $type_provenance, $filtre_date);
                $nbre_factures = calcul_nbre_factures($factures);
                $total_factures += $nbre_factures;

                //FACTURES N1
                $factures_N1 = get_factures_by_site_by_destination_vente_N1($cvo['ID'], $destination_vente, $type_provenance, $filtre_date);
                $nbre_factures_N1 = calcul_nbre_factures($factures_N1);
                $total_factures_N1 += $nbre_factures_N1;

                //variation
                $variation_factures = calcul_variation_factures($nbre_factures, $nbre_factures_N1);


                //MARGE
                $marge = calcul_marge_total_factures($factures);
                $total_marge += $marge;
                $marge_N1 = calcul_marge_total_factures($factures_N1);
                $total_marge_N1 += $marge_N1;
                $variation_marge = calcul_variation_marge($marge, $marge_N1);
                // $variation_marge = 0;

                // MOYENNE
                $moyenne_marge = calcul_moyenne_marge($marge, $nbre_factures);
                $moyenne_marge_N1 = calcul_moyenne_marge($marge_N1, $nbre_factures_N1);
                // $variation_moyenne = calcul_variation_moyenne($moyenne_marge, $moyenne_marge_N1);
                // $variation_moyenne = 0;

                //CUMUL
                // $nbre_bdc_cumul = get_nbre_bdc_cumul_by_site_by_destination_vente($cvo['ID'], $destination_vente, $type_provenance,$filtre_date);
                // $total_bdc_cumul += $nbre_bdc_cumul;
                $nbre_factures_cumul = get_nbre_factures_cumul_by_site_by_destination_vente($cvo['ID'], $destination_vente, $type_provenance, $filtre_date);
                $total_factures_cumul += $nbre_factures_cumul;
                $nbre_factures_cumul_N1 = get_nbre_factures_cumul_N1_by_site_by_destination_vente($cvo['ID'], $destination_vente, $type_provenance, $filtre_date);
                $total_factures_cumul_N1 += $nbre_factures_cumul_N1;


                //remplissage tableau
                $table_suivi_bdc .= "<tr>";
                $table_suivi_bdc .= "<td class='td_n'> " . $cvo['nom_cvo'] . " </td>";
                $table_suivi_bdc .= "<td class='td_n'><a href='$url_details?cvo=" . $cvo['ID'] . "&destination_vente=$destination_vente&type_provenance=$type_provenance&type=bdc&$query_date_cumul'>" . $nbre_bdc . " </a></td>";
                $table_suivi_bdc .= "<td class='td_n'><a href='$url_details?cvo=" . $cvo['ID'] . "&destination_vente=$destination_vente&type_provenance=$type_provenance&type=facture&$query_date'>" . $nbre_factures . "</a></td>";
                $table_suivi_bdc .= "<td class='td_n1'><a href='$url_details?cvo=" . $cvo['ID'] . "&destination_vente=$destination_vente&type_provenance=$type_provenance&type=facture&$query_date_N1'>" . $nbre_factures_N1 . "</a></td>";
                $table_suivi_bdc .= "<td class='td_n'>" . $variation_factures . "%</td>";
                $table_suivi_bdc .= "<td class='td_n'>" . $marge . "</td>";
                $table_suivi_bdc .= "<td class='td_n1'>" . $marge_N1 . " </td>";
                $table_suivi_bdc .= "<td class='td_n'>" . $variation_marge . "%</td>";
                $table_suivi_bdc .= "<td class='td_n'>" . $moyenne_marge . "</td>";
                $table_suivi_bdc .= "<td class='td_n1'>" . $moyenne_marge_N1 . "</td>";
                // $table_suivi_bdc .= "<td class='td_n'>" . $variation_moyenne . "%</td>";
                // $table_suivi_bdc .= "<td class='td_n'><a href='$url_details?cvo=" . $cvo['ID'] . "&destination_vente=$destination_vente&type_provenance=$type_provenance&type=bdc&$query_date'>" . $nbre_bdc_cumul . " </a></td>";
                $table_suivi_bdc .= "<td class='td_n'><a href='$url_details?cvo=" . $cvo['ID'] . "&destination_vente=$destination_vente&type_provenance=$type_provenance&type=facture&$query_date'>" . $nbre_factures_cumul . "</a></td>";
                $table_suivi_bdc .= "<td class='td_n'><a href='$url_details?cvo=" . $cvo['ID'] . "&destination_vente=$destination_vente&type_provenance=$type_provenance&type=facture&$query_date_cumul_N1'>" . $nbre_factures_cumul_N1 . "</a></td>";
                $table_suivi_bdc .= "</tr>";
            }

            //ligne total
            $table_suivi_bdc .= "<tr style='background:#ECECEC;'>";
            $table_suivi_bdc .= "<td class='td_n'> TOTAL </td>";
            $table_suivi_bdc .= "<td class='td_n bold_total_16'>" . $total_bdc . "</td>";
            $table_suivi_bdc .= "<td class='td_n bold_total_16'> " . $total_factures . " </td>";
            $table_suivi_bdc .= "<td class='td_n bold_total_16'>" . $total_factures_N1 . "</td>";
            $table_suivi_bdc .= "<td class='td_n bold_total_16'></td>";
            $table_suivi_bdc .= "<td class='td_n bold_total_16'>" . $total_marge . " </td>";
            $table_suivi_bdc .= "<td class='td_n bold_total_16'>" . $total_marge_N1 . " </td>";
            $table_suivi_bdc .= "<td class='td_n bold_total_16'></td>";
            $table_suivi_bdc .= "<td class='td_n bold_total_16'></td>";
            $table_suivi_bdc .= "<td class='td_n bold_total_16'></td>";
            $table_suivi_bdc .= "<td class='td_n bold_total_16'>" . $total_factures_cumul . "</td>";
            $table_suivi_bdc .= "<td class='td_n bold_total_16'>" . $total_factures_cumul_N1 . "</td>";



            $table_suivi_bdc .= "</tr>";

            //fin contenu

            $table_suivi_bdc .= "</table> ";

            break;
    }


    $return = $table_suivi_bdc;

    // var_dump($return);

    return $return;
}


function create_table_shop_exterieurs($header, $categorie = '', $immatriculation = '', $mva = '', $type = '')
{
    //données
    $liste_shop_exterieurs = get_liste_shop_exterieurs($categorie, $immatriculation, $mva, $type);

    $table_shop_exterieurs = "";

    $table_shop_exterieurs .= "<table class='my_tab_perso'>";
    //header
    $table_shop_exterieurs .= create_header_row_shop_ext($header);
    //fin header

    //contenu
    foreach ($liste_shop_exterieurs as $shop_ext) {

        $compteur_immo = get_compteur_immo($shop_ext['date_declaration'], $shop_ext['ID']);
        $last_action = get_last_action($shop_ext['ID']);

        //remplissage tableau
        $table_shop_exterieurs .= "<tr>";
        $table_shop_exterieurs .= "<td class='td_n'> " . $shop_ext['immatriculation'] . " </td>";
        $table_shop_exterieurs .= "<td class='td_n'> " . $shop_ext['modele'] . " </td>";
        $table_shop_exterieurs .= "<td class='td_n'> " . $shop_ext['mva'] . " </td>";
        $table_shop_exterieurs .= "<td class='td_n'> " . $shop_ext['kilometrage'] . " </td>";
        $table_shop_exterieurs .= "<td class='td_n'> " . ($shop_ext['garantie'] == 0 ? 'non' : 'oui') . " </td>";
        $table_shop_exterieurs .= "<td class='td_n'> " . $shop_ext['num_contrat'] . " </td>";
        $table_shop_exterieurs .= "<td class='td_n' style='max-width:30px'> " . $compteur_immo . " </td>";
        $table_shop_exterieurs .= "<td class='td_n'> " . $shop_ext['date_declaration'] . " </td>";
        $table_shop_exterieurs .= "<td class='td_n'> " . $shop_ext['type_panne_libelle'] . " </td>";
        $table_shop_exterieurs .= "<td class='td_n'> " . $shop_ext['detail_panne'] . " </td>";
        $table_shop_exterieurs .= "<td class='td_n'> " . $shop_ext['localisation'] . " </td>";

        if (isset($shop_ext['last_action']) && $shop_ext['last_action'] !== '') {
            $table_shop_exterieurs .= "<td class='td_n'> " . $shop_ext['last_action']['date_action'] . " - " . $shop_ext['last_action']['action'] . " </td>";
            $table_shop_exterieurs .= "<td class='td_n'> " . $shop_ext['last_action']['remarque'] . " </td>";
            $table_shop_exterieurs .= "<td class='td_n'> " . ($shop_ext['last_action']['is_factured'] == '1' ? 'oui' : 'non') . " </td>";
            $table_shop_exterieurs .= "<td class='td_n'> " . $shop_ext['last_action']['montant_facture'] . " </td>";
        } else {
            $table_shop_exterieurs .= "<td class='td_n'> </td>";
            $table_shop_exterieurs .= "<td class='td_n'> </td>";
            $table_shop_exterieurs .= "<td class='td_n'> </td>";
            $table_shop_exterieurs .= "<td class='td_n'> </td>";
        }

        $table_shop_exterieurs .= "<td class='td_n'> " . $shop_ext['date_demande_recup'] . " </td>";

        if ($shop_ext['date_recup'] && $shop_ext['agence_recup']) {
            $table_shop_exterieurs .= "<td class='td_n'> " . $shop_ext['date_recup'] . " (" . $shop_ext['agence_recup'] . ") </td>";
        } else {
            $table_shop_exterieurs .= "<td class='td_n'>  </td>";
        }
        $table_shop_exterieurs .= "<td class='td_n' style='width:50px'>";
        $table_shop_exterieurs .= "<a href='modif_shop_exterieur.php?id=" . $shop_ext['ID'] . "' style='margin-right:10px' title='Modifier'>
        <box-icon name='edit'></box-icon>
        </a>";
        // $table_shop_exterieurs .= "<a title='lecture en détail' href='lecture_shop_exterieur.php?id=" . $shop_ext['ID'] . "'><box-icon name='file-find'></box-icon></a>";

        $table_shop_exterieurs .= "</td>";

        $table_shop_exterieurs .= "</tr>";
    }
    //fin contenu
    $table_shop_exterieurs .= "</table> ";


    // var_dump($table_shop_exterieurs);

    return $table_shop_exterieurs;
}


function create_table_montage_traqueurs($header, $filtre = '')
{

    //données
    if (isset($filtre)) {
        $liste_traqueurs = get_liste_montage_traqueurs($filtre);
    } else {
        $liste_traqueurs = get_liste_montage_traqueurs();
    }

    $table_traqueurs = "";

    $table_traqueurs .= "<table class='my_tab_perso'>";
    //header
    $table_traqueurs .= create_header_row_traqueurs($header);
    //fin header

    //contenu
    foreach ($liste_traqueurs as $traqueur) {

        //remplissage tableau
        $table_traqueurs .= "<tr>";
        $table_traqueurs .= "<td class='td_n'> " . $traqueur['immatriculation'] . " </td>";
        $table_traqueurs .= "<td class='td_n'> " . $traqueur['serial_number'] . " </td>";
        $table_traqueurs .= "<td class='td_n' style='width:250px;'> " . $traqueur['imei'] . " </td>";
        $table_traqueurs .= "<td class='td_n'> " . $traqueur['sim'] . " </td>";
        $table_traqueurs .= "<td class='td_n'> " . $traqueur['type'] . " </td>";
        $table_traqueurs .= "<td class='td_n'> " . $traqueur['mva'] . " </td>";
        $table_traqueurs .= "<td class='td_n'> " . $traqueur['date_installation'] . " </td>";
        $table_traqueurs .= "<td class='td_n'> " . $traqueur['date_export_maj_site'] . " </td>";
        $table_traqueurs .= "<td class='td_n' style='width:150px;'> " . $traqueur['montage'] . " </td>";
        $table_traqueurs .= "<td class='td_n'> " . $traqueur['montage_nom'] . " </td>";
        $table_traqueurs .= "<td class='td_n' style='width:350px;'> " . $traqueur['montage_position'] . " </td>";
        $table_traqueurs .= "<td class='td_n'> " . $traqueur['obd'] . " </td>";
        $table_traqueurs .= "<td class='td_n'> " . $traqueur['obd_nom'] . " </td>";
        $table_traqueurs .= "<td class='td_n'> " . $traqueur['soudure'] . " </td>";

        $table_traqueurs .= "<td class='td_n' style='width:50px'>";
        $table_traqueurs .= "<a href='modif_ajout_montage_traqueur.php?id=" . $traqueur['ID'] . "' style='margin-right:10px' title='Modifier'>
        <box-icon name='edit'></box-icon>
        </a>";
        // $table_traqueurs .= "<a title='lecture en détail' href='lecture_shop_exterieur.php?id=" . $shop_ext['ID'] . "'><box-icon name='file-find'></box-icon></a>";

        $table_traqueurs .= "</td>";

        $table_traqueurs .= "</tr>";
    }
    //fin contenu
    $table_traqueurs .= "</table> ";


    // var_dump($table_traqueurs);

    return $table_traqueurs;

}


function create_table_liste_traqueurs($header, $filtre = '')
{

    //données
    $liste_traqueurs = get_liste_traqueurs($filtre);

    $table_traqueurs = "";

    $table_traqueurs .= "<table class='my_tab_perso'>";
    //header
    $table_traqueurs .= create_header_row_traqueurs($header);
    //fin header

    //contenu
    foreach ($liste_traqueurs as $traqueur) {

        //remplissage tableau
        $table_traqueurs .= "<tr>";
        $table_traqueurs .= "<td class='td_n' style='width:250px;'> " . $traqueur['serial_number'] . " </td>";
        $table_traqueurs .= "<td class='td_n' style='width:250px;'> " . $traqueur['imei'] . " </td>";
        // $table_traqueurs .= "<td class='td_n' style='width:250px;'> " . $traqueur['sim'] . " </td>";

        switch ($traqueur['actif']) {
            case 1:
                $table_traqueurs .= "<td class='td_vert'>  Actif  </td>";
                break;

            default:
                $table_traqueurs .= "<td class='td_rouge'>  Inactif  </td>";
                break;
        }

        $traqueur_monte = check_traqueur_if_monte($traqueur['ID']);

        switch ($traqueur_monte) {
            case true:
                $table_traqueurs .= "<td class='td_vert'> OUI </td>";
                break;

            default:
                $table_traqueurs .= "<td class='td_rouge'> NON </td>";
                break;
        }

        switch ($traqueur['export']) {
            case 1:
                $table_traqueurs .= "<td class='td_vert'>  OUI  </td>";
                break;

            default:
                $table_traqueurs .= "<td class='td_rouge'>  NON  </td>";
                break;
        }

        if ($traqueur_monte) {
            $table_traqueurs .= "<td class='td_n' style='width:50px'>";
            $table_traqueurs .= "<a href='modif_ajout_montage_traqueur.php?id=" . $traqueur['ID'] . "' > <button type='button' class='btn btn-warning btn-sm' style='color:red;font-weight:bold'> Modifier </button> </a>";
            // $table_traqueurs .= "<a title='lecture en détail' href='lecture_shop_exterieur.php?id=" . $shop_ext['ID'] . "'><box-icon name='file-find'></box-icon></a>";
            $table_traqueurs .= "</td>";
        } else {
            $table_traqueurs .= "<td class='td_n' style='width:50px'>";
            $table_traqueurs .= "<a href='modif_ajout_montage_traqueur.php?id=" . $traqueur['ID'] . "' > <button type='button' class='btn btn-success btn-sm' style='font-weight:bold'> Montage </button> </a>";
            // $table_traqueurs .= "<a title='lecture en détail' href='lecture_shop_exterieur.php?id=" . $shop_ext['ID'] . "'><box-icon name='file-find'></box-icon></a>";
            $table_traqueurs .= "</td>";
        }



        $table_traqueurs .= "</tr>";
    }
    //fin contenu
    $table_traqueurs .= "</table> ";


    // var_dump($table_traqueurs);

    return $table_traqueurs;

}

