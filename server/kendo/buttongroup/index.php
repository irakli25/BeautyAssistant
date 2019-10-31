<?php
require_once '../include/header.php';
require_once '../lib/Kendo/Autoload.php';

$buttonGroup = new \Kendo\UI\ButtonGroup('select-period');
$month = new \Kendo\UI\ButtonGroupItem();
$month->text("Month");
$quarter = new \Kendo\UI\ButtonGroupItem();
$quarter->text("Quarter");
$year = new \Kendo\UI\ButtonGroupItem();
$year->text("Year");

$buttonGroup->addItem($month, $quarter, $year);
?>

<div class="demo-section k-content">
    <div>
        <?php echo $buttonGroup->render(); ?>
    </div>
</div>

<style>
   .demo-section {
       text-align: center;
   }
</style>
<?php require_once '../include/footer.php'; ?>
