<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	exit;
}

// https://hmarketing.ru/blog/bitrix/svoy-shablon-postranichnoy-navigatsii/
// NavShowAlways всегда показывать постраничную навигацию,
// NavTitle название списка элементов, например «Статьи» или «Новости»
//      в компоненте это параметр PAGER_TITLE
// NavRecordCount общее количество статей (записей)
// NavPageCount общее количество страниц
// NavPageNomer номер текущей страницы
// NavPageSize количество статей на одну страницу
//      данный параметр в компоненте NEWS_COUNT
// bShowAll разрешено или нет показывать ссылку «Все статьи»
// 		в компоненте это параметр PAGER_SHOW_ALL
// NavShowAll равен true, если показываются все статьи, без постраничной навигации
// NavNum номер постраничной навигации (PAGEN_1, PAGEN_2, …) которые мы подменяем перед вызовом компонента
// bDescPageNumbering использовать или нет обратную постраничную навигацию
// nPageWindow количество страниц, которые отображаются в постраничной навигации
// 		в компоненте это параметр NEWS_COUNT
// bSavePage равна true если в главном модуле отмечена опция «Запоминать последнюю открытую страницу»
// sUrlPath путь к странице относительно корня
// NavQueryString строка GET-параметров
// nStartPage номер первой страницы слева для текущей страницы
// nEndPage номер первой страница справа для текущей страницы
// NavFirstRecordShow порядковый номер первой статьи на текущей странице
// NavLastRecordShow порядковый номер последней статьи на текущей странице

$bFirst = true;

if (!$arResult["NavShowAlways"]) {
	if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false)) {
		return;
	}
}

if ($arResult['NavQueryString']) {
	$arrGet = explode('&amp;', $arResult['NavQueryString']);

	$search = 'page_' . $arResult['NavNum'] . '=' . $arResult['NavPageNomer'];
	foreach ($arrGet as $key => $item) {
		// if (strpos($search, $item) !== false) {
		// 	unset($arrGet[$key]);
		// }
		
		if ($search == $item) {
			unset($arrGet[$key]);
		}

	}
	$arResult['NavQueryString'] = implode('&', $arrGet);
}

$strNavQueryString = $arResult['NavQueryString'] != '' ? $arResult['NavQueryString'] . '&amp;' : '';
$strNavQueryStringFull = $arResult['NavQueryString'] != '' ? '?' . $arResult['NavQueryString'] : '';

?>

<div data-nav-box="<?=$arResult['NavNum']?>">
	<div style="display: flex;gap: 17px;">
		<!-- Начало и Предыдущая страницы -->
		<div >
			<?php if ($arResult['NavPageNomer'] > 1): ?>
				<a href="<?= $arResult['sUrlPath'] . $strNavQueryStringFull ?>">Начало</a>
				<?php if ($arResult['NavPageNomer'] > 2): ?>
					<a href="<?= $arResult['sUrlPath'] . '?' . $strNavQueryString . 'page_' . $arResult['NavNum'] . '=' . ($arResult["NavPageNomer"] - 1) ?>">Предыдущая</a>
				<? else: ?>
					<a href="<?= $arResult["sUrlPath"] . $strNavQueryStringFull ?>">Предыдущая</a>
				<? endif ?>
			<?php else: ?>
				<!-- !!!! todo  -->
				<span>Начало</span> <b>#</b>
				<span>Предыдущая</span> <b>#</b>
			<?php endif; ?>
		</div>
		<!-- Начало и Предыдущая страницы -->
		<!-- основа построения пагинации -->
		<div>
			<?php if ($arResult["NavPageNomer"] > 1): ?>
				<?php if ($arResult["nStartPage"] > 1): ?>
					<a href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>">1</a>
				<?php endif; ?>
				<?php if ($arResult["nStartPage"] > 2): ?>
					<a href="<?= $arResult["sUrlPath"] . '?' . $strNavQueryString . 'page_' . $arResult['NavNum'] . '=' . round($arResult["nStartPage"] / 2) ?>">...</a>
				<?php endif; ?>
			<?php endif; ?>
			<?php do { 
					if ($arResult["nStartPage"] == $arResult["NavPageNomer"]): ?>
						<span><?= $arResult["nStartPage"] ?></span>
				<?php elseif ($arResult["nStartPage"] == 1): ?>
						<a href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>">
							<?= $arResult["nStartPage"] ?>
						</a>
				<?php else: ?>
						<a href="<?= $arResult["sUrlPath"] . '?' . $strNavQueryString . 'page_' . $arResult['NavNum'] . '=' . $arResult["nStartPage"] ?>">
							<?= $arResult["nStartPage"] ?>
						</a>
				<?php endif;
					$arResult["nStartPage"]++;
				} while ($arResult["nStartPage"] <= $arResult["nEndPage"]); ?>
			
			<?php if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]): ?>
				<?php if ($arResult["nEndPage"] < $arResult["NavPageCount"]): ?>
					<?php if ($arResult["nEndPage"] < ($arResult["NavPageCount"] - 1)): ?>
						<a href="<?= $arResult["sUrlPath"] . '?' . $strNavQueryString . 'page_' . $arResult['NavNum'] . '=' . round($arResult["nEndPage"] + ($arResult["NavPageCount"] - $arResult["nEndPage"]) / 2) ?>">...</a>
					<?php endif; ?>
						<a href="<?= $arResult["sUrlPath"] . '?' . $strNavQueryString . 'page_' . $arResult['NavNum'] . '=' . $arResult["NavPageCount"] ?>"><?= $arResult["NavPageCount"] ?></a>
				<?php endif; ?>
			<?php endif; ?>
		</div>
		<!-- основа построения пагинации -->
		<!-- Следующая и Конец страниц -->
		<div>
			<?php if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]): ?>
				<a href="<?= $arResult["sUrlPath"] . '?' . $strNavQueryString . 'page_' . $arResult['NavNum'] . '=' .($arResult["NavPageNomer"] + 1) ?>">Следующая</a>
				<a href="<?= $arResult["sUrlPath"] . '?' . $strNavQueryString . 'page_'. $arResult['NavNum'] .'='. $arResult["NavPageCount"] ?>">Конец</a>
			<? else: ?>
				<span>Следующая</span> <b>#</b>
				<span>Конец</span> <b>#</b>
			<? endif ?>
		</div>
	</div>
	<br>
	<!-- отображение элементов по страницам или все -->
	<?php if ($arResult['bShowAll']): ?>
		<div>
			<a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>SHOWALL_<?= $arResult['NavNum'] . '=' . ($arResult['NavShowAll'] ? '0' : '1') ?>">
				<?= $arResult['NavShowAll'] ? 'По страницам' : 'Все' ?>
			</a>
		</div>
	<? endif ?>
	<br>
	<!-- Кнопка показать еще -->
	<?php if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]): ?>
		<button data-navnum-="<?=$arResult['NavNum']?>" data-show-more="<?=$arResult['NavNum']?>" data-url-show-more="<?= $arResult["sUrlPath"] . '?' . $strNavQueryString . 'page_' . $arResult['NavNum'] . '=' . ($arResult["NavPageNomer"] + 1) ?>">Показать еще</button>
	<? endif ?>
</div>
