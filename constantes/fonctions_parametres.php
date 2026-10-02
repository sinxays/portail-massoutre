<?php


use App\Connection;


function get_all_users()
{

    $pdo = Connection::getPDO();
    // Récupération des utilisateurs
    $request = $pdo->query("
    SELECT users.id as user_id,users.nom,users.prenom,users.email,users.login,users.role_id,users.actif,roles.id as role_id,roles.libelle_role FROM users 
    LEFT JOIN roles ON roles.id = users.role_id 
    ORDER BY users.id ASC");
    $result = $request->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

?>