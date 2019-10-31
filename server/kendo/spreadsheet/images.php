<?php
require_once '../lib/Kendo/Autoload.php';
require_once '../include/header.php';

$spreadsheet = new \Kendo\UI\Spreadsheet('spreadsheet');
$spreadsheet->attr('style', 'width: 100%;');


$fido = array('testImage' => "..\\\content\\\web\\\spreadsheet\\\sample-image.png");
$fido = (object)$fido;
$spreadsheet->images($fido);


$sheet = new \Kendo\UI\SpreadsheetSheet();
$sheet->name("Food Order");
$spreadsheet->addSheet($sheet);


$drawing = new \Kendo\UI\SpreadsheetSheetDrawing();

$drawing->topLeftCell("E3");
$drawing->offsetX(30);
$drawing->offsetY(10);
$drawing->width(450);
$drawing->height(330);
$drawing->image("testImage");

$sheet -> addDrawing($drawing);


$row = new \Kendo\UI\SpreadsheetSheetRow();
$sheet->addRow($row);

$cell = new \Kendo\UI\SpreadsheetSheetRowCell();
$row->addCell($cell);

$cell->value("ID");
$cell->textAlign("center");
$cell->background("rgb(167,214,255)");
$cell->color("rgb(0,62,117)");

$cell = new \Kendo\UI\SpreadsheetSheetRowCell();
$row->addCell($cell);

$cell->value("Product");
$cell->textAlign("center");
$cell->background("rgb(167,214,255)");
$cell->color("rgb(0,62,117)");


$row = new \Kendo\UI\SpreadsheetSheetRow();
$sheet->addRow($row);

$cell = new \Kendo\UI\SpreadsheetSheetRowCell();
$row->addCell($cell);

$cell->value("216321");
$cell->textAlign("center");
$cell->background("rgb(255,255,255)");
$cell->color("rgb(0,62,117)");

$cell = new \Kendo\UI\SpreadsheetSheetRowCell();
$row->addCell($cell);

$cell->value("Calzone");
$cell->background("rgb(255,255,255)");
$cell->color("rgb(0,62,117)");


$row = new \Kendo\UI\SpreadsheetSheetRow();
$sheet->addRow($row);

$cell = new \Kendo\UI\SpreadsheetSheetRowCell();
$row->addCell($cell);

$cell->value("546897");
$cell->textAlign("center");
$cell->background("rgb(229,243,255)");
$cell->color("rgb(0,62,117)");

$cell = new \Kendo\UI\SpreadsheetSheetRowCell();
$row->addCell($cell);

$cell->value("Margarita");
$cell->background("rgb(229,243,255)");
$cell->color("rgb(0,62,117)");


$row = new \Kendo\UI\SpreadsheetSheetRow();
$sheet->addRow($row);

$cell = new \Kendo\UI\SpreadsheetSheetRowCell();
$row->addCell($cell);

$cell->value("456231");
$cell->textAlign("center");
$cell->background("rgb(255,255,255)");
$cell->color("rgb(0,62,117)");

$cell = new \Kendo\UI\SpreadsheetSheetRowCell();
$row->addCell($cell);

$cell->value("Pollo Formaggio");
$cell->background("rgb(255,255,255)");
$cell->color("rgb(0,62,117)");


$row = new \Kendo\UI\SpreadsheetSheetRow();
$sheet->addRow($row);

$cell = new \Kendo\UI\SpreadsheetSheetRowCell();
$row->addCell($cell);

$cell->value("455873");
$cell->textAlign("center");
$cell->background("rgb(229,243,255)");
$cell->color("rgb(0,62,117)");

$cell = new \Kendo\UI\SpreadsheetSheetRowCell();
$row->addCell($cell);

$cell->value("Greek Salad");
$cell->background("rgb(229,243,255)");
$cell->color("rgb(0,62,117)");


$row = new \Kendo\UI\SpreadsheetSheetRow();
$sheet->addRow($row);

$cell = new \Kendo\UI\SpreadsheetSheetRowCell();
$row->addCell($cell);

$cell->value("456892");
$cell->textAlign("center");
$cell->background("rgb(255,255,255)");
$cell->color("rgb(0,62,117)");

$cell = new \Kendo\UI\SpreadsheetSheetRowCell();
$row->addCell($cell);

$cell->value("Spinach and Blue Cheese");
$cell->background("rgb(255,255,255)");
$cell->color("rgb(0,62,117)");


$column = new \Kendo\UI\SpreadsheetSheetColumn();
$column->width(100);
$sheet->addColumn($column);

$column = new \Kendo\UI\SpreadsheetSheetColumn();
$column->width(215);
$sheet->addColumn($column);


echo $spreadsheet->render();
?>

<!-- Include JSZip to enable Excel Export-->
<script src="../content/shared/js/jszip.min.js"></script>

<?php require_once '../include/footer.php'; ?>
