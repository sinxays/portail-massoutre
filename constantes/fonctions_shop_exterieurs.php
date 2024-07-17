<?php


use app\Connection;

function get_liste_shop_exterieurs($categorie)
{

    $where = "";
    if ($categorie !== 0) {
        $where = " WHERE vh.categorie_id = $categorie";
    }

    $pdo = Connection::getPDO();

    $request = $pdo->query("SELECT vh.ID,vh.immatriculation,vh.modele,vh.num_contrat,vh.mva,vh.kilometrage,vh.garantie,vh.date_demande_recup,vh.date_recup,vh.agence_recup,
    cat.libelle,
    type_panne.type_panne_libelle,
    panne.localisation,panne.date_declaration
      FROM shop_ext_vehicules as vh
      LEFT JOIN shop_ext_categories as cat ON vh.categorie_id = cat.id
      LEFT JOIN shop_ext_panne as panne ON vh.id = panne.vehicule_id
      LEFT JOIN shop_ext_type_panne as type_panne ON type_panne.id = panne.type_panne_id
      $where");
    $result_liste = $request->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result_liste as $index => $vehicule) {
        $request = $pdo->query("SELECT action.* 
        FROM shop_ext_action as action
        JOIN ( SELECT MAX(action2.ID) as max_id
              FROM shop_ext_action as action2
              LEFT JOIN shop_ext_vehicules AS vh ON vh.ID = action2.vehicule_id
              WHERE date_action = (SELECT MAX(date_action) FROM shop_ext_action WHERE vehicule_id = " . $vehicule['ID'] . ")
              GROUP BY action2.date_action ) AS subquery ON subquery.max_id = action.ID");

        $result_last_action = $request->fetch(PDO::FETCH_ASSOC);

        if ($result_last_action) {
            $result_liste[$index]['last_action'] = $result_last_action;
        }
    }
    return $result_liste;
}

function get_detail_shop_ext($id)
{
    $pdo = Connection::getPDO();

    $request = $pdo->query("SELECT vh.ID,vh.immatriculation,vh.modele,vh.num_contrat,vh.mva,vh.kilometrage,vh.garantie,vh.date_demande_recup,vh.date_recup,vh.agence_recup,
    type_panne.type_panne_libelle,
    panne.localisation,panne.date_declaration,
    cat.libelle
      FROM shop_ext_vehicules as vh
      LEFT JOIN shop_ext_categories as cat ON vh.categorie_id = cat.id
      LEFT JOIN shop_ext_panne as panne ON vh.id = panne.vehicule_id
      LEFT JOIN shop_ext_type_panne as type_panne ON type_panne.id = panne.type_panne_id
      WHERE vh.id = $id");

    $result_shop_ext = $request->fetch(PDO::FETCH_ASSOC);

    //on va récupérer les actions

    $request = $pdo->query("SELECT action.id,action.date_action,action.action,action.remarque,action.is_factured,action.montant_facture
      FROM shop_ext_action as action
      LEFT JOIN shop_ext_vehicules as vh ON vh.id = action.vehicule_id
      WHERE vh.id = $id");
    $result_actions = $request->fetchAll(PDO::FETCH_ASSOC);

    $result['shop'] = $result_shop_ext;
    $result['actions'] = $result_actions;


    return $result;
}

function get_list_type_panne_libelle()
{
    $pdo = Connection::getPDO();

    $request = $pdo->query("SELECT * FROM shop_ext_type_panne");
    $result = $request->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

function ajouter_shop_exterieur($array_shop_ext)
{
    // var_dump($array_shop_ext);

    $pdo = Connection::getPDO();

    $data_vh = [
        'immatriculation' => $array_shop_ext['immatriculation'],
        'mva' => $array_shop_ext['mva'],
        'km' => $array_shop_ext['km'],
        'modele' => $array_shop_ext['modele'],
        'garantie' => $array_shop_ext['garantie'],
        'num_contrat' => $array_shop_ext['num_contrat']
    ];
    $sql = "INSERT INTO shop_ext_vehicules (immatriculation,modele,mva,kilometrage,garantie,num_contrat) 
    VALUES (:immatriculation, :modele,:mva, :km,:garantie, :num_contrat)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data_vh);
    $lastID = $pdo->lastInsertId();

    //on ajoute ensuite dans panne
    $data_vh = [
        'date_declaration' => $array_shop_ext['date_declaration'],
        'type_panne' => $array_shop_ext['type_panne'],
        'localisation' => $array_shop_ext['localisation'],
        'vehicule_id' => $lastID
    ];
    $sql = "INSERT INTO shop_ext_panne (date_declaration,type_panne_id,localisation,vehicule_id) 
    VALUES (:date_declaration, :type_panne, :localisation, :vehicule_id)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data_vh);

}

function get_compteur_immo($date_declaration, $id)
{
    $date_today = date("Y-m-d");

    $date1 = new DateTime($date_declaration);
    $date2 = new DateTime($date_today);

    // Calcul de la différence entre les deux dates
    $interval = $date1->diff($date2);

    $compteur_immo = $interval->days;

    //on en profite pour update le champ compteur_immo
    $pdo = Connection::getPDO();
    $data = [
        'id' => $id,
        'compteur_immo' => $compteur_immo
    ];
    $sql = "UPDATE shop_ext_vehicules 
    SET compteur_immo=:compteur_immo
    WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);


    return $compteur_immo;
}

function get_last_action($id)
{
    $pdo = Connection::getPDO();

    $request = $pdo->query("SELECT action.action, action.date_action,action.remarque,action.is_factured,action.montant_facture,vh.date_demande_recup,vh.date_recup,vh.agence_recup 
    FROM shop_ext_action AS action
    LEFT JOIN shop_ext_vehicules as vh ON vh.ID = action.vehicule_id
    WHERE action.vehicule_id = $id 
    ORDER BY action.date_action DESC LIMIT 1");
    $result = $request->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        if ($result['is_factured'] == 1) {
            $result['is_factured'] = 'oui';
        }
        return $result;
    } else {
        return array(
            'action' => '',
            'date_action' => '',
            'remarque' => '',
            'is_factured' => '',
            'montant_facture' => '',
            'date_demande_recup' => '',
            'date_recup' => '',
            'agence_recup' => ''
        );

    }

}

function ajout_action($data_new_action)
{

    $pdo = Connection::getPDO();

    $data = [
        'date_action' => $data_new_action['date_action'],
        'action_effectuee' => $data_new_action['action_effectuee'],
        'remarque' => $data_new_action['remarque'],
        'is_action_factured' => $data_new_action['is_action_factured'],
        'montant_action' => $data_new_action['montant_action'],
        'vehicule_id' => $data_new_action['vehicule_id']
    ];

    $sql = "INSERT INTO shop_ext_action (action,date_action,remarque,is_factured,montant_facture,vehicule_id) 
    VALUES (:action_effectuee, :date_action,:remarque, :is_action_factured,:montant_action, :vehicule_id)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);

}

function update_shop_ext($data_shop_ext)
{
    $pdo = Connection::getPDO();

    $data = [
        'immatriculation' => $data_shop_ext['immatriculation'],
        'modele' => $data_shop_ext['modele'],
        'mva' => $data_shop_ext['mva'],
        'km' => $data_shop_ext['km'],
        'garantie' => $data_shop_ext['garantie'],
        'num_contrat' => $data_shop_ext['num_contrat'],
        'date_demande_recup' => $data_shop_ext['date_demande_recup'],
        'date_recup' => $data_shop_ext['date_recup'],
        'agence_recup' => $data_shop_ext['agence_recup'],
        'vehicule_id' => $data_shop_ext['vehicule_id']
    ];

    $sql = "UPDATE shop_ext_vehicules 
    SET immatriculation=:immatriculation, 
    modele=:modele,
    mva=:mva,
    kilometrage=:km,
    garantie=:garantie,
    num_contrat=:num_contrat,
    date_demande_recup=:date_demande_recup,
    date_recup=:date_recup,
    agence_recup=:agence_recup
    WHERE id=:vehicule_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);


    $data = [
        'date_declaration' => $data_shop_ext['date_declaration'],
        'type_panne' => $data_shop_ext['type_panne'],
        'localisation' => $data_shop_ext['localisation'],
        'vehicule_id' => $data_shop_ext['vehicule_id']
    ];
    $sql = "UPDATE shop_ext_panne 
    SET date_declaration=:date_declaration, 
    type_panne_id=:type_panne,
    localisation=:localisation
    WHERE vehicule_id=:vehicule_id";
    $stmt = $pdo->prepare($sql);

    var_dump($stmt);
    $stmt->execute($data);

}