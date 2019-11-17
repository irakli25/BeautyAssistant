<?php
require_once '../lib/Kendo/Autoload.php';
require_once '../include/header.php';
?>


<div class="demo-section k-content">
    <h4>Rating Label</h4>
    <?php
        $rating = new \Kendo\UI\Rating('rating');

        $rating
            ->min(1)
            ->max(6)
            ->value(3);

        echo $rating->render();
     ?>
</div>

<div class="demo-section k-content">
    <h4>Rating Label Template</h4>
    <?php
        $ratingLabelTemplate = new \Kendo\UI\Rating('ratingLabelTemplate');

        $label = new \Kendo\UI\RatingLabel();
        $label->templateId('labelTemplate');

        $ratingLabelTemplate
            ->min(1)
            ->max(6)
            ->value(3)
            ->label($label);

        echo $ratingLabelTemplate->render();
     ?>

    <script id="labelTemplate" type="text/x-kendo-template">
        <span>#=value# out of #=maxValue#</span>
    </script>
</div>

<div class="demo-section k-content">
    <h4>Rating Without Label</h4>
    <?php
        $ratingLabelDisabled = new \Kendo\UI\Rating('ratingLabelDisabled');

        $ratingLabelDisabled
            ->min(1)
            ->max(6)
            ->value(3)
            ->label(false);

        echo $ratingLabelDisabled->render();
     ?>
</div>

<?php require_once '../include/footer.php'; ?>