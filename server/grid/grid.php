<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../kendo/lib/DataSourceResult.php';
require_once '../kendo/lib/Kendo/Autoload.php';
require_once '../../classes/class.settings.php';
require_once "../../classes/class.db.php";

session_start();
$sql_details = array(
	'user' => settings::DB_USER,
	'pass' => settings::DB_PASS,
	'db'   => settings::DB_NAME,
	'host' => settings::DB_HOST
);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');

    $request = json_decode(file_get_contents('php://input'));

    $result = new DataSourceResult(
        "mysql:host=$sql_details[host];dbname=$sql_details[db]",
        "$sql_details[user]",
        "$sql_details[pass]",
        array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION )

    );

    echo json_encode($result->read('district', array('id', 'name'), $request));

    exit;
}

$transport = new \Kendo\Data\DataSourceTransport();

$read = new \Kendo\Data\DataSourceTransportRead();

$read->url('server/grid/grid.php')
     ->contentType('application/json')
     ->type('POST');

$transport ->read($read)
          ->parameterMap('function(data) {
              return kendo.stringify(data);
          }');

$model = new \Kendo\Data\DataSourceSchemaModel();

// $contactNameField = new \Kendo\Data\DataSourceSchemaModelField('ContactName');
// $contactNameField->type('string');

$contactTitleField = new \Kendo\Data\DataSourceSchemaModelField('id');
$contactTitleField->type('string');

$companyNameField = new \Kendo\Data\DataSourceSchemaModelField('name');
$companyNameField->type('string');

// $countryField = new \Kendo\Data\DataSourceSchemaModelField('Country');
// $countryField->type('string');

$model
// ->addField($contactNameField)
      ->addField($contactTitleField)
      ->addField($companyNameField);
    //   ->addField($countryField);

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

// $contactName = new \Kendo\UI\GridColumn();
// $contactName->field('ContactName')
//             ->template("<div class='customer-photo'style='background-image: url(../content/web/Customers/#:data.CustomerID#.jpg);'></div><div class='customer-name'>#: ContactName #</div>")
//             ->title('Contact Name')
//             ->width(240);

$contactTitle = new \Kendo\UI\GridColumn();
$contactTitle->field('id')
            ->title('Contact Title');

$companyName = new \Kendo\UI\GridColumn();
$companyName->field('name')
            ->title('Company Name');

// $Country = new \Kendo\UI\GridColumn();
// $Country->field('Country')
//         ->width(150);

$pageable = new Kendo\UI\GridPageable();
$pageable->refresh(true)
      ->pageSizes(true)
      ->buttonCount(5);

$grid->addColumn( $contactTitle, $companyName)
     ->dataSource($dataSource)
    //  ->groupable(true)
     ->addToolbarItem(new \Kendo\UI\GridToolbarItem('search'))
     ->columnMenu(true)
    ->pageable($pageable)
    ->sortable(true)
;

// echo $grid->render();


$data= array("page" => '<head><meta charset="utf-8"/></head><body><div>
									
								
'. $grid->render().'

</div></body>');


echo json_encode($data);

?>