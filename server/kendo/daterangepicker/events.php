<?php

require_once '../lib/Kendo/Autoload.php';
require_once '../include/header.php';
?>
<div id="example" style="text-align: center;">
    <div class="demo-section k-content wide" style="display: inline-block;">
        <h4>Select a date range </h4>
    <?php
    $dateRangePicker = new \Kendo\UI\DateRangePicker('daterangepicker');
    $dateRangePicker->open('onOpen')
            ->close('onClose')
            ->change('onChange')
            ->attr('style', 'width: 100%')
            ->attr('title', 'daterangepicker');

    echo $dateRangePicker->render();
    ?>
    </div>
        <div class="box">
        <h4>Console log</h4>
        <div class="console"></div>
    </div>
</div>
<script>
    function onOpen() {
        kendoConsole.log("Open");
    }

    function onClose() {
        kendoConsole.log("Close");
    }

    function onChange() {
        var range = this.range();
        kendoConsole.log("Change :: start - " + kendo.toString(range.start, 'd') + " end - " + kendo.toString(range.end, 'd'));
    }
</script>
<?php require_once '../include/footer.php'; ?>
