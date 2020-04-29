<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Application,
    Bitrix\Main\Page\Asset,
    Bitrix\Main\Loader,
    Bitrix\Main\Localization\Loc,
    A1expert\Cities;
global $USER;
global $USER_FIELD_MANAGER;
if($USER->IsAuthorized())
{
    $userBonuses = $USER_FIELD_MANAGER->GetUserFields('USER', $USER->GetID(), LANGUAGE_ID)['UF_BONUSES']['VALUE'] ?: 0;
    $accountLink = '/account/';
}
else
    $accountLink = '/auth/';
Loc::loadMessages(__FILE__);
$dir = $APPLICATION->GetCurDir();
$page = $APPLICATION->GetCurPage(true);
$assets = Asset::getInstance();
$cities = new Cities();
$mainPage = ($page == "/index.php") ? true : false;
setcookie('city', $cities->curCity['ID'], 0, '/');
$pageIntroBg = ($APPLICATION->GetDirProperty('pageIntroBg') == 'Y') ? 'page-intro--background' : '';
?>
<!DOCTYPE html>
<html lang="<?=LANGUAGE_ID?>">
	<head>
        
        <?
        $APPLICATION->ShowHead();
        //strings
        $assets->addString('<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">');
        $assets->addString('<meta http-equiv="X-UA-Compatible" content="IE=edge">');?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.0.2/nouislider.min.js"></script>
		<script src="https://npmcdn.com/flatpickr/dist/flatpickr.min.js"></script>
        <script src="https://npmcdn.com/flatpickr/dist/l10n/ru.js"></script>
        <script type="text/javascript" src="https://vk.com/js/api/share.js?95" charset="windows-1251"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.0.2/nouislider.min.css" rel="stylesheet">
        <link href="/local/assets/styles/jquery.kladr.min.css" rel="stylesheet">
        <script src="/local/assets/scripts/jquery.kladr.min.js" type="text/javascript"></script><?
        //CSS
        $assets->addCss('/local/assets/styles/main.css');
        //SCRIPTS
        $assets->addJS('/local/assets/scripts/main.js');
        $assets->addJS('/local/assets/scripts/devA.js');
        $assets->addJS('/local/assets/scripts/devK.js');
        ?>
        <?//<link href="/local/assets/images/icon.png" rel="icon" type="image/png">?>
		<title><?$APPLICATION->ShowProperty('metaTitle');?></title>
    </script>
	</head>

	<body class="page">
        <?$APPLICATION->showPanel();?>
        <?//print($cities->MakeCitiesList());
        // ShowRes();
        ?>
        <div class="wrapper">
            <div class="tooltip hide"></div>
            <div class="loadingLayout hide" id="loadingLayout"></div>
            <div class="loading hide" id="loading"></div>
            <div class="gifts hide" id="giftsPopup">
                <div class="gifts__container">

                    <div class="gifts__close" id="jsGiftsClose">×</div>
                    <div class="freeGoods hide" id="freeGoods">
                        <div class="gifts__header">Вы можете выбрать подарок:</div>
                        <?$APPLICATION->IncludeComponent("bitrix:news.list", "gifts", [
                            "FIELD_CODE" => ["NAME","PREVIEW_PICTURE"],
                            "IBLOCK_ID" => 7,
                            "CACHE_FILTER" => "N",
                            "CACHE_GROUPS" => "Y",
                            "CACHE_TIME" => "36000000",
                            "CACHE_TYPE" => "A",
                            "CHECK_DATES" => "Y",
                            "DISPLAY_NAME" => "Y",
                            "DISPLAY_PICTURE" => "N",
                            "SET_BROWSER_TITLE" => "N",
                            "SET_LAST_MODIFIED" => "N",
                            "SET_META_DESCRIPTION" => "N",
                            "SET_META_KEYWORDS" => "N",
                            "SET_STATUS_404" => "N",
                            "SET_TITLE" => "N",
                            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                            "INCLUDE_SUBSECTIONS" => "N",
                            "SORT_BY1" => "SORT",
                            "SORT_BY2" => "ASC"]);?>
                        <div class="gifts__cancel" id="jsGiftsCancel">мне не нужны подарки</div>
                    </div>
                    <div class="slyshKupi hide" id="slyshKupi">
                        <img src="/local/assets/images/slyshKupi.png" alt="" class="slyshKupi__img">
                        <div class="slyshKupi__header">До подарка вам осталось:</div>
                        <div class="slyshKupi__ammount"><span id="leftToGift">2 475</span>&nbsp;₽</div>
                        <a href="/catalog/" class="slyshKupi__backToMenuBtn">вернуться в меню</a>
                        <a href="/order/" class="slyshKupi__orderBtn">продолжить оформление</a>
                    </div>
                </div>
            </div>
            <div class="layout"></div>
            <header class="header">
                <div class="header__top">
                    <div class="header-mobile-top">
                        <div class="container">
                            <ul class="header-mobile-top__list">
                                <li class="header-mobile-top__item">
                                    <svg xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <use xlink:href="/local/assets/images/icon.svg#icon_pin"></use>
                                    </svg><a href="#" class="jsCityToggler"><?=$cities->curCity['NAME']?></a>
                                </li>
                                <li class="header-mobile-top__item">
                                    <svg xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <use xlink:href="/local/assets/images/icon.svg#icon_phone"></use>
                                    </svg><?=$cities->curCity['props']['PHONE']['VALUE'];?>
                                </li>
                                <li class="header-mobile-top__item">
                                    <a href="#">
                                        <svg xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <use xlink:href="/local/assets/images/icon.svg#icon_user"></use>
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="container header__container">
                        <div class="basket__layout jsBasketClose jsBasketLayout hide"></div>
                        <div class="basket hide jsBasket">
                            <?$basket = $APPLICATION->IncludeComponent('a1expert:basket', '', Array());?>
                        </div>
                        <div class="logo header__logo">
                            <a href="/" class="logo__link">
                                <img src="/local/assets/styles/images/logo_colored.png" alt="Сытый самурай" width="129" height="113">
                            </a>
                        </div>
                        <div class="header__inner">
                            <div class="header__content header__content--top">
                                <nav class="menu">
                                    <?$APPLICATION->IncludeComponent("bitrix:menu", "top", Array(
                                        "ALLOW_MULTI_SELECT" => "N",
                                        "CHILD_MENU_TYPE" => "",
                                        "DELAY" => "N",
                                        "MAX_LEVEL" => "1",
                                        "MENU_CACHE_GET_VARS" => array(""),
                                        "MENU_CACHE_TIME" => "3600000",
                                        "MENU_CACHE_TYPE" => "A",
                                        "MENU_CACHE_USE_GROUPS" => "Y",
                                        "ROOT_MENU_TYPE" => "top",
                                        "USE_EXT" => "N")
                                    );?>
                                </nav>
                                <ul class="controls header__controls">
                                    <?if($USER->IsAuthorized())
                                    {?>
                                    <li class="controls__item">
                                        <p class="controls__element controls__element--bonus">
                                            <svg xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <use xlink:href="/local/assets/images/icon.svg#icon_blades"></use>
                                            </svg><?=(empty($userBonuses))?'0':$userBonuses;?> бонусов
                                        </p>
                                    </li><?
                                    }?>
                                    <li class="controls__item">
                                        <a href="<?=$accountLink?>" class="controls__element controls__element--account">
                                            <svg xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <use xlink:href="/local/assets/images/icon.svg#icon_user"></use>
                                            </svg>Личный кабинет
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="header__content header__content--mobile">
                                <button class="header__menu-toggler"></button>
                                <?$APPLICATION->IncludeComponent("bitrix:menu", "topMobile", Array(
                                    "ALLOW_MULTI_SELECT" => "N",
                                    "CHILD_MENU_TYPE" => "",
                                    "DELAY" => "N",
                                    "MAX_LEVEL" => "1",
                                    "MENU_CACHE_GET_VARS" => array(""),
                                    "MENU_CACHE_TIME" => "3600000",
                                    "MENU_CACHE_TYPE" => "A",
                                    "MENU_CACHE_USE_GROUPS" => "Y",
                                    "ROOT_MENU_TYPE" => "top",
                                    "USE_EXT" => "Y")
                                );?>
                                <ul class="info header__info">
                                    <li class="info__item info__item--address info__item--invert">
                                        <svg xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <use xlink:href="/local/assets/images/icon.svg#icon_pin"></use>
                                        </svg>Доставка еды
                                        <a href="#" class="info__city-name jsCityToggler">&nbsp;в <?=$cities->curCity['NAME']?>е</a>
                                    </li>
                                    <li class="info__item info__item--phone info__item--invert">
                                        <svg xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <use xlink:href="/local/assets/images/icon.svg#icon_phone"></use>
                                        </svg><?=$cities->curCity['props']['PHONE']['VALUE'];?>
                                    </li>
                                    <li class="info__item info__item--work-time info__item--invert">
                                        <svg xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <use xlink:href="/local/assets/images/icon.svg#icon_timer"></use>
                                        </svg>Принимаем заказы с<br /><?=$cities->curCity['props']['WORK_TIME']['VALUE'];?>
                                    </li>
                                </ul>
                                <div class="cart-header header__cart">
                                    <div class="cart-header__info">
                                        <p class="cart-header__total-price"><span id="smallBasketPrice"><?=(int)$basket['PRICE']?></span> ₽</p>
                                        <p class="cart-header__total-quantity">Товаров в корзине: <span id="smallBasketQuant"><?=$basket['COUNT'];?></span></p>
                                    </div>
                                    <a  class="cart-header__link jsBasketToggler">
                                        <svg xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <use xlink:href="/local/assets/images/icon.svg#icon_cart"></use>
                                        </svg>Корзина
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <nav class="submenu">
                    <div class="container">
                        <div class="submenu__inner">
                            <?$APPLICATION->IncludeComponent("bitrix:menu", "catalog", Array(
                                "ALLOW_MULTI_SELECT" => "N",
                                "CHILD_MENU_TYPE" => "",
                                "DELAY" => "N",
                                "MAX_LEVEL" => "1",
                                "MENU_CACHE_GET_VARS" => array(""),
                                "MENU_CACHE_TIME" => "3600000",
                                "MENU_CACHE_TYPE" => "A",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "ROOT_MENU_TYPE" => "catalog",
                                "USE_EXT" => "Y")
                            );?>
                        </div>
                    </div>
                </nav>
            </header>
            <main class="main">
                <?if(!$mainPage)
                {?>
                <div class="page-intro <?=$pageIntroBg?>">
                    <div class="container page-intro__container">
                        <h1 class="page-title"><?$APPLICATION->ShowTitle(true);?></h1>
                        <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "crumbs", Array("PATH" => "", "SITE_ID" => "s1", "START_FROM" => "0"));?>
                    </div><?
                }
                else
                {?>
                <div class="hero main__section">
                    <div data-src="" class="hero__carousel"><img src="/local/assets/images/hero1.jpg" alt="акция"></div><?
                }?>
                </div>
