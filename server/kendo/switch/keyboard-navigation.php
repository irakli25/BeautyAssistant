<?php
require_once '../include/header.php';
require_once '../lib/Kendo/Autoload.php';

$switch = new \Kendo\UI\SwitchButton('switch');
?>

<div class="demo-section k-content">
    <div>
        <?php echo $switch->render(); ?>
    </div>
</div>

<div class="box">
        <div class="box-col">
            <h4>Focus</h4>
            <ul class="keyboard-legend">
                <li>
                    <span class="button-preview">
                        <span class="key-button leftAlign">Alt</span>
                        +
                        <span class="key-button">W</span>
                    </span>
                    <span class="button-descr">
                        Focuses the first button of the ButtonGroup.
                    </span>
                </li>
            </ul>
        </div>
        <div class="box-col">
            <h4>Supported keys and user actions</h4>
            <ul class="keyboard-legend">
                <li>
                    <span class="button-preview">
                        <span class="key-button">Space</span>
                    </span>
                    <span class="button-descr">
                        Toggles the checked state
                    </span>
                </li>
            </ul>
        </div>
</div>

<script>
    $(document).ready(function() {
        $(document.body).keydown(function(e) {
            if (e.altKey && e.keyCode == 87) {
                $("#select-period")[0].focus();
            }
        });
    });
</script>

<style>
   .demo-section {
       text-align: center;
   }
</style>
<?php require_once '../include/footer.php'; ?>
