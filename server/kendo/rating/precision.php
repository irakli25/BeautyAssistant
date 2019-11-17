<?php
require_once '../lib/Kendo/Autoload.php';
require_once '../include/header.php';
?>

<div class="demo-section k-content">
    <h4>Item Precision</h4>
    <?php
        $ratingItem = new \Kendo\UI\Rating('ratingItem');

        $ratingItem
            ->min(1)
            ->max(6)
            ->value(3)
            ->precision('item');

        echo $ratingItem->render();
     ?>
</div>

<div class="demo-section k-content">
    <h4>Half Precision</h4>
    <?php
        $ratingHalf = new \Kendo\UI\Rating('ratingHalf');

        $ratingHalf
            ->min(1)
            ->max(6)
            ->value(3.5)
            ->precision('half');

        echo $ratingHalf->render();
     ?>
</div>

<?php require_once '../include/footer.php'; ?>