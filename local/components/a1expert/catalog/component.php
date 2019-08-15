<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

/** @global CIntranetToolbar $INTRANET_TOOLBAR */
global $INTRANET_TOOLBAR;

use Bitrix\Main\Context,
	Bitrix\Main\Type\DateTime,
	Bitrix\Main\Loader,
	Bitrix\Iblock,
	A1expert\Fixer;
$fixer = new Fixer();
CPageOption::SetOptionString("main", "nav_page_in_session", "N");

if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 36000000;
$arParams["IBLOCK_TYPE"] = trim($arParams["IBLOCK_TYPE"]);
$arParams["IBLOCK_ID"] = intval($arParams["IBLOCK_ID"]);
$arParams["PARENT_SECTION"] = intval($arParams["PARENT_SECTION"]);
$arParams["INCLUDE_SUBSECTIONS"] = $arParams["INCLUDE_SUBSECTIONS"]!="N";

$arParams["SORT_BY1"] = trim($arParams["SORT_BY1"]);
if(strlen($arParams["SORT_BY1"])<=0)
{
	$arParams["SORT_BY1"] = "SORT";
	$arParams["SORT_ORDER1"]="ASC";
}
if(!is_array($arParams["FIELD_CODE"]))
	$arParams["FIELD_CODE"] = array();
foreach($arParams["FIELD_CODE"] as $key=>$val)
	if(!$val)
		unset($arParams["FIELD_CODE"][$key]);

if(!is_array($arParams["PROPERTY_CODE"]))
	$arParams["PROPERTY_CODE"] = array();
foreach($arParams["PROPERTY_CODE"] as $key=>$val)
	if($val==="")
		unset($arParams["PROPERTY_CODE"][$key]);
$arParams["DETAIL_URL"]=trim($arParams["DETAIL_URL"]);
$arParams["CACHE_FILTER"] = $arParams["CACHE_FILTER"]=="Y";
$arParams["SET_TITLE"] = $arParams["SET_TITLE"]!="N";
$arParams["SET_BROWSER_TITLE"] = (isset($arParams["SET_BROWSER_TITLE"]) && $arParams["SET_BROWSER_TITLE"] === 'N' ? 'N' : 'Y');
$arParams["SET_META_KEYWORDS"] = (isset($arParams["SET_META_KEYWORDS"]) && $arParams["SET_META_KEYWORDS"] === 'N' ? 'N' : 'Y');
$arParams["SET_META_DESCRIPTION"] = (isset($arParams["SET_META_DESCRIPTION"]) && $arParams["SET_META_DESCRIPTION"] === 'N' ? 'N' : 'Y');
$arParams["ADD_SECTIONS_CHAIN"] = $arParams["ADD_SECTIONS_CHAIN"]!="N"; //Turn on by default
$arParams["INCLUDE_IBLOCK_INTO_CHAIN"] = $arParams["INCLUDE_IBLOCK_INTO_CHAIN"]!="N";
$arParams["STRICT_SECTION_CHECK"] = (isset($arParams["STRICT_SECTION_CHECK"]) && $arParams["STRICT_SECTION_CHECK"] === "Y");


if($this->startResultCache(false, array(($arParams["CACHE_GROUPS"]==="N"? false: $USER->GetGroups()), $arNavigation)))
{
	if(!Loader::includeModule("iblock") && !Loader::includeModule("catalog"))
	{
		$this->abortResultCache();
		ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
		ShowError(" or catalog modul not installed");
		return;
	}

	
	$rsIBlock = CIBlock::GetList(array(), array(
		"ACTIVE" => "Y",
		"ID" => $arParams["IBLOCK_ID"],
	));
	$arResult = $rsIBlock->GetNext();
	if (!$arResult)
	{
		$this->abortResultCache();
		Iblock\Component\Tools::process404(trim($arParams["MESSAGE_404"]) ?: GetMessage("T_NEWS_NEWS_NA"), true, $arParams["SET_STATUS_404"] === "Y", $arParams["SHOW_404"] === "Y", $arParams["FILE_404"]);
		return;
	}
	$arResult["USER_HAVE_ACCESS"] = $bUSER_HAVE_ACCESS;
	$arSelect = array_merge($arParams["FIELD_CODE"], array(
		"ID",
		"IBLOCK_ID",
		"IBLOCK_SECTION_ID",
		"NAME",
		"PREVIEW_PICTURE",
		'CATALOG_PRICE_1'
	));
	$bGetProperty = count($arParams["PROPERTY_CODE"])>0;
	if($bGetProperty)
		$arSelect[]="PROPERTY_*";
	$arFilter = array (
		"IBLOCK_ID" => $arResult["ID"],
		"IBLOCK_LID" => SITE_ID,
		"ACTIVE" => "Y",
	);

	$PARENT_SECTION = CIBlockFindTools::GetSectionID($arParams["PARENT_SECTION"], $arParams["PARENT_SECTION_CODE"], array("GLOBAL_ACTIVE" => "Y", "IBLOCK_ID" => $arResult["ID"]));
	$arParams["PARENT_SECTION"] = $PARENT_SECTION;
	if($arParams["PARENT_SECTION"]>0)
	{
		$arFilter["SECTION_ID"] = $arParams["PARENT_SECTION"];
		if($arParams["INCLUDE_SUBSECTIONS"])
			$arFilter["INCLUDE_SUBSECTIONS"] = "Y";
		$arResult["SECTION"]= array("PATH" => array());
		$rsPath = CIBlockSection::GetNavChain($arResult["ID"], $arParams["PARENT_SECTION"]);
		$rsPath->SetUrlTemplates("", $arParams["SECTION_URL"], $arParams["IBLOCK_URL"]);
		while($arPath = $rsPath->GetNext())
		{
			$ipropValues = new Iblock\InheritedProperty\SectionValues($arParams["IBLOCK_ID"], $arPath["ID"]);
			$arPath["IPROPERTY_VALUES"] = $ipropValues->getValues();
			$arResult["SECTION"]["PATH"][] = $arPath;
		}
		$ipropValues = new Iblock\InheritedProperty\SectionValues($arResult["ID"], $arParams["PARENT_SECTION"]);
		$arResult["IPROPERTY_VALUES"] = $ipropValues->getValues();
	}
	else
	{
		$arResult["SECTION"]= false;
	}
	
	$arSort = array($arParams["SORT_BY1"]=>$arParams["SORT_ORDER1"], $arParams["SORT_BY2"]=>$arParams["SORT_ORDER2"]);
	$arResult["ITEMS"] = array();
	$arResult["ELEMENTS"] = array();
	$rsElement = CIBlockElement::GetList($arSort, $arFilter, false, $arNavParams, $arSelect);
	$rsElement->SetUrlTemplates($arParams["DETAIL_URL"], "", $arParams["IBLOCK_URL"]);
	while($obElement = $rsElement->GetNextElement())
	{
		$arItem = $obElement->GetFields();
		$arButtons = CIBlock::GetPanelButtons($arItem["IBLOCK_ID"], $arItem["ID"], 0, array("SECTION_BUTTONS"=>false, "SESSID"=>false));
		$arItem["EDIT_LINK"] = $arButtons["edit"]["edit_element"]["ACTION_URL"];
		$arItem["DELETE_LINK"] = $arButtons["edit"]["delete_element"]["ACTION_URL"];
		$arItem["FIELDS"] = array();
		$arItem['PREVIEW_PICTURE'] = (!empty($arItem['PREVIEW_PICTURE'])) ? \CFile::GetPath($arItem['PREVIEW_PICTURE']) : '';
		if($bGetProperty)
			$arItem["PROPERTIES"] = $obElement->GetProperties();
		$arItem["DISPLAY_PROPERTIES"]=array();
		foreach($arParams["PROPERTY_CODE"] as $pid)
		{
			$prop = &$arItem["PROPERTIES"][$pid];
			if((is_array($prop["VALUE"]) && count($prop["VALUE"])>0) || (!is_array($prop["VALUE"]) && strlen($prop["VALUE"])>0))
				$arItem["DISPLAY_PROPERTIES"][$pid] = CIBlockFormatProperties::GetDisplayValue($arItem, $prop, "news_out");
		}
		$dbSections = CIBlockElement::GetElementGroups($arItem['ID'], true, ['ID']);
		while ($itemSection = $dbSections->Fetch())
		{
			$arItem['SECTIONS_ID'][] = $itemSection['ID'];
		}
		$arResult["ITEMS"][] = $arItem;
		$arResult["ELEMENTS"][] = $arItem["ID"];
	}

	//Товары с торговыми предложениями
	$elementsWithOffers = []; // массив ID товаров
	//Если инфоблоков с товарами будет больше чем один - надо убрать второй параметр $arParams['IBLOCK_ID'] вообще.
	$rsOffers = CCatalogSKU::getExistOffers($arResult['ELEMENTS'],  $arParams['IBLOCK_ID']);
	foreach ($rsOffers as $key => $value)
	{
		if($value)
			$elementsWithOffers[] = $key;
	}
	$offersList = CCatalogSKU::getOffersList($elementsWithOffers, $iblockID = $arParams['IBLOCK_ID'], $skuFilter = [], $fields = ['CATALOG_PRICE_1'], $propertyFilter = ['ID'=>[9]]);
	
	foreach ($offersList as $key => $item)
	{
		foreach ($item as $value)
		{			
			if($value['PROPERTIES']['CITY']['VALUE'] == $_COOKIE['city'])
				$sortedOffers[$key] = $value;
		}
	}

	$arResult['filters'] = [];
	foreach ($arResult['ITEMS'] as $key => $arItem)
	{
		if(array_key_exists($arItem['ID'], $sortedOffers))
		{
			$arResult['ITEMS'][$key]['CATALOG_PRICE_1'] = $sortedOffers[$arItem['ID']]['CATALOG_PRICE_1'];
			$arResult['ITEMS'][$key]['OFFERS'] = $offersList[$arItem['ID']];
		}
		foreach ($arItem['PROPERTIES']['FILTER']['VALUE'] as $value)
			$arResult['filters'][$value] = $value;
	}
	unset($arItem);
	$this->setResultCacheKeys(array(
		"ID",
		"IBLOCK_TYPE_ID",
		"LIST_PAGE_URL",
		"NAME",
		"SECTION",
		"ELEMENTS",
		"IPROPERTY_VALUES",
		"ITEMS_TIMESTAMP_X",
		"filters",
	));
	$this->includeComponentTemplate();
}

if(isset($arResult["ID"]))
{
	$arTitleOptions = null;
	if($USER->IsAuthorized())
	{
		if(
			$APPLICATION->GetShowIncludeAreas()
			|| (is_object($GLOBALS["INTRANET_TOOLBAR"]) && $arParams["INTRANET_TOOLBAR"]!=="N")
			|| $arParams["SET_TITLE"]
		)
		{
			if(Loader::includeModule("iblock"))
			{
				$arButtons = CIBlock::GetPanelButtons(
					$arResult["ID"],
					0,
					$arParams["PARENT_SECTION"],
					array("SECTION_BUTTONS"=>false)
				);

				if($APPLICATION->GetShowIncludeAreas())
					$this->addIncludeAreaIcons(CIBlock::GetComponentMenu($APPLICATION->GetPublicShowMode(), $arButtons));

				if(
					is_array($arButtons["intranet"])
					&& is_object($INTRANET_TOOLBAR)
					&& $arParams["INTRANET_TOOLBAR"]!=="N"
				)
				{
					$APPLICATION->AddHeadScript('/bitrix/js/main/utils.js');
					foreach($arButtons["intranet"] as $arButton)
						$INTRANET_TOOLBAR->AddButton($arButton);
				}

				if($arParams["SET_TITLE"])
				{
					$arTitleOptions = array(
						'ADMIN_EDIT_LINK' => $arButtons["submenu"]["edit_iblock"]["ACTION"],
						'PUBLIC_EDIT_LINK' => "",
						'COMPONENT_NAME' => $this->getName(),
					);
				}
			}
		}
	}

	$APPLICATION->SetTitle($arResult["SECTION"]["PATH"][0]["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]);
	$APPLICATION->SetPageProperty('metaTitle', $arResult["SECTION"]["PATH"][0]["IPROPERTY_VALUES"]["SECTION_META_TITLE"]);
	if($arParams["ADD_SECTIONS_CHAIN"] && is_array($arResult["SECTION"]))
	{
		foreach($arResult["SECTION"]["PATH"] as $arPath)
		{
			if ($arPath["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"] != "")
				$APPLICATION->AddChainItem($arPath["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"], $arPath["~SECTION_PAGE_URL"]);
			else
				$APPLICATION->AddChainItem($arPath["NAME"], $arPath["~SECTION_PAGE_URL"]);
		}
	}

	if ($arParams["SET_LAST_MODIFIED"] && $arResult["ITEMS_TIMESTAMP_X"])
	{
		Context::getCurrent()->getResponse()->setLastModified($arResult["ITEMS_TIMESTAMP_X"]);
	}

	return $arResult;
}
