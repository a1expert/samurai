<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("pageIntroBg", "Y");
$APPLICATION->SetTitle("О компании");
// ShowRes($cities);
?><section class="section main__section about">
	<h2 class="visually-hidden">Принципы работы и контакты</h2>
	<div class="container">
		<div class="section__layout about__layout">
			<p class="intro-text about__intro"><?$APPLICATION->IncludeFile('/local/inc_areas/about/sect_inc0.php', array(), array('MODE' => 'text', 'NAME'=>'Текст'));?></p>
			<section class="section principles main__section">
				<h2 class="section__title">3 принципа нашей компании</h2>
				<ul class="principles__list">
					<li class="principles__item principles__item--fast">
					<h3 class="principles__title">Привозим быстро.</h3>
					<p class="principles__text"><?$APPLICATION->IncludeFile('/local/inc_areas/about/sect_inc1.php', array(), array('MODE' => 'text', 'NAME'=>'Текст'));?></p>
					</li>
					<li class="principles__item principles__item--fresh">
					<h3 class="principles__title">Готовим из свежего.</h3>
					<p class="principles__text"><?$APPLICATION->IncludeFile('/local/inc_areas/about/sect_inc2.php', array(), array('MODE' => 'text', 'NAME'=>'Текст'));?></p>
					</li>
					<li class="principles__item principles__item--promo">
					<h3 class="principles__title">Работаем для клиентов.</h3>
					<p class="principles__text"><?$APPLICATION->IncludeFile('/local/inc_areas/about/sect_inc3.php', array(), array('MODE' => 'text', 'NAME'=>'Текст'));?></p>
					</li>
				</ul>
			</section>
			<section class="contacts">
				<h2 class="section__title">Телефоны для принятия заказов</h2>
				<ul class="contacts__phones">
				<?foreach ($cities->cities as $key => $city)
				{?>
					<li class="contacts__phones-item">
						<span class="contacts__subtitle contacts__city-name"><?=$city['NAME'];?></span>
						<span class="contacts__phone-number"><?=$city['props']['ABOUT_PHONE']['VALUE'];?></span>
					</li>
					<?
				}?>
					
					<li class="contacts__phones-item">
						<span class="contacts__subtitle contacts__city-name">Единый телефон службы контроля качества:</span>
						<span class="contacts__phone-number"><?$APPLICATION->IncludeFile('/local/inc_areas/about/phone5.php', array(), array('MODE' => 'text', 'NAME'=>'Телефон'));?></span>
					</li>
				</ul>
				<p class="contacts__subtitle">Мы в социальных сетях:</p>
				<ul class="contacts__socials">
					<li class="contacts__socials-item"><a href="<?=$cities->curCity['props']['VK_LINK']['VALUE'];?>" target="_blank">Vkontakte</a></li>
					<li class="contacts__socials-item"><a href="<?=$cities->curCity['props']['INSTA_LINK']['VALUE'];?>" target="_blank">Instagram</a></li>
					<li class="contacts__socials-item"><a href="<?=$cities->curCity['props']['OK_LINK']['VALUE'];?>" target="_blank">Одноклассники</a></li>
					<li class="contacts__socials-item"><a href="<?=$cities->curCity['props']['FB_LINK']['VALUE'];?>" target="_blank">Facebook</a></li>
				</ul>
			</section>
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
	"SET_TITLE" => "N",
	"SHOW_404" => "N",
	"SORT_BY1" => "TIMESTAMP_X",
	"SORT_BY2" => "",
	"SORT_ORDER1" => "DESC",
	"SORT_ORDER2" => "",
	"STRICT_SECTION_CHECK" => "N"
));?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>