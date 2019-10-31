<?php
    require_once '../include/header.php';
    require_once '../lib/Kendo/Autoload.php';
    $switch = new \Kendo\UI\SwitchButton('switch');
?>

<div class="demo-section k-content">
  <?php echo $switch->render(); ?>
</div>

<div class="box wide">
    <div class="box-col">
        <h4>Toggle</h4>
        <button class="k-button" id="toggleSwitch" type="button">Toggle Checked</button>
    </div>
    <div class="box-col">
        <h4>Enable</h4>
        <button class="k-button" id="enableSwitch" type="button">Toggle Enabled</button>
    </div>
    <div class="box-col">
        <h4>ReadOnly</h4>
        <button class="k-button" id="readonlySwitch" type="button">Toggle ReadOnly</button>
    </div>
</div>

<script>
  $(document).ready(function() {
    var switchInstance = $("#switch").data("kendoSwitch");


    $("#enableSwitch").click(function () {
        switchInstance.enable(!!switchInstance.element.attr("disabled"));
    });

    $("#readonlySwitch").click(function () {
        switchInstance.readonly(!switchInstance.element.attr("readonly"));
    });

    $("#toggleSwitch").click(function () {
        switchInstance.toggle();
    });
  });
</script>

<style>
    .demo-section {
        text-align: center;
    }
    .box .k-textbox {
        margin: 0;
        width: 80px;
    }
</style>
<?php require_once '../include/footer.php'; ?>