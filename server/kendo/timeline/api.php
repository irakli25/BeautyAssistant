<?php
require_once '../lib/Kendo/Autoload.php';
require_once '../include/timeline.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');

    $result = timeline_horizontal_data();

    echo json_encode($result);

    exit;
}

require_once '../include/header.php';

?>
<div class="box wide">
    <div class="box-col">
        <h4>Navigation</h4>
        <ul class="options">
            <li>
                <button class="k-button prev">Previous</button>
                <button class="k-button next">Next</button>
            </li>
        </ul>
    </div>
    <div class="box-col">
        <h4>Open Event at Index</h4>
        <ul class="options">
            <li>
                <?php
                $numeric = new \Kendo\UI\NumericTextBox('eventIndex');
                $numeric->min(0)
                        ->max(20)
                        ->decimals(0)
                        ->format("n0")
                        ->value(0);
                echo $numeric->render();
                ?>
                <button class="openEvent k-button">Open event</button>
            </li>
        </ul>
    </div>
</div>

 <div class="demo-section k-content wide">
<?php

    $transport = new \Kendo\Data\DataSourceTransport();
    $transport->read(array('url' => 'horizontal.php', 'type' => 'POST', 'dataType' => 'json'));;

    $model = new \Kendo\Data\DataSourceSchemaModel();

    $datefield = new \Kendo\Data\DataSourceSchemaModelField('date');
    $datefield->type('date');

    $model->addField($datefield);

    $schema = new \Kendo\Data\DataSourceSchema();
    $schema->model($model);

    $dataSource = new \Kendo\Data\DataSource();

    $dataSource->transport($transport)
               ->schema($schema);


    $timeline = new \Kendo\UI\Timeline('timeline');


    $timeline->orientation("horizontal")
             ->dataSource($dataSource);

    echo $timeline->render();
?>
</div>

<script>
$(document).ready(function () {
    var next = function (e) {
        var timeline = $("#timeline").data("kendoTimeline");
        timeline.next();
    };

    var prev = function (e) {
        var timeline = $("#timeline").data("kendoTimeline");
        timeline.previous();
    };

    var openEvent = function (e) {
        if (e.type != "keypress" || kendo.keys.ENTER == e.keyCode) {
            var timeline = $("#timeline").data("kendoTimeline"),
                eventIndex = $("#eventIndex").val(),
                event = timeline.element.find("li.k-timeline-track-item:not(.k-timeline-flag-wrap)").eq(eventIndex);

            timeline.open(event);
        }
    };


    $(".next").click(next);
    $(".prev").click(prev);

    $(".openEvent").click(openEvent);
    $(".openEvent").keypress(openEvent);
});
</script>

<?php require_once '../include/footer.php'; ?>