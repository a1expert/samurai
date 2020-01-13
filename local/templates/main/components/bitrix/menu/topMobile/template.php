<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
// ShowRes($arResult);
$catalog = [];
$menu = [];
foreach ($arResult as $i => $v)
{
	if($v['PARAMS']['FROM_IBLOCK'] == true)
	{
		$catalog[] = $v;
	}
	else
	{
		$menu[] = $v;
	}
}?>
<div class="mobile-menu">
	<div class="mobile-menu__scroll">
		<div class="mobile-menu__header">
			<img src="/local/assets/styles/images/logo_colored.png" alt="" class="mobile-menu__logo">
			<button class="mobile-menu__close"></button>
		</div>
		<div class="mobile-menu__body">
			<div class="mobile-menu__accordeon">
				<div class="mobile-menu__item mobile-menu__item--dropdown"><a href="#">Меню</a>
					<ul class="mobile-menu__dropdown">
					<?foreach ($catalog as $item)
					{?>
						<li class="mobile-menu__dropdown-item"><a href="<?=$item['LINK'];?>"><?=$item['TEXT'];?></a></li>
						<?
					}?>
					</ul>
				</div>
				<?foreach ($menu as $item)
				{?>
					<div class="mobile-menu__item"><a href="<?=$item['LINK'];?>"><?=$item['TEXT'];?></a></div>
					<?
				}?>
			</div>
		</div>
		<div class="mobile-menu__footer">
			<ul class="mobile-menu__list">
				<li class="mobile-menu__list-item">
					<a href="#" class="jsCityToggler">
						<svg xmlns:xlink="http://www.w3.org/1999/xlink">
							<use xlink:href="http://butorin-e-v1.myjino.ru/local/assets/images/icon.svg#icon_timer"></use>
						</svg>
						Сургут
					</a>
				</li>
				<li class="mobile-menu__list-item">
					 <a href="tel:88005553535">
					 <svg xmlns:xlink="http://www.w3.org/1999/xlink">
							<use xlink:href="http://butorin-e-v1.myjino.ru/local/assets/images/icon.svg#icon_phone"></use>
						</svg>
				 88005553535</a>
				</li>
				<li class="mobile-menu__list-item">
					<a href="#">
						 <svg xmlns:xlink="http://www.w3.org/1999/xlink">
							<use xlink:href="http://butorin-e-v1.myjino.ru/local/assets/images/icon.svg#icon_user"></use>
						</svg>	
						Личный кабинет
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>