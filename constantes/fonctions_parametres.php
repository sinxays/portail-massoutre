<?php


use App\Connection;


function get_all_users()
{

    $pdo = Connection::getPDO();
    // Récupération des utilisateurs
    $request = $pdo->query("
    SELECT * FROM users 
    LEFT JOIN roles ON roles.id = users.role_id 
    ORDER BY users.id ASC");
    $result = $request->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

?>