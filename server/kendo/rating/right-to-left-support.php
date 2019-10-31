<?php
require_once '../lib/Kendo/Autoload.php';
require_once '../include/header.php';
?>

<div class="demo-section k-content center k-rtl">
    <h4>Rating</h4>
    <?php
        $rating = new \Kendo\UI\Rating('rating');

        echo $rating->render();
     ?>
</div>

<?php require_once '../include/footer.php'; ?>