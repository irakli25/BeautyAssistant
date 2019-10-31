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
$scrollView ->enablePager(false);
$scrollView ->contentHeight("100%");
$scrollView ->attr('style', 'height:600px; width:890px; max-width: 100%;');
$scrollView -> templateId('scrollview-template');
$scrollView -> dataSource($dataSource)

?>

<div id="example" style="margin:auto; width:70%">
<?php
echo $scrollView->render();
?>
</div>

<script id="scrollview-template" type="text/x-kendo-template">
    <div class="img-wrapper">
        # for (var i = 0; i < data.length; i++) { #
        <div>
            <div style="width: 140px; height: 140px; background-image: #=setBackground(data[i].ProductID)#; background-repeat:no-repeat; background-size: cover;"></div>
            <p>#= data[i].ProductName #</p>
        </div>
        # } #
    </div>
</script>

<script>
    function setBackground(id) {
        return "url(https://demos.telerik.com/kendo-ui/content/web/foods/" + id + ".jpg)";
    }
</script>

<style>

    div.k-scrollview ul.k-scrollview-wrap > li {
        text-align: center;
        display: table;
        box-sizing: border-box;
    }

    ul.k-scrollview-wrap > li > .img-wrapper {
        padding: 2em;
        display: table-cell;
        vertical-align: middle;
    }

    ul.k-scrollview-wrap > li > .img-wrapper > div {
        width: 30%;
        min-width: 150px;
        box-sizing: border-box;
        display: inline-block;
        vertical-align: top;
        margin-bottom: 1em;
    }

    ul.k-scrollview-wrap > li > .img-wrapper > div > div {
        margin: auto;
        margin-bottom: 0.5em;
    }

</style>

<?php require_once '../include/footer.php'; ?>