<?php
require_once '../include/header.php';
require_once '../lib/Kendo/Autoload.php';
?>
<div id="example" style="text-align: center;">
    <div class="demo-section k-content wide" style="display: inline-block;">
    <div style="margin-bottom: 20px;">
        <?php
        $numberOfViews = new \Kendo\UI\NumericTextBox('numberOfViews');
        $numberOfViews->min(2)
                    ->max(10)
                    ->value(2)
                    ->restrictDecimals(true)
                    ->format("{0:n0}");
        echo $numberOfViews->render();
        $numberOfViewsBtn = new \Kendo\UI\Button('numberOfViewsBtn');
        $numberOfViewsBtn->content("Apply Changes")
                        ->click("click");
        echo $numberOfViewsBtn->render();
        ?>
    </div>
    <?php
    $multiViewCalendar = new \Kendo\UI\MultiViewCalendar('multiViewCalendar');
    $multiViewCalendar->selectable("range")
        ->showViewHeader(true);
    echo $multiViewCalendar->render();
    ?>
    </div>
    <script>
        function click() {
            var numberOfViews = $("#numberOfViews").data().kendoNumericTextBox.value();
            if (numberOfViews > 0) {
                $("#multiViewCalendar").data().kendoMultiViewCalendar.setOptions({ views: numberOfViews });
            }
        }
    </script>
</div>
<?php require_once '../include/footer.php'; ?>
