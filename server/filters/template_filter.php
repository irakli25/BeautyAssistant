<?php
header('Content-Type: text/html; charset=utf-8');
require_once '../kendo/lib/DataSourceResult.php';
require_once '../kendo/lib/Kendo/Autoload.php';
require_once '../../classes/class.settings.php';


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

$exp = $_REQUEST['exp'];
$dist = $_REQUEST['dist'];

if (is_array($exp)){
	$expe = implode(",",$exp);
	$size = sizeof($exp);
}
else{
	$expe = $exp;
	$arr = explode(",",$exp);
	$size = sizeof($arr);
}


$query = "SELECT 0 AS id , 'ასისტენტი' AS name, '' AS 'img'  

UNION  SELECT users.id,  users.name, users.img 

FROM users 

JOIN user_experience ON user_experience.user_id = users.id
JOIN user_district ON user_district.user_id = users.id

WHERE  users.active = 1 AND users.name is not null AND user_experience.experience_id in ($expe) AND user_district.district_id = $dist
group by users.id
having count(distinct  user_experience.experience_id) = $size";


						if ($_SERVER['REQUEST_METHOD'] == 'POST') {
							header('Content-Type: application/json');

							$request = json_decode(file_get_contents('php://input'));

							$result = new DataSourceResult(
								"mysql:host=$sql_details[host];dbname=$sql_details[db]",
								"$sql_details[user]",
								"$sql_details[pass]",
								array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION )

							);

							echo json_encode($result->read($table_name, array($id, $list,'img'), $request,"temp", '', $query));

							exit;
						}
						
						$transport = new \Kendo\Data\DataSourceTransport();

						$read = new \Kendo\Data\DataSourceTransportRead();

						$read->url('server/filters/template_filter.php?select_id='.$select_id.'&table_name='.$table_name.'&id='.$id.'&list='.$list.'&width='.$width.'&exp='.$expe.'&dist='.$dist)
							->contentType('application/json')
							->type('POST');

						$transport->read($read)
								->parameterMap('function(data) {
									return kendo.stringify(data);
								}');

						$schema = new \Kendo\Data\DataSourceSchema();
						$schema->data('data')
							->total($table_name);

						$dataSource = new \Kendo\Data\DataSource();

						$dataSource->transport($transport)
								->schema($schema)
								->serverFiltering(true);

						$dropDownList = new \Kendo\UI\DropDownList($select_id);

						$dropDownList->dataSource($dataSource)
									->value(0)
									->dataTextField($list)
									->dataValueField($id)
									->filter('contains')
									->ignoreCase(false)
									
             ->template(<<<TEMPLATE
<span class="non-selected-value" background style= "#: get_img(data.img) #" ></span><span ><h3>#: data.name #</h3></span>
TEMPLATE
            ) ->valueTemplate(<<<TEMPLATE
            <span class="selected-value" background style= "#: get_img(data.img) #" />
            <span>#: data.name #</span>
TEMPLATE
            )
									->attr('style', $width);

									$data= array("page" => '<head><meta charset="utf-8"/></head><body><div class="demo-section k-content">
									
								
								'. $dropDownList->render().'
								
								</div></body>',"element_id" =>$select_id);


                                echo json_encode($data);



								function get_test(){return "test";}
?>