<?php


use app\Connection;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

function get_liste_suivi_lag($immatriculation = '', $type_entretien = '', $client = '', $deleted)
{

    $where = "vh_alerte.deleted = $deleted";
    if ($type_entretien && $type_entretien !== 0) {
        $where = "code.ID = $type_entretien AND vh_alerte.deleted = $deleted";
    } else if ($immatriculation && $immatriculation !== '') {
        $where = "vh.immatriculation LIKE '%$immatriculation%' AND vh_alerte.deleted = $deleted";
    } else if ($client && $client !== '') {
        $where = "vh.client LIKE '%$client%' AND vh_alerte.deleted = $deleted";
    }
    //archivé ou non
    else if ($deleted && $deleted !== '') {
        $where = "vh_alerte.deleted = $deleted";
    }

    $pdo = Connection::getPDO();

    $request = $pdo->query("SELECT vh.immatriculation,vh.marque,vh.modele,vh.km_echoes,vh.client,vh.ID as vh_id,
    code.type,code.libelle,
    vh_alerte.date_to_entretien,vh_alerte.km_to_entretien,vh_alerte.ID as alerte_id
        FROM suivi_lag_vehicules as vh 
        LEFT JOIN suivi_lag_vehicules_alertes as vh_alerte ON vh.ID = vh_alerte.id_vehicule
        LEFT JOIN suivi_lag_code_alertes as code ON code.ID = vh_alerte.id_code_alerte
        WHERE $where AND code.type IS NOT NULL ");
    $result_liste = $request->fetchAll(PDO::FETCH_ASSOC);

    // var_dump($request->queryString);

    //pour avoir le dernier commentaire
    foreach ($result_liste as $index => $alerte) {
        $request = $pdo->query("SELECT action.* 
        FROM suivi_lag_actions as action
        JOIN ( SELECT MAX(action2.ID) as max_id
              FROM suivi_lag_actions as action2
              LEFT JOIN suivi_lag_vehicules_alertes AS alerte ON alerte.ID = action2.id_alerte
              WHERE date_action = (SELECT MAX(date_action) FROM suivi_lag_actions WHERE id_alerte = " . $alerte['alerte_id'] . ") AND action2.id_alerte = " . $alerte['alerte_id'] . ") AS subquery ON subquery.max_id = action.ID");

        $result_last_action = $request->fetch(PDO::FETCH_ASSOC);

        if ($result_last_action) {
            $result_liste[$index]['last_action'] = $result_last_action;
        }
    }
    return $result_liste;
}

function import_fichier_excel_to_suivi_lag($type_fichier, $fichier_excel)
{

    $count_nb_vh = 0;
    $count_nb_vh_imported = 0;

    $pdo = Connection::getPDO();
    $pdo_intranet = Connection::getPDO_2();

    $spreadsheet = IOFactory::load($fichier_excel);
    $sheet = $spreadsheet->getActiveSheet();
    $lignes = $sheet->toArray();
    array_shift($lignes); // enlève les en-têtes


    switch ($type_fichier) {
        case 'base':
            foreach ($lignes as $ligne) {
                $count_nb_vh++;

                print_r($ligne);
                saut_de_ligne();

                $immatriculation = $ligne[0];
                $client = $ligne[1];

                // on check deja si le vh n'existe pas déja
                $request = $pdo->query("SELECT ID FROM suivi_lag_vehicules WHERE immatriculation = '$immatriculation'");
                $result = $request->fetch(PDO::FETCH_COLUMN);

                if (!$result) {

                    //on va chercher dans le portail les details modele et marque
                    $request = $pdo_intranet->query("SELECT m.libelle as marque , mc.libelle as modele from vehicules as v
                            LEFT JOIN marques as m ON m.id = v.marque_id
                            LEFT JOIN modelescommerciaux as mc ON  mc.id =  v.modelecommercial_id
                            WHERE v.immatriculation = '$immatriculation'");
                    $result = $request->fetch(PDO::FETCH_ASSOC);

                    $marque = $result['marque'];
                    $modele = $result['modele'];

                    try {
                        $data_vh = [
                            'immatriculation' => $immatriculation,
                            'client' => $client,
                            'marque' => $marque,
                            'modele' => $modele,
                            'deleted' => 0,
                        ];
                        $sql = "INSERT INTO suivi_lag_vehicules (immatriculation,client,marque,modele,deleted) 
                        VALUES (:immatriculation, :client,:marque,:modele,:deleted)";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute($data_vh);
                        $count_nb_vh_imported++;

                    } catch (PDOException $e) {
                        error_log($e->getMessage());
                        // En développement
                        die("Erreur SQL : " . $e->getMessage());
                        // En production, plutôt :
                        // die("Une erreur est survenue.");
                    }

                }
            }

            break;


        // pour mettre a jour le kilometrage des véhicules équipés   
        case 'echoes':
            foreach ($lignes as $ligne) {

                // print_r($ligne);
                $immatriculation = $ligne[2];
                $km_echoes = $ligne[6];

                try {
                    $data_vh = [
                        'immatriculation' => $immatriculation,
                        'km_echoes' => $km_echoes
                    ];
                    $sql = "UPDATE suivi_lag_vehicules SET km_echoes = :km_echoes WHERE immatriculation = :immatriculation and deleted = 0";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute($data_vh);
                } catch (PDOException $e) {
                    error_log($e->getMessage());
                    // En développement
                    die("Erreur SQL : " . $e->getMessage());
                    // En production, plutôt :
                    // die("Une erreur est survenue.");
                }
            }

            break;


        //mettre a jour les alertes    
        case 'hitech':

            $i = 2;
            $array_vh_no_exist = array();
            $array_code_alert_no_exist = array();

            foreach ($lignes as $ligne) {

                $check = FALSE;

                // print_r($ligne);
                // saut_de_ligne();
                $immatriculation = $ligne[0];
                $type_alerte_code = (int) $ligne[3];
                // $type_alerte_libelle = $ligne[4];
                $km_alerte_entretien = $ligne[7];


                // Récupération directe de la cellule date (colonne F)
                $dateExcel = $sheet->getCell("F$i")->getValue();
                if ($dateExcel !== null && is_numeric($dateExcel)) {
                    $date_alerte_entretien_format_us = Date::excelToDateTimeObject($dateExcel)
                        ->format('Y-m-d');
                } else {
                    $date_alerte_entretien_format_us = null;
                }

                $km_alerte_entretien !== null ? $km_alerte_entretien : null;

                //on va chercher le véhicule lié si il existe
                $request = $pdo->query("SELECT ID FROM suivi_lag_vehicules WHERE immatriculation = '$immatriculation' and deleted = 0");
                $result = $request->fetch(PDO::FETCH_COLUMN);

                if ($result) {
                    $id_vh = (int) $result;

                    // var_dump($id_vh);
                    // saut_de_ligne();

                    //on va boucler sur les codes alertes jusqu'a trouver le correspondant
                    $request = $pdo->query("SELECT * FROM suivi_lag_code_alertes");
                    $liste_alertes = $request->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($liste_alertes as $type_alerte) {
                        // si on trouve le code alerte correspondant
                        if ($type_alerte_code == (int) $type_alerte['code_alerte']) {
                            $check = TRUE;
                            // on crée l'alerte lié au vh 
                            $data = [
                                'id_vehicule' => $id_vh,
                                'id_code_alerte' => $type_alerte['ID'],
                                'km_to_entretien' => $km_alerte_entretien,
                                'date_to_entretien' => $date_alerte_entretien_format_us,
                                'deleted' => 0,
                            ];
                            $sql = "INSERT INTO suivi_lag_vehicules_alertes (id_vehicule,id_code_alerte,km_to_entretien,date_to_entretien,deleted) 
                                        VALUES (:id_vehicule, :id_code_alerte,:km_to_entretien, :date_to_entretien,:deleted)";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute($data);

                        } else {

                        }
                    }
                    if (!$check) {
                        $array_code_alert_no_exist[] = $type_alerte_code . " - " . $immatriculation;
                    }


                } else {
                    $array_vh_no_exist[] = $immatriculation;
                }

                $i++;
            }

            var_dump($array_code_alert_no_exist);
            saut_de_ligne();
            saut_de_ligne();
            var_dump($array_vh_no_exist);


            break;

    }


}


function get_detail_suivi_lag($id)
{
    $pdo = Connection::getPDO();

    $request = $pdo->query("SELECT vh.immatriculation,vh.marque,vh.modele,vh.km_echoes,vh.client,vh.ID as vh_id,
    code.type,code.libelle,code.ID as code_id,
    vh_alerte.date_to_entretien,vh_alerte.km_to_entretien,vh_alerte.ID as alerte_id,vh_alerte.statut
        FROM suivi_lag_vehicules as vh 
        LEFT JOIN suivi_lag_vehicules_alertes as vh_alerte ON vh.ID = vh_alerte.id_vehicule
        LEFT JOIN suivi_lag_code_alertes as code ON code.ID = vh_alerte.id_code_alerte
        WHERE vh_alerte.ID = $id");

    $result_suivi_lag = $request->fetch(PDO::FETCH_ASSOC);

    //on va récupérer les actions par l'id de l'alerte

    $id_alerte = $result_suivi_lag['alerte_id'];

    $request = $pdo->query("SELECT action.ID,action.date_action,action.type_action,action.commentaire,action.action_retour_client,action.action_a_effectuer
      FROM suivi_lag_actions as action
      WHERE id_alerte = $id_alerte");
    $result_actions = $request->fetchAll(PDO::FETCH_ASSOC);

    $result['infos'] = $result_suivi_lag;
    $result['actions'] = $result_actions;


    return $result;
}


function ajout_modif_action_suivi_lag($data_new_action)
{

    $pdo = Connection::getPDO();

    // si on trouve un ID alors on modifie une action déja existante
    if (isset($data_new_action['action_id']) && $data_new_action['action_id'] !== '') {
        $data = [
            'id_action' => $data_new_action['action_id'],
            'date_action' => $data_new_action['date_action'],
            'action_type' => $data_new_action['action_type'],
            'action_effectuee' => $data_new_action['action_effectuee'],
            'action_retour_client' => $data_new_action['action_retour_client'],
            'action_a_effectuer_next' => $data_new_action['action_a_effectuer_next']
        ];

        $sql = "UPDATE suivi_lag_actions SET commentaire = :action_effectuee,
        date_action =:date_action ,
        type_action =:action_type ,
        action_retour_client=:action_retour_client,
        action_a_effectuer=:action_a_effectuer_next 
        WHERE ID = :id_action";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);


    }
    //sinon c'est une nouvelle action
    else {
        $data = [
            'date_action' => $data_new_action['date_action'],
            'action_type' => $data_new_action['action_type'],
            'action_effectuee' => $data_new_action['action_effectuee'],
            'action_retour_client' => $data_new_action['action_retour_client'],
            'action_a_effectuer_next' => $data_new_action['action_a_effectuer_next'],
            'alerte_id' => $data_new_action['alerte_id']
        ];

        $sql = "INSERT INTO suivi_lag_actions (id_alerte,date_action,type_action,commentaire,action_retour_client,action_a_effectuer)
        VALUES (:alerte_id, :date_action,:action_type, :action_effectuee,:action_retour_client, :action_a_effectuer_next)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);

    }
}

function delete_action_suivi_lag_by_id($id_action)
{

    $pdo = Connection::getPDO();

    $data = [
        'action_id' => $id_action
    ];

    $sql = 'DELETE FROM suivi_lag_actions WHERE ID=:action_id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);

}


function get_action_suivi_lag_from_id($id)
{
    $pdo = Connection::getPDO();

    $id_action = intval($id);

    $request = $pdo->query("SELECT * FROM suivi_lag_actions WHERE ID = $id_action");

    $result_action = $request->fetch(PDO::FETCH_ASSOC);

    return $result_action;
}


function update_suivi_lag_alerte($data)
{

    $pdo = Connection::getPDO();

    //update statut
    $data = [
        'alerte_id' => $data['alerte_id'],
        'statut_alerte' => $data['statut_alerte'],
    ];

    $sql = "UPDATE suivi_lag_vehicules_alertes 
    SET statut=:statut_alerte 
    WHERE ID=:alerte_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);
}

function get_suivi_lag_type_alertes()
{

    $pdo = Connection::getPDO();

    $request = $pdo->query("SELECT * FROM suivi_lag_code_alertes");

    $result = $request->fetchAll(PDO::FETCH_ASSOC);

    return $result;

}

function archiver_alerte_suivi_lag($alerte_id)
{
    $pdo = Connection::getPDO();
    $data = [
        'alerte_id' => $alerte_id,
    ];
    $sql = "UPDATE suivi_lag_vehicules_alertes SET deleted = 1 WHERE ID=:alerte_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);
}