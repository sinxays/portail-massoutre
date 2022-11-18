<?php

include  "../../include.php";

$agences = get_all_agences();
$table = create_table_marges($marges_table_header_row, $agences);

echo $table;
