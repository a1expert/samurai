<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Обратная связь");
?>
<section class="section main__section create-feedback">
    <div class="container">
        <div class="section__layout create-feedback__layout">
            <h2 class="visually-hidden">Оставить отзыв о нас</h2>
            <p class="create-feedback__notice"><?$APPLICATION->IncludeFile('/local/inc_areas/reviews/topText.php', array(), array('MODE' => 'text', 'NAME'=>''));?></p>
            <form class="form create-feedback__form" name="review" action="http://xvideos.com/" method="POST" enctype="multipart/form-data" id="revForm">
                <div class="form__top">
					<div class="form__group formTopGroup">
						<label for="name" class="form__label">Ваше имя</label>
						<input id="name" type="text" name="name" class="input">
					</div>
                    <div class="form__group formTopGroup">
						<label for="phone" class="form__label">Ваш номер телефона</label>
						<input id="phone" type="text" name="phone" class="input">
					</div>
                    <div class="form__group formTopGroup">
						<label for="email" class="form__label">Ваш email</label>
						<input id="email" type="text" name="email" class="input">
					</div>
                </div>
                <div class="form__body">
                    <div class="form__group">
						<label for="comment" class="form__label">Описание заказа или комментарий</label>
						<textarea id="comment" rows="4" name="comment" class="textarea comment"></textarea>
					</div>
                    <?/*<div class="form__group">
						<input id="photo" type="file" class="visually-hidden">
						<label for="photo" class="form__label form__file">Добавьте фотографию</label>
					</div>*/?>
                    <div class="form__group">
						<input id="policy" type="checkbox" name="policy" class="visually-hidden">
						<label for="policy" class="form__label form__policy">Заполняя настоящую форму вы даете свое согласие на обработку своих персональных данных</label>
					</div>
                </div>
				<div class="form__footer">
					<button type="submit" class="button form__submit" id="revSubmit">отправить комментарий</button>
				</div>
			</form>
        </div>
    </div>
</section>
<?$APPLICATION->IncludeComponent("bitrix:news.list", "reviews", Array(
	"ACTIVE_DATE_FORMAT" => "d.m.Y",
	"ADD_SECTIONS_CHAIN" => "N",
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
	"DISPLAY_DATE" => "Y",
	"DISPLAY_NAME" => "Y",
	"DISPLAY_PICTURE" => "N",
	"DISPLAY_PREVIEW_TEXT" => "Y",
	"DISPLAY_TOP_PAGER" => "N",
	"FIELD_CODE" => array("DETAIL_TEXT","PREVIEW_TEXT",'DATE_CREATE'),//PREVIEW_TEXT - это отзыв, DETAIL_TEXT - это ответ
	"FILTER_NAME" => "",
	"HIDE_LINK_WHEN_NO_DETAIL" => "N",
	"IBLOCK_ID" => 10,
	"IBLOCK_TYPE" => "",
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
	"PARENT_SECTION_CODE" => "",
	"PREVIEW_TRUNCATE_LEN" => "",
	"PROPERTY_CODE" => array("",""),
	"SET_BROWSER_TITLE" => "Y",
	"SET_LAST_MODIFIED" => "N",
	"SET_META_DESCRIPTION" => "Y",
	"SET_META_KEYWORDS" => "Y",
	"SET_STATUS_404" => "N",
	"SET_TITLE" => "Y",
	"SHOW_404" => "N",
	"SORT_BY1" => "TIMESTAMP_X",
	"SORT_BY2" => "",
	"SORT_ORDER1" => "DESC",
	"SORT_ORDER2" => "",
	"STRICT_SECTION_CHECK" => "N"
));?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>