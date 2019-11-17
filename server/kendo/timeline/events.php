<?php
require_once '../lib/Kendo/Autoload.php';
require_once '../include/timeline.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');

    $result = timeline_templates_data();

    echo json_encode($result);

    exit;
}

require_once '../include/header.php';

?>

 <div class="demo-section k-content wide">
<?php

    $transport = new \Kendo\Data\DataSourceTransport();
    $transport->read(array('url' => 'templates.php', 'type' => 'POST', 'dataType' => 'json'));;

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
             ->dataSource($dataSource)
             ->eventTemplateId("eventTemplate")
             ->change("onChange")
             ->navigate("onNavigate")
             ->actionClick("onActionClick")
             ->dataBound("onDataBound");

    echo $timeline->render();
?>
</div>

<div class="box wide">
    <h4>Console log</h4>
    <div class="console"></div>
</div>

<script id="eventTemplate" type="text/x-kendo-template">
    <div class="k-card-header">
        <h5 class="k-card-title">#= data.title #</h5>
        <h6 class="k-card-subtitle"><strong>#= kendo.toString(data.date, "MMM d, yyyy")#</strong></h6>
    </div>
    <div class="k-card-body">
        <div class="k-card-description">
            <p>#= data.description #</p>
        </div>
    </div>
    <div class="k-card-actions">
        <a class="k-button k-flat k-primary" href="#= data.actions[0].url #" target="_blank">#= data.actions[0].text #</a>
    </div>
</script>

<script>
    function onChange(e) {
        kendoConsole.log("Event Title: " + e.dataItem.title);
    }

    function onNavigate(e) {
        kendoConsole.log("Action: " + e.action);
    }

    function onActionClick(e) {
        kendoConsole.log("Action text: " + e.element.text());
    }

    function onDataBound(e) {
        kendoConsole.log("Events count: " + e.sender.dataSource.view().length);
    }
</script>

<style>
    .demo-section, .box {
        max-width: 1200px;
    }
</style>

<?php require_once '../include/footer.php'; ?>