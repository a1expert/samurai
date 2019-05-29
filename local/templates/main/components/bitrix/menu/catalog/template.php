<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<ul class="submenu__list">
<?foreach($arResult as $arItem)
{
	if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
		continue;?>
	<li class="submenu__item"><a href="<?=$arItem["LINK"]?>" class="submenu__link"><?=$arItem["TEXT"]?></a></li>
	<?
}?>
	<li class="submenu__item"><button type="button" class="submenu__toggler">burger_menu</button></li>
</ul>