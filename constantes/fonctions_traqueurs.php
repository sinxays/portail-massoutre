<?php


use app\Connection;

function ajouter_montage_traqueur($datas)
{
    $pdo = Connection::getPDO();


    //on ajoute d'abord dans la table traqueur
    $datas_traqueur = [
        'serial_number' => $datas['serial_number'],
        'sim' => $datas['sim'],
        'imei' => $datas['imei']
    ];

    $sql = "INSERT INTO geoloc_traqueurs (serial_number,imei,sim) 
    VALUES (:serial_number, :imei,:sim)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($datas_traqueur);
    $lastID_traqueur = $pdo->lastInsertId();

    //on ajoute ensuite le véhicule
    $data_vh = [
        'immatriculation' => $datas['immatriculation'],
        'type' => $datas['type'],
        'mva' => $datas['mva']
    ];
    $sql = "INSERT INTO geoloc_vehicules (immatriculation,type,mva) 
    VALUES (:immatriculation, :type, :mva)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data_vh);
    $lastID_vh = $pdo->lastInsertId();

    //on ajoute enfin le montage
    $data_montage = [
        'id_traqueur' => $lastID_traqueur,
        'id_vehicule' => $lastID_vh,
        'date_installation' => $datas['date_installation'],
        'date_maj_site' => $datas['maj_site'] !== '' ? $datas['maj_site'] : NULL,
        'lieu_montage' => $datas['lieu_montage'],
        'nom_monteur' => $datas['nom_monteur'],
        'position' => $datas['position'],
        'obd' => $datas['obd'],
        'obd_nom_monteur' => $datas['nom_monteur_obd'],
        'soudure' => $datas['soudure'],
        'actif' => 1

    ];
    $sql = "INSERT INTO geoloc_montage (id_traqueur,id_vehicule,date_installation,date_maj_site,montage,montage_nom,montage_position,obd,obd_nom,soudure,actif) 
    VALUES (:id_traqueur, :id_vehicule, :date_installation,:date_maj_site,:lieu_montage,:nom_monteur,:position,:obd,:obd_nom_monteur,:soudure,:actif)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data_montage);

}

function get_liste_traqueurs($filtre = '')
{

    $where = '';

    if (isset($filtre) && !empty($filtre)) {
        // Extraire la clé du tableau 'filtre'
        $cle = key($filtre['filtre']); // Retourne le type de filtre 
        $value = $filtre['filtre'][$cle]; // retourne la valeur du filtre 

        switch ($cle) {
            case 'actif':
                $where = "WHERE actif = $value";
                break;
            case 'serial_number':
                $where = "WHERE serial_number LIKE '%$value%'";
                break;
            case 'imei':
                $where = "WHERE imei LIKE '%$value%'";
                break;

            // par défaut prendre tout les actifs/inactifs
            default:
                $where = "";
                break;
        }
    }



    $pdo = Connection::getPDO();

    $request = $pdo->query("SELECT * FROM geoloc_traqueurs $where ");
    $result_liste = $request->fetchAll(PDO::FETCH_ASSOC);
    // var_dump(->queryString);

    return $result_liste;
}

function get_details_traqueur($id)
{
    $pdo = Connection::getPDO();

    $request = $pdo->query("SELECT gt.ID,gt.serial_number,gt.imei,gt.actif,
    gm.date_installation,gm.date_maj_site,gm.montage,gm.montage_nom,gm.montage_position,gm.obd,gm.obd_nom,gm.soudure,
    gv.immatriculation,gv.type,gv.mva
    FROM geoloc_traqueurs AS gt
    LEFT JOIN geoloc_montage AS gm ON gt.ID = gm.id_traqueur
    LEFT JOIN geoloc_vehicules AS gv ON gv.ID = gm.id_vehicule
    WHERE gt.ID = $id ");
    $traqueur = $request->fetch(PDO::FETCH_ASSOC);

    return $traqueur;
}

function insert_traqueur($serial_number, $imei)
{ // Préparer la requête d'insertion SQL

    $pdo = Connection::getPDO();


    //on ajoute d'abord dans la table traqueur
    $datas_traqueur = [
        'serial_number' => $serial_number,
        'imei' => $imei
    ];


    $sql = "INSERT INTO geoloc_traqueurs (serial_number,imei) VALUES (:serial_number, :imei)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($datas_traqueur);

}

function update_montage_traqueur($data)
{

}

function get_liste_montage_traqueurs($filtre = '')
{
    $where = '';

    if (isset($filtre) && !empty($filtre)) {
        // Extraire la clé du tableau 'filtre'
        $cle = key($filtre['filtre']); // Retourne le type de filtre 
        $value = $filtre['filtre'][$cle]; // retourne la valeur du filtre 

        switch ($cle) {
            case 'immatriculation':
                $where = "WHERE actif = $value";
                break;
            case 'mva':
                $where = "WHERE serial_number LIKE '%$value%'";
                break;

            // par défaut prendre tout les actifs/inactifs
            default:
                $where = "";
                break;
        }
    }

    $pdo = Connection::getPDO();

    $request = $pdo->query("SELECT * FROM geoloc_montage AS gm
    LEFT JOIN geoloc_vehicules AS gv ON gm.id_vehicule = gv.ID
    LEFT JOIN geoloc_traqueurs AS gt ON gm.id_traqueur = gt.ID
      $where ");
    $result_liste = $request->fetchAll(PDO::FETCH_ASSOC);
    // var_dump(->queryString);

    return $result_liste;

}
