<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)die();
// ShowRes($arResult);?>
<div class="basket__btnClose centered jsBasketClose">вернуться в меню</div>
<?if(count($arResult['ITEMS']) == 0)
{?>
    <h3 class="basket__title">Корзина пуста</h3>
    <a href="/catalog/" class="basket__makeOrderBtn centered">Перейти в меню</a>
    <?
}
else
{?>
    <h3 class="basket__title">Ваш заказ</h3>
    <div class="basketList" id="jsBasketList">
        <?foreach ($arResult['ITEMS'] as $key => $arItem)
        {?>
            <div class="basksetList__item product jsProduct" id="id<?=$arItem['PRODUCT_ID'];?>" data-id="<?=$arItem['PRODUCT_ID'];?>" data-quant="<?=$arItem['QUANTITY'];?>">
                <img class="product__img" src="<?=$arItem['IMG'];?>" alt="<?=$arItem['NAME']?>">
                <div class="product__content">
                    <div class="product__name"><?=$arItem['NAME']?></div>
                    <div class="product__quantity">
                        <div class="product__btnMinus centered jsDecrement" data-id="<?=$arItem['PRODUCT_ID'];?>">–</div>
                        <input type="number" name="curQuant" class="product__curQuantity jsCurQuant" data-id="<?=$arItem['PRODUCT_ID'];?>" value="<?=$arItem['QUANTITY'];?>"/>
                        <div class="product__btnPlus centered jsIncrement" data-id="<?=$arItem['PRODUCT_ID'];?>">+</div>
                    </div>
                    <div class="product__price"><?=$arItem['PRICE'];?> ₽</div>
                </div>
                <div class="product__delBtn jsDelBtn" data-id="<?=$arItem['PRODUCT_ID'];?>">×</div>
            </div><?
        }?>
        <div style="display:none;" id="basketFlag"></div>
    </div>
    <?foreach ($arResult['GIFTS'] as $key => $arGift)
    {?>
        <div class="basketGift">
            <img class="basketGift__img" src="<?=$arGift['IMG']?>" alt="">
            <div class="basksetGift__content">
                <img src="/local/assets/images/gift.png" class="basketGift__icon" alt="gift-icon">
                <div class="basketGift__name"><?=$arGift['NAME']?></div>
                <div class="basketGift__price">0 ₽</div>
            </div>
        </div><?
    }?>
    <?if(!empty($arResult['shoved']))
    {?>
        <h3 class="basket__title basket__title-add">Так-же берут:</h3>
        <div class="basketList mb30">
        <?foreach ($arResult['shoved'] as $key => $arShoved)
        {?>
            <div class="basksetList__item product">
                <img class="product__img" src="<?=$arShoved['PREVIEW_PICTURE']['SRC'];?>" alt="<?=$arShoved['NAME']?>">
                <div class="product__content">
                    <div class="product__name"><?=$arShoved['NAME']?></div>
                    <div data-id="<?=$arShoved['ID']?>" class="basket__addBtn jsBuy_link">Добавить</div>
                    <div class="product__price"><?=$arShoved['CATALOG_PRICE_1'];?> ₽</div>
                </div>
            </div><?
        }?>
        </div>
        <?
    }?>
    <!-- <div class="basketPromocode">
        <input name="basketPromocode" class="basketPromocode__input" id="promocodeInput" type="text" value="" placeholder="Промокод (если есть)" />
        <button id="promocodeBtn" class="basketPromocode__btn">Применить</button>
    </div> -->
    <div class="basketPrice <?=($arResult['arPrice']['isDiscount']) ? 'basketPrice-old' : '';?>">К оплате: <span class="basketPrice__value jsBasketPrice" data-value="<?=$arResult['arPrice']['discountPrice'];?>"><?=$arResult['arPrice']['price'];?> руб</span></div>
    <div class="basketDiscountPrice <?=(!$arResult['arPrice']['isDiscount']) ? 'hide' : '';?>">Сумма со скидкой: <span class="basketDiscountPriceValue <?=(!$arResult['arPrice']['isDiscount']) ? 'hide' : '';?> jsDiscountPrice"><?=$arResult['arPrice']['discountPrice'];?> руб.</span></div>
    <button href="/order/" class="basket__makeOrderBtn centered" id="basketOrderBtn">оформить заказ</button>
    <?
}?>
<div style="display:none;" id="basketItemsQuant" data-value="<?=$arResult['COUNT'];?>"><?=$arResult['COUNT'];?></div>