<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

?>

<?php 
    if ($arParams['AJAX_PAGEN']) {
        $APPLICATION->RestartBuffer();
    }
?>

<div data-elems-box="<?=$arResult['NavNum']?>">
    <?php foreach ($arResult['ITEMS'] as $key => $item) : ?>
        <div data-elem-box><?=$item['NAME'];?></div>
    <?php endforeach; ?>
    <!-- производим вывод пагинации -->
    <?php echo $arResult['NAV_STRING']; ?>
</div>

<?php 
    if ($arParams['AJAX_PAGEN']) {
        exit;
    }
?>