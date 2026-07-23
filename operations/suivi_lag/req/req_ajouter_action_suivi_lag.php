<?php

include "../../../include.php";

if (isset($_POST)) {
    // var_dump($_POST);
    ajout_modif_action_suivi_lag($_POST);
}