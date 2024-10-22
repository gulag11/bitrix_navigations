<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	exit;
}

?>

<div js-nav-box>
	<div style="display: flex;gap: 17px;">
		<div >
			<?php foreach ($arResult['buttons']['left_btns'] as $item) : ?>
				<?php if ($item['link']): ?>
					<a href="<?= $item['link'] ?>"><?=$item['name']?></a>
				<?php else: ?>
					<span><?=$item['name']?></span>
				<?php endif; ?>	
			<?php endforeach; ?>
		</div>
		<!-- основа построения пагинации -->
		<div>
			<?php foreach ($arResult['pages'] as $item) : ?>
				<?php if (!$item['link']) : ?>
					<span><?=$item['num']?></>
				<?php else : ?>
					<a href="<?=$item['link']?>"><?=$item['num']?></a>
				<?php endif; ?>
			<?php endforeach ; ?>
		</div>
		<!-- основа построения пагинации -->
		<div>
			<?php foreach ($arResult['buttons']['right_btns'] as $item) : ?>
				<?php if ($item['link']): ?>
					<a href="<?= $item['link'] ?>"><?=$item['name']?></a>
				<?php else: ?>
					<span><?=$item['name']?></span>
				<?php endif; ?>	
			<?php endforeach; ?>
		</div>
	</div>
	<br>
	<!-- Кнопка показать еще -->
	<?php if ($arResult['buttons']['show_more']): ?>
		<button js-show-more="<?= $arResult['buttons']['show_more']['link'] ?>">
			<?=$arResult['buttons']['show_more']['name']?>
		</button>
	<? endif ?>
</div>