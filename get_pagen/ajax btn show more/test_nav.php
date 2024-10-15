<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Application;
use Bitrix\Main\Page\Asset;

echo '<style>body {background: #7b7755;}</style>';

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

Loader::includeModule('iblock');

$getData = Application::getInstance()->getContext()->getRequest()->getQueryList()->toArray();
$isAjax = Application::getInstance()->getContext()->getRequest()->isAjaxRequest();

?>
    <script src="/bitrix/js/main/core/core.js" ></script>
    <script src="<?=SITE_TEMPLATE_PATH?>/test_nav.js"></script>
<?php 


// https://dev.1c-bitrix.ru/user_help/components/content/articles_and_news/news_list.php

// PAGER_SHOW_ALWAYS    При отмеченной опции постраничная навигация будет выводиться всегда
// PAGER_TEMPLATE       Указывается название шаблона постраничной навигации.  
// DISPLAY_TOP_PAGER  При отмеченной опции постраничная навигация будет выведена вверху страницы, над списком.
// DISPLAY_BOTTOM_PAGER  При отмеченной опции постраничная навигация будет выведена внизу страницы, под списком.
// PAGER_SHOW_ALL  При отмеченной опции в постраничную навигацию будет добавлена ссылка Все
// PAGER_BASE_LINK_ENABLE При отмеченной опции доступна обработка ссылок для постраничной навигации. Становятся активными дополнительные поля.
    // PAGER_BASE_LINK    Задается адрес для построения ссылок. Если в параметре ничего не указывать, то адрес будет построен автоматически.
    // PAGER_PARAMS_NAME    Задается имя переменной, в которой передается массив с переменными для построения ссылок компонентом постраничной навигации.

// создаем массив параметров имя которого мы передаем в PAGER_PARAMS_NAME
// на основании данных этого массива будет формироваться строка get параметров в массиве $arResult['NavQueryString']
// $arrPager['get_param'] = 'val_param';
// вывод пагинации происходит в шаблоне компонента через echo $arResult['NAV_STRING'];

// производим замену page_ на PAGEN_ для сео 

if (isset($getData['page']) && intval($getData['page']) > 0) {
    $GLOBALS['PAGEN_1'] = $_REQUEST['PAGEN_1'] = $_GET['PAGEN_1'] = $_GET['page'];
    unset($_GET['page'], $_REQUEST['page'], $GLOBALS['page']);
}

// передаем переменную isAjax в параметр компонента template для RestartBuffer
//todo RestartBuffer();

$APPLICATION->IncludeComponent(
    'bitrix:news.list',
    'test_news_list',
    [
        'IBLOCK_ID' => '21',
        'NEWS_COUNT' => 5,
        'AJAX_PAGEN' => $isAjax, // передаем параметр который отслеживает ajax
        'GET_PARAMS' => $getData,

        'PAGER_SHOW_ALWAYS' => 'N', // ??????????
        'PAGER_BASE_LINK_ENABLE' => 'Y',
        'PAGER_TITLE' => 'test pagin title 1',
        'PAGER_TEMPLATE' => 'test_nav',
        'PAGER_DESC_NUMBERING' => 'N',
        'PAGER_DESC_NUMBERING_CACHE_TIME' => '36000',
        'PAGER_SHOW_ALL' => 'N',
        'PAGER_BASE_LINK' => '',
        'PAGER_PARAMS_NAME' => 'arrPager',
        
        'DISPLAY_TOP_PAGER' => 'N',
        'DISPLAY_BOTTOM_PAGER' => 'Y',

        'DISPLAY_DATE' => 'N',
        'DISPLAY_NAME' => 'N',
        'DISPLAY_PICTURE' => 'N',
        'DISPLAY_PREVIEW_TEXT' => 'N',
        'AJAX_MODE' => 'N',
        'SORT_BY1' => 'ACTIVE_FROM',
        'SORT_ORDER1' => 'DESC',
        'SORT_BY2' => 'SORT',
        'SORT_ORDER2' => 'ASC',
        'FILTER_NAME' => '',
        'FIELD_CODE' => [
            'NAME'
        ],
        'PROPERTY_CODE' => [
            'DESCRIPTION'
        ],
        'CHECK_DATES' => 'Y',
        'DETAIL_URL' => '',
        'PREVIEW_TRUNCATE_LEN' => '',
        'ACTIVE_DATE_FORMAT' => 'd.m.Y',
        'SET_TITLE' => 'N',
        'SET_BROWSER_TITLE' => 'N',
        'SET_META_KEYWORDS' => 'N',
        'SET_META_DESCRIPTION' => 'N',
        'SET_LAST_MODIFIED' => 'N',
        'INCLUDE_IBLOCK_INTO_CHAIN' => 'N',
        'ADD_SECTIONS_CHAIN' => 'N',
        'HIDE_LINK_WHEN_NO_DETAIL' => 'Y',
        'PARENT_SECTION' => '',
        'PARENT_SECTION_CODE' => '',
        'INCLUDE_SUBSECTIONS' => 'N',
        'CACHE_TYPE' => 'N',
        'CACHE_TIME' => '3600',
        'CACHE_FILTER' => 'N',
        'CACHE_GROUPS' => 'N',
        'SET_STATUS_404' => 'Y',
        'SHOW_404' => 'Y',
        'MESSAGE_404' => '',
        'AJAX_OPTION_JUMP' => 'N',
        'AJAX_OPTION_STYLE' => 'Y',
        'AJAX_OPTION_HISTORY' => 'N',
        'AJAX_OPTION_ADDITIONAL' => ''
    ]
);
