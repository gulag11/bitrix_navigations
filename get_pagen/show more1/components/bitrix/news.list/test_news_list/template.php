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

<div js-elems-box>
    <?php foreach ($arResult['ITEMS'] as $key => $item) : ?>
        <div><?=$item['NAME'];?></div>
    <?php endforeach; ?>
    <?= $arResult['NAV_STRING']; ?>
</div>

<?php
    if ($arParams['AJAX_PAGEN']) {
        exit;
    }
?>