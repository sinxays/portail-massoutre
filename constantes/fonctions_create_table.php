<?php

use App\Connection;

function create_table_collaborateurs_payplan($header, $array_collaborateurs)
{

    $table_collaborateurs_payplan = "";

    $table_collaborateurs_payplan .= "<tr>";
    foreach ($header as $title_header) {
        $table_collaborateurs_payplan .= "<th class='th1'> $title_header </th>";
    }
    $table_collaborateurs_payplan .= "</tr>";

    foreach ($array_collaborateurs as $collaborateur) {
        $table_collaborateurs_payplan .= "<tr>";
        $table_collaborateurs_payplan .= "<td>" . $collaborateur["nom_complet"] . " </td>";
        $table_collaborateurs_payplan .= "<td>0</td>";
        $table_collaborateurs_payplan .= "<td>0</td>";
        $table_collaborateurs_payplan .= "</tr>";
    }

    return $table_collaborateurs_payplan;
}


function create_table_stats_loc_agence_type($header, $liste_agence, $type, $date)
{

    $table_stats_loc = "";

    $table_stats_loc .= "<table class='my_tab_perso'>";

    //header
    $table_stats_loc .= "<tr>";
    foreach ($header as $title_header) {
        $table_stats_loc .= "<th class='th1'> $title_header </th>";
    }
    $table_stats_loc .= "</tr>";
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
    $table_stats_loc .= "<tr>";
    foreach ($header as $title_header) {
        $table_stats_loc .= "<th class='th1'> $title_header </th>";
    }
    $table_stats_loc .= "</tr>";
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
    $table_agences .= "<tr>";
    foreach ($header as $title_header) {
        $table_agences .= "<th class='th1'> $title_header </th>";
    }
    $table_agences .= "</tr>";
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
            $table_liste_tel .= "<tr>";
            foreach ($header as $title_header) {
                $table_liste_tel .= "<th class='th3'> $title_header </th>";
            }
            $table_liste_tel .= "</tr>";
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
    $table_imprimantes .= "<tr>";
    foreach ($header as $title_header) {
        $table_imprimantes .= "<th class='th3'> $title_header </th>";
    }
    $table_imprimantes .= "</tr>";
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
    $table_cvo .= "<tr>";
    foreach ($header as $title_header) {
        $table_cvo .= "<th class='th1'> $title_header </th>";
    }
    $table_cvo .= "</tr>";
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

    $table_marges .= "<table class='my_tab_perso'>";
    $table_marges .= "<tr>";
    foreach ($header as $title_header) {
        $table_marges .= "<th class='th2'> $title_header </th>";
    }
    $table_marges .= "</tr>";

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

function create_table_payplan($header, $array)
{

    $commisionable = 1;
    $table_payplan = "";

    $array_collaborateurs_payplan = get_all_collaborateurs_payplan();

    // var_dump($array_collaborateurs_payplan);




    //header
    $table_payplan .= "<tr>";
    foreach ($header as $title_header) {
        $table_payplan .= "<th class='th1'> $title_header </th>";
    }
    $table_payplan .= "</tr>";
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
        $table_payplan .= "<td>" . utf8_encode($payplan['Destination']) . " </td>";
        $table_payplan .= "<td>" . $payplan['Type_Vehicule'] . " </td>";
        $table_payplan .= "<td>" . utf8_encode($payplan['Type_Achat']) . " </td>";
        $table_payplan .= "<td>" . $payplan['Categorie_VU'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Modele'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Reference_lot'] . " </td>";
        $table_payplan .= "<td>" . utf8_encode($payplan['Finition']) . " </td>";
        $table_payplan .= "<td>" . $payplan['Parc_Achat'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Nom_Acheteur'] . " </td>";
        $table_payplan .= "<td>" . $payplan['Date_Vente'] . " </td>";
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
            $table_payplan .= "<td><strong style='font-size: 12px;'>" . utf8_encode($payplan['Options']) . " </strong></td>";
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
    $table_reseau .= "<tr>";
    foreach ($header as $title_header) {
        $table_reseau .= "<th class='th3'> $title_header </th>";
    }
    $table_reseau .= "</tr>";
    //fin header


    //contenu
    foreach ($liste_reseaux as $reseau) {
        $table_reseau .= "<tr>";
        $table_reseau .= "<td class='td_n' style='width: 150px;'>" . utf8_encode($reseau['nom_infrastructure']) . " </td>";
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
