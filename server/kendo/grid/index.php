<?php
require_once '../lib/DataSourceResult.php';
require_once '../lib/Kendo/Autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');

    $request = json_decode(file_get_contents('php://input'));

    $result = new DataSourceResult('sqlite:..//sample.db');

    echo json_encode($result->read('Customers', array('CustomerID', 'ContactName', 'ContactTitle', 'CompanyName', 'Country'), $request));

    exit;
}

require_once '../include/header.php';

$transport = new \Kendo\Data\DataSourceTransport();

$read = new \Kendo\Data\DataSourceTransportRead();

$read->url('index.php')
     ->contentType('application/json')
     ->type('POST');

$transport ->read($read)
          ->parameterMap('function(data) {
              return kendo.stringify(data);
          }');

$model = new \Kendo\Data\DataSourceSchemaModel();

$contactNameField = new \Kendo\Data\DataSourceSchemaModelField('ContactName');
$contactNameField->type('string');

$contactTitleField = new \Kendo\Data\DataSourceSchemaModelField('ContactTitle');
$contactTitleField->type('string');

$companyNameField = new \Kendo\Data\DataSourceSchemaModelField('CompanyName');
$companyNameField->type('string');

$countryField = new \Kendo\Data\DataSourceSchemaModelField('Country');
$countryField->type('string');

$model->addField($contactNameField)
      ->addField($contactTitleField)
      ->addField($companyNameField)
      ->addField($countryField);

$schema = new \Kendo\Data\DataSourceSchema();
$schema->data('data')
       ->errors('errors')
       ->groups('groups')
       ->model($model)
       ->total('total');

$dataSource = new \Kendo\Data\DataSource();

$dataSource->transport($transport)
           ->pageSize(10)
           ->serverPaging(true)
           ->serverSorting(true)
           ->serverGrouping(true)
           ->schema($schema);

$grid = new \Kendo\UI\Grid('grid');

$contactName = new \Kendo\UI\GridColumn();
$contactName->field('ContactName')
            ->template("<div class='customer-photo'style='background-image: url(../content/web/Customers/#:data.CustomerID#.jpg);'></div><div class='customer-name'>#: ContactName #</div>")
            ->title('Contact Name')
            ->width(240);

$contactTitle = new \Kendo\UI\GridColumn();
$contactTitle->field('ContactTitle')
            ->title('Contact Title');

$companyName = new \Kendo\UI\GridColumn();
$companyName->field('CompanyName')
            ->title('Company Name');

$Country = new \Kendo\UI\GridColumn();
$Country->field('Country')
        ->width(150);

$pageable = new Kendo\UI\GridPageable();
$pageable->refresh(true)
      ->pageSizes(true)
      ->buttonCount(5);

$grid->addColumn($contactName, $contactTitle, $companyName, $Country)
     ->dataSource($dataSource)
     ->sortable(true)
     ->groupable(true)
     ->pageable($pageable)
     ->attr('style', 'height:550px');

echo $grid->render();
?>

<style type="text/css">
    .customer-photo {
        display: inline-block;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-size: 32px 35px;
        background-position: center center;
        vertical-align: middle;
        line-height: 32px;
        box-shadow: inset 0 0 1px #999, inset 0 0 10px rgba(0,0,0,.2);
        margin-left: 5px;
    }

    .customer-name {
        display: inline-block;
        vertical-align: middle;
        line-height: 32px;
        padding-left: 3px;
    }
</style>

<?php require_once '../include/footer.php'; ?>
