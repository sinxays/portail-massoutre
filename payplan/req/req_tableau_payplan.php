<?php

include  "../../include.php";


$payplan = get_payplan();
$table = create_table_payplan($payplan_table_header_row, $payplan);



echo $table;
