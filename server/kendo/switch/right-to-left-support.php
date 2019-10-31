<?php
require_once '../include/header.php';
require_once '../lib/Kendo/Autoload.php';

$switch = new \Kendo\UI\SwitchButton('switch');
?>

<div class="demo-section k-rtl k-content">
    <div>
        <?php echo $switch->render(); ?>
    </div>
</div>

<?php require_once '../include/footer.php'; ?>
