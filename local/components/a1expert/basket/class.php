<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)die();
use \A1expert\Fixer,
    \Bitrix\Main\Application,
    \A1expert\Basket;
class A1SamuraiBasket extends \CBitrixComponent
{
    public function executeComponent()
    {
        $this->arResult = Basket::getList();
        if (!empty($this->arResult['ITEMS']))
        {
            $arElemetsId['elementsId'] = [];
            $arElemetsId['productId'] = [];
            foreach ($this->arResult['ITEMS'] as $key => $arItem)
            {
                if($arItem['ELEMENT_INFO'] === false)
                {
                    $arElemetsId['productId'][$key] = $arItem['PRODUCT_ID'];
                    $arElemetsId['elementsId'][$key] = $arItem['PRODUCT_ID'];
                }
                else
                {
                    $arElemetsId['productId'][$arItem['ELEMENT_INFO']['ID']] = $arItem['PRODUCT_ID'];
                    $arElemetsId['elementsId'][$key] = $arItem['ELEMENT_INFO']['ID'];
                    $elsIblockId = $arItem['ELEMENT_INFO']['IBLOCK_ID'];
                }
            }
            $fixer = new Fixer();
            $arElemets = $fixer->GetElements([], ['ID'=> $arElemetsId['elementsId']], false,false, ['PREVIEW_PICTURE', 'ID'], false);
            
            foreach ($arElemets as $key => $value)
                $newArElements[$arElemetsId['productId'][$value['ID']]] = $value;
            
            $arElemets = $newArElements;
            unset($newArElements);
            foreach ($this->arResult['ITEMS'] as $key => $value)
                $this->arResult['ITEMS'][$key]['IMG'] = $arElemets[$key]['PREVIEW_PICTURE']['SRC'];
            
            foreach ($this->arResult['ITEMS'] as $key => $value)
            {
                if($value['PRICE'] == 0)
                {
                    if($this->arResult['PRICE'] < 1000)
                    {
                        Basket::Remove($this->arResult['ITEMS'][$key]['PRODUCT_ID']);
                        unset($this->arResult['ITEMS'][$key]);
                    }
                    else
                    {
                        $this->arResult['GIFTS'][$key] = $value;
                        unset($this->arResult['ITEMS'][$key]);
                    }
                }
            }
            //Впариваемые товары
            $cache = Application::getInstance()->getManagedCache();
            if ($cache->read(36000000, 'shoved'))
                $this->arResult['shoved'] = $cache->get('shoved');
            else
            {
                $shovedProducts = $fixer->GetElements([], ['IBLOCK_ID'=>SHOVE_ID], false, false, ['IBLOCK_ID', 'ID', 'NAME', 'PREVIEW_PICTURE', 'CATALOG_PRICE_1'], false);
                $cache->set('shoved', $shovedProducts);
                $this->arResult['shoved'] = $shovedProducts;
            }   
        }
        $this->includeComponentTemplate();
        return $this->arResult;
    }
}
