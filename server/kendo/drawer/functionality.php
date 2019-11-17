<?php

require_once '../include/header.php';
require_once '../lib/Kendo/Autoload.php';

?>

 <div class="demo-section k-content">
    <div class="box">
        <div class="box-col">
            <h4>Position</h4>
            <ul class="fieldlist">
                <li>
                    <input type="radio" name="position" id="left" class="k-radio" checked="checked">
                    <label class="k-radio-label" for="left">Left</label>
                    <input type="radio" name="position" id="right" class="k-radio">
                    <label class="k-radio-label" for="right">Right</label>
                </li>
            </ul>
        </div>
        <div class="box-col">
            <h4>Mode</h4>
            <ul class="fieldlist">
                <li>
                    <input type="radio" name="mode" id="overlay" class="k-radio" checked="checked">
                    <label class="k-radio-label" for="overlay">Overlay</label>
                    <input type="radio" name="mode" id="push" class="k-radio">
                    <label class="k-radio-label" for="push">Push</label>
                </li>
            </ul>
        </div>
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
    $drawerOverlay = new \Kendo\UI\Drawer('overlay-drawer');
    $drawerPush = new \Kendo\UI\Drawer('push-drawer');


    $drawerPush->startContent();
    ?>
            <div style="height: 200px;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Error accusantium odit, optio nulla maiores quo neque fugit debitis dignissimos incidunt maxime? Eum voluptatem blanditiis voluptatum praesentium dolorem, dolore placeat debitis quod delectus laborum assumenda cupiditate quaerat quam fugiat deleniti suscipit necessitatibus.</div>

    <?php
    $drawerPush->endContent();

    $drawerPush->template("
                <ul>
                    <li data-role='drawer-item'><span class='k-item-text'>First Item</span></li>
                    <li data-role='drawer-separator'></li>
                    <li data-role='drawer-item'><span class='k-item-text'>Second Item</span></li>
                    <li data-role='drawer-item' class='k-state-selected'><span class='k-item-text'>Third Item</span></li>
                    <li data-role='drawer-separator'></li>
                    <li data-role='drawer-item'><span class='k-item-text'>Last Item</span></li>
                </ul>
        ");

    $drawerPush->mode("push")
           ->position("left")
           ->width(150)
           ->swipeToOpen(false);

    $drawerOverlay ->template("
                    <ul>
                        <li data-role='drawer-item'><span class='k-item-text'>First Item</span></li>
                        <li data-role='drawer-separator'></li>
                        <li data-role='drawer-item'><span class='k-item-text'>Second Item</span></li>
                        <li data-role='drawer-item' class='k-state-selected'><span class='k-item-text'>Third Item</span></li>
                        <li data-role='drawer-separator'></li>
                        <li data-role='drawer-item'><span class='k-item-text'>Last Item</span></li>
                    </ul>
        ");

    $drawerOverlay->position("left")
           ->swipeToOpen(false);


    echo $drawerOverlay->render();
    echo $drawerPush->render();
?>
</div>

<script>
    $(function(){
        $("[name='mode']").click(function (e) {
            var drawerId = $("[name='mode']:not(:checked)").attr("id") + "-drawer";
            var position = $("[name='position']:checked").attr("id");
            $("#" + drawerId).data().kendoDrawer.hide();
            drawerId = e.currentTarget.id + "-drawer";
            $("#" + drawerId).data().kendoDrawer.position(position);
            $("#" + drawerId).data().kendoDrawer.show();
        });

        $("[name='position']").click(function (e) {
            var drawerId = $("[name='mode']:checked").attr("id") + "-drawer";
            var position = e.currentTarget.id;
            $("#" + drawerId).data().kendoDrawer.position(position);

        });

        $("#show").click(function (e) {
            var drawerId = $("[name='mode']:checked").attr("id") + "-drawer";
            var position = $("[name='position']:checked").attr("id");
            var drawerInstance = $("#" + drawerId).data().kendoDrawer;

            drawerInstance.position(position);
            drawerInstance.show();
        });

        $("#hide").click(function (e) {
            var drawerId = $("[name='mode']:checked").attr("id") + "-drawer";
            $("#" + drawerId).data().kendoDrawer.hide();
        });
    })
</script>

<style>
    .fieldlist {
        margin: 0 0 -1em;
        padding: 0;
    }

    .fieldlist li {
        list-style: none;
        padding-bottom: 1em;
    }

    #overlay-drawer {
        border: 0;
    }

    .k-drawer-content {
        padding: 1em;
    }

    #example .demo-section {
        max-width: 640px;
    }
</style>

<?php require_once '../include/footer.php'; ?>


