<?php

require_once '../lib/Kendo/Autoload.php';
require_once '../include/header.php';

?>
<div role="application">
<script src="../content/shared/js/products.js"></script>
<script>

    window.contentPath = "../content/mobile/apps/sushi";
    window.dataSource1 = new kendo.data.DataSource({
        pageSize: 20,
        data: products,
        schema: {
            model: {
                id: "ProductID",
                fields: {
                    ProductID: { editable: false, nullable: true },
                    ProductName: { validation: { required: true } },
                    Category: { defaultValue: { CategoryID: 1, CategoryName: "Beverages" } },
                    UnitPrice: { type: "number", validation: { required: true, min: 1 } }
                }
            }
        }
    });

    function unitPriceEditor(container, options) {
        $('<input data-bind="value: value" name="' + options.field + '"/>')
            .appendTo(container)
            .kendoNumericTextBox();
    }

    function categoryDropDownEditor(container, options) {
        $('<input data-bind="value: value" name="' + options.field + '"/>')
            .appendTo(container)
            .kendoDropDownList({
                dataTextField: "CategoryName",
                dataValueField: "CategoryID",
                dataSource: {
                    type: "odata",
                    transport: {
                        read: "https://demos.telerik.com/kendo-ui/service/Northwind.svc/Categories"
                    }
                }
            });
    }

</script>
<?php
    $filter = new \Kendo\UI\Filter("filter");
    $filter->applyButton(true);

    $nameField = new \Kendo\UI\FilterField();

    $nameField->name("ProductName")
                    ->label("Product Name");

    $categoryField = new \Kendo\UI\FilterField();

    $categoryField->name("CategoryID")
                    ->type("number")
                    ->defaultValue(1)
                    ->editorTemplateHandler("categoryDropDownEditor")
                    ->label("Category");

    $priceField = new \Kendo\UI\FilterField();

    $priceField->name("UnitPrice")
                    ->type("number")
                    ->editorTemplateHandler("unitPriceEditor")
                    ->label("Unit Price");

    $unitsField = new \Kendo\UI\FilterField();

    $unitsField->name("UnitsInStock")
                    ->type("number")
                    ->label("Units In Stock");

    $quantityField = new \Kendo\UI\FilterField();

    $quantityField->name("QuantityPerUnit")
                  ->label("Quantity Per Unit");

    $filter->addField($nameField)
        ->addField($categoryField)
        ->addField($priceField)
        ->addField($quantityField)
        ->addField($unitsField);

    echo $filter->render();

?>

<br />
<br />
<br />

<?php
    $grid = new \Kendo\UI\Grid('grid');

    $productName = new \Kendo\UI\GridColumn();
    $productName->field('ProductName')
                ->title('Product Name');

    $category = new \Kendo\UI\GridColumn();
    $category->field('Category')
                ->template("#=Category.CategoryName#")
                ->title('Category');

    $unitPrice = new \Kendo\UI\GridColumn();
    $unitPrice->field('UnitPrice')
                ->format('{0:c}')
                ->title('Unit Price');

    $unitsInStock = new \Kendo\UI\GridColumn();
    $unitsInStock->field('UnitsInStock')
                ->title('Units In Stock');

    $quantity = new \Kendo\UI\GridColumn();
    $quantity->field('QuantityPerUnit')
                ->title('Quantity Per Unit');

    $pageable = new Kendo\UI\GridPageable();
    $pageable->refresh(true)
          ->pageSizes(true)
          ->buttonCount(5);

    $grid->addColumn($productName, $category, $unitPrice, $unitsInStock, $quantity)
         ->pageable($pageable)
         ->attr('style', 'height:550px');

    echo $grid->render();
    ?>
</div>
<script>
    $(document).ready(function () {
        var grid = $("#grid").data("kendoGrid");
        grid.setDataSource(dataSource1);
        filter = $("#filter").data("kendoFilter");
        filter.dataSource = dataSource1;
    });
</script>
<?php require_once '../include/footer.php'; ?>