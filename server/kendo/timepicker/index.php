<?php
require_once '../include/header.php';
require_once '../lib/Kendo/Autoload.php';
?>
<div class="demo-section k-content">
    <h4>Set alarm time</h4>
<?php
$timePicker = new \Kendo\UI\TimePicker('timepicker');
$timePicker->value('10:00 AM');
$timePicker->attr('style', 'width: 100%');
$timePicker->attr('title', 'timepicker')
$timePicker->dateInput(true);

echo $timePicker->render();
?>
  <h4 style="padding-top: 2em;">Alarm description</h4>
  <input id="descr" class="k-textbox" type="text" value="Wake up" style="width: 100%" />
</div>
<?php require_once '../include/footer.php'; ?>
