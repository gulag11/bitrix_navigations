<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	exit;
}

?>

<div>
	<div style="display: flex;gap: 17px;">
		<!-- Начало и Предыдущая страницы -->
		<div >
			<?php if ($arResult['reduct']['begin_page']['conditions']): ?>
				<a href="<?= $arResult['reduct']['begin_page']['links'] ?>">Начало</a>
				<?php if ($arResult['reduct']['prev_page']['conditions']): ?>
					<a href="<?= $arResult['reduct']['prev_page']['link_1'] ?>">Предыдущая</a>
				<? else: ?>
					<a href="<?= $arResult['reduct']['prev_page']['link_2'] ?>">Предыдущая</a>
				<? endif ?>
			<?php else: ?>
				<span>Начало</span> <b>#</b>
				<span>Предыдущая</span> <b>#</b>
			<?php endif; ?>
		</div>
		<!-- Начало и Предыдущая страницы -->
		<!-- основа построения пагинации -->
		<div>
			<?php if ($arResult['reduct']['dots']['first']['conditions'][0]): ?>
				<?php if ($arResult['reduct']['dots']['first']['conditions'][1]): ?>
					<a href="<?= $arResult['reduct']['dots']['first']['links'][0] ?>">1</a>
				<?php endif; ?>
				<?php if ($arResult['reduct']['dots']['first']['conditions'][2]): ?>
					<a href="<?= $arResult['reduct']['dots']['first']['links'][1] ?>">...</a>
				<?php endif; ?>
			<?php endif; ?>
			<?php do { 
					if ($arResult["nStartPage"] == $arResult["NavPageNomer"]): ?>
						<span><?= $arResult["nStartPage"] ?></span>
				<?php elseif ($arResult["nStartPage"] == 1): ?>
						<a href="<?= $arResult['reduct']['pages']['links'][0] ?>"><?= $arResult["nStartPage"] ?></a>
				<?php else: ?>
						<a href="<?= $arResult['reduct']['pages']['links'][1] . $arResult["nStartPage"] ?>"><?= $arResult["nStartPage"] ?></a>
				<?php endif;
					$arResult["nStartPage"]++;
				} while ($arResult["nStartPage"] <= $arResult["nEndPage"]); ?>
			<?php if ($arResult['reduct']['dots']['second']['conditions'][0]): ?>
				<?php if ($arResult['reduct']['dots']['second']['conditions'][1]): ?>
					<?php if ($arResult['reduct']['dots']['second']['conditions'][2]): ?>
						<a href="<?= $arResult['reduct']['dots']['second']['links'][0] ?>">...</a>
					<?php endif; ?>
						<a href="<?= $arResult['reduct']['dots']['second']['links'][1] ?>"><?= $arResult["NavPageCount"] ?></a>
				<?php endif; ?>
			<?php endif; ?>
		</div>
		<!-- основа построения пагинации -->
		<!-- Следующая и Конец страниц -->
		<div>
			<?php if ($arResult['reduct']['end_page']['conditions']): ?>
				<a href="<?= $arResult['reduct']['end_page']['link_next'] ?>">Следующая</a>
				<a href="<?= $arResult['reduct']['end_page']['link_end'] ?>">Конец</a>
			<? else: ?>
				<span>Следующая</span> <b>#</b>
				<span>Конец</span> <b>#</b>
			<? endif ?>
		</div>
	</div>
</div>
