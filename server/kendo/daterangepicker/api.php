<?php

require_once '../lib/Kendo/Autoload.php';
require_once '../include/header.php';
?>

<div id="example" style="text-align: center;">
    <div class="demo-section k-content wide" style="display: inline-block;">
        <h4>Select a date range </h4>
    <?php
    $dateRangePicker = new \Kendo\UI\DateRangePicker('daterangepicker');
    $dateRangePicker->attr('style', 'width: 100%')
    ->attr('title', 'daterangepicker');
    echo $dateRangePicker->render();
    ?>
    </div>

    <div class="box wide">
        <div class="box wide">
            <div class="box-col">
                <h4>Open / Close</h4>
                <ul class="options">
                    <li>
                        <button id="open" class="k-button">Open</button>
                        <button id="close" class="k-button">Close</button>
                    </li>
                </ul>
            </div>
            <div class="box-col">
                <h4>Set / Get Value</h4>
                <ul class="options">
                    <li>
                        <input id="startValue" value="1/19/2019" style="float:none" />
                        <input id="endValue" value="2/28/2019" style="float:none" />
                        <button id="set" class="k-button">Set value</button>
                    </li>
                    <li style="text-align: right;">
                        <button id="get" class="k-button">Get value</button>
                    </li>
                </ul>
            </div>
            <div class="box-col">
                <h4>Enable / Disable</h4>
                <ul class="options">
                    <li>
                        <button id="enable" class="k-button">Enable</button>
                        <button id="disable" class="k-button">Disable</button>
                        <button id="readonly" class="k-button">Readonly</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var startDate = $("#startValue").kendoDatePicker().data("kendoDatePicker");
            var endDate = $("#endValue").kendoDatePicker().data("kendoDatePicker");

            var dateRangePicker = $("#daterangepicker").data("kendoDateRangePicker");

            var setValue = function () {
                var range = { start: startDate.value(), end: endDate.value() };
                dateRangePicker.range(range);
            };

            $("#enable").click(function() {
                dateRangePicker.enable();
            });

            $("#disable").click(function() {
                dateRangePicker.enable(false);
            });

            $("#readonly").click(function() {
                dateRangePicker.readonly();
            });

            $("#open").click(function() {
                dateRangePicker.open();
            });

            $("#close").click(function() {
                dateRangePicker.close();
            });

            $("#set").click(setValue);

            $("#get").click(function() {
                var range = dateRangePicker.range()
                alert("Start - " + range.start + " End - " + range.end);
            });
        });
    </script>
    <style>
    .box .k-textbox {
        width: 80px;
    }
    .box .k-button {
        min-width: 80px;
    }
    </style>
</div>

<?php require_once '../include/footer.php'; ?>
