<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;

global $USER;
global $USER_FIELD_MANAGER;

Loader::includeModule('iblock');
Loader::includeModule('sale');
Loader::includeModule('catalog');

$fuserId = CSaleBasket::GetBasketUserID();

$dbBasketItems = CSaleBasket::GetList(
	array("ID" => "ASC"),
	array(
		"FUSER_ID" => $fuserId,
		"LID" => SITE_ID,
		"ORDER_ID" => "NULL",
		"DELAY"=>"N"
	),
	false,
	false,
	array(
		"ID", "NAME", "CALLBACK_FUNC", "MODULE", "PRODUCT_ID", "PRODUCT_PRICE_ID", "QUANTITY", "DELAY", "CAN_BUY", "PRICE", "WEIGHT", "DETAIL_PAGE_URL",
		"NOTES", "CURRENCY", "VAT_RATE", "CATALOG_XML_ID", "PRODUCT_XML_ID", "SUBSCRIBE", "DISCOUNT_PRICE", "PRODUCT_PROVIDER_CLASS", "TYPE", "SET_PARENT_ID"
	)
);

$arOrder = array(
	'SITE_ID' => SITE_ID,
	'USER_ID' => $GLOBALS["USER"]->GetID(),
	'ORDER_PRICE' => 0,
	'ORDER_WEIGHT' => 0,
	'BASKET_ITEMS' => array(),
);

$arOptions = array(
	'COUNT_DISCOUNT_4_ALL_QUANTITY' => "Y",
);

$arErrors = array();

while ($arBasketItems = $dbBasketItems->Fetch())
{
	$arOrder['ORDER_PRICE'] += $arBasketItems["PRICE"] * $arBasketItems["QUANTITY"];
	$arOrder['ORDER_WEIGHT'] += $arBasketItems["WEIGHT"] * $arBasketItems["QUANTITY"];
	$arOrder['BASKET_ITEMS'][] = $arBasketItems;
}

if (count($arOrder['BASKET_ITEMS']) != 0) {
	if($USER->IsAuthorized()) {
		$bonuses = $USER_FIELD_MANAGER->GetUserFields('USER', $USER->GetID(), LANGUAGE_ID)['UF_BONUSES']['VALUE'] ?: 0;
		$action_bonuses = intval(trim($_GET['bonuses']));
		if (($action_bonuses < 0) || ($action_bonuses > $bonuses) || ($action_bonuses > $arOrder['ORDER_PRICE'])) {
			$arErrors[] = 'Bonuses';
		}
		else {
			$USER->Update($USER->GetID(), array('UF_BONUSES' => $bonuses - $action_bonuses));
			$arOrder['ORDER_PRICE'] = $arOrder['ORDER_PRICE'] - $action_bonuses;
		}
	}

	?><pre><?print_r($arOrder)?></pre><?

	CSaleDiscount::DoProcessOrder($arOrder, $arOptions, $arErrors);

	?><pre><?print_r($arOrder)?></pre><?
	?><pre><?print_r($arOptions)?></pre><?
	?><pre><?print_r($arErrors)?></pre><?
}