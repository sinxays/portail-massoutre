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

function get_liste_traqueurs($imei = '', $sn = '', $sim = '')
{

    $where = "";
    if ($imei && $imei !== '') {
        $where = " AND imei LIKE '%$imei%'";
    } else if ($sn && $sn !== '') {
        $where = " AND serial_number LIKE '%$sn%'";
    } else if ($sim && $sim !== '') {
        $where = " AND sin LIKE '%$sim%'";
    }

    $pdo = Connection::getPDO();

    $request = $pdo->query("SELECT * FROM geoloc_traqueurs WHERE actif = 1 $where ");
    $result_liste = $request->fetchAll(PDO::FETCH_ASSOC);

    // var_dump(->queryString);

    return $result_liste;

}

function get_details_traqueur($id)
{
    $pdo = Connection::getPDO();

    $request = $pdo->query("SELECT gm.ID,gm.date_installation,gm.date_maj_site,gm.montage,gm.montage_nom,gm.montage_position,gm.obd,gm.obd_nom,gm.soudure,
    gt.serial_number,gt.imei,gt.sim,
    gv.immatriculation,gv.type,gv.mva 
      FROM geoloc_montage AS gm
      LEFT JOIN geoloc_traqueurs AS gt ON gt.ID = gm.id_traqueur
      LEFT JOIN geoloc_vehicules AS gv ON gv.ID = gm.id_vehicule
      WHERE gm.actif = 1 AND gm.ID = $id ");
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
