<?php
require_once '../include/header.php';
require_once '../lib/Kendo/Autoload.php';
?>

<div id="tshirt-view" class="demo-section k-content">
	  <h4>Customize your Kendo T-shirt</h4>
    <img id="tshirt" alt="T-shirt image" src="../content/web/combobox/tShirt.png" />
    <h4><label for="fabric">T-shirt Fabric</label></h4>
<?php
$fabrics = new \Kendo\Data\DataSource();
$fabrics->data(array(
    array('text' => 'Cotton', 'value'=> 1),
    array('text' => 'Polyester', 'value'=> 2),
    array('text' => 'Cotton/Polyester', 'value'=> 3),
    array('text' => 'Rib Knit', 'value'=> 4)
));

$input = new \Kendo\UI\ComboBox('fabric');
$input->dataSource($fabrics)
      ->dataTextField('text')
      ->dataValueField('value')
      ->filter('contains')
      ->placeholder('Select fabric ...')
      ->suggest(true)
      ->index(3)
      ->attr('style', 'width: 100%;');

echo $input->render();
?>
    <h4 style="margin-top: 2em;"><label for="size">T-shirt Size</label></h4>
<?php

$select = new \Kendo\UI\ComboBox('size');
$select->dataSource(array('X-Small', 'Small', 'Medium', 'Large', 'X-Large', '2X-Large'))
       ->placeholder('Select size ...')
       ->index(0)
       ->attr('style', 'width: 100%;');

echo $select->render();
?>
    <button class="k-button k-primary" id="get" style="margin-top: 2em; float: right;">Customize</button>
</div>
<style>
    #tshirt {
        display: block;
        margin: 2em auto;
    }
    .k-readonly
    {
        color: gray;
    }
</style>

<script>
    $(document).ready(function() {
        // create ComboBox from select HTML element
        var input = $("#input").data("kendoComboBox");
        var select = $("#select").data("kendoComboBox");

        $("#get").click(function() {
            alert('Thank you! Your Choice is:\n\nFabric ID: '+input.value()+' and Size: '+select.value());
        });
    });
</script>

<?php require_once '../include/footer.php'; ?>
