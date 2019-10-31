<?php
require_once '../include/header.php';
require_once '../lib/Kendo/Autoload.php';

$switch = new \Kendo\UI\SwitchButton('switch');
?>

<div class="demo-section k-content">
    <div>
        <?php echo $switch->render(); ?>
    </div>
</div>

<style>
   .demo-section {
       text-align: center;
   }
</style>
<?php require_once '../include/footer.php'; ?>
