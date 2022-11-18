<?php

include "../include.php";


// if (!empty($_FILES['csv_file']['tmp_name']) && !empty($_POST['date_import'])) {



$filename = $_FILES["csv_file"]["tmp_name"];;

$date = $_POST['date_csv'];

import_csv_stats_journaliere($filename, $date);

alimenter_tableau_stats_journalieres($date);

echo "import et alimentation OK";