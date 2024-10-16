<?php

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

use Bitrix\Main\Web\Uri;
use Bitrix\Main\Application;

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

$arResult['sUrlPath'] = str_replace('/page-' . $arResult['NavPageNomer'], '', $arResult['sUrlPath']);
$arResult['sUrlPathParams'] = str_replace('/page-' . $arResult['NavPageNomer'], '', $arResult['sUrlPathParams']);

$arResult['reduct'] = [
    'begin_page' => [
        'conditions' => $arResult['NavPageNomer'] > 1,
        'links' => $arResult['sUrlPath'] . $strNavQueryStringFull
    ],
    'prev_page' => [
        'conditions' => $arResult['NavPageNomer'] > 2,
        'link_1' => $arResult['sUrlPath'] . 'page-' . ($arResult["NavPageNomer"] - 1) . '/' . $strNavQueryStringFull,
        'link_2' => $arResult["sUrlPath"] . $strNavQueryStringFull
    ],
    'dots' => [
        'first' => [
            'conditions' => [
                $arResult["NavPageNomer"] > 1,
                $arResult["nStartPage"] > 1,
                $arResult["nStartPage"] > 2
            ],
            'links' => [
                $arResult["sUrlPath"] . $strNavQueryStringFull,
                $arResult['sUrlPath'] . 'page-' . (round($arResult["nStartPage"] / 2)) . '/' . $strNavQueryStringFull
            ]
        ],
        'second' => [
            'conditions' => [
                $arResult["NavPageNomer"] < $arResult["NavPageCount"],
                $arResult["nEndPage"] < $arResult["NavPageCount"],
                $arResult["nEndPage"] < ($arResult["NavPageCount"] - 1)
            ],
            'links' => [
                $arResult['sUrlPath'] . 'page-' . (round($arResult["nEndPage"] + ($arResult["NavPageCount"] - $arResult["nEndPage"]) / 2)) . '/' . $strNavQueryStringFull,
                $arResult['sUrlPath'] . 'page-' . $arResult["NavPageCount"] . '/' . $strNavQueryStringFull,
            ]
        ]
    ],
    'pages' => [
        'conditions' => [
            $arResult["nStartPage"] == $arResult["NavPageNomer"],
            $arResult["nStartPage"] == 1,
        ],
        'links' => [
            $arResult["sUrlPath"] . $strNavQueryStringFull,
            // $arResult["sUrlPath"] . '?' . $strNavQueryString . 'page' . '=',
            $arResult['sUrlPath'] . 'page-',
            $strNavQueryStringFull
        ]
    ],
    'end_page' => [
        'conditions' => $arResult["NavPageNomer"] < $arResult["NavPageCount"],
        'link_next' => $arResult['sUrlPath'] . 'page-' . ($arResult["NavPageNomer"] + 1) . '/' . $strNavQueryStringFull,
        'link_end' => $arResult['sUrlPath'] . 'page-' . $arResult["NavPageCount"] . '/' . $strNavQueryStringFull
    ],
    'show_more' => [
        'link' => $arResult['sUrlPath'] . 'page-' . ($arResult["NavPageNomer"] + 1) . '/' . $strNavQueryStringFull
    ],
];