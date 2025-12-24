<?php

include "../../include.php";

$filtre = array();

if (isset($_POST['collaborateur']) && $_POST['collaborateur'] !== '') {
    $id_collaborateur = intval($_POST['collaborateur']);

    if (isset($_POST['date'])) {

        $date = $_POST['date'];

        $payplan_v2_bdc_factures = get_payplan_v2_detail_bdc_factures_collaborateur($id_collaborateur, $date);
        $payplan_v2_reprises = get_payplan_v2_detail_reprises_collaborateur($id_collaborateur, $date);
        $payplan_v2_garanties = get_payplan_v2_detail_garanties_collaborateur($id_collaborateur, $date);
        $payplan_v2_packfirst = get_payplan_v2_detail_packfirst_collaborateur($id_collaborateur, $date);



        #On assemble le tout sur un seul même tableau final
        $result_final = array();

        // $payplan_v2[0] = les BDC
        // $payplan_v2[0] = les factures

        #creation du tableau final
        foreach ($payplan_v2_bdc_factures[0] as $key => $collaborateur_bdc) {
            $collaborateur_bdc_id = $collaborateur_bdc['id_collaborateur_payplan'];

            $result_final[$key] = [
                'ID' => $collaborateur_bdc_id,
                'nom' => $collaborateur_bdc['nom'],
                'prenom' => $collaborateur_bdc['prenom'],
                'nb_bdc' => (int) $collaborateur_bdc['nb_bdc'],
                'nb_factures' => 0, // valeur par défaut
                'nb_reprises' => 0, // valeur par défaut
                'nb_garanties' => 0, // valeur par défaut
                'cumul_prix_ht_garanties' => 0, // valeur par défaut
                'nb_pack_first' => 0, // valeur par défaut
            ];
        }

        #on y amène les factures dans ce tableau final
        foreach ($payplan_v2_bdc_factures[1] as $key => $value) {
            $id_to_search = $value['id_collaborateur_payplan'];
            foreach ($result_final as $key => $result) {
                if ($result['ID'] == $id_to_search) {
                    $result_final[$key]['nb_factures'] = $value['nb_factures'];
                }
            }
        }

        foreach ($payplan_v2_reprises as $key => $value) {
            $id_to_search = $value['id_collaborateur_payplan'];
            foreach ($result_final as $key => $result) {
                if ($result['ID'] == $id_to_search) {
                    $result_final[$key]['nb_reprises'] = $value['nb_reprises'];
                }
            }
        }

        foreach ($payplan_v2_garanties as $key => $value) {
            $id_to_search = $value['id_collaborateur_payplan'];
            foreach ($result_final as $key => $result) {
                if ($result['ID'] == $id_to_search) {
                    $result_final[$key]['nb_garanties'] = $value['nb_garanties'];
                    $result_final[$key]['cumul_prix_ht_garanties'] = $value['cumul_prix_ht_garantie'];
                }
            }
        }

        foreach ($payplan_v2_packfirst as $key => $value) {
            $id_to_search = $value['id_collaborateur_payplan'];
            foreach ($result_final as $key => $result) {
                if ($result['ID'] == $id_to_search) {
                    $result_final[$key]['nb_pack_first'] = $value['nb_pack_first'];
                }
            }
        }


        // var_dump($result_final);


        $table = create_table_payplan_grille_de_gestion($payplan_v2_table_header_row, $result_final);

    }
}

echo $table;
