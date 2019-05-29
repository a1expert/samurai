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
        
        public function __construct()
        {
            $cache = Application::getInstance()->getManagedCache();
            $fixer = new Fixer();
            $arOrder = $fixer->SetOrder();
            $arFilter = $fixer->SetFilter(array("IBLOCK_ID"=>CITIES_IB));
            $arSelect = $fixer->SetSelect(array('ID', 'IBLOCK_ID', 'NAME', 'CODE', 'PROPERTY_LINK'));
            if ($cache->read(36000000, "cities"))
            {
                $this->cities = $cache->get("cities");
            }
            else
            {
                $arResult = $fixer->GetElements($arOrder, $arFilter, false, false, $arSelect);
                $cahedCities = $arResult;
                $cache->set("cities", $cahedCities);
                $this->cities = $cahedCities;
            }
            if(empty($this->cities))
                throw new Exception('cities is empty!', 0, __FILE__, __LINE__);
        }

        function MakeCitiesList()
        {
            $citiesList = '<div class="cities">
                                <ul class="cities__list">';
            foreach ($this->cities as $city)
            {
                $citiesList .= "<li class=\"cities__item\">
                                    <a href=\"//{$city['PROPERTY_LINK_VALUE']}\" class=\"cities__link\" data-city=\"{$city['CODE']}\">{$city['NAME']}</a>
                                </li>";
            }
            $citiesList .= '</ul>
                        </div>';
            return $citiesList;
        }

        function SetCookie()
        {
            foreach ($this->cities as $city)
            {
                if($_SERVER['HTTP_HOST'] === $city['PROPERTY_LINK_VALUE'])
                    setcookie('city', $city['CODE'], 0, '/');
            }
        }
    }    
}