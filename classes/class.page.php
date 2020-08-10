<?php
require_once "class.db.php";

class Page
{
	protected $id;
	protected $user_id;
	public function __construct($a)
	{
		$this->id = $a;
		if(isset($_SESSION['USER'])){
			$this->user_id = $_SESSION['USER'];
		}
		else{
			$this->user_id = 0;
		}
	}
	public function get_page()
	{
		$mysql = new DB();
		$pnf = '';
		$query = "SELECT `page` from `pages` WHERE `id`=" . $this->id;
		$res = $mysql->query($query);
		$result = $res->fetch_assoc();
		$page = $result["page"];
		if ($page == "") {
			$page = "404";
			$pnf = "404";
		}
		echo "<div id ='container' class='container container_" . $page . " container_style " . $pnf . "' user = '".$_SESSION['USER']."'>";
		
		if($this->user_id != 0){
			$query = "SELECT `authentication` from `users` WHERE `id`=" . $this->user_id;
			$res = $mysql->query($query);
			$result = $res->fetch_assoc();
			$authentication = $result["authentication"];
			if($authentication == "0")
				require_once("front/authentication/authentication.html");
			else{
				require_once("front/$page/$page.html");
				require_once("front/login/login.html");
			}
		}
		else{
			require_once("front/$page/$page.html");
			require_once("front/login/login.html");
		}
		

		echo "</div>";
	}
}

?>
