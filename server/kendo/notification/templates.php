<?php
require_once '../include/header.php';
require_once '../lib/Kendo/Autoload.php';
?>

<?php

$position = new \Kendo\UI\NotificationPosition();
$position->pinned(true);
$position->top(30);
$position->right(30);

$infoTemplate = new \Kendo\UI\NotificationTemplate();
$infoTemplate->type('info');
$infoTemplate->templateId('emailTemplate');

$errorTemplate = new \Kendo\UI\NotificationTemplate();
$errorTemplate->type('error');
$errorTemplate->templateId('errorTemplate');

$uploadSuccess = new \Kendo\UI\NotificationTemplate();
$uploadSuccess->type('success');
$uploadSuccess->templateId('successTemplate');

$notification = new \Kendo\UI\Notification('notification');
$notification->position($position);
$notification->autoHideAfter(0);
$notification->stacking("down");
$notification->addTemplate($infoTemplate);
$notification->addTemplate($errorTemplate);
$notification->addTemplate($uploadSuccess);

echo $notification->render();

?>

<span id="notification" style="display:none;"></span>

<div class="demo-section k-content" style="text-align: center;">

    <h4>Show notification:</h4>
    <p>
        <button id="showEmailNotification" class="k-button">Email</button><br />
        <button id="showErrorNotification" class="k-button">Error</button><br />
        <button id="showSuccessNotification" class="k-button">Upload Success</button>
    </p>
    <h4>Hide notification:</h4>
    <p>
        <button id="hideAllNotifications" class="k-button">Hide All Notifications</button>
    </p>

</div>

<script id="emailTemplate" type="text/x-kendo-template">
  <div class="new-mail">
    <img src="../content/web/notification/envelope.png" />
    <h3>#= title #</h3>
    <p>#= message #</p>
  </div>
</script>

<script id="errorTemplate" type="text/x-kendo-template">
  <div class="wrong-pass">
    <img src="../content/web/notification/error-icon.png" />
    <h3>#= title #</h3>
    <p>#= message #</p>
  </div>
</script>

<script id="successTemplate" type="text/x-kendo-template">
  <div class="upload-success">
    <img src="../content/web/notification/success-icon.png" />
    <h3>#= message #</h3>
  </div>
</script>

<script>
  $(document).ready(function() {

  var notification = $("#notification").data("kendoNotification");

  $("#showEmailNotification").click(function(){
    notification.show({
      title: "New E-mail",
      message: "You have 1 new mail message!"
    }, "info");
  });

  $("#showErrorNotification").click(function(){
    notification.show({
      title: "Wrong Password",
      message: "Please enter your password again."
    }, "error");
  });

  $("#showSuccessNotification").click(function(){
    notification.show({
      message: "Upload Successful"
    }, "success");
  });

  $("#hideAllNotifications").click(function(){
    notification.hide();
  });

  });
</script>

<style>
    .demo-section p {
        margin: 3px 0 20px;
        line-height: 50px;
    }
    .demo-section .k-button {
        width: 250px;
    }


    /* Notifications */
    .k-notification h3 {
        padding: 30px 10px 5px;
        font-size: 1em;
        line-height: normal;
    }
    .k-notification img {
        margin: 20px;
        float: left;
    }


    /* Info template */
    .new-mail {
        width: 300px;
        height: 100px;
    }

    /* Error template */
    .wrong-pass {
        width: 300px;
        height: 100px;
    }

    /* Success template */
    .upload-success {
        width: 300px;
        height: 100px;
    }


    /* For Bootstrap v4 theme */
    .k-bootstrap-v4 .k-notification h3 {
        padding: 10px 10px 5px;
    }
    .k-bootstrap-v4 .k-notification img {
        margin: 10px 20px 0 0;
    }
    .k-bootstrap-v4 .new-mail,
    .k-bootstrap-v4 .wrong-pass,
    .k-bootstrap-v4 .upload-success {
        width: calc( 300px - 2.5rem );
        height: calc( 100px - 1.5rem );
    }


    /* For Material v2 theme */
    .k-material-v2 .k-notification h3 {
        padding: 10px 10px 5px;
    }
    .k-material-v2 .k-notification img {
        margin: 10px 20px 0 0;
    }
    .k-material-v2 .new-mail,
    .k-material-v2 .wrong-pass,
    .k-material-v2 .upload-success {
        width: 270px;
        height: 70px;
    }
</style>

<?php require_once '../include/footer.php'; ?>