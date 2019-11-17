<?php
require_once '../include/header.php';
require_once '../lib/Kendo/Autoload.php';

$scrollView = new \Kendo\UI\ScrollView('scrollView') ;
$scrollView ->contentHeight("100%");
$scrollView ->attr('style', 'height:748px; width:1022px; max-width: 100%;');

$item1 = new \Kendo\UI\ScrollViewItem();
$item1->startContent();
?>
    <div class='photo photo1'></div>
<?php
$item1->endContent();

$item2 = new \Kendo\UI\ScrollViewItem();
$item2->startContent();
?>
    <div class='photo photo2'></div>
<?php
$item2->endContent();

$item3 = new \Kendo\UI\ScrollViewItem();
$item3->startContent();
?>
    <div class='photo photo3'></div>
<?php
$item3->endContent();

$item4 = new \Kendo\UI\ScrollViewItem();
$item4->startContent();
?>
    <div class='photo photo4'></div>
<?php
$item4->endContent();

$item5 = new \Kendo\UI\ScrollViewItem();
$item5->startContent();
?>
    <div class='photo photo5'></div>
<?php
$item5->endContent();

$item6 = new \Kendo\UI\ScrollViewItem();
$item6->startContent();
?>
    <div class='photo photo6'></div>
<?php
$item6->endContent();

$item7 = new \Kendo\UI\ScrollViewItem();
$item7->startContent();
?>
    <div class='photo photo7'></div>
<?php
$item7->endContent();

$item8 = new \Kendo\UI\ScrollViewItem();
$item8->startContent();
?>
    <div class='photo photo8'></div>
<?php
$item8->endContent();

$item9 = new \Kendo\UI\ScrollViewItem();
$item9->startContent();
?>
    <div class='photo photo9'></div>
<?php
$item9->endContent();

$item10 = new \Kendo\UI\ScrollViewItem();
$item10->startContent();
?>
    <div class='photo photo10'></div>
<?php
$item10->endContent();

$scrollView-> addItem($item1, $item2, $item3, $item4, $item5, $item6, $item7, $item8, $item9, $item10)

?>

<div id="example" style="margin:auto; width:70%">
<?php
echo $scrollView->render();
?>
</div>

<?php require_once '../include/footer.php'; ?>

<style>

    #scrollView .photo {
        display: inline-block;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
        width:inherit;
        height:inherit;
    }

    .photo1 {
      background-image: url("../content/shared/images/photos/<?php echo rand(1,29) ?>.jpg");
    }

    .photo2 {
        background-image: url("../content/shared/images/photos/<?php echo rand(1,29) ?>.jpg");
    }

    .photo3 {
        background-image: url("../content/shared/images/photos/<?php echo rand(1,29) ?>.jpg");
    }

    .photo4 {
        background-image: url("../content/shared/images/photos/<?php echo rand(1,29) ?>.jpg");
    }

    .photo5 {
        background-image: url("../content/shared/images/photos/<?php echo rand(1,29) ?>.jpg");
    }

    .photo6 {
        background-image: url("../content/shared/images/photos/<?php echo rand(1,29) ?>.jpg");
    }

    .photo7 {
        background-image: url("../content/shared/images/photos/<?php echo rand(1,29) ?>.jpg");
    }

    .photo8 {
        background-image: url("../content/shared/images/photos/<?php echo rand(1,29) ?>.jpg");
    }

    .photo9 {
        background-image: url("../content/shared/images/photos/<?php echo rand(1,29) ?>.jpg");
    }

    .photo10 {
        background-image: url("../content/shared/images/photos/<?php echo rand(1,29) ?>.jpg");
    }
</style>