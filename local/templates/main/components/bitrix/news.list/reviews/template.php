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
<section class="section feedback">
    <div class="container">
        <h2 class="section__title">Отзывы о нашей работе</h2>
		<?foreach($arResult['ITEMS'] as $arItem)
		{
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));?>
        <div class="comments feedback__comments" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <div class="comment">
                <div class="comment__header">
                    <p class="comment__author"><svg xmlns:xlink="http://www.w3.org/1999/xlink">
                            <use xlink:href="/local/assets/images/icon.svg#icon_person-comment"></use>
                            </svg><strong><?=$arItem['NAME'];?></strong></p>
                    <p class="comment__date"><small><?=preg_split('/\s/', $arItem['DATE_CREATE'])[0];?></small></p>
                </div>
                <div class="comment__body"><?=$arItem['PREVIEW_TEXT'];?></div>
			</div>
		<?if(!empty($arItem['DETAIL_TEXT']))
		{?>
            <div class="answer">
                <div class="answer__header">
                    <p class="answer__author"><svg xmlns:xlink="http://www.w3.org/1999/xlink">
                            <use xlink:href="/local/assets/images/icon.svg#icon_samurai-answer"></use>
                            </svg><strong>Сытый самурай</strong></p>
                </div>
                <div class="answer__body"><?=$arItem['DETAIL_TEXT'];?></div>
			</div>
			<?
		}?>
        </div>
		<?
		}?>
    </div>
</section>