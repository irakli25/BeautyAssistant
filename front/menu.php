<?php require_once "./classes/class.db.php" ?>
<header>
	<!--<nav>
		 <div class="logo">
		
			<div class="pic"></div>
			<span>Beauty Assistant</span>
			<div class="div1"></div>
			<div class="div2"></div>
		</div>
		<ul class="navigation_ul">
			<?php /*
			$mysql = new DB();
			$query = "SELECT `pages_id`, `name` FROM `menu` WHERE `active` = 1";
			$result = $mysql->query($query);
			while ($arr = $result->fetch_assoc()) {
				echo "<li><a href='?route=" . $arr['pages_id'] . "' class='menu_list'>" . $arr['name'] . "</a></li>";
			}


		

			if(isset($_SESSION['USER'])){
				$query = "SELECT `uid` FROM `users` WHERE `id` = '$_SESSION[USER]'";
				$res = $mysql->getResult($query);
				echo '<li class="dropbtn fullscreen">
				<div>
				<span class="in " href="#"  >'.$_SESSION['USER_NAME'].'</span>
				  	<div class="dropdown-content">
						<a  href="?route=7&uid='.$res.'" class="">ჩემი კაბინეტი</a>
						<a href="#" class="" id="logout">გასვლა</a>
					</div> 
				</div></li>
				<li class="mobile_li">
						<a  href="?route=7&uid='.$res.'" class="">ჩემი კაბინეტი</a>
				
				</li>
				<li class="mobile_li">
						<a href="#" class="" id="logout">გასვლა</a>
				
				</li>';
			}
			else{
				echo '<li class="dropbtn"><div>
				<span class="in" id="login" href="#"  >შესვლა</span>
				 
				</div></li>';

			}


			echo '
			<li class="social">
			<div class="fb"></div>
			<div class="instagram"></div>
			<div class="call"></div></li>
		';*/
			
			
			
			?>
		</ul>
		<p class="clear"></p>
	</nav> -->
<?php $mysql = new DB(); ?>

		<div class = "header1">
			<div class="header1_content">
				<div class="beauty_logo">
					<span><i>B</i>eauty<i>A</i>ssistant</span>
				</div>
				<div  class="login flex">
					<?php

						if(isset($_SESSION['USER'])){
							$query = "SELECT `uid` FROM `users` WHERE `id` = '$_SESSION[USER]'";
							$res = $mysql->getResult($query);
							echo '<li class=" dropbtn fullscreen">
							<div class="flex">
							<div  class="icon_log_in in"> <i class="fas fa-user"></i> </div> <span>'.$_SESSION['USER_NAME'].'</span>
								<div class="dropdown-content">
									<a  href="?route=7&uid='.$res.'" class="">ჩემი კაბინეტი</a>
									<a href="#" class="" id="logout">გასვლა</a>
								</div> 
							</div></li>
							<li class="mobile_li">
									<a  href="?route=7&uid='.$res.'" class="">ჩემი კაბინეტი</a>
							
							</li>
							<li class="mobile_li">
									<a href="#" class="" id="logout">გასვლა</a>
							
							</li>';
							// echo '<div  class="icon_log_in"> <i class="fas fa-user"></i> </div> <span>'.$_SESSION['USER_NAME'].'</span>';
						}
						else{
							echo '<div id="login" class="flex" style="width:100px" ><div class="icon_log_in in"> <i class="fas fa-lock"></i> </div> <span>შესვლა</span></div>';

						}

					?>
					
				</div>
			</div>
		</div>
		<div class="header2">
			<div class="header2_content">
				
			<ul class="navigation_ul">
					<?php 
					
					$query = "SELECT `pages_id`, `name` FROM `menu` WHERE `active` = 1";
					$result = $mysql->query($query);
					while ($arr = $result->fetch_assoc()) {
						echo "<li><a href='?route=" . $arr['pages_id'] . "' class='menu_list'>" . $arr['name'] . "</a></li>";
					}


				

					// if(isset($_SESSION['USER'])){
					// 	$query = "SELECT `uid` FROM `users` WHERE `id` = '$_SESSION[USER]'";
					// 	$res = $mysql->getResult($query);
					// 	echo '<li class="dropbtn fullscreen">
					// 	<div>
					// 	<span class="in " href="#"  >'.$_SESSION['USER_NAME'].'</span>
					// 		<div class="dropdown-content">
					// 			<a  href="?route=7&uid='.$res.'" class="">ჩემი კაბინეტი</a>
					// 			<a href="#" class="" id="logout">გასვლა</a>
					// 		</div> 
					// 	</div></li>
					// 	<li class="mobile_li">
					// 			<a  href="?route=7&uid='.$res.'" class="">ჩემი კაბინეტი</a>
						
					// 	</li>
					// 	<li class="mobile_li">
					// 			<a href="#" class="" id="logout">გასვლა</a>
						
					// 	</li>';
					// }
					// else{
					// 	echo '<li class="dropbtn"><div>
					// 	<span class="in" id="login" href="#"  >შესვლა</span>
						
					// 	</div></li>';

					// }

					?>
			</div>
		</div>



	<!-- <div class="container-hamburger" onclick="hamburger(this)">
		<div class="bar1"></div>
		<div class="bar2"></div>
		<div class="bar3"></div>
	</div> -->
</header>
