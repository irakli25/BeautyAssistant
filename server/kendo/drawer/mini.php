<?php

require_once '../include/header.php';
require_once '../lib/Kendo/Autoload.php';

?>

 <div class="demo-section k-content wide">
<?php

    $toolbar = new \Kendo\UI\ToolBar('toolbar');
    $button = new \Kendo\UI\ToolBarItem();
    $heading = new \Kendo\UI\ToolBarItem();

    $button->type('button');
    $button->icon('menu');
    $button->attributes(array('class' => 'k-bare'));
    $button->click(toggleDrawer);

    $heading->template("<h3 style='margin-left: 20px;'>Weather Forecast in Europe</h3>");

    $toolbar->addItem(
        $button,
        $heading
    );

    echo $toolbar->render();

    $drawer = new \Kendo\UI\Drawer('drawer');
    $mini = new \Kendo\UI\DrawerMini('mini');

    $mini->true;

    $drawer->startContent();
    ?>
            <div id="drawer-content">
                <div id="Paris">
                    <span class="rainy ">&nbsp;</span>
                    <div class="weather">
                        <h2>17<span>&ordm;C</span></h2>
                        <p>Rainy weather in Paris.</p>
                    </div>
                </div>
                <div class="hide">
                    <span class="sunny">&nbsp;</span>
                    <div class="weather">
                        <h2>29<span>&ordm;C</span></h2>
                        <p>Sunny weather in Madrid.</p>
                    </div>
                </div>
                <div class="hide">
                    <span class="sunny">&nbsp;</span>
                    <div class="weather">
                        <h2>21<span>&ordm;C</span></h2>
                        <p>Sunny weather in Rome.</p>
                    </div>
                </div>
                <div class="hide">
                    <span class="cloudy">&nbsp;</span>
                    <div class="weather">
                        <h2>16<span>&ordm;C</span></h2>
                        <p>Cloudy weather in Berlin.</p>
                    </div>
                </div>
            </div>
    <?php
    $drawer->endContent();

    $drawer->template("
        <ul>
            <li data-role='drawer-item' class='k-state-selected'><span class='k-icon flag france-flag'></span><span class='k-item-text'>Paris</span></li>
            <li data-role='drawer-item'><span class='k-icon flag spain-flag'></span><span class='k-item-text'>Madrid</span></li>
            <li data-role='drawer-item'><span class='k-icon flag italy-flag'></span><span class='k-item-text'>Rome</span></li>
            <li data-role='drawer-item'><span class='k-icon flag germany-flag'></span><span class='k-item-text'>Berlin</span></li>
        </ul>
    ");

    $drawer->mode("push")
           ->mini($mini)
           ->itemClick("onItemClick")
           ->position("left")
           ->minHeight(330)
           ->swipeToOpen(true);


    echo $drawer->render();
?>
</div>

<script>
    function onItemClick(e) {
        e.sender.element.find("#drawer-content > div").addClass("hide");
        e.sender.element.find("#drawer-content > div").eq(e.item.index()).removeClass("hide");
    }

    function toggleDrawer() {
        var drawerInstance = $("#drawer").data().kendoDrawer;
        var drawerContainer = drawerInstance.drawerContainer;
        if(drawerContainer.hasClass("k-drawer-expanded")) {
            drawerInstance.hide();
        } else {
            drawerInstance.show();
        }
    }
</script>

<style>
        .sunny, .cloudy, .rainy {
            display: block;
            margin: 30px auto 10px;
            width: 128px;
            height: 128px;
            background: url('../content/web/tabstrip/weather.png') transparent no-repeat 0 0;
        }

        .flag {
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            background-color: transparent;
        }

        .france-flag {
            background-image: url('../content/web/drawer/france-flag.png');
        }

        .spain-flag {
            background-image: url('../content/web/drawer/spain-flag.png');
        }

        .italy-flag {
            background-image: url('../content/web/drawer/italy-flag.png');
        }

        .germany-flag {
            background-image: url('../content/web/drawer/germany-flag.png');
        }

        .cloudy {
            background-position: -128px 0;
        }

        .rainy {
            background-position: -256px 0;
        }

        .weather {
            margin: 0 auto 30px;
            text-align: center;
        }

        .hide {
            display: none;
        }

        .k-drawer-content {
            padding: 1em;
        }

        #example .demo-section {
            max-width: 640px;
        }

        .k-toolbar .k-icon {
            font-size: 18px;
        }
</style>

<?php require_once '../include/footer.php'; ?>


