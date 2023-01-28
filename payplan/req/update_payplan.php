<?php

include  "../../include.php";


$payplan = get_commission();
define_payplan_final($payplan);
$table = create_table_commission($commission_table_header_row, $payplan);



echo $table;
