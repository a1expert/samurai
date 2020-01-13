<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<ul class="submenu__list">
<?$i = 0;
foreach($arResult as $arItem)
{
	if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
		continue;
	if($i == 10)
	{?>
		<li class="submenu__item submenu__item--toggler">
			<button type="button" class="submenu__toggler">burger_menu</button>
			<ul class="submenu__responsive-list">
				<li class="submenu__item"><a href="<?=$arItem["LINK"]?>" class="submenu__link"><?=$arItem["TEXT"]?></a></li><?
	}
	else
	{?>
		<li class="submenu__item"><a href="<?=$arItem["LINK"]?>" class="submenu__link"><?=$arItem["TEXT"]?></a></li><?
	}
	$i++;
}
if($i >= 10)
	echo '</ul>
	</li>';?>	
</ul>