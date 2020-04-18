<?php
header('Content-Type: text/html; charset=utf-8');
require_once '../kendo/lib/DataSourceResult.php';
require_once '../kendo/lib/Kendo/Autoload.php';
require_once '../../classes/class.settings.php';
require_once "../../classes/class.db.php";
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
session_start();
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
$where = $_REQUEST['where'];
$width = $_REQUEST['width'];
$get_val   = $_REQUEST['get_val'];
$profile  = $_REQUEST['profile'];
$query ="";



if(!isset($_REQUEST['arr']) || $_REQUEST['arr'] =='')
    $value = get_val($table_name,$get_val);
    else{
        $arr = $_REQUEST['arr'];
        $value = get_in($arr,$table_name);
    }


if($select_id == "calc_district" && $profile != ""){
    $query ="SELECT district.id, 	district.`name`

    FROM district
    JOIN user_district ON district_id = district.id
    WHERE user_district.user_id = '$profile'";
}

						if ($_SERVER['REQUEST_METHOD'] == 'POST') {
							header('Content-Type: application/json');

							$request = json_decode(file_get_contents('php://input'));

							$result = new DataSourceResult(
								"mysql:host=$sql_details[host];dbname=$sql_details[db]",
								"$sql_details[user]",
								"$sql_details[pass]",
								array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION )

							);

							echo json_encode($result->read($table_name, array($id, $list), $request,"first",$where,$query));

							exit;
						}
						
						$transport = new \Kendo\Data\DataSourceTransport();

						$read = new \Kendo\Data\DataSourceTransportRead();

						$read->url('server/filters/filter.php?select_id='.$select_id.'&table_name='.$table_name.'&id='.$id.'&list='.$list.'&width='.$width.'&where='.$where.'&get_val='.$get_val.'&profile='.$profile)
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
									->value($value)
									->dataTextField($list)
									->dataValueField($id)
									->filter('contains')
									->ignoreCase(false)
									// ->animation(false)
									->attr('style', $width);

									$data= array("page" => '<head><meta charset="utf-8"/></head><body><div class="demo-section k-content">
									
								
								'. $dropDownList->render().'
								
								</div></body>',"element_id" =>$select_id,"where"  => $where);


								echo json_encode($data);
					
								



	function get_val($table_name,$get){
		$table = "user_".$table_name;
		$id = $table_name."_id";
		$db = new DB();
		$user_id = $_SESSION['USER'];
		$arr = array();
		$query = "SELECT `$id` AS `id` , `$table_name`.`name`
		FROM `$table` 
		JOIN `$table_name` ON `$table_name`.id = `$id`
		WHERE `user_id` = '$user_id' LIMIT 1";
		$res = $db->query($query);
		$arr = $res->fetch_assoc();

		if($arr['id'] != '' && $get == "1") return $arr['id'];


		return 0;
	}

	function get_in($arr,$table_name){
        $db = new DB();
        $array = array();
        if($arr == "") $arr = 0;
        $query = "SELECT `id`, `name` FROM $table_name WHERE id in ($arr)";
        $res = $db->query($query);
		$arr = $res->fetch_assoc();

		if($arr['id'] != '' ) return $arr['id'];

        return $array;

    }



?>