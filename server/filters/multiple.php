<?php
header('Content-Type: text/html; charset=utf-8');
require_once '../kendo/lib/DataSourceResult.php';
require_once '../kendo/lib/Kendo/Autoload.php';
require_once '../../classes/class.settings.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

$sql_details = array(
	'user' => settings::DB_USER,
	'pass' => settings::DB_PASS,
	'db'   => settings::DB_NAME,
	'host' => settings::DB_HOST
);


$id = $_REQUEST['id'];
$table_name = $_REQUEST['table_name'];
$list =   $_REQUEST['list'];
$select_id = $_REQUEST['select_id'];

$width = $_REQUEST['width'];

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                header('Content-Type: application/json');

                $request = json_decode(file_get_contents('php://input'));

                $result = new DataSourceResult(
                    "mysql:host=$sql_details[host];dbname=$sql_details[db]",
                    "$sql_details[user]",
                    "$sql_details[pass]",
                    array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION )

                );

                echo json_encode($result->read($table_name, array($id, $list), $request,"up"));

                exit;
            }

            $transport = new \Kendo\Data\DataSourceTransport();

            $read = new \Kendo\Data\DataSourceTransportRead();

            $read->url('server/filters/filter.php?select_id='.$select_id.'&table_name='.$table_name.'&id='.$id.'&list='.$list.'')
                ->contentType('application/json')
                ->type('POST');

            $transport->read($read)
                    ->parameterMap('function(data) {
                        if(!data["filter"].filters.length) {
                            delete data["filter"];
                        }
                        return kendo.stringify(data);
                    }');

            $schema = new \Kendo\Data\DataSourceSchema();
            $schema->data('data')
                ->total($table_name);

            $dataSource = new \Kendo\Data\DataSource();

            $dataSource->transport($transport)
                    ->schema($schema)
                    ->serverFiltering(true);

            $multiselect = new \Kendo\UI\MultiSelect($select_id);

            $multiselect->dataSource($dataSource)
                        ->dataTextField($list)
                        ->dataValueField($id)
                        ->value(array(array("ProductName"=>"Chang","ProductID"=>"2"),array("ProductName"=>"Uncle Bob's Organic Dried Pears","ProductID"=>"7")))
                        ->autoBind(false)
                        ->filter('contains')
                        ->ignoreCase(false)
                        ->attr('style', $width);



            $data= array("page" => '<head><meta charset="utf-8"/></head><body><div class="demo-section k-content">
                        
                    
                    '. $multiselect->render().'
                    
                    </div></body>',"element_id" =>$select_id);
                    

            echo json_encode($data);


?>