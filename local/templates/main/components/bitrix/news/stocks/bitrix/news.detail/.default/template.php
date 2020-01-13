<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
ShowRes($arResult);
?>
#anchor#
<div class="stock-popup">
	<div class="stock-popup__header" style="background-image: url(<?=$arResult['DETAIL_PICTURE']['SRC'];?>)"></div>
	<div class="stock-popup__body">
		<h3 class="stock-popup__title"><?=$arResult['NAME'];?></h3>
		<div class="stock-popup__text"><?=$arResult['PREVIEW_TEXT'] ?></div>
		<p class="stock-popup__note">*<?=$arResult['DISPLAY_PROPERTIES']['ADDCOND']['DISPLAY_VALUE'];?></p>
	</div>
	<div class="stock-popup__footer">
		<p class="stock-popup__footer-note">Поделиться с друзьями:</p>
		<ul class="socials socials--invert socials--small">
		<li class="socials__item">
			<a class="socials__link socials__link--vk" href="#">
				<svg xmlns:xlink="http://www.w3.org/1999/xlink">
					<use xlink:href="/local/assets/images/icon.svg#icon_vk"></use>
				</svg>	
			</a>		
		</li>			
		<li class="socials__item">
			<a class="socials__link socials__link--fb" href="#">
				<svg xmlns:xlink="http://www.w3.org/1999/xlink">
					<use xlink:href="/local/assets/images/icon.svg#icon_facebook"></use>
				</svg>
			</a>		
		</li>			
		<li class="socials__item">
			<a class="socials__link socials__link--inst" href="#"> 
				<svg xmlns:xlink="http://www.w3.org/1999/xlink">
					<use xlink:href="/local/assets/images/icon.svg#icon_instagram"></use>
				</svg>
			</a>		
		</li>			
		<li class="socials__item">
			<a class="socials__link socials__link--ok" href="#">
				<svg xmlns:xlink="http://www.w3.org/1999/xlink">
					<use xlink:href="/local/assets/images/icon.svg#icon_odnoklassniki"></use>
				</svg>
			</a>		
		</li>			
		</ul>			
	</div>
</div>
#endanchor#