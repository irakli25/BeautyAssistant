<?php

ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

require_once '../lib/Kendo/Autoload.php';

require_once '../include/header.php';


?>
<div class="box wide">
    <div class="box-col">
        <h4>Cell comments</h4>
        <ul class="options">
            <li>
                <button class="k-button" id="toggle">Click to add / remove comment from A2 cell</button>
            </li>
        </ul>
    </div>
</div>
<?php
$spreadsheet = new \Kendo\UI\Spreadsheet('spreadsheet');

$spreadsheet->attr('style', 'width: 100%; height: 420px');

$sheet = new \Kendo\UI\SpreadsheetSheet();
$sheet->name("Comments");

$spreadsheet->addSheet($sheet);

$row = new \Kendo\UI\SpreadsheetSheetRow();
$sheet->addRow($row);

$cell = new \Kendo\UI\SpreadsheetSheetRowCell();
$row->addCell($cell);

$cell->value("This cell has a comment.");
$cell->bold(true);
$cell->comment("Comment set on the cell with the Spreadsheet initialization.");

$row = new \Kendo\UI\SpreadsheetSheetRow();

$sheet->addRow($row);

$cell = new \Kendo\UI\SpreadsheetSheetRowCell();
$row->addCell($cell);

$cell->value("This cell will get a comment on button click.");
$cell->bold(true);

$column = new \Kendo\UI\SpreadsheetSheetColumn();
$column->width(300);
$sheet->addColumn($column);

echo $spreadsheet->render();
?>

<!-- Include JSZip to enable Excel Export-->
<script src="../content/shared/js/jszip.min.js"></script>
<script>
    $("#toggle").click(function () {
        var range = $("#spreadsheet").getKendoSpreadsheet().activeSheet().range("A2");
        var comment = range.comment();

        if (comment === null) {
            range.comment("Comment added using range API call");
        } else {
            range.comment(null);
        }
    });
</script>

<?php require_once '../include/footer.php'; ?>
