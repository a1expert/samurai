<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !==true)die();?>
<?
// ShowRes($arResult, false, true);
$discount = $arResult['basePrice'] > $arResult['price'];
?>
<div class="tabs">
    <div class="tabs__mobile-controls">
        <div class="tabs__mobile-controls-inner">
            <svg xmlns:xlink="http://www.w3.org/1999/xlink"><use xlink:href="/local/assets/images/icon.svg#icon_cursor"></use></svg>
            <select class="tabs__mobile-controls-toggler">
                <option value="tab-1" data-icon="/local/assets/images/icon.svg#icon_cursor" selected>Как обычно</option>
                <option value="tab-2" data-icon="/local/assets/images/icon.svg#icon_phone-working">В один клик</option>
            </select>
        </div>
    </div>
    <div class="tabs__controls">
        <button data-tab="tab-1" class="tabs__button tabs__button--active">
            <svg xmlns:xlink="http://www.w3.org/1999/xlink"><use xlink:href="/local/assets/images/icon.svg#icon_cursor"></use></svg>Как обычно
        </button>
        <button data-tab="tab-2" class="tabs__button">
            <svg xmlns:xlink="http://www.w3.org/1999/xlink"><use xlink:href="/local/assets/images/icon.svg#icon_phone-working"></use></svg>В один клик
        </button>
    </div>
    <div class="tabs__content orderTabs">
        <div id="tab-1">
            <form action="https://www.xvideos.com/gay" class="order-form" method="POST" enctype="multipart/form-data" name="order" id="orderForm">
                <fieldset class="order-form__section order-form__who">
                    <legend class="order-form__legend">Кому доставить?</legend>
                    <div class="order-form__layout">
                        <div class="order-form__group order-form__group--medium">
                            <label for="NAME" class="order-form__label">Ваше имя*</label>
                            <input id="NAME" name="NAME" type="text" class="input order-form__input" value="<?=(!empty($arResult['cuser']['NAME']))?$arResult['cuser']['NAME']:'';?>" required>
                        </div>
                        <div class="order-form__group order-form__group--medium">
                            <label for="PHONE" class="order-form__label">Ваш телефон*</label>
                            <input id="PHONE" name="PHONE" type="text" class="input order-form__input" value="<?=(!empty($arResult['cuser']['PERSONAL_PHONE']))?$arResult['cuser']['PERSONAL_PHONE']:'';?>" required>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="order-form__section order-form__who">
                    <legend class="order-form__legend">Куда везем?</legend>
                    <div class="order-form__layout">
                        <div class="order-form__group order-form__group--medium">
                            <label for="CITY" class="order-form__label">Выберите город*</label>
                            <div class="select">
                                <select name="CITY" class="order-form__select select__toggler" required>
                                <?foreach ($arResult['cities'] as $id => $city)
                                {?>
                                    <option <?=($id == $arResult['curCity']['ID'])?'selected':'';?> value="<?=$city['NAME'];?>"><?=$city['NAME'];?></option>
                                    <?
                                }?>
                                </select>
                            </div>
                        </div>
                        <div class="order-form__group order-form__group--medium">
                            <label for="STREET" class="order-form__label">Ваша улица</label>
                            <input type="text" id="STREET" name="STREET" class="input order-form__input" value="">
                        </div>
                        <div class="order-form__group order-form__group--small">
                            <label for="HOUSE" class="order-form__label">Дом</label>
                            <input type="text" id="HOUSE" name="HOUSE" class="input order-form__input" value="">
                        </div>
                        <div class="order-form__group order-form__group--small">
                            <label for="FLAT" class="order-form__label">Квартира</label>
                            <input type="text" id="FLAT" name="FLAT" class="input order-form__input" value="">
                        </div>
                        <div class="order-form__group order-form__group--small">
                            <label for="FRONT_DOOR" class="order-form__label">Подъезд</label>
                            <input type="text" id="FRONT_DOOR" name="FRONT_DOOR" class="input order-form__input" value="">
                        </div>
                    </div>
                </fieldset>
                <fieldset class="order-form__section order-form__who">
                    <legend class="order-form__legend">Время доставки</legend>
                    <div class="order-form__layout">
                        <div class="order-form__group order-form__group--medium order-form__group--date">
                            <label for="date" class="order-form__label">Выберите дату</label>
                            <input id="date" name="DATE" type="text" class="input order-form__input" value="">
                        </div>
                        <div class="order-form__group order-form__group--medium order-form__group--time">
                            <label for="time" class="order-form__label">Выберите время</label>
                            <input id="time" name="TIME" type="text" class="input order-form__input" value="">
                        </div>
                        <div class="order-form__group order-form__group--medium">
                            <div class="checkbox order-form__current-time">
                                <input id="FAST" name="FAST" type="checkbox" class="visually-hidden" value="Y">
                                <label for="FAST" class="checkbox__label">Привезти в ближайшее время</label>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="order-form__section order-form__who">
                    <legend class="order-form__legend">Способы оплаты</legend>
                    <div class="order-form__layout">
                        <div class="order-form__group order-form__group--custom">
                            <input id="cash" type="radio" name="paymentType" class="visually-hidden order-form__custom-checkbox" value="3" required>
                            <label for="cash" class="order-form__label order-form__label--clickable">Наличными</label>
                        </div>
                        <div class="order-form__group order-form__group--custom">
                            <input id="online" type="radio" name="paymentType" class="visually-hidden order-form__custom-checkbox" value="7" required>
                            <label for="online" class="order-form__label order-form__label--clickable">Картой на сайте</label>
                        </div>
                        <div class="order-form__group order-form__group--custom">
                            <input id="card" type="radio" name="paymentType" class="visually-hidden order-form__custom-checkbox" value="5" required>
                            <label for="card" class="order-form__label order-form__label--clickable">Картой курьеру</label>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="order-form__section order-form__who">
                    <div class="order-form__layout">
                        <div class="order-form__group">
                            <label for="COMMENT" class="order-form__label">Комментарий при необходимости</label>
                            <textarea id="COMMENT" name="COMMENT" rows="4" class="order-form__textarea textarea"></textarea>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="order-form__section bonuses">
                    <legend class="order-form__legend visually-hidden">Информация о бонусах клиента</legend>
                    <div class="bonuses__layout">
                        <div class="bonuses__balance">
                            <p class="bonuses__label">
                                <strong>Баланс бонусных баллов:</strong>
                                <div class="bonuses__data" data-bonuses_exist="167">
                                    <svg xmlns:xlink="http://www.w3.org/1999/xlink"><use xlink:href="/local/assets/images/icon.svg#icon_blades"></use></svg>
                                    <p>167 бонусов</p>
                                </div>
                            </p>
                        </div>
                        <div class="bonuses__spend">
                            <p class="bonuses__label"><strong>Баланс бонусных баллов:</strong></p>
                            <div class="bonuses__inner">
                                <div class="range-slider bonuses__slider"></div>
                                <div class="bonuses__data bonuses__data--small">
                                    <input type="text" value="0" onpaste="return false" value="">
                                    <svg xmlns:xlink="http://www.w3.org/1999/xlink"><use xlink:href="/local/assets/images/icon.svg#icon_blades"></use></svg>
                                </div>
                                <button class="bonuses__spend-button">Списать</button>
                            </div>
                        </div>
                        <div class="bonuses__get">
                            <p class="bonuses__label"><strong>Получите после заказа:</strong></p>
                            <div class="bonuses__data"><svg xmlns:xlink="http://www.w3.org/1999/xlink"><use xlink:href="/local/assets/images/icon.svg#icon_blades"></use></svg>
                                <p>167 бонусов</p>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="order-form__section order-form__summary">
                    <legend class="visually-hidden">Промокоды, сумма заказа</legend>
                    <div class="order-form__layout">
                        <div class="order-form__group order-form__group--custom order-form__group--promocode">
                            <label for="promocode" class="order-form__label">Промокод, (если есть)</label>
                            <input id="promocode" name="promocode" type="text" class="input order-form__input" value="">
                            <button type="submit" class="order-form__reboot" id="addPromo">
                                <svg xmlns:xlink="http://www.w3.org/1999/xlink"> <use xlink:href="/local/assets/images/icon.svg#icon_reload"></use></svg>
                            </button>
                        </div>
                        <div class="order-form__group order-form__group--custom order-form__group--change">
                            <label for="change" class="order-form__label"> С какой суммы подготовить сдачу:</label>
                            <input id="change" name="PAYSUM" type="text"class="input order-form__input" value="">
                        </div>
                        <div class="order-form__group order-form__group--custom order-form__total" data-price="<?=$arResult['price'];?>">
                            <p class="order-form__total-price <?=($discount) ? 'order-form__total-price--old':'';?>">
                                <small>К оплате:<?=$arResult['basePrice'];?> руб.</small>
                            </p>
                            <p class="order-form__total-price order-form__total-price--new <?=(!$discount) ? 'hide':'';?>">
                                <span class="order-form__total-price-title">Сумма со скидкой</span>
                                <span class="order-form__total-price order-form__total-price--important"><?=$arResult['price'];?> руб.</span>
                            </p>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="order-form__controls <?=(!$arResult['open']) ? 'order-form__controls--alert' : '';?>">
                    <div class="order-form__layout">
                        <div class="order-form__group">
                            <p class="order-form__alert <?=($arResult['open']) ?'hide': '';?>">Внимание! В настоящее время доставка не осуществляется. Ваш заказ поступит в обработку в 10:30</p>
                            <div class="order-form__controls-inner">
                                <a href="" class="order-form__back">Вернуться в меню</a>
                                <input type="hidden" name="addOrder" value="Fuck them all">
                                <button type="submit" class="order-form__submit">Оформить заказ</button>
                            </div>
                            <p class="order-form__policy">
                                <small>Отправляя настоящую форму, вы даете согласие на обработку своих<a href="#"> персональных данных</a></small>
                            </p>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        <div id="tab-2"></div>
    </div>
</div>