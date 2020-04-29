<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<pre style="display:none;"><?var_dump($arResult)?></pre>
<section class="section main__section">
    <div class="container">
        <h2 class="section__title">Товар дня</h2>
        <div class="sale">
            <ul class="sale__controls js-tabs">
                <?foreach ($arResult['ITEMS'] as $key => $arItem) {?>
                    <li class="sale__controls-item">
                        <button data-linked-id="sale-today-<?=$arItem['ID']?>" class="sale__control<?= array_key_first($arResult['ITEMS']) == $key ? ' sale__control--active' : ''?>">
                            <?=$arResult['TEXT'][$key]?>
                        </button>
                    </li>
                <?}?>
            </ul>
            <div class="sale__content">
                <?foreach ($arResult['ITEMS'] as $key => $arItem) {?>
                    <div id="sale-today-<?=$arItem['ID']?>" class="sale__item">
                        <div class="sale__description">
                            <div class="sale__title"><?=$arItem['NAME']?></div>
                            <ul class="sale__chars">
                                <li class="sale__chars-item sale__chars-item--weight"><svg
                                        xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <use xlink:href="/local/assets/images/icon.svg#icon_scale"></use>
                                        </svg><?=$arItem['PROPERTY_8']?> грамм</li>
                                <?if (!empty($arItem['PROPERTY_1'])) {?>
                                    <li class="sale__chars-item sale__chars-item--quantity"><svg
                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <use xlink:href="/local/assets/images/icon.svg#icon_sushi"></use></svg><?=$arItem['PROPERTY_1']?> штук</li>
                                <?}?>
                            </ul>

                            <div class="sale__footer">
                                <div class="sale__price">
                                    <p class="sale__old-price"><?=$arItem['PRICE']['RESULT_PRICE']['BASE_PRICE']?> ₽</p>
                                    <p class="sale__new-price"><?=$arItem['PRICE']['RESULT_PRICE']['DISCOUNT_PRICE']?> ₽</p>
                                </div>
                                <?if ($key == 0) {?>
                                    <div class="sale__button"><button class="button button--add-to-cart jsBuy_link id<?=$arItem['ID']?>" data-id="<?=$arItem['ID']?>"><svg
                                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <use xlink:href="/local/assets/images/icon.svg#icon_cart"></use>
                                                </svg>Беру!</button></div>
                                <?}?>
                            </div>
                        </div>
                        <div class="sale__photo"><img src="<?=CFile::GetPath($arItem['PREVIEW_PICTURE'])?>"></div>
                        <div class="sale__counter">
                            <div class="counter js-counter" data-time="<?=$arResult['DATES'][$key]?>">
                                <p class="sale__subtitle"><strong>До <?=($key == 0) ? 'конца' : 'начала'?> акции <br>осталось:</strong></p>
                                <div class="counter__body">
                                    <div class="counter__hours">
                                        <div class="counter__num">00</div>
                                        <div class="counter__text">часов</div>
                                    </div>
                                    <div class="counter__divider">:</div>
                                    <div class="counter__minutes">
                                        <div class="counter__num">00</div>
                                        <div class="counter__text">минут</div>
                                    </div>
                                    <div class="counter__divider">:</div>
                                    <div class="counter__seconds">
                                            <div class="counter__num">00</div>
                                            <div class="counter__text">секунд</div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?}?>
            </div>
        </div>
    </div>
</section>

<?/*
<div class="filters main__filters">
    <div class="container">
        <form class="filters__form filters__form--filtrating">
            <input class="filters__item visually-hidden jsFiltersBtn" type="checkbox" name="type" id="all" data-sectionid="all">
            <label class="filters__label" id="labelAll" for="all">Все</label>
            <?$fid = 0;
            foreach ($arResult['filters'] as $filter)
            {?>
                <input class="filters__item visually-hidden jsFiltersBtn" type="checkbox" name="type" id="filter<?=$fid?>" data-sectionid="<?=$filter?>">
                <label class="filters__label jsFiltersLabel" for="filter<?=$fid++?>" data-sectionid="<?=$filter?>"><?=$filter?></label>
                <?
            }?>
        </form>
        <form class="filters__form filters__form--sorting">
            <p class="filters__subtitile">Сортировать</p>
            <?/* id НЕ ТРОГАТЬ!!! На них держится сортировка *//*?>
            <button class="filters__toggler" id="rating" type="button">По популярности</button>
            <button class="filters__toggler" id='price' type="button">По цене</button>
            <?/*<button class="filters__toggler" type="button">По составляющим</button>*//*?>
        </form>
    </div>
</div>

<section class="section main__section cards-grid">
    <div class="container">
        <h2 class="visually-hidden">Список товаров</h2>
        <ul class="cards-grid__list">
        <?foreach ($arResult['ITEMS'] as $key => $arItem)
        {
            $price = $arItem['PRICES']['RESULT_PRICE']['BASE_PRICE'];
            $discountPrice = ((bool)$arItem['PRICES']['IS_DISCOUNT']) ? $arItem['PRICES']['DISCOUNT_PRICE'] : false;
            if(!empty($arItem['OFFERS']))
            {
                $id = current($arItem['OFFERS'])['ID'];
                $price = current($arItem['OFFERS'])['PRICES']['RESULT_PRICE']['BASE_PRICE'];
                $discountPrice = ($arItem['OFFERS'][0]['PRICES']['IS_DISCOUNT']) ? $arItem['OFFERS'][0]['PRICES']['DISCOUNT_PRICE'] : false;
                //Pizza
                if(!empty($arItem['OFFERS'][0]['PROPERTIES']['PIZZA_SIZE']['VALUE']))
                {
                    $is_pizza = true;
                    foreach ($arItem['OFFERS'] as $offer)
                    {
                        $pizzas[] =
                        [
                            'id' => $offer['ID'],
                            'price' => $offer['PRICES']['RESULT_PRICE']['BASE_PRICE'],
                            'discountPrice' => ($offer['PRICES']['IS_DISCOUNT']) ? $offer['PRICES']['DISCOUNT_PRICE'] : false,
                            'size' => $offer['PROPERTIES']['PIZZA_SIZE']['VALUE'],
                            'weight' => $offer['CATALOG_WEIGHT']
                        ];
                    }
                }
            }
            else
                $id = $arItem['ID'];
            $itemFilter = implode(',', $arItem['PROPERTIES']['FILTER']['VALUE']);
            if($id == WOK_ID)
            {?>
                <li class="cards-grid__item">
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
                <li class="cards-grid__item jsCatalogItem" style="order: <?=$key?>" data-sectionsid="<?=$itemFilter;?>" data-price="<?=($discountPrice) ? $discountPrice : $price;?>" data-rating="<?=$arItem['PROPERTIES']['RATING']['VALUE']?>">
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
                                <li class="card__chars-item card__chars-item--main card__chars-item--weight jsItemWeight"><?=(empty($arItem['CATALOG_WEIGHT']))?$arItem['DISPLAY_PROPERTIES']['WEIGHT']['DISPLAY_VALUE']:$arItem['CATALOG_WEIGHT'];?></li>
                                <?if(!empty($arItem['DISPLAY_PROPERTIES']['ROLLS_COUNT']['DISPLAY_VALUE']))
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
                            <?if($is_pizza)
                            {?>
                                <div style="display:none!important;" class="pizza_exist"></div>
                                <div class="card__pizzaSize">
                                <?foreach ($pizzas as $i => $pizza)
                                {
                                    //ни до ни после этого дива ничего не вставлять(теги)!!! Либо лезь в жс файл и меняй там функционал кнопок!!! Говнокод рулит!?>
                                    <div class="pizzaSize <?=($i == 0)?'pizzaSize-first activeSize' : 'pizzaSize-second';?> jsPizzaSizeBtn" data-id="<?=$pizza['id'];?>" data-weight="<?=$pizza['weight'];?> гр">
                                        <span class="pizza__sizeValue"><?=$pizza['size'];?> см</span>
                                    </div>
                                    <?if($i > 1)break;//Макетом не предусмотренно больше двух размеров пиццы
                                }?>
                                </div>
                                <div class="card__footer">
                                <?foreach ($pizzas as $i => $pizza)
                                {?>
                                    <div class="card__price <?=($i == 0)?'' : 'hide';?> jsPizzaPrice id<?=$pizza['id'];?>">
                                        <p class="card__priceP <?=($pizza['discountPrice'])?'card__priceP-old':'';?>"><?=$pizza['price'];?> <span class="currency">₽</span></p>
                                        <p class="card__priceP card__priceP-discount <?=(!$pizza['discountPrice'])?'hide':'';?>"><?=$pizza['discountPrice'];?> <span class="currency">₽</span></p>
                                    </div>
                                    <div class="card__add-to-cart jsBuy_link <?=($i == 0)?'' : 'hide';?> jsPizzaBuyBtn id<?=$pizza['id'];?>" data-id="<?=$pizza['id'];?>">Беру!</div>
                                    <?if($i > 1)break;//Макетом не предусмотренно больше двух размеров пиццы                                    
                                }?>
                                </div>
                                <?
                                unset($pizzas);
                                $is_pizza = false;
                            }
                            else
                            {?>
                                <div class="card__footer">
                                    <div class="card__price">
                                        <p class="card__priceP <?=($discountPrice)?'card__priceP-old':'';?>"><?=$price;?> <span class="currency">₽</span></p>
                                        <p class="card__priceP card__priceP-discount <?=(!$discountPrice)?'hide':'';?>"><?=$discountPrice;?> <span class="currency">₽</span></p>
                                    </div>
                                    <div class="card__add-to-cart jsBuy_link id<?=$id?>" data-id="<?=$id?>">Беру!</div>
                                </div>
                                <?
                            }?>
                        </div>
                        <div class="card__social">
                            <p class="card__social-label">Поделитесь с друзьями:</p>
                            <a href="https://vk.com/share.php?<?
                                ?>title=<?=urlencode($arItem['NAME'])?>&<?
                                ?>image=<?=$_SERVER['HTTP_X_FORWARDED_PROTOCOL']?>://<?=$_SERVER['HTTP_HOST']?><?=$arItem['DETAIL_PICTURE'];?>&<?
                                ?>url=<?=$_SERVER['HTTP_X_FORWARDED_PROTOCOL']?>://<?=$_SERVER['HTTP_HOST']?><?=preg_split('/\?/', $_SERVER['REQUEST_URI'])[0]?>" target="_blank" aria-label="ВКонтакте" class="card__social-link" rel="nofollow">
                                <svg xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <use xlink:href="/local/assets/images/icon.svg#icon_vk"></use>
                                </svg>
                            </a>
                            <?/*
                            <a href="#" aria-label="facebook" class="card__social-link">
                                <svg xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <use xlink:href="/local/assets/images/icon.svg#icon_facebook"></use>
                                </svg>
                            </a>
                            <a href="#" aria-label="одноклассники" class="card__social-link">
                                <svg xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <use xlink:href="/local/assets/images/icon.svg#icon_odnoklassniki"></use>
                                </svg>
                            </a>*//*?>
                        </div>
                    </article>
                </li>
                <?
            }
        }?>
        </ul>
    </div>
</section>
<?if(!empty($arResult['SECTION']['PATH'][0]['DESCRIPTION']))
{?>
    <section class="section content">
        <div class="container">
            <div class="section__layout content__layout">
                <?=$arResult['SECTION']['PATH'][0]['~DESCRIPTION'];?>
            </div>
        </div>
    </section>
<?
}?>