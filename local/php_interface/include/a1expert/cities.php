<?
namespace A1expert
{
    use \Bitrix\Main\Context,
    \Bitrix\Main\Type\DateTime,
    \Bitrix\Main\Loader,
    \Bitrix\Main\Application,
    \Bitrix\Iblock,
    \A1expert\Fixer;

    class Cities
    {
        public $cities;
        public $curCity;
        
        public function __construct()
        {
            $cache = Application::getInstance()->getManagedCache();
            $fixer = new Fixer();
            $arOrder = $fixer->SetOrder();
            $arFilter = $fixer->SetFilter(array("IBLOCK_ID"=>CITIES_ID));
            $arSelect = $fixer->SetSelect(array('ID', 'IBLOCK_ID', 'NAME', 'CODE', 'PROPERTY_LINK', 'PROPERTY_PHONE', 'PROPERTY_WORK_TIME'));
            if ($cache->read(36000000, "cities"))
                $this->cities = $cache->get("cities");
            else
            {
                $arResult = $fixer->GetElements($arOrder, $arFilter, false, false, $arSelect);
                foreach ($arResult as $key => $value)
                    $newRes[$value['ID']] = $value;
                $arResult = $newRes;
                $cahedCities = $arResult;
                $cache->set("cities", $cahedCities);
                $this->cities = $cahedCities;
            }
            foreach ($this->cities as $city)
                if($_SERVER['HTTP_HOST'] === $city['PROPERTY_LINK_VALUE'])
                    $this->curCity = $city;
                else
                    $this->curCity = $this->cities[array_key_first($this->cities)];
            if(empty($this->cities))
                throw new Exception('cities is empty!', 0, __FILE__, __LINE__);
            
        }

        function MakeCitiesList()
        {
            $citiesList = '<div class="cities">';
            foreach ($this->cities as $city)
            {
                $citiesList .= "<a href=\"//{$city['PROPERTY_LINK_VALUE']}\" class=\"cities__link\" data-city=\"{$city['ID']}\">{$city['NAME']}</a>";
            }
            $citiesList .= '</div>';
            return $citiesList;
        }
    }    
}