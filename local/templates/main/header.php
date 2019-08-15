<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Application,
    Bitrix\Main\Page\Asset,
    Bitrix\Main\Loader,
    Bitrix\Main\Localization\Loc,
    A1expert\Cities;
Loc::loadMessages(__FILE__);
$dir = $APPLICATION->GetCurDir();
$page = $APPLICATION->GetCurPage(true);
$assets = Asset::getInstance();
$cities = new Cities();
$mainPage = ($page == "/index.php") ? true : false;
$cities->SetCookie();
$pageIntroBg = ($APPLICATION->GetDirProperty('pageIntroBg') == 'Y') ? 'page-intro--background' : '';
?>
<!DOCTYPE html>
<html lang="<?=LANGUAGE_ID?>">
	<head>
        <?
        $APPLICATION->ShowHead();
        //strings
        $assets->addString('<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui">');
        $assets->addString('<meta http-equiv="X-UA-Compatible" content="IE=edge">');
        //CSS
        $assets->addCss('/local/assets/styles/main.css');
		//SCRIPTS
        $assets->addJS('/local/assets/scripts/main.js');
        ?>
        <link as="font" crossorigin="anonymous" href="fonts/Circe-Bold.woff" rel="preload">
        <link as="font" crossorigin="anonymous" href="fonts/Circe-Bold.woff2" rel="preload">
        <link as="font" crossorigin="anonymous" href="fonts/Circe-Light.woff" rel="preload">
        <link as="font" crossorigin="anonymous" href="fonts/Circe-Light.woff2" rel="preload">
        <link as="font" crossorigin="anonymous" href="fonts/Circe-Regular.woff" rel="preload">
        <link as="font" crossorigin="anonymous" href="fonts/Circe-Regular.woff2" rel="preload">
        <?//<link href="/local/assets/images/icon.png" rel="icon" type="image/png">?>
		<title><?$APPLICATION->ShowProperty('metaTitle');?></title>
	</head>
    
	<body>
        <?$APPLICATION->showPanel();?>
        <?//print($cities->MakeCitiesList());?>
        <div class="wrapper">
            <div class="layout">
                <header class="header">
                    <div class="header__top">
                        <div class="container header__container">
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
                                        "USE_EXT" => "Y")
                                    );?>
                                    </nav>
                                    <ul class="controls header__controls">
                                        <li class="controls__item">
                                            <p class="controls__element controls__element--bonus">150 бонусов</p>
                                        </li>
                                        <li class="controls__item">
                                            <a class="controls__element controls__element--account" href="#">Личный кабинет</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="header__content">
                                    <ul class="info">
                                        <li class="info__item info__item--address">Доставка еды <span class="info__city-name">в Сургуте</span></li>
                                        <li class="info__item info__item--phone">+7(3462)269-57-58</li>
                                        <li class="info__item info__item--work-time">Принимаем заказы с<br>с 10:30 - 23:30</li>
                                    </ul>
                                    <div class="cart header__cart">
                                        <div class="cart__info">
                                            <p class="cart__total-price">100 475 P</p>
                                            <p class="cart__total-quantity">1 товар</p>
                                        </div>
                                        <a href="#" class="cart__link">Корзина</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <nav class="submenu">
                        <div class="container">
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
                    </nav>
                </header>
                <main class="main">
                    <div class="page-intro <?=$pageIntroBg?>">
                        <div class="container page-intro__container">
                            <h1 class="page-title"><?$APPLICATION->ShowTitle(true);?></h1>
                            <?if(!$mainPage)$APPLICATION->IncludeComponent("bitrix:breadcrumb", "crumbs",	Array("PATH" => "", "SITE_ID" => "s1", "START_FROM" => "0"));?>
                        </div>
                    </div>