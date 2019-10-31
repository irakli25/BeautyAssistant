<?php
require_once '../include/header.php';
require_once '../lib/Kendo/Autoload.php';
?>
<div id="example">
    <div style="text-align: center;">
        <div class="demo-section k-content wide" style="display: inline-block;">
            <h4>Pick a date</h4>
        <?php
        $multiViewCalendar = new \Kendo\UI\MultiViewCalendar('multiViewCalendar');
        $multiViewCalendar->value(new DateTime('today', new DateTimeZone('UTC')))
                        ->selectable("range");

        echo $multiViewCalendar->render();
        ?>
        </div>
    </div>

    <div class="box wide">
        <div class="box-col">
            <h4>Get value</h4>
            <ul class="options">
                <li>
                    <button id="get" class="k-button">Get range</button>
                </li>
            </ul>
        </div>
        <div class="box-col">
            <h4>Set value</h4>
            <ul class="options">
                <li>
                    <input id="startValue" />
                    <button id="set" class="k-button">Set range</button>
                    <br />
                    <input id="endValue" />
                </li>
            </ul>
        </div>
        <div class="box-col">
            <h4>Navigation</h4>
            <ul class="options">
                <li>
                    <select id="direction">
                        <option value="up">upper view</option>
                        <option value="down">lower view</option>
                        <option value="past">past</option>
                        <option value="future" selected="selected">future</option>
                    </select>
                    <button id="navigate" class="k-button">Navigate</button>
                </li>
            </ul>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            var today = new Date();
            var multiViewCalendar = $("#multiViewCalendar").data("kendoMultiViewCalendar");
            multiViewCalendar.value(today);

            var navigate = function () {
                var value = $("#direction").val();
                switch (value) {
                    case "up":
                        multiViewCalendar.navigateUp();
                        break;
                    case "down":
                        multiViewCalendar.navigateDown(new Date());
                        break;
                    case "past":
                        multiViewCalendar.navigateToPast();
                        break;
                    default:
                        multiViewCalendar.navigateToFuture();
                        break;
                }
            },
            setValue = function () {
                var start = $("#startValue").data("kendoDatePicker").value();
                var end = $("#endValue").data("kendoDatePicker").value();
                if (start && end && +start < +end) {
                    multiViewCalendar.selectRange({start: start, end: end});
                }
            };

            $("#get").click(function () {
                var multiViewCalendar = $("#multiViewCalendar").data().kendoMultiViewCalendar;
                var range = multiViewCalendar.selectRange();
                if (range.start && range.end) {
                    var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                    alert("Start: " + range.start.toLocaleDateString("en-US", options) + "\nEnd: " + range.end.toLocaleDateString("en-US", options));
                } else {
                    alert("Please select a range");
                }
            });

            $("#startValue").kendoDatePicker({
                value: today
            });

            $("#endValue").kendoDatePicker({
                value: new Date(today.getFullYear(), today.getMonth(), today.getDate() + 10)
            });

            $("#set").click(setValue);

            $("#direction").kendoDropDownList({
                change: navigate
            });

            $("#navigate").click(navigate);
        });
    </script>
</div>

<?php require_once '../include/footer.php'; ?>
