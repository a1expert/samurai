<?
global $APPLICATION;
$aMenuLinksExt = $APPLICATION->IncludeComponent("bitrix:menu.sections", "", Array(
	"CACHE_TIME" => "36000000",
	"CACHE_TYPE" => "A",
	"DEPTH_LEVEL" => "2",
	"DETAIL_PAGE_URL" => "",
	"IBLOCK_ID" => "1",
	"IBLOCK_TYPE" => "content",
	"IS_SEF" => "Y",
	"SECTION_PAGE_URL" => "#SECTION_CODE#/",
	"SECTION_URL" => "",
	"SEF_BASE_URL" => "/catalog/",
	"FOR_BOTTOM_MENU" => "Y"
));

$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
?>