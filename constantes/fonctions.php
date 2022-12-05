<?php

use App\Connection;

use function PHPSTORM_META\type;

function saut_de_ligne()
{
    echo "<br/><br/>";
}

function passage_a_la_ligne()
{
    echo "<br/>";
}

function get_agence_by_id($id_agence)
{
    $pdo = Connection::getPDO();
    $request = $pdo->query("SELECT * FROM agences WHERE ID = $id_agence");
    $result = $request->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}



function search_agence_by_name($name_agence)
{
    $name_agence = strtoupper($name_agence);
    $pdo = Connection::getPDO();
    $request = $pdo->query("SELECT * FROM agences WHERE nom_agence LIKE '%$name_agence%'");
    $result = $request->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function get_cvo_by_id($id_cvo)
{
    $pdo = Connection::getPDO();
    $request = $pdo->query("SELECT * FROM cvo WHERE ID = $id_cvo");
    $result = $request->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function get_chef_agence_by_agence_id($id_agence)
{
    $pdo = Connection::getPDO();
    $request = $pdo->query("SELECT * FROM chef_agence WHERE ID_agence = $id_agence");
    $result = $request->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function get_vendeurs_by_cvo_id($id_cvo)
{
    $pdo = Connection::getPDO();
    $request = $pdo->query("SELECT * FROM cvo_vendeurs WHERE id_cvo = $id_cvo");
    $result = $request->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function get_all_agences_names()
{
    $pdo = Connection::getPDO();
    $request = $pdo->query("SELECT nom_agence FROM agences");
    $result = $request->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function get_all_agences()
{
    $pdo = Connection::getPDO();
    $request = $pdo->query("SELECT * FROM agences ORDER BY nom_agence ASC");
    $result = $request->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function get_all_cvo()
{
    $pdo = Connection::getPDO();
    $request = $pdo->query("SELECT * FROM cvo ORDER BY nom_cvo ASC");
    $result = $request->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function get_all_collaborateurs()
{
    $pdo = Connection::getPDO();
    $request = $pdo->query("SELECT * 
    FROM collaborateurs AS c
    LEFT JOIN infrastructure AS i 
    ON c.id_infrastructure_collaborateur = i.ID
    LEFT JOIN service_numero AS g
    ON c.id_service = g.ID
    ORDER BY c.nom ASC");
    $result = $request->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function get_liste_telephonique()
{
    $pdo = Connection::getPDO();
    $request = $pdo->query("SELECT req1.*,i.prefixe_toip FROM (SELECT c1.nom,c1.prenom,c1.ligne_directe,c1.interne,c1.id_infrastructure_collaborateur,c1.id_service,g1.nom_service,g1.numero_service,g1.num_court_interne ,g1.id_infrastructure_service FROM collaborateurs AS c1
    LEFT JOIN service_numero AS g1
    ON c1.id_service = g1.ID
    UNION
    SELECT c2.nom,c2.prenom,c2.ligne_directe,c2.interne,c2.id_infrastructure_collaborateur,c2.id_service,g2.nom_service,g2.numero_service,g2.num_court_interne,g2.id_infrastructure_service FROM collaborateurs as c2
    RIGHT JOIN service_numero AS g2
    ON c2.id_service = g2.ID) AS req1
    LEFT JOIN infrastructure as i
    ON i.ID = req1.id_infrastructure_collaborateur AND req1.id_infrastructure_service = i.ID  
    ORDER BY `req1`.`nom` ASC");
    $result = $request->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function get_liste_telephonique_2($id_type)
{
    $pdo = Connection::getPDO();
    $request = $pdo->query("SELECT nom_infrastructure,prefixe_toip,ndi,numero_court
    FROM infrastructure 
    WHERE type_infrastructure_id = $id_type
    ORDER BY nom_infrastructure ASC");
    $result = $request->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function get_all_reseau()
{
    $pdo = Connection::getPDO();
    $request = $pdo->query("SELECT * FROM reseau as r
    LEFT JOIN infrastructure as i on i.ID = r.id_infrastructure_reseau
    ORDER BY i.nom_infrastructure ASC");
    $result = $request->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function search_infrastructure_by_name($tmp_infrastructure_input)
{
    $pdo = Connection::getPDO();
    $request = $pdo->query("SELECT * FROM reseau as r 
    LEFT JOIN infrastructure as i 
    ON i.ID = r.id_infrastructure_reseau 
    WHERE i.nom_infrastructure LIKE '%$tmp_infrastructure_input%' 
    ORDER BY i.nom_infrastructure ASC ");
    $result = $request->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function get_reseau_by_infrastructure_id($id_infrastructure)
{
    $pdo = Connection::getPDO();
    $request = $pdo->query("SELECT * FROM reseau as r
    LEFT JOIN infrastructure as i on i.ID = r.id_infrastructure_reseau 
    WHERE r.id_infrastructure_reseau = '$id_infrastructure'");
    $result = $request->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function get_secteur_by_ID($id_secteur)
{
    $pdo = Connection::getPDO();
    $request = $pdo->query("SELECT ID,nom_secteur from secteurs WHERE ID = $id_secteur");
    $result = $request->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function get_agence_by_secteur($id_secteur)
{
    $pdo = Connection::getPDO();
    $request = $pdo->query("SELECT a.ID,a.nom_agence 
    FROM `agences` AS a 
    INNER JOIN secteurs as s ON a.secteur = s.ID 
    WHERE s.ID = $id_secteur 
    ORDER BY a.nom_agence; 
    ");
    $result = $request->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function getAllSecteurs()
{
    $pdo = Connection::getPDO();
    $request = $pdo->query("SELECT ID,nom_secteur from secteurs 
    order by nom_secteur");
    $result = $request->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function getAllDistrict()
{
    $pdo = Connection::getPDO();
    $request = $pdo->query("SELECT ID,nom_district from districts
    order by nom_district");
    $result = $request->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function getAllAgencesGroupSecteurDistrict()
{
    $pdo = Connection::getPDO();
    $request = $pdo->query("SELECT ID,nom_district from districts
    order by nom_district");
    $final_select_array = $request->fetchAll(PDO::FETCH_ASSOC);

    foreach ($final_select_array as $key_district => $agencesOrSecteur) {
        $request = $pdo->query("SELECT ID,nom_agence FROM agences WHERE district = " . $agencesOrSecteur['ID'] . " AND secteur = 0 order by nom_agence");
        $result = $request->fetchAll(PDO::FETCH_ASSOC);
        $final_select_array[$key_district]['agences'] = $result;
    }

    foreach ($final_select_array as $key_district => $district_array) {
        $request = $pdo->query("SELECT ID,nom_secteur from secteurs where liaison_district = " . $district_array['ID'] . " order by nom_secteur");
        $result = $request->fetchAll(PDO::FETCH_ASSOC);
        $final_select_array[$key_district]['secteurs'] = $result;
        foreach ($final_select_array[$key_district]['secteurs'] as $key_secteur => $secteur) {
            $request = $pdo->query("SELECT ID,nom_agence from agences where secteur = " . $secteur['ID'] . " order by nom_agence");
            $result = $request->fetchAll(PDO::FETCH_ASSOC);
            $final_select_array[$key_district]['secteurs'][$key_secteur]['agences'] = $result;
        }
    }

    return $final_select_array;
}


function get_agence_by_district($id_district)
{
    $pdo = Connection::getPDO();
    $request = $pdo->query("    SELECT a.ID,a.nom_agence 
    FROM `agences` AS a 
    INNER JOIN districts as d ON a.district = d.ID 
    WHERE d.ID = $id_district 
    ORDER BY a.nom_agence; 
    ");
    $result = $request->fetchAll(PDO::FETCH_ASSOC);
    return $result;
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
        $table_agences .= "<td class='td_n' style='width: 70px;'>" . $agence['code_gare'] . "</td>";
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



function import_csv_imprimante($csv_imprimante)
{
    if (sizeof($csv_imprimante) > 0) {
        $file = fopen($csv_imprimante, "r");

        $pdo = Connection::getPDO();
        //lire la premiere ligne d'entete et ne rien faire avec 
        fgetcsv($file, 10000, ";");

        while (($getData = fgetcsv($file, 10000, ";")) !== FALSE) {

            $data = [
                'num_serie' => $getData[0],
                'infrastructure' => intval($getData[1]),
                'emplacement' => $getData[2],
                'prestataire' => $getData[3],
                'marque' => $getData[4],
                'modele' => $getData[5],
                'ip_vlan' => $getData[6],
                'ip_locale' => $getData[7],
            ];

            $sql = "INSERT INTO imprimantes 
            (num_serie, id_infrastructure_imprimante, emplacement,prestataire,marque,modele,ip_vpn,ip_locale)
            VALUES (:num_serie, :infrastructure, :emplacement, :prestataire, :marque, 
            :modele, :ip_vlan, :ip_locale)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);
        }
        fclose($file);
    }
}


function import_any_values($table, $champs, $datas)
{

    $pdo = Connection::getPDO();

    $champs_string = implode(",", $champs);
    $data = array();

    foreach ($champs as $index => $key_champ) {
        //on associe les valeurs au mot clé 
        $data[":" . $key_champ] = utf8_decode($datas[$index]);
        //on crée le string pour les mots clés
        $array_string[] = ":" . $key_champ;
    }

    // on rend le array en string pour le sql en bas
    $final_array_string = implode(",", $array_string);



    $sql = "INSERT INTO $table 
    ($champs_string)
    VALUES ($final_array_string)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);
}




// function import_csv_stats_journaliere($csv_file, $date_import)
function import_csv_stats_journaliere($csv_file, $date)
{

    //d'abord on vide la table d'import 
    vider_table_import_stats();

    if (sizeof($csv_file) > 0) {
        $file = fopen($csv_file, "r");

        $pdo = Connection::getPDO();
        // $yesterday = date("Y-m-d", strtotime("yesterday"));
        $date = $date;
        //lire la premiere ligne d'entete et ne rien faire avec 
        fgetcsv($file, 10000, ";");

        while (($getData = fgetcsv($file, 10000, ";")) !== FALSE) {

            $data = [
                'code_agence' => $getData[0],
                'libelle_agence' => $getData[1],
                // 'mois' => format_date_FR_TO_US($getData[2])
                'date' => $date,
                'transaction_owned' => $getData[3],
                'pourcentage_local_owned' => floatval(replace_comma_with_dot($getData[4])),
                'pourcentage_intercity_owned' => floatval(replace_comma_with_dot($getData[5])),
                'tk_owned' => intval(str_replace(' ', '', $getData[6])),
                'rev_trans_owned' => floatval(replace_comma_with_dot($getData[7])),
                'rve_day_owned' => floatval(replace_comma_with_dot($getData[8])),
                'nb_jours_loc_owned' => intval(str_replace(' ', '', $getData[9])),
                'duree_owned' => floatval(replace_comma_with_dot($getData[10])),
                'rpu_owned' => intval($getData[11]),
                'util_owned' => floatval(replace_comma_with_dot($getData[12])),
                'car_days_owned' => intval(str_replace(' ', '', $getData[13])),
                'flotte_moyenne_owned' => intval(str_replace(' ', '', $getData[14])),
                'departs_owned' => intval(str_replace(' ', '', $getData[15])),
                'transaction_foreign' => intval($getData[16]),
                'pourcentage_local_foreign' => floatval(replace_comma_with_dot($getData[17])),
                'pourcentage_intercity_foreign' => floatval(replace_comma_with_dot($getData[18])),
                'tk_foreign' => intval(str_replace(' ', '', $getData[19])),
                'rev_trans_foreign' => floatval(replace_comma_with_dot($getData[20])),
                'rve_day_foreign' => floatval(replace_comma_with_dot($getData[21])),
                'nb_jours_loc_foreign' => intval($getData[22]),
                'duree_foreign' => floatval(replace_comma_with_dot($getData[23])),
                'rpu_foreign' => intval(str_replace(' ', '', $getData[24])),
                'util_foreign' => floatval(replace_comma_with_dot($getData[25])),
                'car_days_foreign' => intval($getData[26]),
                'flotte_moyenne_foreign' => intval($getData[27]),
                'departs_foreign' => intval($getData[28]),
                'transaction_combined' => intval($getData[29]),
                'pourcentage_local_combined' => floatval(replace_comma_with_dot($getData[30])),
                'pourcentage_intercity_combined' => floatval(replace_comma_with_dot($getData[31])),
                'tk_combined' => intval(str_replace(' ', '', $getData[32])),
                'rev_trans_combined' => floatval(replace_comma_with_dot($getData[33])),
                'rve_day_combined' => floatval(replace_comma_with_dot($getData[34])),
                'nb_jours_loc_combined' =>  intval(str_replace(' ', '', $getData[35])),
                'duree_combined' => floatval(replace_comma_with_dot($getData[36])),
                'rpu_combined' => intval(str_replace(' ', '', $getData[37])),
                'util_combined' => floatval(replace_comma_with_dot($getData[38])),
                'car_days_combined' => intval(str_replace(' ', '', $getData[39])),
                'flotte_moyenne_combined' => intval($getData[40]),
                'departs_combined' => intval($getData[41]),
                'cdw_combined' => intval(str_replace(' ', '', $getData[42])),
                'tp_combined' => intval($getData[43]),
                'pai_combined' => intval(str_replace(' ', '', $getData[44])),
                'ow_fee_combined' => intval(str_replace(' ', '', $getData[45])),

            ];

            $sql = "INSERT INTO import_stats_journalieres 
            (code_agence, libelle_agence, date,transaction_owned,pourcentage_local_owned,
            pourcentage_intercity_owned,tk_owned,rev_trans_owned,rve_day_owned,nb_jours_loc_owned,
            duree_owned,rpu_owned,util_owned,car_days_owned,flotte_moyenne_owned,departs_owned,
            transaction_foreign,pourcentage_local_foreign,pourcentage_intercity_foreign,tk_foreign,rev_trans_foreign,
            rve_day_foreign,nb_jours_loc_foreign,duree_foreign,rpu_foreign,util_foreign,car_days_foreign,flotte_moyenne_foreign,departs_foreign,
            transaction_combined,pourcentage_local_combined,pourcentage_intercity_combined,tk_combined,rev_trans_combined,rve_day_combined,
            nb_jours_loc_combined,duree_combined,rpu_combined,util_combined,car_days_combined,flotte_moyenne_combined,departs_combined,
            cdw_combined,tp_combined,pai_combined, ow_fee_combined) 
            VALUES (:code_agence, :libelle_agence, :date, :transaction_owned, :pourcentage_local_owned, 
            :pourcentage_intercity_owned, :tk_owned, :rev_trans_owned, :rve_day_owned, :nb_jours_loc_owned, 
            :duree_owned, :rpu_owned, :util_owned, :car_days_owned, :flotte_moyenne_owned, :departs_owned, 
            :transaction_foreign, :pourcentage_local_foreign, :pourcentage_intercity_foreign, :tk_foreign, :rev_trans_foreign, 
            :rve_day_foreign, :nb_jours_loc_foreign, :duree_foreign, :rpu_foreign, :util_foreign, :car_days_foreign, :flotte_moyenne_foreign, :departs_foreign, 
            :transaction_combined, :pourcentage_local_combined, :pourcentage_intercity_combined, :tk_combined, :rev_trans_combined, :rve_day_combined, 
            :nb_jours_loc_combined, :duree_combined, :rpu_combined, :util_combined, :car_days_combined, :flotte_moyenne_combined, :departs_combined, 
            :cdw_combined, :tp_combined, :pai_combined, :ow_fee_combined)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);
        }
        fclose($file);
    }
}


function format_date_FR_TO_US($date_FR)
{
    $date_tmp = explode("/", $date_FR);
    if (strlen($date_tmp[1]) < 2) {
        $date_tmp[1] = '0' . $date_tmp[1];
    }
    if (strlen($date_tmp[0]) < 2) {
        $date_tmp[0] = '0' . $date_tmp[0];
    }
    $date_final = $date_tmp[2] . '/' . $date_tmp[1] . '/' . $date_tmp[0];

    return $date_final;
}

function format_date_US_TO_FR($date_US)
{
    $date_tmp = explode("-", $date_US);
    if (strlen($date_tmp[1]) < 2) {
        $date_tmp[1] = '0' . $date_tmp[1];
    }
    if (strlen($date_tmp[2]) < 2) {
        $date_tmp[2] = '0' . $date_tmp[2];
    }
    $date_final = $date_tmp[2] . '/' . $date_tmp[1] . '/' . $date_tmp[0];

    return $date_final;
}

function vider_table_import_stats()
{
    $pdo = Connection::getPDO();
    $sql = "TRUNCATE TABLE import_stats_journalieres";
    //Prepare the SQL query.
    $statement = $pdo->prepare($sql);
    //Execute the statement.
    $statement->execute();
}


function alimenter_tableau_stats_journalieres($date)
{
    //exemple avec une seule agence pour le moment à enlever par la suite pour mettre toutes les agences
    // $ID_agence_test = 6;
    $date_test = date("2022-07-20");
    $date = $date;
    $agences = get_all_agences();

    $pdo = Connection::getPDO();

    $request = $pdo->query("SELECT ID 
    FROM import_stats_journalieres 
    WHERE ID = 1");
    $result = $request->fetch(PDO::FETCH_COLUMN);


    if (!empty($result)) {

        foreach ($agences as $key => $agence) {

            $id_agence = $agence['ID'];
            $nom_agence = $agence['nom_agence'];

            $request = $pdo->query("SELECT ID,nom_agence,code_vp,code_vu,code_gare 
            FROM agences 
            WHERE ID = $id_agence");
            $result = $request->fetchAll(PDO::FETCH_ASSOC);

            $array_code_vp_gare = array();
            $array_code_vu = array();


            /**** alimenter d'abord le VP ****/

            foreach ($result as $agence) {
                $array_code_vp_gare['code_vp'] = $agence['code_vp'];
                $array_code_vp_gare['code_gare'] = $agence['code_gare'];
            }

            // var_dump($array_code_vp_gare);

            /** GET CA_TMI_N **/
            $ca_tmi_n_vp = get_ca_tmi_n($array_code_vp_gare);
            /* $ca_tmi_n_1 = get_ca_tmi_n_1($array_code_vp_vu_gare); */

            /*** GET USED ***/
            $used = get_used($array_code_vp_gare);
            $vp_gare_nb_jour_loc_owned = $used['nb_jours_loc_owned'];
            $vp_gare_car_days_owned = $used['car_days_owned'];

            /** GET RO **/
            $ro_vp = get_ro($array_code_vp_gare);

            /** GET RI **/
            $ri_vp = get_ri($array_code_vp_gare);

            /** GET NBJ **/
            $nbj_vp = get_nbj($array_code_vp_gare);

            /**  GET DUREE (GET NBJ dedans) **/
            $duree_vp = get_duree($array_code_vp_gare, $ri_vp);

            /** GET REV/RA **/
            $rev_ra_vp = $ca_tmi_n_vp / $ri_vp;



            // INSERTION des données dans VP
            $data = [
                'id_agence' => $id_agence,
                'date' => $date,
                'ca_tmi_n' => $ca_tmi_n_vp,
                'used' => $used['valeur_used'],
                'ro_n' => $ro_vp,
                'ri_n' => $ri_vp,
                'duree' => $duree_vp,
                'rev_ra' => $rev_ra_vp,
                'nb_jour' => $nbj_vp,
            ];
            $sql = "INSERT INTO stats_journalieres_vp (id_agence, date, ca_tmi_n,used,ro_n,ri_n,duree,rev_ra,nb_jour) 
            VALUES (:id_agence, :date, :ca_tmi_n, :used, :ro_n, :ri_n, :duree, :rev_ra, :nb_jour)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);


            /**** alimenter ensuite le VU ****/

            foreach ($result as $agence) {
                $array_code_vu['code_vu'] = $agence['code_vu'];
            }

            $ca_tmi_n_vu = get_ca_tmi_n($array_code_vu);
            /* $ca_tmi_n_1 = get_ca_tmi_n_1($array_code_vp_vu_gare); */

            /*** GET USED ***/
            $used = get_used($array_code_vu);
            $vu_nb_jour_loc_owned = $used['nb_jours_loc_owned'];
            $vu_car_days_owned = $used['car_days_owned'];

            /** GET RO **/
            $ro_vu = get_ro($array_code_vu);


            /** GET RI **/
            $ri_vu = get_ri($array_code_vu);

            /** GET NBJ **/
            $nbj_vu = get_nbj($array_code_vu);

            /**  GET DUREE  **/
            $duree_vu = get_duree($array_code_vu, $ri_vu);

            /** GET REV/RA **/
            if ($ri_vu !== 0) {
                $rev_ra_vu = $ca_tmi_n_vu / $ri_vu;
            } else {
                $rev_ra_vu = 0;
            }


            // INSERTION des données dans VU
            $data = [
                'id_agence' => $id_agence,
                'date' => $date,
                'ca_tmi_n' => $ca_tmi_n_vu,
                'used' => $used['valeur_used'],
                'ro_n' => $ro_vu,
                'ri_n' => $ri_vu,
                'duree' => $duree_vu,
                'rev_ra' => $rev_ra_vu,
                'nb_jour' => $nbj_vu,

            ];
            $sql = "INSERT INTO stats_journalieres_vu (id_agence, date, ca_tmi_n,used,ro_n,ri_n,duree,rev_ra,nb_jour) 
            VALUES (:id_agence, :date,  :ca_tmi_n, :used, :ro_n, :ri_n, :duree, :rev_ra, :nb_jour)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);


            /**** calculer le cumul et alimenter la table cumul ****/

            /** GET CA_TMI_N CUMUL  **/
            $cumul_ca_tmi_n = $ca_tmi_n_vp + $ca_tmi_n_vu;

            /** GET USED CUMUL **/
            $cumul_used = round((float)(($vp_gare_nb_jour_loc_owned + $vu_nb_jour_loc_owned) / ($vp_gare_car_days_owned + $vu_car_days_owned)) * 100, 2);

            /** GET RO CUMUL**/
            $ro_cumul = $ro_vp + $ro_vu;

            /** GET RI CUMUL**/
            $ri_cumul = $ri_vp + $ri_vu;

            /**  GET DUREE et NBJ CUMUL **/
            $nb_jour_cumul = $nbj_vp + $nbj_vu;
            $duree_cumul =  $nb_jour_cumul / $ri_cumul;

            /** GET REV/RA **/
            $rev_ra_cumul = $cumul_ca_tmi_n / $ri_cumul;



            // INSERTION des données dans CUMUL
            $data = [
                'id_agence' => $id_agence,
                'date' => $date,
                'ca_tmi_n' => $cumul_ca_tmi_n,
                'used' => $cumul_used,
                'ro_n' => $ro_cumul,
                'ri_n' => $ri_cumul,
                'duree_cumul' => $duree_cumul,
                'rev_ra' => $rev_ra_cumul,
                'nb_jour' => $nb_jour_cumul,
            ];
            $sql = "INSERT INTO stats_journalieres_cumul (id_agence, date, ca_tmi_n,used,ro_n,ri_n,duree,rev_ra,nb_jour) 
            VALUES (:id_agence, :date, :ca_tmi_n, :used, :ro_n, :ri_n, :duree_cumul, :rev_ra, :nb_jour)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);
        }
        return true;
    }
    //si la table import est vide
    else {
        return false;
    }
}

function ajouter_imprimante($imprimante)
{
    $pdo = Connection::getPDO();

    // INSERTION des données dans VP
    $data = [
        "num_serie" => $imprimante["num_serie"],
        "infrastructure" => $imprimante["agence"],
        "emplacement" => $imprimante["emplacement"],
        "prestataire" => $imprimante["prestataire"],
        "marque" => $imprimante["marque"],
        "modele" => $imprimante["modele"],
        "ip_vpn" => $imprimante["ip_vpn"],
        "ip_locale" => $imprimante["ip_locale"]
    ];
    $sql = "INSERT INTO imprimantes (num_serie, id_infrastructure_imprimante, emplacement,prestataire,marque,modele,ip_vpn,ip_locale) 
                VALUES (:num_serie, :infrastructure, :emplacement, :prestataire, :marque, :modele, :ip_vpn, :ip_locale)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);
}

function get_ca_tmi_n($code_agence)
{
    $pdo = Connection::getPDO();
    foreach ($code_agence as $type_code => $value) {
        if (!is_null($value)) {
            $request = $pdo->query("SELECT tk_combined,
            cdw_combined,
            tp_combined,
            pai_combined,
            ow_fee_combined 
            FROM import_stats_journalieres 
            WHERE code_agence = " . $value);
            $result = $request->fetch(PDO::FETCH_ASSOC);
            // var_dump($result);
            $total[$type_code] = 0;
            foreach ($result as $value2) {
                $total[$type_code] = $total[$type_code] + $value2;
            }

            // var_dump($total[$type_code]);
        }
    }

    // var_dump($total);

    $valeur_totale  = 0;
    foreach ($total as $val) {
        $valeur_totale  = $valeur_totale + $val;
    }

    return $valeur_totale;
}

function get_all_imprimantes()
{
    $pdo = Connection::getPDO();
    // $request = $pdo->query("SELECT * FROM imprimantes ORDER BY ID ASC");
    $request = $pdo->query("SELECT i.ID,i.num_serie,i.id_infrastructure_imprimante,i.emplacement,i.prestataire,i.marque,i.modele,i.ip_vpn,i.ip_locale,s.nom_infrastructure
    FROM imprimantes AS i 
    LEFT JOIN infrastructure AS s
    ON i.id_infrastructure_imprimante = s.ID
    ORDER BY s.nom_infrastructure ASC");
    $result["tableau"] = $request->fetchAll(PDO::FETCH_ASSOC);

    //to get the number of rows returned by the req
    $request = $pdo->query("SELECT count(i.ID)
     FROM imprimantes AS i 
    LEFT JOIN infrastructure AS s
    ON i.id_infrastructure_imprimante = s.ID
    ORDER BY s.nom_infrastructure ASC");
    $nb_rows = $request->fetchColumn();
    $result["nb_rows"] = $nb_rows;

    return $result;
}

function get_all_imprimantes_by_agence_id($id_agence)
{
    if ($id_agence !== 0) {
        $where = " WHERE i.id_agence = $id_agence ";
    } else {
        $where  = " ";
    }
    $pdo = Connection::getPDO();
    // $request = $pdo->query("SELECT * FROM imprimantes ORDER BY ID ASC");
    $request = $pdo->query("SELECT i.ID,i.num_serie,i.id_agence,i.emplacement,i.prestataire,i.marque,i.modele,i.ip_vpn,i.ip_locale,a.nom_agence,d.nom_district 
    FROM imprimantes as i 
    LEFT JOIN agences as a 
    ON i.id_agence = a.ID 
    LEFT JOIN districts as d 
    ON d.ID = a.district
    $where
    ORDER BY i.ID ASC");

    $result = $request->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function get_all_imprimantes_by_infrastructure_id($id_infrastructure)
{
    if ($id_infrastructure !== 0) {
        $where = " WHERE i.id_infrastructure_imprimante = $id_infrastructure ";
    } else {
        $where  = " ";
    }
    $pdo = Connection::getPDO();
    // $request = $pdo->query("SELECT * FROM imprimantes ORDER BY ID ASC");
    $request = $pdo->query("SELECT i.ID,i.num_serie,i.id_infrastructure_imprimante,i.emplacement,i.prestataire,i.marque,i.modele,i.ip_vpn,i.ip_locale,s.nom_infrastructure
    FROM imprimantes as i 
    LEFT JOIN infrastructure as s 
    ON i.id_infrastructure_imprimante = s.ID
    $where
    ORDER BY i.ID ASC");
    $result["tableau"] = $request->fetchAll(PDO::FETCH_ASSOC);

    //to get the number of rows returned by the req
    $request = $pdo->query("SELECT count(i.ID)
    FROM imprimantes as i 
    LEFT JOIN infrastructure as s
    ON i.id_infrastructure_imprimante = s.ID 
    $where
    ORDER BY i.ID ASC");
    $nb_rows = $request->fetchColumn();
    $result["nb_rows"] = $nb_rows;

    return $result;
}

function get_all_imprimantes_by_prestataire($prestataire)
{
    if ($prestataire !== "tous") {
        $where = " WHERE i.prestataire = '$prestataire' ";
    } else {
        $where  = " ";
    }
    $pdo = Connection::getPDO();
    // $request = $pdo->query("SELECT * FROM imprimantes ORDER BY ID ASC");
    $request = $pdo->query("SELECT i.ID,i.num_serie,i.id_infrastructure_imprimante,i.emplacement,i.prestataire,i.marque,i.modele,i.ip_vpn,i.ip_locale,s.nom_infrastructure
    FROM imprimantes as i 
    LEFT JOIN infrastructure as s
    ON i.id_infrastructure_imprimante = s.ID 
    $where
    ORDER BY i.ID ASC");
    $result["tableau"] = $request->fetchAll(PDO::FETCH_ASSOC);

    //to get the number of rows returned by the req
    $request = $pdo->query("SELECT count(i.ID)
    FROM imprimantes as i 
    LEFT JOIN infrastructure as s
    ON i.id_infrastructure_imprimante = s.ID 
    $where
    ORDER BY i.ID ASC");
    $nb_rows = $request->fetchColumn();

    $result["nb_rows"] = $nb_rows;

    return $result;
}

function get_imprimante_by_num_serie($num_serie)
{
    $pdo = Connection::getPDO();
    // $request = $pdo->query("SELECT * FROM imprimantes ORDER BY ID ASC");
    $request = $pdo->query("SELECT i.ID,i.num_serie,i.id_infrastructure_imprimante,i.emplacement,i.prestataire,i.marque,i.modele,i.ip_vpn,i.ip_locale,s.nom_infrastructure
    FROM imprimantes as i 
    LEFT JOIN infrastructure as s
    ON i.id_infrastructure_imprimante = s.ID 
    WHERE i.num_serie LIKE '%$num_serie%'");
    $result["tableau"] = $request->fetchAll(PDO::FETCH_ASSOC);

    //to get the number of rows returned by the req
    $request = $pdo->query("SELECT count(i.ID)
     FROM imprimantes as i 
     LEFT JOIN infrastructure as s
     ON i.id_infrastructure_imprimante = s.ID 
     WHERE i.num_serie LIKE '%$num_serie%'");
    $nb_rows = $request->fetchColumn();
    $result["nb_rows"] = $nb_rows;

    return $result;
}


function get_all_infrastructure()
{
    $pdo = Connection::getPDO();
    // $request = $pdo->query("SELECT * FROM imprimantes ORDER BY ID ASC");
    $request = $pdo->query("SELECT *
    FROM infrastructure
    ORDER BY nom_infrastructure ASC");
    $result  = $request->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function get_all_infrastructure_type($id_type)
{
    $pdo = Connection::getPDO();
    // $request = $pdo->query("SELECT * FROM imprimantes ORDER BY ID ASC");
    $request = $pdo->query("SELECT *
    FROM infrastructure
    WHERE type_infrastructure_id = $id_type
    ORDER BY nom_infrastructure ASC");
    $result  = $request->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}


function get_used($code_agence)
{
    $pdo = Connection::getPDO();
    $nb_jour_loc_owned = 0;
    $car_days_owned = 0;

    foreach ($code_agence as $type_code => $value) {
        if (!is_null($value)) {
            $request = $pdo->query("SELECT nb_jours_loc_owned,
            car_days_owned
            FROM import_stats_journalieres 
            WHERE code_agence = " . $value);

            $result = $request->fetch(PDO::FETCH_ASSOC);

            $nb_jour_loc_owned += $result['nb_jours_loc_owned'];
            $car_days_owned += $result['car_days_owned'];
        }
    }

    //règle de calcul pour USED
    $valeur_totale = round((float)($nb_jour_loc_owned / $car_days_owned) * 100, 2);

    $result_array_used['nb_jours_loc_owned'] = $nb_jour_loc_owned;
    $result_array_used['car_days_owned'] = $car_days_owned;
    $result_array_used['valeur_used'] = $valeur_totale;
    return $result_array_used;
}

function get_ro($code_agence)
{
    $pdo = Connection::getPDO();
    $total_ro = 0;

    foreach ($code_agence as $type_code => $value) {
        if (!is_null($value)) {
            $request = $pdo->query("SELECT departs_combined
            FROM import_stats_journalieres 
            WHERE code_agence = " . $value);
            $result = $request->fetch(PDO::FETCH_ASSOC);

            $total_ro = $total_ro + $result['departs_combined'];
        }
    }
    return $total_ro;
}

function get_nbj($code_agence)
{
    $pdo = Connection::getPDO();
    $total_nbj = 0;

    foreach ($code_agence as $type_code => $value) {
        if (!is_null($value)) {
            $request = $pdo->query("SELECT nb_jours_loc_combined
            FROM import_stats_journalieres 
            WHERE code_agence = " . $value);
            $result = $request->fetch(PDO::FETCH_ASSOC);

            $total_nbj = $total_nbj + $result['nb_jours_loc_combined'];
        }
    }
    return $total_nbj;
}

function get_nom_infrastructure_by_id($id_infrastructure)
{
    $pdo = Connection::getPDO();
    // $request = $pdo->query("SELECT * FROM imprimantes ORDER BY ID ASC");
    $request = $pdo->query("SELECT nom_infrastructure
    FROM infrastructure
    WHERE ID = $id_infrastructure");
    $result  = $request->fetch(PDO::FETCH_ASSOC);
    return $result["nom_infrastructure"];
}

function get_prefixe_toip($id_infrastructure)
{
    $pdo = Connection::getPDO();
    // $request = $pdo->query("SELECT * FROM imprimantes ORDER BY ID ASC");
    $request = $pdo->query("SELECT prefixe_toip
    FROM infrastructure
    WHERE ID = $id_infrastructure");
    $result  = $request->fetch(PDO::FETCH_ASSOC);
    return $result["prefixe_toip"];
}

function get_duree($code_agence, $ri)
{
    $pdo = Connection::getPDO();
    $nb_jour_loc_combined = 0;

    foreach ($code_agence as $type_code => $value) {
        if (!is_null($value)) {
            $request = $pdo->query("SELECT nb_jours_loc_combined
            FROM import_stats_journalieres 
            WHERE code_agence = " . $value);
            //pour recup qu'une seule valeur sans array
            $result = $request->fetch(PDO::FETCH_COLUMN);

            $nb_jour_loc_combined += $result;
        }
    }
    //prendre le cas ou le il n'y a pas de ri
    if (($nb_jour_loc_combined !== 0) || ($ri !== 0)) {
        $nb_jour_loc_combined = $nb_jour_loc_combined / $ri;
    } else {
        $nb_jour_loc_combined = 0;
    }

    return $nb_jour_loc_combined;
}

function get_ri($code_agence)
{
    $pdo = Connection::getPDO();
    $total_ri = 0;

    foreach ($code_agence as $type_code => $value) {
        if (!is_null($value)) {
            $request = $pdo->query("SELECT transaction_combined
            FROM import_stats_journalieres 
            WHERE code_agence = " . $value);
            $result = $request->fetch(PDO::FETCH_ASSOC);

            $total_ri = $total_ri + $result['transaction_combined'];
        }
    }
    return $total_ri;
}

function replace_comma_with_dot($value_csv)
{
    $value_return = str_replace(',', '.', $value_csv);
    return $value_return;
}

function get_stats_journalieres($agence, $type, $date)
{

    // $test_date = date("2022-07-27");
    $test_date = $date;

    $pdo = Connection::getPDO();

    //si on filtre par AGENCE alors $agence n'est pas un array
    if (!is_array($agence)) {
        if ($agence == 0) {
            $sql_agence = "";
        } else {
            $sql_agence = "AND s.id_agence = $agence";
        }
    }
    //si on choisit un SECTEUR alors $agence est un array
    else {
        foreach ($agence as $id_agence) {
            $liste_id[] = $id_agence['ID'];
        }
        $liste_id_agence_secteur = implode(',', $liste_id);
        $sql_agence = "AND s.id_agence IN (" . $liste_id_agence_secteur . ")";
    }



    switch ($type) {
        case "vp":
            $stats_type = "stats_journalieres_vp";
            break;
        case "vu":
            $stats_type = "stats_journalieres_vu";
            break;
        case "cumul":
            $stats_type = "stats_journalieres_cumul";
            break;
    }

    $request = $pdo->query("SELECT * FROM $stats_type as s 
    LEFT JOIN agences as a ON s.id_agence = a.ID 
    WHERE s.date = '$test_date' $sql_agence 
    ORDER BY a.nom_agence ASC");
    $result = $request->fetchAll(PDO::FETCH_ASSOC);

    $requete =  $request->queryString;

    $return["tableau"] = $result;
    $return["requete"] = $requete;

    return $return;
}

function vider_vp_vu_cumul()
{
    $pdo = Connection::getPDO();
    $sql = "TRUNCATE TABLE stats_journalieres_cumul";
    //Prepare the SQL query.
    $statement = $pdo->prepare($sql);
    //Execute the statement.
    $statement->execute();

    $sql = "TRUNCATE TABLE stats_journalieres_vp";
    //Prepare the SQL query.
    $statement = $pdo->prepare($sql);
    //Execute the statement.
    $statement->execute();

    $sql = "TRUNCATE TABLE stats_journalieres_vu";
    //Prepare the SQL query.
    $statement = $pdo->prepare($sql);
    //Execute the statement.
    $statement->execute();
}

function get_all_collaborateurs_cvo()
{
    // $pdo = Connection::getPDO();
    // $request = $pdo->query("SELECT c.nom,c.prenom,c.identifiant_payplan,f.fonction,cvo.nom_cvo FROM collaborateurs_payplan as c
    //                         LEFT JOIN fonction_collaborateur as f ON c.id_fonction = f.ID 
    //                         LEFT JOIN cvo ON c.id_site = cvo.ID 
    //                         ORDER BY c.nom ASC");
    // $result = $request->fetchAll(PDO::FETCH_ASSOC);
    // return $result;

    $pdo = Connection::getPDO();
    $request = $pdo->query("SELECT ID,nom_cvo FROM cvo
                            ORDER BY nom_cvo ASC");
    $liste_site_cvo = $request->fetchAll(PDO::FETCH_ASSOC);

    foreach ($liste_site_cvo as $key_site_cvo => $site_cvo) {
        $request = $pdo->query("SELECT ID,nom,prenom,identifiant_payplan FROM collaborateurs_payplan
        WHERE id_site = " . $site_cvo['ID'] . " 
        ORDER BY nom ASC");
        $liste_collaborateur = $request->fetchAll(PDO::FETCH_ASSOC);
        $liste_site_cvo[$key_site_cvo]['collaborateurs'] = $liste_collaborateur;
    }
    return $liste_site_cvo;
}

function get_payplan()
{

    $pdo = Connection::getPDO_2();
    $request = $pdo->query("SELECT vehicules.immatriculation AS Immatriculation,
    destinations.libelle AS Destination,
    typeachats.libelle AS Type_Achat,
    typevehicules.libelle AS Type_Vehicule,
    categoriesvu.libelle AS Categorie_VU,
    modelescommerciaux.libelle AS Modele,
    vehicules.reference_lot AS Reference_lot,
    finitions.libelle AS Finition,
    vehicules.parc_achat AS Parc_Achat,
    vehicules.nom_acheteur_massoutre AS Nom_Acheteur,
    vehicules.date_vente AS Date_Vente,
    vehicules.prix_achat_net_remise AS Prix_achat_net_remise,
    vehicules.duree_stock AS Duree_stock,
    vehicules.date_premiere_location AS Date_premiere_location,
    vehicules.date_derniere_location AS Date_derniere_location,
    vehicules.date_stock AS Date_stock,
    vehicules.prix_carte_grise AS Prix_carte_grise,
    vehicules.prix_transport AS Prix_transport,
    vehicules.montant_bonus_malus AS Montant_Bonus_Malus,
    vehicules.commission_gca AS Commission_GCA,
    vehicules.commission_achat AS Commission_Achat,
    factureventes.marge_nette AS Marge_nette,
    CONCAT(utilisateurs.prenom,' ',utilisateurs.nom) AS Vendeur,
    factureventes.destination_sortie AS Destination_sortie,
    factureventes.prix_reserve AS Prix_reserve,
    factureventes.montant AS Montant,
    factureventes.nom_client AS Client,
    factureventes.marge_financement AS Marge_Financement,
    factureventes.montant_garantie AS Montant_Garantie,
    factureventes.marge_pack AS Marge_Pack,
    factureventes.montant_pack_livraison AS Montant_Pack_Livraison,
    factureventes.marges_diverses AS Marges_diverses,
    factureventes.commission_massoutre AS Commissions_Massoutre,
    factureventes.montant_publicite AS Montant_Publicite,
    factureventes.montant_revision AS Montant_Revision, 
    factureventes.montant_carrosserie AS Montant_Carrosserie,
    factureventes.montant_preparation AS Montant_Preparation,
    factureventes.montant_ct AS Montant_Ct,
    factureventes.prix_transport_CVO AS Prix_Transport_CVO,
    factureventes.date_facturation AS Date_facturation,
    vehicules.options as Options
    
    FROM vehicules
    LEFT JOIN destinations ON vehicules.destination_id = destinations.id
    LEFT JOIN typeachats ON vehicules.typeachat_id = typeachats.id
    LEFT JOIN typevehicules ON vehicules.typevehicule_id = typevehicules.id
    LEFT JOIN categoriesvu ON vehicules.categorievu_id = categoriesvu.id
    LEFT JOIN modelescommerciaux ON vehicules.modelecommercial_id = modelescommerciaux.id
    LEFT JOIN finitions ON vehicules.finition_id = finitions.id
    LEFT JOIN factureventes ON (vehicules.id = factureventes.vehicule_id  AND factureventes.deleted = 0)
    LEFT JOIN utilisateurs ON factureventes.vendeur_id = utilisateurs.id
    
    WHERE factureventes.date_facturation>='2022-11-01'");

    $payplan = $request->fetchAll(PDO::FETCH_ASSOC);


    return $payplan;
}

function define_type_com($type_achat, $type_vh, $cat_vu)
{
    if ($type_achat == 'Reprise') {
        $return = 'Com. Reprise';
    } else if ($type_vh == 'VP') {
        $return = 'Com. VP';
    } else if ($cat_vu == 1) {
        $return = 'Com. VP';
    } elseif ($cat_vu == 20) {
        $return = 'Com. VP';
    } else {
        $return = 'Com. VU';
    }
    return $return;
}
