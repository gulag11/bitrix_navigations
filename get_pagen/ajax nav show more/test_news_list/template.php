<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

?>

<div js-parent-box>
    <?php
        if ($arParams['AJAX_PAGEN']) {
            $APPLICATION->RestartBuffer();
        }
    ?>

    <div js-elems-box="<?=$arResult['NavNum']?>">
        <?php foreach ($arResult['ITEMS'] as $key => $item) : ?>
            <div><?=$item['NAME'];?></div>
        <?php endforeach; ?>
        <!-- производим вывод пагинации -->
    </div>
    
    <?php echo $arResult['NAV_STRING']; ?>
    
    <?php
        if ($arParams['AJAX_PAGEN']) {
            exit;
        }
    ?>

</div>