<?php

require_once '../lib/Kendo/Autoload.php';
require_once '../include/header.php';
?>
<div class="demo-section k-content">
        <h4>Show e-mails from:</h4>
<?php
$datePicker = new \Kendo\UI\DatePicker('datepicker');

$datePicker->value(new DateTime('10/10/2011', new DateTimeZone('UTC')))
           ->attr('style', 'width: 100%')
           ->attr('title', 'datepicker');

echo $datePicker->render();
?>
<h4 style="margin-top: 2em;">Add to archive mail from:</h4>

<?php
$monthPicker = new \Kendo\UI\DatePicker('monthpicker');

$monthPicker->value(new DateTime('November 2011', new DateTimeZone('UTC')))
            ->start('year')
            ->depth('year')
            ->format('MMMM yyyy')
            ->dateInput(true)
            ->attr('style', 'width: 100%')
            ->attr('title', 'monthpicker');

echo $monthPicker->render();
?>
</div>
<?php require_once '../include/footer.php'; ?>
