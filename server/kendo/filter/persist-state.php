<?php

require_once '../lib/Kendo/Autoload.php';
require_once '../include/header.php';

?>
<div role="application">
<div class="box wide">
    <a href="#" class="k-button" id="save">Save State</a>
    <a href="#" class="k-button" id="load">Load State</a>
</div>
<script>

    window.contentPath = "../content/mobile/apps/sushi";
    window.dataSource1 = new kendo.data.DataSource({
        type: "odata",
        transport: {
            read: "https://demos.telerik.com/kendo-ui/service/Northwind.svc/Customers"
        },
        pageSize: 20
    });

    dataSource1.fetch(function () {
        var grid = $("#grid").data("kendoGrid");
        grid.setDataSource(this);
        filter = $("#filter").data("kendoFilter");
        filter.dataSource = this;
    });

</script>
<?php
    $filter = new \Kendo\UI\Filter("filter");
    $filter->applyButton(true);
    $filter->expressionPreview(true);
    $filter->expression(json_decode('{"logic":"or","filters":[{"field":"ContactTitle","value":"Sales Representative","operator":"eq"}]}'));

    $nameField = new \Kendo\UI\FilterField();

    $nameField->name("ContactName")
                    ->label("Contact Name");

    $companyField = new \Kendo\UI\FilterField();

    $companyField->name("CompanyName")
                    ->label("Company Name");

    $titleField = new \Kendo\UI\FilterField();

    $titleField->name("ContactTitle")
                  ->label("Contact Title");

    $country = new \Kendo\UI\FilterField();

    $country->name("Country")
                  ->label("Country");

    $filter->addField($nameField)
        ->addField($titleField)
        ->addField($country)
        ->addField($companyField);

    echo $filter->render();

?>

<br />
<br />
<br />

<?php
    $grid = new \Kendo\UI\Grid('grid');

    $contactName = new \Kendo\UI\GridColumn();
    $contactName->field('ContactName')
                ->template("<div class='customer-photo'style='background-image: url(../content/web/Customers/#:data.CustomerID#.jpg);'></div><div class='customer-name'>#: ContactName #</div>")
                ->title('Contact Name')
                ->width(240);

    $contactTitle = new \Kendo\UI\GridColumn();
    $contactTitle->field('ContactTitle')
                ->title('Contact Title');

    $companyName = new \Kendo\UI\GridColumn();
    $companyName->field('CompanyName')
                ->title('Company Name');

    $Country = new \Kendo\UI\GridColumn();
    $Country->field('Country')
            ->width(150);

    $pageable = new Kendo\UI\GridPageable();
    $pageable->refresh(true)
          ->pageSizes(true)
          ->buttonCount(5);

    $grid->addColumn($contactName, $contactTitle, $companyName, $Country)
         ->pageable($pageable)
         ->attr('style', 'height:550px');

    echo $grid->render();
    ?>
</div>

<script>
$(function() {
    var filter = $("#filter").getKendoFilter();
    filter.dataSource = dataSource1;
    filter.applyFilter();

    $("#save").click(function (e) {
        e.preventDefault();
        localStorage["kendo-filter-options"] = kendo.stringify(filter.getOptions());
    });
    $("#load").click(function (e) {
        e.preventDefault();
        var options = localStorage["kendo-filter-options"];
        if (options) {
            options = JSON.parse(options);
            options.dataSource = dataSource1;
            filter.setOptions(options);
            filter.applyFilter();
        }
    });
});
</script>

<style type="text/css">
    .customer-photo {
        display: inline-block;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-size: 32px 35px;
        background-position: center center;
        vertical-align: middle;
        line-height: 32px;
        box-shadow: inset 0 0 1px #999, inset 0 0 10px rgba(0,0,0,.2);
        margin-left: 5px;
    }

    .customer-name {
        display: inline-block;
        vertical-align: middle;
        line-height: 32px;
        padding-left: 3px;
    }
</style>
<?php require_once '../include/footer.php'; ?>