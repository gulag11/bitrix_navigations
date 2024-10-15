<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

?>

<div>
    <?php foreach ($arResult['ITEMS'] as $key => $item) : ?>
        <div><?=$item['NAME'];?></div>
    <?php endforeach; ?>
    <?= $arResult['NAV_STRING']; ?>
</div>
