<?php

include  "../../include.php";

error_reporting(E_ALL);
ini_set("display_errors", 1);





$payplan = get_commission();
define_payplan_final($payplan);
$table = create_table_commission($commission_table_header_row, $payplan);



echo $table;
