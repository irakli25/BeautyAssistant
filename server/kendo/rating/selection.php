<?php
require_once '../lib/Kendo/Autoload.php';
require_once '../include/header.php';
?>

<div class="demo-section k-content">
    <h4>Continuous Selection</h4>
    <?php
        $ratingContinuous = new \Kendo\UI\Rating('ratingContinuous');

        $ratingContinuous
            ->min(1)
            ->max(6)
            ->value(3)
            ->selection('continuous');

        echo $ratingContinuous->render();
     ?>
</div>

<div class="demo-section k-content">
    <h4>Single Selection</h4>
    <?php
        $ratingSingle = new \Kendo\UI\Rating('ratingSingle');

        $ratingSingle
            ->min(1)
            ->max(6)
            ->value(3)
            ->selection('single');

        echo $ratingSingle->render();
     ?>
</div>

<?php require_once '../include/footer.php'; ?>