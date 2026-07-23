<?php
include "../../../include.php";

if (isset($_POST)) {
    $action_id = $_POST['action_id'];
    // var_dump($action_id);
    $action = get_action_suivi_lag_from_id($action_id);
    
    if ($action) {
        echo json_encode($action);
    } else {
        // Retourne une erreur si l'action n'est pas trouvée
        echo json_encode(['error' => 'Action not found']);
    }
}