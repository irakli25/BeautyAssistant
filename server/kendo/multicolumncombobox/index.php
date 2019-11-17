<?php
require_once '../include/header.php';
require_once '../lib/Kendo/Autoload.php';
?>

<?php
$transport = new \Kendo\Data\DataSourceTransport();

$read = new \Kendo\Data\DataSourceTransportRead();

$read->url('http://demos.telerik.com/kendo-ui/service/Northwind.svc/Customers');

$transport->read($read);

$dataSource = new \Kendo\Data\DataSource();

$dataSource->type('odata')
           ->transport($transport);

$multicolumncomboBox = new \Kendo\UI\MultiColumnComboBox('customers');

$multicolumncomboBox->dataSource($dataSource)
         ->dataTextField('ContactName')
         ->dataValueField('CustomerID')
         ->filter('contains')
         ->filterFields(array('ContactName', 'ContactTitle', 'CompanyName', 'Country'))
         ->addColumn(
            array('field' => 'ContactName', 'title' => 'Contact Name', 'template' => '<div class="customer-photo" style="background-image: url(../content/web/Customers/#:data.CustomerID#.jpg);"></div><span class="customer-name">#: ContactName #</span>', 'width' => 200),
            array('field' => 'ContactTitle', 'title' => 'Contact Title', 'width' => 200),
            array('field' => 'CompanyName', 'title' => 'Company Name', 'width' => 200),
            array('field' => 'Country', 'title' => 'Country', 'width' => 200)
           )
        ->footerTemplate('Total #: instance.dataSource.total() # items found')
         ->attr('style', 'width: 100%;');

?>
<div class="demo-section k-content">
    <h4>Customers</h4>
<?php
echo $multicolumncomboBox->render();
?>
    <div class="demo-hint">Hint: You can filter by the fields defined in the filterFields option.</div>
</div>

<style type="text/css">
    .customer-photo {
        display: inline-block;
        box-shadow: inset 0 0 1px #999, inset 0 0 10px rgba(0,0,0,.2);
        margin: 0 10px 0;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-size: 100%;
        background-repeat: no-repeat;
        vertical-align: middle;
    }
</style>

<?php require_once '../include/footer.php'; ?>
