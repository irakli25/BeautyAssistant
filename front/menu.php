<?php require_once "./classes/class.db.php" ?>
<header>
	<nav>
		<div class="logo">
			<a href="?pg=1"><img src="media/icons/logo.png" alt="logo" width="120" /></a>
		</div>
		<ul class="navigation_ul">
			<?php
			$mysql = new DB();
			$query = "SELECT `pages_id`, `name` FROM `menu` WHERE `active` = 1";
			$result = $mysql->query($query);
			while ($arr = $result->fetch_assoc()) {
				echo "<li><a href='?pg=" . $arr['pages_id'] . "'>" . $arr['name'] . "</a></li>";
			}
			echo '<li class="dropbtn"><div>
            <span id="in">შესვლა</span>
              <div class="dropdown-content">
                <a id="login" href="#">ავტორიზაცია</a>
                <a href="register.html">რეგისტრაცია</a>
              </div>
            </div></li>';
			?>
		</ul>
		<p class="clear"></p>
	</nav>

</header>
