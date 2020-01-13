<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();
use Bitrix\Main\Context,
    Bitrix\Main\Loader,
    Bitrix\Sale\Order,
    Bitrix\Sale\Basket,
    Bitrix\Catalog,
    \Bitrix\Main\Application,
    \A1expert\Fixer;

class A1SamuraiOrder extends \CBitrixComponent
{
    
    public function executeComponent()
    {
        Bitrix\Main\Loader::includeModule("sale");
        Bitrix\Main\Loader::includeModule("catalog");
        global $USER;
        $userId = $USER->GetId();

        $cache = Application::getInstance()->getManagedCache();
        if ($cache->read(36000000, "ordersHistory_$userId"))
        {
            $this->arResult = $cache->get("ordersHistory_$userId");
            ShowRes($cache->get("ordersHistory_$userId"));
        }
        else
        {
            $filter = ['USER_ID'=>$userId];
            $sort = ['ID'=>'DESC'];
            $orderList = Bitrix\Sale\Order::getList(['filter' => $filter, 'order'=>$sort, 'limit'=>6]);
            $orders = []; $ordersIds = [];
            while($rsOrder = $orderList->fetch())
            {
                $orders[$rsOrder['ID']] = ['ID'=>$rsOrder['ID'], 'STATUS'=>$rsOrder['STATUS_ID']/*N - не выполнен, F - выполнен */, 'DATE'=>ConvertDateTime($rsOrder['DATE_INSERT'].date, "DD.MM.YYYY", "ru")];
                $ordersIds[] = $rsOrder['ID'];
            }
            $rsbasket = Basket::getList(['filter'=>['ORDER_ID'=>$ordersIds]]);
            $arElementsId = [];
            while($basket = $rsbasket->fetch())
            {
                $arElementsId[] = $basket['PRODUCT_ID'];
                $orders[$basket['ORDER_ID']]['ITEMS'][$basket['PRODUCT_ID']] = [
                    'ID'=>$basket['PRODUCT_ID'],
                    'NAME'=>$basket['NAME'],
                    'PRICE'=>$basket['PRICE']
                ];
            }
            $fixer = new Fixer();
            $arElements = $fixer->GetElements([], ['ID'=> $arElementsId], false, false, ['IBLOCK_ID', 'PREVIEW_PICTURE', 'ID', 'NAME'], false);
            foreach($arElements as $el)
                $newArElements[$el['ID']] = $el;
            foreach($newArElements as $key => $arElement)
            {
                $newArElements[$key]['ELEMENT_INFO'] = \CCatalogSku::GetProductInfo($arElement['ID']);
                if($newArElements[$key]['ELEMENT_INFO'] !== false)
                    $realElementsIds[$newArElements[$key]['ELEMENT_INFO']['SKU_PROPERTY_ID']] = $newArElements[$key]['ELEMENT_INFO']['ID'];
            }
            $realElements = $fixer->GetElements([], ['ID'=> $realElementsIds], false,false, ['IBLOCK_ID', 'PREVIEW_PICTURE', 'ID', 'NAME'], false);
            foreach ($realElements as $value)
                $tmp[$value['ID']] = $value;
            $realElements = $tmp;
            unset($tmp);
            foreach ($realElementsIds as $key => $value)
                $newArElements[$key]['PREVIEW_PICTURE'] = $realElements[$value]['PREVIEW_PICTURE'];
            foreach ($orders as $vkey => $value)
            {
                foreach ($value['ITEMS'] as $ikey => $item)
                    $orders[$vkey]['ITEMS'][$ikey]['img'] = $newArElements[$ikey]['PREVIEW_PICTURE']['SRC'];
            }            
            $cache->set("ordersHistory_$userId", $orders);
            ShowRes($cache);
            $this->arResult = $orders;
        }

        $this->includeComponentTemplate();
    }
}