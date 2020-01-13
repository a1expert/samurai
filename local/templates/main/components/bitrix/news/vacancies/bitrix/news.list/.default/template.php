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
// ShowRes($arResult);
?>
<section class="vacancies main">
	<div class="main__wrapper">
		<div class="main__container container">
			<h1 class="visually-hidden">Список вакансий</h1>
			<p class="vacancies__lead"><strong class="vacancies__stong">Общие требования к соискателям:</strong> <?=$arResult['DESCRIPTION'];?></p>
			<ul class="vacancies__list">
			<?foreach($arResult['ITEMS'] as $arItem)
			{
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));?>
				<li class="vacancies__item vacancyCard">
					<div class="vacancyCard__avatar vacancyCard__avatar avatar" style="background-image: url(<?=$arItem['PREVIEW_PICTURE']['SRC'];?>);"></div>
					<h3 class="vacancyCard__header"><?=$arItem['NAME']?></h3>
					<div class="vacancyCard__text-wrapper">
						<p class="vacancyCard__text">Зарплата: <b class="vacancyCard__bold">от <?=$arItem['DISPLAY_PROPERTIES']['SALARY']['DISPLAY_VALUE'];?> ₽</b></p>
						<p class="vacancyCard__text">График работы: <b class="vacancyCard__bold"><?=$arItem['DISPLAY_PROPERTIES']['WORK_TIME']['DISPLAY_VALUE'];?></b></p>
						<p class="vacancyCard__text">Опыт работы: <b class="vacancyCard__bold"><?=$arItem['DISPLAY_PROPERTIES']['EXPERIENCE']['DISPLAY_VALUE'];?></b></p>
					</div>
					<a class="card__btn btn" href="<?=$arItem['DETAIL_PAGE_URL'];?>">Подробнее</a>
				</li>
				<?}?>
			</ul>
		</div>
	</div>
</section>