<?php
require_once '../include/header.php';
require_once '../lib/Kendo/Autoload.php';
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.2.2/pdf.js"></script>
<script>
    window.pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.2.2/pdf.worker.js';
</script>

<div id="example" class="demo-section k-content wide" style="height: 1200px;">
    <?php
    $pdfjs = new \Kendo\UI\PDFViewerPdfjsProcessing();
    $pdfjs->file("../content/web/pdfViewer/sample.pdf");

    $pdfViewer = new \Kendo\UI\PDFViewer('pdfViewer');
    $pdfViewer->pdfjsProcessing($pdfjs);

    echo $pdfViewer->render();
    ?>
</div>
<style>
    html body #pdfViewer {
        width: 100% !important;
    }
</style>
<?php require_once '../include/footer.php'; ?>
