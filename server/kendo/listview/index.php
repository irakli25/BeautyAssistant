<?php

require_once '../lib/DataSourceResult.php';
require_once '../lib/Kendo/Autoload.php';

$result = new DataSourceResult('sqlite:..//sample.db');

$data = $result->read('Products', array('ProductID', 'ProductName', 'UnitPrice', 'UnitsInStock', 'Discontinued'));

require_once '../include/header.php';

?>

<script type="text/x-kendo-tmpl" id="template">
    <div class="product">
        <img src="../content/web/foods/#:ProductID#.jpg" alt="#:ProductName# image" />
        <h3>#:ProductName#</h3>
        <p>#:kendo.toString(UnitPrice, "c")#</p>
    </div>
</script>

<div class="demo-section k-content wide">
<?php

    $model = new \Kendo\Data\DataSourceSchemaModel();

$productNameField = new \Kendo\Data\DataSourceSchemaModelField('ProductName');
$productNameField->type('string');

$unitPriceField = new \Kendo\Data\DataSourceSchemaModelField('UnitPrice');
$unitPriceField->type('number');

$unitsInStockField = new \Kendo\Data\DataSourceSchemaModelField('UnitsInStock');
$unitsInStockField->type('number');

$discontinuedField = new \Kendo\Data\DataSourceSchemaModelField('Discontinued');
$discontinuedField->type('boolean');

$model->addField($productNameField)
      ->addField($unitPriceField)
      ->addField($unitsInStockField)
      ->addField($discontinuedField);

$schema = new \Kendo\Data\DataSourceSchema();
$schema->data('data')
       ->model($model)
       ->total('total');

$dataSource = new \Kendo\Data\DataSource();

$dataSource->data($data)
           ->pageSize(20)
           ->schema($schema);

    $listview = new \Kendo\UI\ListView('listView');
    $listview->dataSource($dataSource)
             ->templateId('template')
             ->pageable(true);

    echo $listview->render();
?>
</div>

<style>
    #listView {
        padding: 10px 5px;
        margin-bottom: -1px;
        min-height: 510px;
        /* Avoid cutout if font or line is bigger */
        font: inherit;
    }
    .product {
        float: left;
        position: relative;
        width: 111px;
        height: 170px;
        margin: 0 5px;
        padding: 0;
    }
    .product img {
        width: 110px;
        height: 110px;
    }
    .product h3 {
        margin: 0;
        padding: 3px 5px 0 0;
        max-width: 96px;
        overflow: hidden;
        line-height: 1.1em;
        font-size: .9em;
        font-weight: normal;
        text-transform: uppercase;
        color: #999;
    }
    .product p {
        visibility: hidden;
    }
    .product:hover p {
        visibility: visible;
        position: absolute;
        width: 110px;
        height: 110px;
        top: 0;
        margin: 0;
        padding: 0;
        line-height: 110px;
        vertical-align: middle;
        text-align: center;
        color: #fff;
        background-color: rgba(0,0,0,0.75);
        transition: background .2s linear, color .2s linear;
        -moz-transition: background .2s linear, color .2s linear;
        -webkit-transition: background .2s linear, color .2s linear;
        -o-transition: background .2s linear, color .2s linear;
    }
    .k-listview:after {
        content: ".";
        display: block;
        height: 0;
        clear: both;
        visibility: hidden;
    }
</style>

<?php require_once '../include/footer.php'; ?>
