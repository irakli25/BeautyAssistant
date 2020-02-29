<?php
session_start();
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

require_once '../kendo/lib/DataSourceResult.php';
require_once '../kendo/lib/Kendo/Autoload.php';
require_once '../../classes/class.settings.php';
require_once "../../classes/class.db.php";
$db = new DB();
session_start();
$sql_details = array(
	'user' => settings::DB_USER,
	'pass' => settings::DB_PASS,
	'db'   => settings::DB_NAME,
	'host' => settings::DB_HOST
);
$user_id = $_REQUEST['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');

    $request = json_decode(file_get_contents('php://input'));

    $result = new DataSourceResult(
        "mysql:host=$sql_details[host];dbname=$sql_details[db]",
        "$sql_details[user]",
        "$sql_details[pass]",
        array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION )

    );

 
    
    $query= "SELECT o.id `orderid`, f.rand_name `pic`, CONCAT(staff.`name`,' ',staff.surname) `assistant`, GROUP_CONCAT(e.`name`) products, o.price, d.`name` district ,s.`name` street ,o.local_address,  
            CASE
                            WHEN o.`status` = 1 THEN 'მიმდინარე'
                            WHEN o.`status` = 2 THEN 'დადასტურებული'
                            WHEN o.`status` = 3 THEN 'დასრულებული'
                            ELSE 'UNKNOWN'
            END `status`
            
            FROM orders o
            JOIN users staff ON o.staff_id = staff.id
            JOIN users client ON o.client_id = client.id
            JOIN products p ON p.order_id = o.id
            JOIN experience e ON e.id = p.experience_id
            JOIN district d ON d.id = o.district_id
            JOIN street s ON s.id = o.street_id
            JOIN file f ON f.id = staff.img
           WHERE  (client.id = $user_id OR staff.id = $user_id)
            GROUP BY o.id";

    $number = $db->numRows($query);

    echo json_encode($result->read('district', array('id', 'name'), $request,'','',$query,$number));

    exit;
}



$transport = new \Kendo\Data\DataSourceTransport();

$read = new \Kendo\Data\DataSourceTransportRead();

$read->url('server/grid/grid.php?id='.$user_id)
     ->contentType('application/json')
     ->type('POST');

$transport ->read($read)
          ->parameterMap('function(data) {
              return kendo.stringify(data);
          }');

$model = new \Kendo\Data\DataSourceSchemaModel();

$orderid = new \Kendo\Data\DataSourceSchemaModelField('orderid');
$orderid->type('number');

$assistant = new \Kendo\Data\DataSourceSchemaModelField('assistant');
$assistant->type('string');


$pic = new \Kendo\Data\DataSourceSchemaModelField('pic');
$pic->type('string');

$products = new \Kendo\Data\DataSourceSchemaModelField('products');
$products->type('string');

$price = new \Kendo\Data\DataSourceSchemaModelField('price');
$price->type('number');

$district = new \Kendo\Data\DataSourceSchemaModelField('district');
$district->type('string');

$street = new \Kendo\Data\DataSourceSchemaModelField('street');
$street->type('string');

$local_address = new \Kendo\Data\DataSourceSchemaModelField('local_address');
$local_address->type('string');

$status = new \Kendo\Data\DataSourceSchemaModelField('status');
$status->type('string');

$model
      ->addField($orderid)
      ->addField($assistant)
      ->addField($pic)
      ->addField($products)
      ->addField($price)
      ->addField($district)
      ->addField($street)
      ->addField($local_address)
      ->addField($status);


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

$id = new \Kendo\UI\GridColumn();
$id->field('orderid')
            ->width(200)
            ->title('ID');

$assistant_pic = new \Kendo\UI\GridColumn();
$assistant_pic->field('assistant')
            ->template("<div class='customer-photo' style='background-image:url(server/uploads/#: pic #)'></div><div class='customer-name'>#: assistant #</div>")
            ->title('ასისტენტი')
            ->width(240);

$product = new \Kendo\UI\GridColumn();
$product->field('products')

            ->title('მომსახურება');

$amount = new \Kendo\UI\GridColumn();
$amount->field('price')

            ->title('ღირებულება');

$dis = new \Kendo\UI\GridColumn();
$dis->field('district')

            ->title('უბანი');


$str = new \Kendo\UI\GridColumn();
$str->field('street')

            ->title('ქუჩა');

$local = new \Kendo\UI\GridColumn();
$local->field('local_address')
            ->title('ზუსტი მისამართი');


$status = new \Kendo\UI\GridColumn();
$status->field('status')
            ->title('სტატუსი');


$pageable = new Kendo\UI\GridPageable();
$pageable->refresh(true)
      ->pageSizes(true)
      ->buttonCount(5);
      $gridFilterable = new \Kendo\UI\GridFilterable();
      $gridFilterable->mode("row");

$grid->addColumn( $id,$assistant_pic,$product,$amount,$dis,$str,$local,$status)
     ->dataSource($dataSource)
    //  ->columnMenu(true)
    //  ->filterable($gridFilterable)
     ->pageable($pageable)
     ->sortable(true)
     ->attr('style', 'height:300px;width:1500px')

;

// echo $grid->render();


$data= array("page" => '<head><meta charset="utf-8"/></head><body><div>
									
								
'. $grid->render().'

</div></body>');


echo json_encode($data);

?>