<?php
require_once '../include/header.php';
require_once '../lib/Kendo/Autoload.php';

$media = new \Kendo\UI\MediaPlayerMedia('MediaPlayerMedia') ;
$media ->source("https://www.youtube.com/watch?v=Gp7tcOcSKAU");
$media ->title("ProgressNEXT 2018 Highlights");
$mediaPlayer = new \Kendo\UI\MediaPlayer('MediaPlayer') ;
$mediaPlayer->media($media);
$mediaPlayer->autoPlay(true);
$mediaPlayer->navigatable(true);
?>

<div class="demo-section k-content wide" style="max-width: 644px;">
<?php
echo $mediaPlayer->render();
?>
</div>

<?php require_once '../include/footer.php'; ?>

<style>
    .k-mediaplayer {
        height: 360px;
    }
</style>