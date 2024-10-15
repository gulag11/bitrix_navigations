<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	exit;
}

?>

<div js-nav-box>
	<?php if ($arResult['reduct']['end_page']['conditions']): ?>
		<button js-show-more="<?= $arResult['reduct']['show_more']['link'] ?>">Показать еще</button>
	<?php endif; ?>
</div>
