<?php

require_once '../include/header.php';
require_once '../lib/Kendo/Autoload.php';

?>

 <div class="demo-section k-content">
    <div class="box">
        <div class="box-col">
            <h4>Show / Hide</h4>
            <ul class="options">
                <li>
                    <button id="show" class="k-button">Show</button>
                    <button id="hide" class="k-button">Hide</button>
                </li>
            </ul>
        </div>
    </div>
<?php
    $drawer = new \Kendo\UI\Drawer('drawer');

    $drawer->startContent();
    ?>
        <div style='height: 200px;'>Lorem ipsum dolor sit amet consectetur adipisicing elit. Error accusantium odit, optio nulla maiores quo neque fugit debitis dignissimos incidunt maxime? Eum voluptatem blanditiis voluptatum praesentium dolorem, dolore placeat debitis quod delectus laborum assumenda cupiditate quaerat quam fugiat deleniti suscipit necessitatibus.</div>

    <?php
    $drawer->endContent();

    $drawer->template("
                <ul>
                    <li data-role='drawer-item'><span class='k-item-text'>First Item</span></li>
                    <li data-role='drawer-separator'></li>
                    <li data-role='drawer-item'><span class='k-item-text'>Second Item</span></li>
                    <li data-role='drawer-item' class='k-state-selected'><span class='k-item-text'>Third Item</span></li>
                    <li data-role='drawer-separator'></li>
                    <li data-role='drawer-item'><span class='k-item-text'>Last Item</span></li>
                </ul>
        ");

    $drawer->mode("push")
           ->position("left")
           ->width(150)
           ->swipeToOpen(false);


    echo $drawer->render();
?>
</div>

<script>
    $(function(){
        var drawer = $("#drawer").data("kendoDrawer");

        $("#show").click(function () {
            drawer.show();
        });

        $("#hide").click(function () {
            drawer.hide();
        });
    })

</script>

<style>
    #example .demo-section {
        max-width: 640px;
    }
    .k-drawer-content {
        padding: 1em;
    }
</style>

<?php require_once '../include/footer.php'; ?>


