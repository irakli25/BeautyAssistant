<?php
require_once '../include/header.php';
require_once '../lib/Kendo/Autoload.php';

$phone_number = new \Kendo\UI\MaskedTextBox('phone_number');
$phone_number->value("555 123 4567")
             ->mask("(999) 000-0000");

$credit_card = new \Kendo\UI\MaskedTextBox('credit_card');
$credit_card->value("1234 1234 1234 1234")
            ->mask("0000 0000 0000 0000");

$ssn = new \Kendo\UI\MaskedTextBox('ssn');
$ssn->value("003-12-3456")
    ->mask( "000-00-0000");

$postcode = new \Kendo\UI\MaskedTextBox('postcode');
$postcode->value("W1N 1AC")
         ->mask( "L0L 0LL");

?>

<div class="demo-section k-content">
    <ul id="fieldlist">
        <li>
            <label for="phone_number">Phone number:</label>
            <?= $phone_number->render() ?>
        </li>
        <li>
            <label for="credit_card">Credit Card number:</label>
            <?= $credit_card->render() ?>
        </li>
        <li>
            <label for="ssn">Social security number:</label>
            <?= $ssn->render() ?>
        </li>
        <li>
            <label for="postcode">UK postcode:</label>
            <?= $postcode->render() ?>
        </li>
    </ul>
</div>

<style>
    #fieldlist {
        margin: 0 0 -2em;
        padding: 0;
    }

    #fieldlist li {
        list-style: none;
        padding-bottom: 2em;
    }

    #fieldlist label {
        display: block;
        padding-bottom: 1em;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 12px;
        color: #444;
    }

    #fieldlist input {
        width: 100%;
    }
</style>

<?php require_once '../include/footer.php'; ?>
