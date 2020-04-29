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
$i = 0; $j = 0;
?>
<div style="display:none" <?/*Раньше тут был другой комментарий, теперь будет этот. Весь этот раздел получился адовым говнищем и если ты, мой друг, читаешь это - то возможно у тебя возникли трудности, если что весь функциАнал этого дерьмища завязан на символьных кодах разделов, прописанных в том числе и в жабаскрипте, так шо если шо лезь туда, в жабаскрипт и запасись валерьянкой, а лучше снеси все это к хуям, сделай морду кирпичом и скажи, что так и было.*/?> id="huita"></div>
<div class="container">
    <section class="section create-wok">
        <div class="section__layout create-wok__layout">
            <div class="create-wok__grid">
            <?foreach ($arResult['MAIN_PAGE_SECTIONS'] as $arSection)
            {
                if($arSection['UF_ONE_PRICE'] == true)
                {?>

                    <div class="create-wok__grid-item">
                        <article class="create-wok__block">
                            <h3 class="create-wok__subtitle"><?=$arSection['NAME'];?><span class="create-wok__divider"> / </span><span class="create-wok__price"><?=$arResult['ITEMS'][$arSection['ITEMS_KEY'][0]]['CATALOG_PRICE_1'];?> ₽</span></h3>
                            <ul class="create-wok__list">
                            <?if($arSection['CODE'] == 'sauce')
                            {?>
                                <li class="create-wok__item">
                                    <input
                                        id="huita2"
                                        type="radio"
                                        name="<?=$arSection['CODE'];?>"
                                        class="visually-hidden wokConsistBtn <?=$arSection['CODE'];?>"
                                        data-name="Без соуса"
                                        data-price="0"
                                        >
                                    <label for="huita2" class="create-wok__label"><strong class="create-wok__name">Без соуса</strong></label>
                                </li>                           
                            <?
                            }?>
                            <?foreach ($arSection['ITEMS_KEY'] as $itemIndex)
                            {?>
                                <li class="create-wok__item">
                                    <?if($arSection['CODE'] != 'sauce'){?>
                                    <img src="<?=$arResult['ITEMS'][$itemIndex]['PREVIEW_PICTURE']?>"
                                        class="wok__img wok__img-<?=$arSection['CODE'];?>"
                                        data-imgid="<?=$arResult['ITEMS'][$itemIndex]['ID'];?>"
                                        alt="<?=$arResult['ITEMS'][$itemIndex]['NAME'];?>"><?}?>
                                    <input
                                        id="id<?=$arResult['ITEMS'][$itemIndex]['ID'];?>"
                                        type="<?=($arSection['UF_RADIO'] == true) ? 'radio' : 'checkbox';?>"
                                        name="<?=$arSection['CODE'];?>"
                                        class="visually-hidden wokConsistBtn <?=$arSection['CODE'];?>"
                                        data-id="<?=$arResult['ITEMS'][$itemIndex]['ID'];?>"
                                        data-name="<?=$arResult['ITEMS'][$itemIndex]['NAME'];?>"
                                        data-description="<?=$arResult['ITEMS'][$itemIndex]['PROPERTIES']['COMPOUND']['VALUE'];?>"
                                        data-price="<?=$arResult['ITEMS'][$itemIndex]['CATALOG_PRICE_1'];?>"
                                        <?if($i == 0 && $j == 0)
                                        {
                                            echo 'checked';
                                            $defaultId = $arResult['ITEMS'][$itemIndex]['ID'];
                                            $defaultImg = $arResult['ITEMS'][$itemIndex]['PREVIEW_PICTURE'];
                                            $defaultName = $arResult['ITEMS'][$itemIndex]['NAME'];
                                            $defaultDescription = $arResult['ITEMS'][$itemIndex]['PROPERTIES']['COMPOUND']['VALUE'];
                                            $defaultPrice = $arResult['ITEMS'][$arSection['ITEMS_KEY'][0]]['CATALOG_PRICE_1'];
                                        }?>
                                    >   
                                    <label for="id<?=$arResult['ITEMS'][$itemIndex]['ID'];?>" class="create-wok__label">
                                        <strong class="create-wok__name"><?=$arResult['ITEMS'][$itemIndex]['NAME'];?></strong>
                                        <small class="create-wok__description"><?=$arResult['ITEMS'][$itemIndex]['PROPERTIES']['COMPOUND']['VALUE'];?></small>
                                    </label>
                                </li>
                                <?
                                $j++;
                            }?>

                            </ul>
                            <div class="wok__navigation">
                            	<button class="wok__next js-wok-next">Далее</button>
                            </div>
                        </article>
                    </div>
                <?
                }
                else
                {?>
                    <div class="create-wok__grid-item">
                        <article class="create-wok__block">
                            <h3 class="create-wok__subtitle"><?=$arSection['NAME'];?></h3>
                            <ul class="create-wok__list">
                            <?if($arSection['CODE'] == 'sauce')
                            {?>
                                <li class="create-wok__item">
                                    <input
                                        id="huita2"
                                        type="radio"
                                        name="<?=$arSection['CODE'];?>"
                                        class="visually-hidden wokConsistBtn <?=$arSection['CODE'];?>"
                                        data-name="Без соуса"
                                        data-price="0"
                                        >
                                    <label for="huita2" class="create-wok__label"><strong class="create-wok__name">Без соуса</strong></label>
                                </li>                           
                            <?
                            }?>
                            <?foreach ($arSection['ITEMS_KEY'] as $itemIndex)
                            {?>
                                <li class="create-wok__item">
                                <?if($arSection['CODE'] != 'sauce')
                                {?>
                                    <img src="<?=$arResult['ITEMS'][$itemIndex]['PREVIEW_PICTURE']?>"
                                        class="wok__img wok__img-<?=$arSection['CODE'];?>"
                                        data-imgid="<?=$arResult['ITEMS'][$itemIndex]['ID'];?>"
                                        alt="<?=$arResult['ITEMS'][$itemIndex]['NAME'];?>">
                                <?}?>
                                    <input
                                        id="id<?=$arResult['ITEMS'][$itemIndex]['ID'];?>"
                                        type="<?=($arSection['UF_RADIO'] == true) ? 'radio' : 'checkbox';?>"
                                        name="<?=$arSection['CODE'];?>"
                                        class="visually-hidden wokConsistBtn <?=$arSection['CODE'];?>"
                                        data-id="<?=$arResult['ITEMS'][$itemIndex]['ID'];?>"
                                        data-name="<?=$arResult['ITEMS'][$itemIndex]['NAME'];?>"
                                        data-description="<?=$arResult['ITEMS'][$itemIndex]['PROPERTIES']['COMPOUND']['VALUE'];?>"
                                        data-price="<?=$arResult['ITEMS'][$itemIndex]['CATALOG_PRICE_1'];?>">
                                    <label for="id<?=$arResult['ITEMS'][$itemIndex]['ID'];?>" class="create-wok__label">
                                        <strong class="create-wok__name"><?=$arResult['ITEMS'][$itemIndex]['NAME'];?></strong>
                                        <span class="create-wok__divider">/</span>
                                        <span class="create-wok__price"><?=$arResult['ITEMS'][$itemIndex]['CATALOG_PRICE_1'];?> ₽</span>
                                    </label>
                                </li>
                                <?
                            }?>
                            </ul>
                            <div class="wok__navigation">
                            	<button class="wok__next js-wok-next">Далее</button>
                            	<button class="wok__prev js-wok-prev">Вернуться назад</button>
                            </div>
                        </article>
                    </div>
                    <?
                }
                $i++;
            }?>
                 <div class="create-wok__grid-item create-wok__grid-item--output">
                    <article class="create-wok__output">
                        <h2 class="create-wok__title">Ваша коробочка:</h2>
                        <div class="create-wok__output-picture" id="wokPicture">
                            <img src="/local/assets/images/box1.png" alt="ur wok" class="wok__img">
                            <img src="<?=$defaultImg;?>" alt="ur wok" class="wok__img wok__img-base">
                        </div>
                        <form action="" class="create-wok__output-form" id="wokForm" method="GET">
                            <div id="wokFormItemsList">
                                <div class="create-wok__output-item">
                                    <p class="create-wok__output-info">
                                        <strong class="create-wok__name" id="baseName" data-id="<?=$defaultId;?>"><?=$defaultName;?></strong>
                                        <small class="create-wok__description" id="baseDescription"><?=$defaultDescription;?></small>
                                    </p>
                                    <p class="create-wok__output-sum">
                                        <span class="create-wok__value jsItemPrice" id="basePrice" data-value="<?=$defaultPrice;?>"><?=$defaultPrice;?> <span class="currency">₽</span></span>
                                    </p>
                                </div>
                            </div>
                            <div class="wokSumPrice">Итого: <span class="wokSumPrice__value" id="jsWokSumPriceValue" data-value="<?=$defaultPrice;?>"><?=(int)$defaultPrice;?> ₽</span></div>
                            <button class="wokForm__submit" id="wokFormSubmit">
                                <svg xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <use xlink:href="/local/assets/images/icon.svg#icon_cart"></use>
                                </svg>Добавить в корзину
                            </button>
                            <div class="wok__navigation">
                            	<button class="wok__prev js-wok-reset" type="button">Сбросить</button>
                          	</div>
                        </form>
                    </article>
                </div>
            </div>
        </div>
    </section>
</div>
<div style="display:none;" id="simpleTemplate">
    <div class="create-wok__output-item jsOutputItem" id="st">
        <p class="create-wok__output-info">
            <strong class="create-wok__name jsItemName"></strong>
            <small class="create-wok__description jsItemDescription"></small>
        </p>
        <p class="create-wok__output-sum">
            <span class="create-wok__value jsItemPrice">0</span>
        </p>
    </div>
</template>
<div style="display:none;" id="controlsTemplate">
    <div class="create-wok__output-item jsOutputItem" id="ct">
        <p class="create-wok__output-info">
            <strong class="create-wok__name jsItemName"></strong>
        </p>
        <div class="create-wok__output-controls counter-control">
            <button type="button" class="counter-control__button counter-control__button--der jsWokDecr" data-id="" data-section="">-</button>
            <input type="text" value="1" readonly class="counter-control__value">
            <button type="button" class="counter-control__button counter-control__button--incr jsWokIncr" data-id="" data-section="">+</button>
        </div>
        <p class="create-wok__output-sum">
            <span class="create-wok__value jsItemPrice" data-value="">0</span>
        </p>
    </div>
</div>