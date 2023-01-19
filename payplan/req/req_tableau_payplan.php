<?php

include  "../../include.php";


$payplan = get_payplan();
var_dump($payplan);
die();
$table = create_table_payplan($payplan_table_header_row, $payplan);



echo $table;
