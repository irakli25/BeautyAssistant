<?php
require_once '../include/header.php';
require_once '../lib/Kendo/Autoload.php';

$numeric = new \Kendo\UI\NumericTextBox('numeric');
$numeric->value(17)
        ->min(0)
        ->max(100)
        ->step(1)
        ->attr('style', 'width: 100%')
        ->attr('title', 'numeric');

$currency = new \Kendo\UI\NumericTextBox('currency');
$currency->format('c')
         ->value(30)
         ->min(0)
         ->max(100)
         ->decimals(3)
         ->attr('style', 'width: 100%')
         ->attr('title', 'currency');

$percentage = new \Kendo\UI\NumericTextBox('percentage');
$percentage->format('p0')
           ->value(0.05)
           ->min(0)
           ->max(0.1)
           ->step(0.01)
           ->attr('style', 'width: 100%')
           ->attr('title', 'percentage');

$custom = new \Kendo\UI\NumericTextBox('custom');
$custom->format('#.00 kg')
       ->value(2)
       ->attr('style', 'width: 100%')
       ->attr('title', 'custom');

?>
<div id="add-product" class="demo-section k-content">
    <p class="title">Add new product</p>
    <ul id="fieldlist">
        <li>
            <label for="currency">Price:</label>
        <?= $currency->render() ?>
 </li>
 <li>
    <label for="percentage">Price Discount:</label>
        <?= $percentage->render() ?>
 </li>
 <li>
        <label for="custom">Weight:</label>
        <?= $custom->render() ?>
    </li>
    <li>
        <label for="numeric">Currently in stock:</label>
        <?= $numeric->render() ?>
   </li>
 </ul>
</div>
 <style>
    .demo-section {
        padding: 0;
    }

    #add-product .title {
        font-size: 16px;
        color: #fff;
        background-color: #1e88e5;
        padding: 20px 30px;
        margin: 0;
   }

   #fieldlist {
       margin: 0 0 -1.5em;
       padding: 30px;
   }

   #fieldlist li {
       list-style: none;
       padding-bottom: 1.5em;
   }

   #fieldlist label {
       display: block;
       padding-bottom: .6em;
       font-weight: bold;
       text-transform: uppercase;
       font-size: 12px;
   }

</style>
<?php require_once '../include/footer.php'; ?>
