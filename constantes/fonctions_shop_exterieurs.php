<?php


use app\Connection;

function get_liste_shop_exterieurs($categorie = '', $immatriculation = '', $mva = '')
{

    $where = "";
    if ($categorie && $categorie !== 0) {
        $where = " WHERE vh.categorie_id = $categorie";
    } else if ($immatriculation && $immatriculation !== '') {
        $where = " WHERE vh.immatriculation LIKE '%$immatriculation%'";
    } else if ($mva && $mva !== '') {
        $where = " WHERE vh.mva LIKE '%$mva%'";
    }

    $pdo = Connection::getPDO();

    $request = $pdo->query("SELECT vh.ID,vh.immatriculation,vh.modele,vh.num_contrat,vh.mva,vh.kilometrage,vh.garantie,vh.date_demande_recup,vh.date_recup,vh.agence_recup,
    cat.libelle,
    type_panne.type_panne_libelle,
    panne.localisation,panne.date_declaration,panne.detail_panne
      FROM shop_ext_vehicules as vh
      LEFT JOIN shop_ext_categories as cat ON vh.categorie_id = cat.id
      LEFT JOIN shop_ext_panne as panne ON vh.id = panne.vehicule_id
      LEFT JOIN shop_ext_type_panne as type_panne ON type_panne.id = panne.type_panne_id
      $where");
    $result_liste = $request->fetchAll(PDO::FETCH_ASSOC);

    // var_dump($request->queryString);


    foreach ($result_liste as $index => $vehicule) {
        $request = $pdo->query("SELECT action.* 
        FROM shop_ext_action as action
        JOIN ( SELECT MAX(action2.ID) as max_id
              FROM shop_ext_action as action2
              LEFT JOIN shop_ext_vehicules AS vh ON vh.ID = action2.vehicule_id
              WHERE date_action = (SELECT MAX(date_action) FROM shop_ext_action WHERE vehicule_id = " . $vehicule['ID'] . ") AND vh.ID = " . $vehicule['ID'] . ") AS subquery ON subquery.max_id = action.ID");

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

    $request = $pdo->query("SELECT vh.ID,vh.immatriculation,vh.modele,vh.num_contrat,vh.mva,vh.kilometrage,vh.garantie,vh.date_demande_recup,vh.date_recup,vh.agence_recup,vh.categorie_id,
    type_panne.type_panne_libelle,
    panne.localisation,panne.date_declaration,panne.detail_panne,
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
        'detail_panne' => $array_shop_ext['detail_panne'],
        'localisation' => $array_shop_ext['localisation'],
        'vehicule_id' => $lastID
    ];
    $sql = "INSERT INTO shop_ext_panne (date_declaration,type_panne_id,localisation,vehicule_id,detail_panne) 
    VALUES (:date_declaration, :type_panne, :localisation, :vehicule_id,:detail_panne)";
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

function ajout_modif_action($data_new_action)
{

    $pdo = Connection::getPDO();

    // si on trouve un ID alors on modifie une action déja existante
    if (isset($data_new_action['action_id']) && $data_new_action['action_id'] !== '') {
        $data = [
            'id_action' => $data_new_action['action_id'],
            'date_action' => $data_new_action['date_action'],
            'action_effectuee' => $data_new_action['action_effectuee'],
            'remarque' => $data_new_action['remarque'],
            'is_action_factured' => $data_new_action['is_action_factured'],
            'montant_action' => $data_new_action['montant_action'],
            'vehicule_id' => $data_new_action['vehicule_id']
        ];

        $sql = "UPDATE shop_ext_action SET action = :action_effectuee,
        date_action =:date_action ,
        remarque=:remarque,
        is_factured=:is_action_factured,
        montant_facture=:montant_action,
        vehicule_id=:vehicule_id 
        WHERE ID =:id_action";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);

    }
    //sinon c'est une nouvelle action
    else {
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
}

function delete_action_by_id($id_action)
{

    $pdo = Connection::getPDO();

    $data = [
        'action_id' => $id_action
    ];

    $sql = 'DELETE FROM shop_ext_action WHERE ID=:action_id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);

}

function get_shop_ext_categories()
{
    $pdo = Connection::getPDO();

    $request = $pdo->query("SELECT * FROM shop_ext_categories");

    $result = $request->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

function update_shop_ext($data_shop_ext)
{

    $pdo = Connection::getPDO();

    $date_demande_recup = $data_shop_ext['date_demande_recup'] !== '' ? $data_shop_ext['date_demande_recup'] : NULL;
    $date_recup = $data_shop_ext['date_recup'] !== '' ? $data_shop_ext['date_recup'] : NULL;


    //update du véhicule
    $data = [
        'immatriculation' => $data_shop_ext['immatriculation'],
        'modele' => $data_shop_ext['modele'],
        'mva' => $data_shop_ext['mva'],
        'km' => $data_shop_ext['km'],
        'garantie' => $data_shop_ext['garantie'],
        'num_contrat' => $data_shop_ext['num_contrat'],
        'date_demande_recup' => $date_demande_recup,
        'date_recup' => $date_recup,
        'agence_recup' => $data_shop_ext['agence_recup'],
        'vehicule_id' => $data_shop_ext['vehicule_id'],
        'categorie_shop_ext' => $data_shop_ext['categorie_shop_ext']
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
    agence_recup=:agence_recup,
    categorie_id=:categorie_shop_ext 
    WHERE id=:vehicule_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);


    //update Panne
    $data = [
        'date_declaration' => $data_shop_ext['date_declaration'],
        'type_panne' => $data_shop_ext['type_panne'],
        'detail_panne' => $data_shop_ext['detail_panne'],
        'localisation' => $data_shop_ext['localisation'],
        'vehicule_id' => $data_shop_ext['vehicule_id']
    ];
    $sql = "UPDATE shop_ext_panne 
    SET date_declaration=:date_declaration, 
    type_panne_id=:type_panne,
    detail_panne=:detail_panne,
    localisation=:localisation
    WHERE vehicule_id=:vehicule_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);

}

function get_action_from_id($id)
{
    $pdo = Connection::getPDO();

    $id_action = intval($id);

    $request = $pdo->query("SELECT * FROM shop_ext_action WHERE ID = $id_action");

    $result_action = $request->fetch(PDO::FETCH_ASSOC);

    return $result_action;
}