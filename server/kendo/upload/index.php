<?php
require_once '../lib/Kendo/Autoload.php';
require_once '../include/header.php';
?>
<div class="box">
    <h4>Information</h4>
    <p>
        The Upload can be used as a drop-in replacement
        for file input elements. This "synchronous" mode does not require
        special handling on the server.
    </p>
</div>

<form method="post" action="result.php">
    <div class="demo-section k-content">
<?php
$upload = new \Kendo\UI\Upload('files[]');
$upload->attr('aria-label', 'files');

echo $upload->render();
?>
        <p style="padding-top: 1em; text-align: right">
            <input type="submit" value="Submit" class="k-button k-primary" />
        </p>
    </div>
</form>
<?php require_once '../include/footer.php'; ?>
