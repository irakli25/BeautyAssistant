<?php require_once "./classes/class.db.php" ?>
<header>

<?php $mysql = new DB(); ?>

		<div class = "header1 ">
			<div class="header1_content container">
				<div class="beauty_logo">
					<div></div><h1>Beauty Assistant</h1>
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
							';
							// echo '<div  class="icon_log_in"> <i class="fas fa-user"></i> </div> <span>'.$_SESSION['USER_NAME'].'</span>';
						}
						else{
							echo '<div id="login" class="flex " style="width:100px" ><div class="icon_log_in in"> <i class="fas fa-lock"></i> </div> <span>შესვლა</span></div>';

						}

					?>
					
				</div>
				<div class="mobile_li" id="menu"><i class="fa fa-bars"></i></div>
			</div>
		</div>
		<div class="header2">
			<div class="header2_content container">
				
			<ul class="navigation_ul">
					<?php 
					

					echo'
					
					<li class="mobile_li" id="close_menu"><i class="fa fa-window-close "></i></li>

					';

					$query = "SELECT `pages_id`, `name` FROM `menu` WHERE `active` = 1";
					$result = $mysql->query($query);
					while ($arr = $result->fetch_assoc()) {
						echo "<li><a href='?route=" . $arr['pages_id'] . "' class='menu_list'>" . $arr['name'] . "</a></li>";
					}

					
				

					if(isset($_SESSION['USER'])){
						$query = "SELECT `uid` FROM `users` WHERE `id` = '$_SESSION[USER]'";
						$res = $mysql->getResult($query);
						echo '<hr class="mobile_li"><li class=" mobile_li">
						<div>
						<span class="in " href="#"  ><i class="fas fa-user"></i> '.$_SESSION['USER_NAME'].'</span>
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
						echo '<hr class="mobile_li"><li class=" mobile_li"><div>
						<span class="in" id="login_mobile" href="#"  ><i class="fas fa-lock"></i> შესვლა</span>
						
						</div></li>';

					}

					?>
			</div>
		</div>




</header>
