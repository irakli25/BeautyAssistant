<?php
require_once '../lib/DataSourceResult.php';
require_once '../lib/Kendo/Autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');

    $request = json_decode(file_get_contents('php://input'));

    $result = new DataSourceResult('sqlite:..//sample.db');

    $type = $_GET['type'];

    $columns = array('ProductID', 'ProductName', 'UnitPrice', 'UnitsInStock', 'Discontinued');

    switch($type) {
        case 'create':
            $result = $result->create('Products', $columns, $request->models, 'ProductID');
            break;
        case 'read':
            $result = $result->read('Products', $columns, $request);
            break;
        case 'update':
            $result = $result->update('Products', $columns, $request->models, 'ProductID');
            break;
        case 'destroy':
            $result = $result->destroy('Products', $request->models, 'ProductID');
            break;
    }

    echo json_encode($result, JSON_NUMERIC_CHECK);

    exit;
}

require_once '../include/header.php';

$transport = new \Kendo\Data\DataSourceTransport();

$create = new \Kendo\Data\DataSourceTransportCreate();

$create->url('adaptive-rendering.php?type=create')
     ->contentType('application/json')
     ->type('POST');

$read = new \Kendo\Data\DataSourceTransportRead();

$read->url('adaptive-rendering.php?type=read')
     ->contentType('application/json')
     ->type('POST');

$update = new \Kendo\Data\DataSourceTransportUpdate();

$update->url('adaptive-rendering.php?type=update')
     ->contentType('application/json')
     ->type('POST');

$destroy = new \Kendo\Data\DataSourceTransportDestroy();

$destroy->url('adaptive-rendering.php?type=destroy')
     ->contentType('application/json')
     ->type('POST');

$transport->create($create)
          ->read($read)
          ->update($update)
          ->destroy($destroy)
          ->parameterMap('function(data) {
              return kendo.stringify(data);
          }');

$model = new \Kendo\Data\DataSourceSchemaModel();

$productIDField = new \Kendo\Data\DataSourceSchemaModelField('ProductID');
$productIDField->type('number')
               ->editable(false)
               ->nullable(true);

$productNameField = new \Kendo\Data\DataSourceSchemaModelField('ProductName');
$productNameField->type('string')
                 ->validation(array('required' => true));


$unitPriceValidation = new \Kendo\Data\DataSourceSchemaModelFieldValidation();
$unitPriceValidation->required(true)
                    ->min(1);

$unitPriceField = new \Kendo\Data\DataSourceSchemaModelField('UnitPrice');
$unitPriceField->type('number')
               ->validation($unitPriceValidation);

$unitsInStockField = new \Kendo\Data\DataSourceSchemaModelField('UnitsInStock');
$unitsInStockField->type('number');

$discontinuedField = new \Kendo\Data\DataSourceSchemaModelField('Discontinued');
$discontinuedField->type('boolean');

$model->id('ProductID')
    ->addField($productIDField)
    ->addField($productNameField)
    ->addField($unitPriceField)
    ->addField($unitsInStockField)
    ->addField($discontinuedField);

$schema = new \Kendo\Data\DataSourceSchema();
$schema->data('data')
       ->errors('errors')
       ->model($model)
       ->total('total');

$dataSource = new \Kendo\Data\DataSource();

$dataSource->transport($transport)
           ->batch(true)
           ->pageSize(20)
           ->schema($schema);

$grid = new \Kendo\UI\Grid('grid');

$columnFilterable = new \Kendo\UI\GridColumnFilterable();
$columnFilterable->multi(true)->search(true);

$productName = new \Kendo\UI\GridColumn();
$productName->field('ProductName')
            ->width(120)
            ->filterable($columnFilterable)
            ->title('Product Name');

$unitPrice = new \Kendo\UI\GridColumn();
$unitPrice->field('UnitPrice')
          ->format('{0:c}')
          ->width(120)
          ->title('Unit Price');

$unitsInStock = new \Kendo\UI\GridColumn();
$unitsInStock->field('UnitsInStock')
          ->width(120)
          ->title('Units In Stock');

$discontinued = new \Kendo\UI\GridColumn();
$discontinued->field('Discontinued')
          ->width(120);

$command = new \Kendo\UI\GridColumn();
$command->addCommandItem('edit')
        ->addCommandItem('destroy')
        ->title('&nbsp;')
        ->width(250);

$grid->addColumn($productName, $unitPrice, $unitsInStock, $discontinued, $command)
     ->dataSource($dataSource)
     ->addToolbarItem(new \Kendo\UI\GridToolbarItem('create'))
     ->height(450)
     ->mobile(true)
     ->sortable(true)
     ->pageable(true)
     ->resizable(true)
     ->filterable(true)
     ->columnMenu(true)
     ->editable('popup');

$qrBorder =  new \Kendo\Dataviz\UI\QRCodeBorder();
$qrBorder->color("#000000")
            ->width(5);

$qr = new \Kendo\Dataviz\UI\QRCode('qr');
$qr->value("https://demos.telerik.com/php-ui/grid/adaptive-rendering")
    ->size(170)
    ->attr('style', 'display: inline-block; margin-top: 1em;')
    ->border($qrBorder);

echo '<div id="qr-wrap" style="text-align: center;">'
    . '<p>To test the Adaptive Rendering, scan the QR code or open this demo on a mobile device.</p>'
    . $qr->render()
    . '</div>';
echo '<div id="grid-wrap" style="display: none;">' . $grid->render() . '</div>';
?>

<script>
    $(document).ready(function () {
        var isMobile = Boolean(kendo.support.mobileOS);

        if (isMobile) {
            $("#qr-wrap").hide();
            $("#grid-wrap").show();
            $("#grid").data("kendoGrid").resize();
        }
    });
</script>

<?php require_once '../include/footer.php'; ?>
