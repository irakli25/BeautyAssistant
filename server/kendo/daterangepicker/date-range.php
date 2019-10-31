<?php

require_once '../lib/Kendo/Autoload.php';
require_once '../include/header.php';
?>
<div id="example" style="text-align: center;">
        <div class="demo-section k-content wide" style="display: inline-block;">
                <h4>Select a date range </h4>
        <?php
        $dateRangePicker = new \Kendo\UI\DateRangePicker('daterangepicker');
        $range = new \Kendo\UI\DateRangePickerRange();

        $startDate = new DateTime();
        $endDate = new DateTime();
        $endDate->modify("+7 day");
        $range->start($startDate)
                ->end($endDate);

        $dateRangePicker->range($range)
                ->attr('style', 'width: 100%')
                ->attr('title', 'daterangepicker');

        echo $dateRangePicker->render();
        ?>
        </div>
</div>
<?php require_once '../include/footer.php'; ?>
