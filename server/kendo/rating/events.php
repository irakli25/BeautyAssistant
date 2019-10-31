<?php
require_once '../lib/Kendo/Autoload.php';
require_once '../include/header.php';
?>

<div class="demo-section k-content">
    <h4>Rating Events</h4>
    <?php
        $rating = new \Kendo\UI\Rating('rating');

        $rating
            ->min(1)
            ->max(6)
            ->value(3)
            ->select('onSelect')
            ->change('onChange');

        echo $rating->render();
    ?>
</div>

<div class="box">
    <h4>Console log</h4>
    <div class="console"></div>
</div>

<script>
    function onChange(e) {
        kendoConsole.log("Change :: old value: " + e.oldValue + ", new value: " + e.newValue);
    }

    function onSelect(e) {
        kendoConsole.log("Select :: target: " + e.target);
    }
</script>

<style>
    div.console div {
        height: auto;
    }
</style>

<?php require_once '../include/footer.php'; ?>