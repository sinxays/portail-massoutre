<?php

include  "../../include.php";

$filtre = array();

if (isset($_POST['id_collaborateur']) && $_POST['id_collaborateur'] !== '') {
    if (isset($_POST['type'])) {

        if (isset($_POST['filtre']) && $_POST['filtre'] == 'date') {
            $date_value = $_POST['date_value'];

            if ($date_value == 'mois_en_cours') {
                $filtre['date'] = array("mois_en_cours");
            }

            elseif ($date_value == 'mois_precedent') {
                $filtre['date'] = array("mois_precedent");
            }
            
            //sinon ça veut dire qu'on a une date personnalisée
            else {
                $date_perso_tmp = explode("_", $date_value);
                $date_debut = $date_perso_tmp[0];
                $date_fin = $date_perso_tmp[1];

                $filtre['date'] = array("date_personnalisee", array("date_debut" => $date_debut, "date_fin" => $date_fin));
            }
            // var_dump($filtre);
        }

        switch ($_POST['type']) {
            case 'reprise':
                $id_collaborateur = $_POST['id_collaborateur'];
                $payplan_detail_collaborateur = get_payplan_detail_reprise_collaborateur($id_collaborateur, $filtre);
                $table = create_table_payplan_detail_reprise_collaborateur($payplan_detail_reprise_collaborateur_table_header_row, $payplan_detail_collaborateur);
                break;
            case 'achat':
                $id_collaborateur = $_POST['id_collaborateur'];
                $payplan_detail_collaborateur = get_payplan_detail_achat_collaborateur($id_collaborateur, $filtre);
                $table = create_table_payplan_detail_achat_collaborateur($payplan_detail_achat_collaborateur_table_header_row, $payplan_detail_collaborateur);
                break;
            case 'achat_mvc':
                $id_collaborateur = $_POST['id_collaborateur'];
                $payplan_detail_collaborateur = get_payplan_detail_achat_mvc_collaborateur($id_collaborateur, $filtre);
                $table = create_table_payplan_detail_achat_collaborateur($payplan_detail_achat_collaborateur_table_header_row, $payplan_detail_collaborateur);
                break;
            case 'pack_first':
                $id_collaborateur = $_POST['id_collaborateur'];
                $payplan_detail_collaborateur = get_payplan_detail_pack_first_collaborateur($id_collaborateur, $filtre);
                $table = create_table_payplan_detail_achat_collaborateur($payplan_detail_achat_collaborateur_table_header_row, $payplan_detail_collaborateur);
                break;
        }
    }
}

echo $table;
