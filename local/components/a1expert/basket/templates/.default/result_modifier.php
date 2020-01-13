<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)die();

$wokCount = 0; $wokPrice = 0; $wokCompound = '';
foreach ($arResult['ITEMS'] as $key => $arItem)
{
    if($arItem['IBLOCK_ID'] == WOK_IBLOCK_ID)
    {
        $wokCount++;
        $wokPrice += (int)$arItem['PRICE'];
        $wokCompound += "$arItem[NAME],";
        unset($arResult['ITEMS'][$key]);
    }
}
$arResult['COUNT'] -= ($wokCount - 1);
$wok = [
    'ID' => '0',
    'PRODUCT_ID' => '0',
    'IBLOCK_ID' => '11',
    'PRICE' => $wokPrice,
    'NAME' => 'МОЯ ЛАПША!',
    'QUANTITY' => 1,
    'ELEMENT_INFO' => false,
    'IMG' => '/local/assets/images/mywok.png'
];
array_push($arResult['ITEMS'], $wok);