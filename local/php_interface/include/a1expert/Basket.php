<?
namespace a1expert;
use Bitrix\Main\Loader;
use Bitrix\Sale;
use Bitrix\Catalog;
class Basket
{
    public function __construct()
    {
        Loader::includeModule('iblock');
        Loader::includeModule('sale');
        Loader::includeModule('catalog');
    }
    private function _getSite()
    {
        return \Bitrix\Main\Context::getCurrent()->getSite();
    }
    private function _getBasket()
    {
        return Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), $this->_getSite());
    }

    public function set($productId, $quantity): array
    {
        $productId = (int)$productId;
        $quantity = (float)$quantity;
        if (empty($productId)) {
            return $this->get();
        }
        $basket = $this->_getBasket();
        if ($item = $basket->getExistsItem('catalog', $productId))
        {
            if ($quantity <= 0)
                $item->delete();
            else
                $item->setField('QUANTITY', $quantity);
        }
        else
        {
            if ($quantity > 0)
            {
                $item = $basket->createItem('catalog', $productId);
                $item->setFields(
                [
                    'QUANTITY' => $quantity,
                    'CURRENCY' => \Bitrix\Currency\CurrencyManager::getBaseCurrency(),
                    'LID' => $this->_getSite(),
                    'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider',
                ]);
            }
        }
        $basket->save();
        return $this->get();
    }
    public static function Wok($arrId)
    {
        $class = new self();
        $basket = $class->_getBasket();
        foreach ($arrId as $id)
        {
            if($item = $basket->getExistsItem('catalog', $id))
                $item->setField('QUANTITY', (float)$item->getQuantity() + 1);
            else
            {
                $item = $basket->createItem('catalog', $id);
                $item->setFields(
                [
                    'QUANTITY' => 1,
                    'CURRENCY' => \Bitrix\Currency\CurrencyManager::getBaseCurrency(),
                    'LID' => $class->_getSite(),
                    'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider',
                ]);
            }
        }
        $basket->save();
    }
    public function get(): array
    {
        static $arResult;
        global $USER;
        if (is_null($arResult))
        {
            $arResult = [];
            $arResult['ITEMS'] = [];
            $basket = $this->_getBasket();
            $arResult['arPrice'] = [];
            $arResult['arPrice']['price'] = 0;
            $arResult['arPrice']['discountPrice'] = 0;
            /** @var Sale\BasketItemBase $basketItem */
            
            foreach ($basket->getBasketItems() as $basketItem)
            {
                $quantity = $basketItem->getQuantity();
                $arPrice = \CCatalogProduct::GetOptimalPrice((int)$basketItem->getProductId(), 1, (int)$USER->GetUserGroupArray(), 'N', array(), $this->_getSite(), array());
                $price = round($arPrice['PRICE']['PRICE']) * $basketItem->getQuantity();
                $discountPrice = round($arPrice['DISCOUNT_PRICE']) * $basketItem->getQuantity();
                $arResult['arPrice']['price'] += $price;
                $arResult['arPrice']['discountPrice'] += $discountPrice;
                $arItem = [
                    'ID' => $basketItem->getId(),
                    'PRODUCT_ID' => $basketItem->getProductId(),
                    'IBLOCK_ID' => \CIBlockElement::GetIBlockByID($basketItem->getProductId()),
                    'PRICE' => $discountPrice,
                    'NAME' => $basketItem->getField('NAME'),
                    'QUANTITY' => $basketItem->getQuantity(),
                    'ELEMENT_INFO' => \CCatalogSku::GetProductInfo($basketItem->getProductId()),
                ];
                $arResult['ITEMS'][$arItem['PRODUCT_ID']] = $arItem;
            }
            if (!empty($arResult['ITEMS']))
            {
                $arElements = static::getElements(array_keys($arResult['ITEMS']));
                foreach ($arResult['ITEMS'] as $id => $arItem)
                {
                    if (!isset($arElements[$id]))
                        continue;
                    $arResult['ITEMS'][$id] = array_merge($arResult['ITEMS'][$id], $arElements[$id]);
                }
            }
            ksort($arResult['ITEMS']);
            $arResult['COUNT'] = $basket->count();
            if($arResult['arPrice']['price'] != $arResult['arPrice']['discountPrice'])
                $arResult['arPrice']['isDiscount'] = true;
            else
                $arResult['arPrice']['isDiscount'] = false;
        }
        return $arResult;
    }
    public static function getElements(array $arIds): array
    {
        $arResult = [];
        $rsElements = \CIBlockElement::GetList(['SORT' => 'ASC'], ['ID' => $arIds, 'IBLOCK_ID' => IBLOCK_ID_CATALOG, 'ACTIVE' => 'Y',], false, false,['ID', 'NAME', 'IBLOCK_SECTION_ID', 'PROPERTY_PIZZA_SIZE', 'PROPERTY_VOLUME', 'PROPERTY_WEIGHT', 'PROPERTY_DISCOUNT']);
        $arSections = [];
        while ($arItem = $rsElements->Fetch())
        {
            $arSections[$arItem['IBLOCK_SECTION_ID']][] = $arItem['ID'];
            $arResult[$arItem['ID']] = [
                'NAME' => $arItem['NAME'],
                'PIZZA_SIZE' => $arItem['PROPERTY_PIZZA_SIZE_VALUE'],
                'WEIGHT' => $arItem['PROPERTY_WEIGHT_VALUE'],
                'VOLUME' => $arItem['PROPERTY_VOLUME_VALUE'],
            ];
        }
        if (!empty($arSections))
        {
            $rsSections = \CIBlockSection::GetList(['DEPTH_LEVEL' => 'ASC', 'SORT' => 'ASC'], ['IBLOCK_ID' => IBLOCK_ID_CATALOG, 'ACTIVE' => 'Y', 'ID' => array_keys($arSections)], false, ['ID', 'NAME', 'DEPTH_LEVEL']);
            while ($arItem = $rsSections->Fetch())
            {
                if ($arItem['DEPTH_LEVEL'] == 2)
                {
                    foreach ($arSections[$arItem['ID']] as $elementId)
                        $arResult[$elementId]['NAME'] = $arItem['NAME'];
                }
            }
        }
        return $arResult;
    }
    public static function GetList()
    {
        $class = new self();
        return $class->get();
    }
    public static function Add($productId, $quantity = 1): array
    {
        $class = new self();
        return $class->set($productId, $quantity);
    }
    public static function Update($productId, $quantity): array
    {
        $class = new self();
        return $class->set($productId, $quantity);
    }
    public static function Remove($productId): array
    {
        $class = new self();
        $basket = $class->_getBasket();
        if ($item = $basket->getExistsItem('catalog', $productId)) {
            $item->delete();
            $basket->save();
        }
        return $class->get();
    }
}
