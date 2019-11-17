<?php
require_once '../include/header.php';
require_once '../lib/Kendo/Autoload.php';

$transport = new \Kendo\Data\DataSourceTransport();

$read = new \Kendo\Data\DataSourceTransportRead();
$read->url('https://demos.telerik.com/kendo-ui/service/Northwind.svc/Products');

$transport->read($read);

$dataSource = new \Kendo\Data\DataSource();

$dataSource->transport($transport)
           ->pageSize(3)
           ->type("odata")
           ->serverPaging(true);

$scrollView = new \Kendo\UI\ScrollView('scrollView') ;
$scrollView ->contentHeight("100%");
$scrollView ->attr('style', 'height:500px; width:890px;');
$scrollView -> templateId('scrollview-template');
$scrollView -> dataSource($dataSource)

?>

<div id="example" style="margin:auto; width:70%">
<?php
echo $scrollView->render();
?>
<div class="box wide">
    <div class="box-col">
        <h4>Scroll to page</h4>
        <ul class="options">
            <li>
                <span class="k-textbox k-state-default"><input id="pageValue" value="4" class="k-input" style="float:none" /></span>
                <button id="set" class="k-button">Scroll</button>
            </li>
        </ul>
    </div>
        <div class="box-col">
            <h4>Next / Previous</h4>
            <ul class="options">
                <li>
                    <button id="next" class="k-button">Next</button>
                    <button id="previous" class="k-button">Previous</button>
                </li>
            </ul>
        </div>
    </div>
</div>
</div>

<script id="scrollview-template" type="text/x-kendo-template">
    # for (var i = 0; i < data.length; i++) { #
    <div>
        <div style="width: 100%; height: 100%; background-image: #=setBackground(data[i].ProductID)#;"></div>
        <p>#= data[i].ProductName #</p>
    </div>
    # } #
</script>

<script>
    function setBackground(id) {
        return "url(../content/shared/images/photos/" + (Math.floor(Math.random() * 28) + 1) + ".jpg)";
    }

    $(document).ready(function () {

        var scrollview = $("#scrollView").data("kendoScrollView");

        var setValue = function () {
            scrollview.scrollTo(parseInt($("#pageValue").val()));
        };

        $("#next").click(function () {
            scrollview.next();
        });

        $("#previous").click(function () {
            scrollview.prev();
        });

        $("#set").click(setValue);
    });
</script>

<style>
    #scrollView {
        max-width: 100%;
    }

    .k-scrollview-page > div {
        width: 100%;
        height: 100%;
    }

    .k-scrollview-page > div > div {
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
    }
</style>

<?php require_once '../include/footer.php'; ?>