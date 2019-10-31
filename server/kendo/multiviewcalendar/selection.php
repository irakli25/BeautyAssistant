<?php
require_once '../include/header.php';
require_once '../lib/Kendo/Autoload.php';
?>

<div id="example" style="text-align: center;">
	<div class="demo-section k-content wide" style="display: inline-block;">
	<h4>Multiple Date Selection</h4>
	<?php
	$array = array(
		"sa", "su",
	);

	$multipleMultiViewCalendar = new \Kendo\UI\MultiViewCalendar('multipleMultiViewCalendar');

	$multipleMultiViewCalendar->disableDates($array)
			->weekNumber(true)
			->selectable("multiple");

	echo $multipleMultiViewCalendar->render();
	echo "<br />";
	$rangeMultiViewCalendar = new \Kendo\UI\MultiViewCalendar('rangeMultiViewCalendar');

	$rangeMultiViewCalendar->disableDates($array)
			->weekNumber(true)
			->selectable("range");

	echo $rangeMultiViewCalendar->render();
	?>

	</div>
</div>

<?php require_once '../include/footer.php'; ?>
