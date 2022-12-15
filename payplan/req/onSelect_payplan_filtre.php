<?php

include  "../../include.php";

//filtre destination
if ($_POST["destination"] && $_POST["destination"] !== "") {
    $destination = $_POST["destination"];
    if ($destination !== 'tout') {
        $filtre['destination'] = $_POST["destination"];
    } else {
        $filtre = '';
    }

    $payplan = get_payplan($filtre);
    $table = create_table_payplan($payplan_table_header_row, $payplan);

    echo $table;
}
