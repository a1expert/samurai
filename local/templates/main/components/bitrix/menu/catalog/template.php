<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<ul class="submenu__list">
<?foreach($arResult as $arItem)
{
	if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
		continue;?>
	<li class="submenu__item"><a href="<?=$arItem["LINK"]?>" class="submenu__link"><?=$arItem["TEXT"]?></a></li>
	<?
}?>
</ul>
 <div class="hidden-menu">
    <button type="button" class="hidden-menu__toggler">burger_menu</button>
    <ul class="hidden-menu__list">
			
    </ul>
</div>