<?php
require_once '../include/header.php';
require_once '../lib/Kendo/Autoload.php';

$slider = new \Kendo\UI\Slider('slider');

$slider->attr('class', 'balSlider')
       ->increaseButtonTitle('Right')
       ->decreaseButtonTitle('Left')
       ->min(-10)
       ->max(10)
       ->value(0)
       ->smallStep(2)
       ->largeStep(1)
       ->attr('title', 'slider');

function eqSlider($index, $value) {
    $eqSlider = new \Kendo\UI\Slider("eqSlider$index");

    $eqSlider->attr('class', 'eqSlider')
             ->orientation('vertical')
             ->min(-20)
             ->max(20)
             ->smallStep(1)
             ->largeStep(20)
             ->value($value)
             ->showButtons(false)
             ->attr('title', 'eqSlider1');

    return $eqSlider;
}

?>
<div class="demo-section k-content">
    <h4>Balance</h4>
    <?= $slider->render() ?>
    <h4 style="padding-top: 2em;">Equalizer</h4>
    <div id="equalizer">
        <?= eqSlider(1, 10)->render() ?>
        <?= eqSlider(2, 5)->render() ?>
        <?= eqSlider(3, 0)->render() ?>
        <?= eqSlider(4, 10)->render() ?>
        <?= eqSlider(5, 15)->render() ?>
    </div>
</div>

<style>
    .demo-section {
        text-align: center;
    }

    #equalizer {
        padding-right: 15px;
    }

    div.balSlider {
        width: 100%;
    }

    div.balSlider .k-slider-selection {
        display: none;
    }

    div.eqSlider {
        display: inline-block;
        margin: 1em;
        height: 122px;
        vertical-align: top;
    }
</style>

<?php require_once '../include/footer.php'; ?>
