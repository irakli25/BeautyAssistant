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

<?php require_once '../include/footer.php'; ?>