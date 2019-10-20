<?php require_once "./classes/class.db.php" ?>
<header>
	<nav>
		<div class="logo">
			<a href="?pg=1"><img src="media/icons/mainlogo.png" alt="logo" width="120" /></a>
		</div>
		<ul class="navigation_ul">
			<?php
			$mysql = new DB();
			$query = "SELECT `pages_id`, `name` FROM `menu` WHERE `active` = 1";
			$result = $mysql->query($query);
			while ($arr = $result->fetch_assoc()) {
				echo "<li><a href='?pg=" . $arr['pages_id'] . "' class='menu_list'>" . $arr['name'] . "</a></li>";
			}


		

			if(isset($_SESSION['USER'])){
				echo '<li class="dropbtn"><div>
				<span class="in " href="#"  >'.$_SESSION['USER_NAME'].'</span>
				  <div class="dropdown-content">
					<a  href="#" class="">ჩემი კაბინეტი</a>
					<a href="#" class="" id="logout">გასვლა</a>
				</div> 
				</div></li>';
			}
			else{
				echo '<li class="dropbtn"><div>
				<span class="in menu_list" id="login" href="#"  >შესვლა</span>
				 
				</div></li>';

			}


			echo '
			<li class="social">
			<div class="fb"></div>
			<div class="instagram"></div>
			<div class="call"></div></li>
		';
			
			
			
			?>
		</ul>
		<p class="clear"></p>
	</nav>

</header>
