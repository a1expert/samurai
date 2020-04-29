<?
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)die();
// ShowRes($arResult);
if($arResult['passValidError'] == true)
    echo '<input type="hidden" name="passValidError" id="passValidError" value="true">';?>
<section class="section account main__section">
    <h2 class="section__title">Личные данные</h2>
    <ul class="account__personal">
        <li class="account__personal-item">
            <p class="account__personal-label">
                <svg xmlns:xlink="http://www.w3.org/1999/xlink">
                    <use xlink:href="/local/assets/images/icon.svg#icon_person-account"></use>
                </svg>Ваше имя
            </p>
            <p class="account__personal-data accEditable"><?=$arResult['arUser']['LAST_NAME'] . ' ' . $arResult['arUser']['NAME'];?></p>
            <input id="lastName" name="LAST_NAME" type="text" class="input accEditInput hide" value="<?=$arResult['arUser']['LAST_NAME'];?>">
            <input id="name" name="NAME" type="text" class="input accEditInput hide" value="<?=$arResult['arUser']['NAME'];?>">
        </li>
        <li class="account__personal-item">
            <p class="account__personal-label">
                <svg xmlns:xlink="http://www.w3.org/1999/xlink">
                    <use xlink:href="/local/assets/images/icon.svg#icon_phone-working"></use>
                </svg>Ваш телефон
            </p>
            <p class="account__personal-data accEditable"><?=$arResult['arUser']['PERSONAL_PHONE']?></p>
            <input id="phone" name="PERSONAL_PHONE" type="text" class="input accEditInput hide" value="<?=$arResult['arUser']['PERSONAL_PHONE'];?>">
        </li>
        <li class="account__personal-item">
            <p class="account__personal-label">
                <svg xmlns:xlink="http://www.w3.org/1999/xlink">
                    <use xlink:href="/local/assets/images/icon.svg#icon_calendar"></use>
                </svg>День рожения
            </p>
            <p class="account__personal-data"><?=$arResult['arUser']['PERSONAL_BIRTHDAY']?></p>
        </li>
        <li class="account__personal-item">
            <p class="account__personal-label">
                <svg xmlns:xlink="http://www.w3.org/1999/xlink">
                    <use xlink:href="/local/assets/images/icon.svg#icon_blades"></use>
                </svg>Баланс бонусных баллов
            </p>
            <p class="account__personal-data"><?=(empty($arResult['arUser']['UF_BONUSES']))?'0': $arResult['arUser']['UF_BONUSES'];?> бонусов</p>
        </li>
    </ul>
    <div class="account__controls">
        <button class="order-form__submit accEditSave hide" id="accEditSave">Сохранть изменения</button>
        <a class="account__controls-button" id="editAccData">
            <svg xmlns:xlink="http://www.w3.org/1999/xlink">
                <use xlink:href="/local/assets/images/icon.svg#icon_pencil"></use>
            </svg>Редактировать данные
        </a>
        <input id="password" name="NEW_PASSWORD" type="password" class="input passEditInput hide" value placeholder="Новый пароль">
        <input id="passwordConfirm" name="NEW_PASSWORD_CONFIRM" type="password" class="input passEditInput hide" value placeholder="Подтвердите пароль">
        <button class="order-form__submit editAccPassSave hide" id="editAccPassSave">Сохранть пароль</button>
        <a class="account__controls-button" id="editAccPass">
            <svg xmlns:xlink="http://www.w3.org/1999/xlink">
                <use xlink:href="/local/assets/images/icon.svg#icon_gear"></use>
            </svg>Сменить пароль
        </a>
        <a href="/?logout=yes" class="account__controls-button" id="logout">
            <svg xmlns:xlink="http://www.w3.org/1999/xlink">
                <use xlink:href="/local/assets/images/icon.svg#icon_logout"></use>
            </svg>Выход
        </a>
    </div>
</section>