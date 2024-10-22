<?php

// https://hmarketing.ru/blog/bitrix/svoy-shablon-postranichnoy-navigatsii/
// NavShowAlways всегда показывать постраничную навигацию,
// NavTitle название списка элементов, например «Статьи» или «Новости»
//      в компоненте это параметр PAGER_TITLE
// NavRecordCount общее количество статей (записей)
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

// NavPageCount общее количество страниц
// NavPageNomer номер текущей страницы
// nStartPage номер первой страницы слева для текущей страницы
// nEndPage номер первой страница справа для текущей страницы

// NavFirstRecordShow порядковый номер первой статьи на текущей странице
// NavLastRecordShow порядковый номер последней статьи на текущей странице

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit;
}

$strNavQueryString = $arResult['NavQueryString'] != '' ? $arResult['NavQueryString'] . '&amp;' : '';
$strNavQueryStringFull = $arResult['NavQueryString'] != '' ? '?' . $arResult['NavQueryString'] : '';

if (!$arResult["NavShowAlways"]) {
	if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false)) {
		return;
	}
}

$left = 3;
$right = 3;

$arResult['pages'] = [];
$arResult['buttons']['left_btns'] = [];
$arResult['buttons']['right_btns'] = [];
$arResult['buttons']['show_more'] = [];

// тут задаем кол-во страниц слева и справа от текущей страницы
if ($left) {
	$arResult["nStartPage"] = $arResult['NavPageNomer'] > $left ? $arResult['NavPageNomer'] - $left : 1;
}

if ($right) {
	$arResult["nEndPage"] = $arResult['NavPageNomer'] + $right < $arResult['NavPageCount'] ? $arResult['NavPageNomer'] + $right : $arResult['NavPageCount'];
}

// create pages
if ($arResult["NavPageNomer"] > 1) {
	if ($arResult["nStartPage"] > 1) {
		$arResult['pages'][] = [
			'num' => '1',
			'link' => $arResult["sUrlPath"] . $strNavQueryStringFull
		];
	}

	if ($arResult["nStartPage"] > 2) {
		$arResult['pages'][] = [
			'num' => '...',
			'link' => $arResult["sUrlPath"] . '?' . $strNavQueryString . 'page' . '=' . round($arResult["nStartPage"] / 2)
		];
	}
}

do {
	if ($arResult["nStartPage"] == $arResult["NavPageNomer"]) {
		$arResult['pages'][] = [
			'num' => $arResult["nStartPage"],
		];
	} elseif ($arResult["nStartPage"] == 1) {
		$arResult['pages'][] = [
			'num' => $arResult["nStartPage"],
			'link' => $arResult["sUrlPath"] . $strNavQueryStringFull
		];
	} else {
		$arResult['pages'][] = [
			'num' => $arResult["nStartPage"],
			'link' => $arResult["sUrlPath"] . '?' . $strNavQueryString . 'page' . '=' . $arResult["nStartPage"]
		];
	}
	$arResult["nStartPage"]++;
} while ($arResult["nStartPage"] <= $arResult["nEndPage"]);

if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]) {
	if ($arResult["nEndPage"] < $arResult["NavPageCount"]) {
		if ($arResult["nEndPage"] < ($arResult["NavPageCount"] - 1)) {
			$arResult['pages'][] = [
				'num' => '...',
				'link' => $arResult["sUrlPath"] . '?' . $strNavQueryString . 'page' . '=' . round($arResult["nEndPage"] + ($arResult["NavPageCount"] - $arResult["nEndPage"]) / 2)
			];
		}
		$arResult['pages'][] = [
			'num' => $arResult["NavPageCount"],
			'link' => $arResult["sUrlPath"] . '?' . $strNavQueryString . 'page' . '=' . $arResult["NavPageCount"]
		];
	}
}


// create buttons
	// left_btns (Начало, Предыдущая)
if ($arResult['NavPageNomer'] > 1) {
	$arResult['buttons']['left_btns']['begin'] = [
		'name' => 'Начало',
		'link' => $arResult['sUrlPath'] . $strNavQueryStringFull,
	];
	$arResult['buttons']['left_btns']['prev'] = [
		'name' => 'Предыдущая',
		'link' => $arResult['NavPageNomer'] > 2
		? $arResult['sUrlPath'] . '?' . $strNavQueryString . 'page' . '=' . ($arResult["NavPageNomer"] - 1) :
		$arResult["sUrlPath"] . $strNavQueryStringFull,
	];
} else {
	$arResult['buttons']['left_btns']['begin'] = [
		'name' => 'Начало',
	];
	$arResult['buttons']['left_btns']['prev'] = [
		'name' => 'Предыдущая',
	];
}

// right_btns
if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]) {
	$arResult['buttons']['right_btns']['next'] = [
		'name' => 'Следующая',
		'link' => $arResult["sUrlPath"] . '?' . $strNavQueryString . 'page' . '=' .($arResult["NavPageNomer"] + 1),
	];
	$arResult['buttons']['right_btns']['end'] = [
		'name' => 'Конец',
		'link' => $arResult["sUrlPath"] . '?' . $strNavQueryString . 'page' . '='. $arResult["NavPageCount"],
	];
} else {
	$arResult['buttons']['right_btns']['next'] = [
		'name' => 'Следующая',
	];
	$arResult['buttons']['right_btns']['end'] = [
		'name' => 'Конец',
	];
}

// show_more
if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]) {
	$arResult['buttons']['show_more'] = [
		'name' => 'Показать еще',
		'link' => $arResult["sUrlPath"] . '?' . $strNavQueryString . 'page' . '=' . ($arResult["NavPageNomer"] + 1)
	];
}
