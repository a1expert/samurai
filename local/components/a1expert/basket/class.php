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
            $fixer = new Fixer();            
            foreach ($this->arResult['ITEMS'] as $key => $arItem)
            {
                if($arItem['PRICE'] == 0 && $arItem['IBLOCK_ID'] != WOK_IBLOCK_ID)
                {
                    if($this->arResult['arPrice']['price'] < 1000)
                    {
                        Basket::Remove($this->arResult['ITEMS'][$key]['PRODUCT_ID']);
                        unset($this->arResult['ITEMS'][$key]);
                    }
                    else
                    {
                        $this->arResult['GIFTS'][$key] = $arItem;
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
