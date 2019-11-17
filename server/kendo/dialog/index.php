<?php

require_once '../include/header.php';
require_once '../lib/Kendo/Autoload.php';

$dialog = new \Kendo\UI\Dialog('dialog');
$skipAction = new \Kendo\UI\DialogAction();
$skipAction->text("Skip this version");

$remindAction = new \Kendo\UI\DialogAction();
$remindAction->text("Remind me later");

$intallAction = new \Kendo\UI\DialogAction();
$intallAction->text("Install update")
             ->primary(true);

$dialog->title('Software Update')
       ->width('400px')
       ->closable(false)
       ->modal(false)
       ->close('onClose')
       ->addAction($skipAction, $remindAction, $intallAction)
       ->content('<p>A new version of <strong>Kendo UI</strong> is available. Would you like to download and install it now?<p>');

echo $dialog->render();
?>

<span id="undo" style="display:none" class="k-button hide-on-narrow">Click here to open the dialog</span>

<script>
    $("#undo").click(function () {
        $('#dialog').data("kendoDialog").open();
        $("#undo").fadeOut();
    });

    function onClose() {
        $("#undo").fadeIn();
    }
</script>

<style>
    #example {
        min-height: 350px;
    }
</style>
<?php require_once '../include/footer.php'; ?>
