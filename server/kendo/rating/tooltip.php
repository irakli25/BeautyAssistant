<?php
require_once '../lib/Kendo/Autoload.php';
require_once '../include/header.php';
?>

<div class="demo-section k-content">
    <h4>Rating</h4>
    <?php
        $rating = new \Kendo\UI\Rating('rating');

        echo $rating->render();
    ?>
</div>

<script>
    $(document).ready(function () {
        var rating = $("#rating").getKendoRating();

        rating.wrapper.kendoTooltip({
            filter: ".k-rating-item",
            content: function (e) {
                return e.target.data("title");
            }
        });
    });
</script>

<?php require_once '../include/footer.php'; ?>