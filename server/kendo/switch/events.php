<?php
require_once '../include/header.php';
require_once '../lib/Kendo/Autoload.php';

$switch = new \Kendo\UI\SwitchButton('switch');

$switch -> change('onChange')
?>

<div class="demo-section k-content">
    <div>
        <?php echo $switch->render(); ?>
    </div>
</div>

<div class="box">
    <h4>Console log</h4>
    <div class="console"></div>
</div>

<script>
    function onChange(e) {
        kendoConsole.log("event :: checked (" + e.checked + ")");
    }
</script>

<style>
   .demo-section {
       text-align: center;
   }
</style>
<?php require_once '../include/footer.php'; ?>
