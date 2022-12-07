<?php

include  "../../include.php";




$payplan = get_payplan();
$table = create_table_payplan($payplan, $payplan_table_header_row);



echo $table;
