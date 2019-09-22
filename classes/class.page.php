<?php
require_once "class.db.php";

class Page
{
	protected $id;
	public function __construct($a)
	{
		$this->id = $a;
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
		echo "<div id ='container' class='container_" . $page . " container_style " . $pnf . "' >";
		require_once("front/$page/$page.html");
		require_once("front/login/login.html");

		echo "</div>";
	}
}
