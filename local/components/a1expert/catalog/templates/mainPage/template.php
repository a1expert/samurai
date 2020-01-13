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
foreach ($arResult['MAIN_PAGE_SECTIONS'] as $key => $arSection)
{
    if(empty($arSection['ITEMS_KEY']))
        continue;?>
<section class="section main__section">
    <div class="container">
        <h2 class="section__title"><?=$arSection['NAME']?></h2>
        <ul class="owl-carousel main-items">
            <?foreach ($arSection['ITEMS_KEY'] as $itemKey)
            {
                $arItem = $arResult['ITEMS'][$itemKey];
                $price = $arItem['PRICES']['RESULT_PRICE']['BASE_PRICE'];
                $discountPrice = ((bool)$arItem['PRICES']['IS_DISCOUNT']) ? $arItem['PRICES']['DISCOUNT_PRICE'] : false;
                if(!empty($arItem['OFFERS']))
                {
                    $id = current($arItem['OFFERS'])['ID'];
                    $price = current($arItem['OFFERS'])['PRICES']['RESULT_PRICE']['BASE_PRICE'];
                    $discountPrice = ($arItem['OFFERS'][0]['PRICES']['IS_DISCOUNT']) ? $arItem['OFFERS'][0]['PRICES']['DISCOUNT_PRICE'] : false;
                }
                else
                    $id = $arItem['ID'];
                $itemFilter = implode(',', $arItem['PROPERTIES']['FILTER']['VALUE']);?>
                <?if($id == WOK_ID)
                {?>
                    <li class="">
                        <article class="card card--invert">
                            <div class="card__body">
                                <div class="no_card__toggle">
                                    <h3 class="card__title"><?=$arItem['NAME'];?></h3>
                                </div>
                                <p class="card__ingredients">
                                    <strong><?=$arItem['DISPLAY_PROPERTIES']['COMPOSITION']['DISPLAY_VALUE'];?></strong>
                                </p>
                                <div class="card__footer">
                                    <a href="/catalog/noodles/wok/" class="card__add-to-cart card__add-to-cart--big">Собрать свой WOK</a>
                                </div>
                            </div>
                        </article>
                    </li>
                    <?
                }
                else
                {?>
                <li class="jsCatalogItem" style="order: <?=$itemKey?>" data-sectionsid="<?=$itemFilter;?>" data-price="<?=($discountPrice) ? $discountPrice : $price;?>" data-rating="<?=$arItem['PROPERTIES']['RATING']['VALUE']?>">
                    <article class="card">
                        <a href="#popup" class="card__toggle card__toggle--image">
                            <div class="card__picture-wrapper">
                                <img src="<?=$arItem['PREVIEW_PICTURE'];?>" alt="<?=$arItem['NAME'];?>" class="card__picture card__picture-preview" width="330" height="234">
                                <img src="<?=$arItem['DETAIL_PICTURE'];?>" alt="<?=$arItem['NAME'];?>" class="card__picture card__picture-detail" width="330" height="234">
                            </div>
                        </a>
                        <div class="card__body">
                            <a href="#popup" class="card__toggle card__toggle--text">
                                <h3 class="card__title"><?=$arItem['NAME'];?></h3>
                            </a>
                            <ul class="card__chars">
                                <li class="card__chars-item card__chars-item--main card__chars-item--weight"><?=$arItem['DISPLAY_PROPERTIES']['WEIGHT']['DISPLAY_VALUE'];?></li>
                                <?if(!empty($arItem['DISPLAY_PROPERTIES']['ROLLS_COUNT']['DISPLAY_VALUE']) && $arResult['SECTION']['PATH'][0]['ID'] == 1)
                                {?>
                                    <li class="card__chars-item card__chars-item--main card__chars-item--quantity"><?=$arItem['DISPLAY_PROPERTIES']['ROLLS_COUNT']['DISPLAY_VALUE']?></li>
                                    <?
                                }?>
                                <?if(!empty($arItem['DISPLAY_PROPERTIES']['COMPOSITION']['DISPLAY_VALUE']))
                                {?>
                                    <p class="card__ingredients"><?=$arItem['DISPLAY_PROPERTIES']['COMPOSITION']['DISPLAY_VALUE'];?></p><?
                                }
                                if(isset($arItem['COMPOUND']))
                                {
                                    foreach ($arItem['COMPOUND'] as $i => $v)
                                    {?>
                                        <li class="card__chars-item card__chars-item--extra"><?=$v['DISPLAY_VALUE'];?> гр.<span><?=strtolower($v['NAME']);?></span></li>
                                        <?
                                    }
                                }?>  
                            </ul>
                            <div class="card__footer">
                                <div class="card__price">
                                    <p class="card__priceP <?=($discountPrice)?'card__priceP-old':'';?>"><?=$price;?> <span class="currency">₽</span></p>
                                    <p class="card__priceP card__priceP-discount <?=(!$discountPrice)?'hide':'';?>"><?=$discountPrice;?> <span class="currency">₽</span></p>
                                </div>
                                <div class="card__add-to-cart jsBuy_link" data-id="<?=$id?>">Беру!</div>
                            </div>
                        </div>
                        <div class="card__social">
                            <p class="card__social-label">Поделитесь с друзьями:</p>
                            <a href="#" aria-label="вконтакте" class="card__social-link">
                                <svg xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <use xlink:href="/local/assets/images/icon.svg#icon_vk"></use>
                                </svg>
                            </a>
                            <a href="#" aria-label="facebook" class="card__social-link">
                                <svg xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <use xlink:href="/local/assets/images/icon.svg#icon_facebook"></use>
                                </svg>
                            </a>
                            <a href="#" aria-label="одноклассники" class="card__social-link">
                                <svg xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <use xlink:href="/local/assets/images/icon.svg#icon_odnoklassniki"></use>
                                </svg>
                            </a>
                        </div>
                    </article>
                </li>
                <?}
            }?>
        </ul>
    </div>
</section>
<?
}?>