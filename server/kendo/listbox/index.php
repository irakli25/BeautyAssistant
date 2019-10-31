<?php

require_once '../lib/Kendo/Autoload.php';
require_once '../include/header.php';

?>
<div role="application">
    <div class="demo-section k-content wide">
        <label for="optional" id="employees">Employees</label>
        <label for="selected">Developers</label>
        <br />
<?php
    $attendees = array(
        "Steven White",
        "Nancy King",
        "Nancy Davolio",
        "Robert Davolio",
        "Michael Leverling",
        "Andrew Callahan",
        "Michael Suyama"
    );

    $listBoxToolbar = new \Kendo\UI\ListBoxToolbar();
    $listBoxToolbar->position("right");
    $listBoxToolbar->tools(array("moveUp", "moveDown", "transferTo", "transferFrom", "transferAllTo", "transferAllFrom"));

    $listBoxOptional = new \Kendo\UI\ListBox('optional');

    $listBoxOptional->toolbar($listBoxToolbar)
                    ->dataSource($attendees)
                    ->connectWith("selected");

    echo $listBoxOptional->render();

    // print space for design improvements
    echo " ";

    $listBoxSelected = new \Kendo\UI\ListBox('selected');
    $listBoxSelected->dataSource(array())
                    ->selectable("multiple");

    echo $listBoxSelected->render();
?>
    </div>
</div>

<style>
    .demo-section label {
        margin-bottom: 5px;
        font-weight: bold;
        display: inline-block;
    }

    #employees {
        width: 270px;
    }

    #example .demo-section {
        max-width: none;
        width: 515px;
    }

    #example .k-listbox {
        width: 236px;
        height: 310px;
    }

    #example .k-listbox:first-of-type {
        width: 270px;
        margin-right: 1px;
    }

    .demo-section label {
        padding-left: 8px;
        margin-bottom: 8px;
        font-weight: bold;
        display: inline-block;
    }
</style>
<?php require_once '../include/footer.php'; ?>