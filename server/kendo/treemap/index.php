<?php
require_once '../lib/Kendo/Autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');

    $result = json_decode(file_get_contents('../content/dataviz/js/population-usa.json'));

    echo json_encode($result);

    exit;
}

require_once '../include/header.php';

$transport = new \Kendo\Data\DataSourceTransport();
$transport->read(array('url' => 'index.php', 'type' => 'POST', 'dataType' => 'json'));

$model = new \Kendo\Data\HierarchicalDataSourceSchemaModel();
$model->children("items");

$schema = new \Kendo\Data\HierarchicalDataSourceSchema();
$schema->model($model);

$dataSource = new \Kendo\Data\HierarchicalDataSource();
$dataSource->transport($transport)
           ->schema($schema);

$treeMap = new \Kendo\Dataviz\UI\TreeMap('treeMap');

$treeMap->dataSource($dataSource)
        ->valueField('value')
        ->textField('name')
        ->attr('style', 'height: 600px; font-size; 12px;');

echo $treeMap->render();
?>
)
<div class="box wide">
    <div class="box-col">
        <h4>TreeMap rendering types</h4>
        <ul class="options">
            <li>
                <input id="typeSquarified" name="type"
                            type="radio" value="squarified" checked="checked" autocomplete="off" />
                <label for="typeSquarified">Squarified</label>
            </li>
            <li>
                <input id="typeVertical" name="type"
                            type="radio" value="vertical" autocomplete="off" />
                <label for="typeVertical">Vertical(Slice and Dice)</label>
            </li>
            <li>
                <input id="typeHorizontal" name="type"
                            type="radio" value="horizontal" autocomplete="off" />
                <label for="typeHorizontal">Horizontal(Slice and Dice)</label>
            </li>
        </ul>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(".options").bind("change", refresh);
    });

    function refresh() {
        $("#treeMap").getKendoTreeMap().setOptions({
            type: $("input[name=type]:checked").val()
        });
    }
</script>
<?php require_once '../include/footer.php'; ?>
