<?php
require_once '../include/header.php';
require_once '../lib/Kendo/Autoload.php';
?>

<div id="example" style="text-align: center;">
    <div class="demo-section k-content wide" style="display: inline-block;">
        <h4>MultiViewCalendar Start</h4>
    <?php
    $startMultiViewCalendar = new \Kendo\UI\MultiViewCalendar('startMultiViewCalendar');
    $startMultiViewCalendar->start('decade');

    echo $startMultiViewCalendar->render();

    ?>
    </div>
    <br />
    <div class="demo-section k-content wide" style="display: inline-block;">
        <h4>MultiViewCalendar Depth</h4>
    <?php
    $depthMultiViewCalendar = new \Kendo\UI\MultiViewCalendar('depthMultiViewCalendar');
    $depthMultiViewCalendar->start('year')
            ->depth('year');

    echo $depthMultiViewCalendar->render();
    ?>
    </div>
</div>

<?php require_once '../include/footer.php'; ?>
