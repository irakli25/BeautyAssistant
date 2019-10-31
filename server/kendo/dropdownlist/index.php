<?php

require_once '../lib/Kendo/Autoload.php';
require_once '../include/header.php';
?>
<div id="cap-view" class="demo-section k-content">
    <h4>Customize your Kendo Cap</h4>
    <div id="cap" class="black-cap"></div>
    <h4><label for="color">Cap Color</label></h4>
<?php
$color = new \Kendo\UI\DropDownList('color');

$color->value(1)
      ->change('onChange')
      ->dataTextField('text')
      ->dataValueField('value')
      ->dataSource(array(
          array('text' => 'Black', 'value' => 1),
          array('text' => 'Orange', 'value' => 2),
          array('text' => 'Grey', 'value' => 3)
      ))
      ->attr('style', 'width: 100%');

echo $color->render();
?>
   <h4 style="margin-top: 2em;"><label for="size">Cap Size</label></h4>
<?php
$size = new \Kendo\UI\DropDownList('size');

$size->index(0)
     ->dataSource(array('S - 6 3/4"', 'M - 7 1/4"', 'L - 7 1/8"', 'XL - 7 5/8"'))
     ->attr('style', 'width: 100%');

echo $size->render();
?>
    <button class="k-button k-primary" id="get" style="margin-top: 2em; float: right;">Customize</button>
</div>

<script>
    function onChange() {
        var value = $("#color").val();
        $("#cap")
            .toggleClass("black-cap", value == 1)
            .toggleClass("orange-cap", value == 2)
            .toggleClass("grey-cap", value == 3);
    };

    $(document).ready(function() {
        var color = $("#color").data("kendoDropDownList");
        var size = $("#size").data("kendoDropDownList");

        $("#get").click(function() {
            alert('Thank you! Your Choice is:\n\nColor ID: '+color.value()+' and Size: '+size.value());
        });
    });
</script>
<style>
    #cap {
        width: 242px;
        height: 225px;
        margin: 20px auto;
        background-image: url('../content/web/dropdownlist/cap.png');
        background-repeat: no-repeat;
        background-color: transparent;
    }
    .black-cap {
        background-position: 0 0;
    }
    .grey-cap {
        background-position: 0 -225px;
    }
    .orange-cap {
        background-position: 0 -450px;
    }
</style>
<?php require_once '../include/footer.php'; ?>
