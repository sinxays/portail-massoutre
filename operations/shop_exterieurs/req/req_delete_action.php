<?php

include "../../../include.php";

if (isset($_POST)) {

    $action_id = intval($_POST['id_action']);

    delete_action_by_id($action_id);

}