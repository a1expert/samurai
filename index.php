<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Главная");
?>

<section class="section main__section">
    <div class="container">
        <h2 class="section__title">Товар дня</h2>
        <div class="sale">
            <ul class="sale__controls js-tabs">
                <li class="sale__controls-item"><button
                        class="sale__control sale__control--active">Сегодня</button></li>
                <li class="sale__controls-item"><button class="sale__control">Завтра</button></li>
                <li class="sale__controls-item"><button class="sale__control">Послезавтра</button></li>
            </ul>
            <div class="sale__content">
                <div id="sale-today" class="sale__item">
                    <div class="sale__description">
                        <div class="sale__title">Филадельфия лайт</div>
                        <ul class="sale__chars">
                            <li class="sale__chars-item sale__chars-item--weight"><svg
                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <use xlink:href="/local/assets/images/icon.svg#icon_scale"></use>
                                    </svg>240 грамм</li>
                            <li class="sale__chars-item sale__chars-item--quantity"><svg
                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <use xlink:href="/local/assets/images/icon.svg#icon_sushi"></use></svg>6
                                штук</li>
                        </ul>

                        <div class="sale__footer">
                            <div class="sale__price">
                                <p class="sale__old-price">2 475 ₽</p>
                                <p class="sale__new-price">2 475 ₽</p>
                            </div>
                            <div class="sale__button"><button class="button button--add-to-cart"><svg
                                        xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <use xlink:href="/local/assets/images/icon.svg#icon_cart"></use>
                                        </svg>Беру!</button></div>
                        </div>
                    </div>
                    <div class="sale__photo"><img src="/local/assets/images/sale-pic.png"></div>
                    <div class="sale__counter">
                        <div class="counter js-counter">
                            <p class="sale__subtitle"><strong>До конца акции <br>осталось:</strong></p>
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
            </div>
        </div>
    </div>
</section>
<?$APPLICATION->IncludeComponent("a1expert:catalog", "mainPage", [
    "ACTIVE_DATE_FORMAT" => "d.m.Y",
    "ADD_SECTIONS_CHAIN" => "Y",
    "AJAX_MODE" => "N",
    "AJAX_OPTION_ADDITIONAL" => "",
    "AJAX_OPTION_HISTORY" => "N",
    "AJAX_OPTION_JUMP" => "N",
    "AJAX_OPTION_STYLE" => "Y",
    "CACHE_FILTER" => "N",
    "CACHE_GROUPS" => "Y",
    "CACHE_TIME" => "36000000",
    "CACHE_TYPE" => "A",
    "CHECK_DATES" => "Y",
    "DETAIL_URL" => "",
    "DISPLAY_BOTTOM_PAGER" => "N",
    "DISPLAY_DATE" => "N",
    "DISPLAY_NAME" => "Y",
    "DISPLAY_PICTURE" => "N",
    "DISPLAY_PREVIEW_TEXT" => "N",
    "DISPLAY_TOP_PAGER" => "N",
    "FIELD_CODE" => [],
    "FILE_404" => "",
    "FILTER_NAME" => "",
    "HIDE_LINK_WHEN_NO_DETAIL" => "N",
    "IBLOCK_ID" => "1",
    "IBLOCK_TYPE" => "catolog",
    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
    "INCLUDE_SUBSECTIONS" => "Y",
    "MESSAGE_404" => "",
    "NEWS_COUNT" => "0",
    "PAGER_BASE_LINK_ENABLE" => "N",
    "PAGER_DESC_NUMBERING" => "N",
    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
    "PAGER_SHOW_ALL" => "N",
    "PAGER_SHOW_ALWAYS" => "N",
    "PAGER_TEMPLATE" => ".default",
    "PAGER_TITLE" => "Новости",
    "PARENT_SECTION" => "",
    "PARENT_SECTION_CODE" => '',
    "PREVIEW_TRUNCATE_LEN" => "",
    "PROPERTY_CODE" => ['PROTEINS','WEIGHT','FATS','CALORIES','ROLLS_COUNT','COMPOSITION','CARBOHYDRATES','RATING', 'DISCOUNT'],
    "SECTIONS_PROPERTY_CODE" => ['IBLOCK_ID', 'ID', 'NAME', 'CODE'],
    "SET_BROWSER_TITLE" => "N",
    "SET_LAST_MODIFIED" => "N",
    "SET_META_DESCRIPTION" => "N",
    "SET_META_KEYWORDS" => "N",
    "SET_STATUS_404" => "Y",
    "SET_TITLE" => "N",
    "SHOW_404" => "Y",
    "SORT_BY1" => "",
    "SORT_BY2" => "",
    "SORT_ORDER1" => "",
    "SORT_ORDER2" => "",
    "STRICT_SECTION_CHECK" => "N"
]);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>