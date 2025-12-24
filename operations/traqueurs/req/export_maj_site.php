<?php
require $_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php'; // Inclut PhpSpreadsheet
include $_SERVER["DOCUMENT_ROOT"] . "/include.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$filename = 'export_maj_site.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Requête SQL pour récupérer les traqueurs actifs et non exportés
$traqueurs = get_liste_traqueurs_to_export_maj_site();


// Crée un nouveau fichier Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Ajoute les en-têtes
$row = 1;

$sheet->setCellValue('A' . $row, 'Numéro de série');
$sheet->setCellValue('B' . $row, 'Imei');
$sheet->setCellValue('C' . $row, 'Sim');
$sheet->setCellValue('D' . $row, 'Immatriculation');
$sheet->setCellValue('E' . $row, 'Type');
$sheet->setCellValue('F' . $row, 'Mva');
$sheet->setCellValue('G' . $row, 'Date d\'installation');

// Ajoute les données
$row = 2; // Commence à la ligne 2 (après les en-têtes)
foreach ($traqueurs as $key => $traqueur) {
    $sheet->setCellValue('A' . $row, $traqueur['serial_number']);
    $sheet->setCellValue('B' . $row, $traqueur['imei']);
    $sheet->setCellValue('C' . $row, $traqueur['sim']);
    $sheet->setCellValue('D' . $row, $traqueur['immatriculation']);
    $sheet->setCellValue('E' . $row, $traqueur['type']);
    $sheet->setCellValue('F' . $row, $traqueur['mva']);

    $date_installation = format_date_US_TO_FR($traqueur['date_installation']);
    $sheet->setCellValue('G' . $row, $date_installation);

    //on en profite pour passer le traqueur a l'état exporté
    set_export_traqueur($traqueur['ID']);

    $row++;
}

// Écrit le fichier Excel dans la sortie
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');