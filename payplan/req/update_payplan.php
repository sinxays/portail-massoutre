<?php

include  "../../include.php";


$payplan = get_payplan();
define_payplan($payplan);
$table = create_table_payplan($payplan_table_header_row, $payplan);



echo $table;
