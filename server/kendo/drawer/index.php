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

    $heading->template("<h3 style='margin-left: 20px;'>Mail Box</h3>");

    $toolbar->addItem(
        $button,
        $heading
    );

    echo $toolbar->render();

    $drawer = new \Kendo\UI\Drawer('drawer');

    $drawer->startContent();
    ?>
            <div id="drawer-content">
                <div id="Inbox">
                    <ul class="inboxList">
                        <li>
                            <h6>Monday meeting</h6>
                            <p>Hi Tom, Since Monday I'll be out of office, I'm rescheduling the meeting for Tuesday.</p>
                        </li>
                        <li>
                            <h6>I'm sorry, Tom</h6>
                            <p>Hi Tom, my aunt comes for a visit this Saturday, so I can't come back to St. Pete...</p>
                        </li>
                    </ul>
                </div>
                <div id="Notifications" class="hidden">
                    <ul>
                        <li>Monday meeting</li>
                        <li>Regarding org chart changes</li>
                        <li>Meeting with Cliff</li>
                        <li>Global Marketing Meeting</li>
                        <li>Out tonight with collegues?</li>
                    </ul>
                </div>
                <div id="Calendar" class="hidden">
                    <ul>
                        <li>
                            <h6>11/5 Monday</h6>
                            <p>Martha Birthday</p>
                        </li>
                        <li>
                            <h6>15/6 Sunday</h6>
                            <p>Job interview for internal position</p>
                        </li>
                    </ul>
                </div>
                <div id="Attachments" class="hidden">
                    <ul>
                        <li>Build enterprise apps</li>
                        <li>Fw: Regarding Multiline textbox</li>
                        <li>Away next week</li>
                        <li>Fw: Your Costume is ready</li>
                        <li>Update completed</li>
                    </ul>
                </div>
                <div id="Favourites" class="hidden">
                    <ul>
                        <li>90% Discount!</li>
                        <li>90% Discount!</li>
                        <li>One time offer!</li>
                    </ul>
                </div>
            </div>
    <?php
    $drawer->endContent();

    $drawer->template("
            <ul>
                <li data-role='drawer-item' class='k-state-selected'><span class='k-icon k-i-inbox'></span><span class='k-item-text'>Inbox</span></li>
                <li data-role='drawer-separator'></li>
                <li data-role='drawer-item'><span class='k-icon k-i-notification k-i-bell'></span><span class='k-item-text'>Notifications</span></li>
                <li data-role='drawer-item'><span class='k-icon k-i-calendar'></span><span class='k-item-text'>Calendar</span></li>
                <li data-role='drawer-item'><span class='k-icon k-i-hyperlink-email'></span><span class='k-item-text'>Attachments</span></li>
                <li data-role='drawer-separator'></li>
                <li data-role='drawer-item'><span class='k-icon k-i-star-outline k-i-bookmark-outline'></span><span class='k-item-text'>Favourites</span></li>
            </ul>
        ");

    $drawer->mode("push")
           ->mini(true)
           ->itemClick("onItemClick")
           ->position("left")
           ->minHeight(330)
           ->swipeToOpen(true);


    echo $drawer->render();
?>
</div>

<script>
    function onItemClick(e) {
        e.sender.drawerContainer.find("#drawer-content > div").addClass("hidden");
        e.sender.drawerContainer.find("#drawer-content").find("#" + e.item.find(".k-item-text").text()).removeClass("hidden");
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
    #drawer-content li {
        font-size: 1.2em;
        padding-left: .89em;
        background: 0 0;
        border-radius: 0;
        border-width: 0 0 1px;
        border-color: rgba(33, 37, 41, 0.125);
        border-style: solid;
        line-height: 1.5em;
        padding: 1.09em .84em 1.23em .84em;
    }

    #drawer-content li:last-child {
        border: 0;
    }

    .hidden {
        display: none;
    }

    #example .demo-section {
        max-width: 640px;
    }

    .k-toolbar .k-icon {
        font-size: 18px;
    }
</style>

<?php require_once '../include/footer.php'; ?>


