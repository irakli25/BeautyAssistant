
<?php
require_once '../include/ripple_header.php';
require_once '../lib/Kendo/Autoload.php';
?>


<div class="demo-section k-content wide">
    <div class="row">
        <div class="row-box">
            <h4>Ripple on Buttons</h4>
            <button class="k-button">Default Button</button><br />
            <button class="k-button k-primary">Primary Button</button><br />
        </div>
        <div class="row-box">
            <h4>Ripple on Checkboxes</h4>
            <p style="line-height: 2.5em;">
                <input type="checkbox" id="c1" class="k-checkbox" />
                <label class="k-checkbox-label" for="c1">Checkbox 1</label><br />
                <input type="checkbox" id="c2" class="k-checkbox" />
                <label class="k-checkbox-label" for="c2">Checkbox 2</label><br />
                <input type="checkbox" id="c3" class="k-checkbox" />
                <label class="k-checkbox-label" for="c3">Checkbox 3</label>
            </p>
        </div>
        <div class="row-box">
            <h4>Ripple on Radio Buttons</h4>
            <p style="line-height: 2.5em;">
                <input type="radio" id="r1" name="rg" class="k-radio" checked />
                <label class="k-radio-label" for="r1">Radio 1</label><br />
                <input type="radio" id="r2" name="rg" class="k-radio" />
                <label class="k-radio-label" for="r2">Radio 2</label><br />
                <input type="radio" id="r3" name="rg" class="k-radio" />
                <label class="k-radio-label" for="r3">Radio 3</label>
            </p>
        </div>
    </div>
    <div class="row">
        <div>
            <h4>Ripple on List Items</h4>
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

                $listBoxSelected = new \Kendo\UI\ListBox('selected');
                $listBoxSelected->dataSource(array())
                                ->selectable("multiple");

                echo $listBoxSelected->render();
            ?>
        </div>
    </div>
</div>
<div class="box demo-description wide">
    <h4>Information</h4>
    <p>
    The Kendo UI RippleContainer provides <a href="https://material.io/design/motion/choreography.html#sequencing">the Material ink ripple effect</a>
    for the Kendo UI components and is compatible only with <a href="https://docs.telerik.com/kendo-ui/styles-and-layout/sass-themes">the Sass-based Material Theme</a>.
</div>

<script>
    $(document).ready(function () {
        // Initialize ripple container
        $(".row").kendoRippleContainer();
    });
</script>

<style>
    .row {
        width: 100%;
        float: left;
        margin-bottom: 30px;
    }

    .row button,
    .row input {
        margin: 1em 0;
    }

    .row > .row-box {
        float: left;
        width: 30%;
    }

    .row .k-listbox {
        width: 236px;
        height: 310px;
    }

    .row .k-listbox:first-of-type {
        width: 270px;
        margin-right: 1px;
    }
</style>

<?php require_once '../include/footer.php'; ?>
