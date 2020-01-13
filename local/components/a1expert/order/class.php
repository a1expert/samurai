<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();
use Bitrix\Main\Context,
    Bitrix\Main\Loader,
    Bitrix\Currency\CurrencyManager,
    Bitrix\Sale\Order,
    Bitrix\Sale\Basket,
    Bitrix\Sale\DiscountCouponsManager,
    Bitrix\Sale\Delivery,
    Bitrix\Sale\PaySystem,
    Bitrix\Main\UserTable,
    A1expert\Cities;
#region a1SamuraiOrder
class A1SamuraiOrder extends \CBitrixComponent
{
    public function executeComponent()
    {
        Bitrix\Main\Loader::includeModule("sale");
        Bitrix\Main\Loader::includeModule("catalog");
        global $USER;
        $siteId = Context::getCurrent()->getSite();
        $basket = Basket::loadItemsForFUser(\Bitrix\Sale\Fuser::getId(), $siteId);
        $cities = new Cities();
        $this->arResult['cities'] = $cities->cities;
        $this->arResult['curCity'] = $cities->curCity;
        if($USER->IsAuthorized())
            $this->arResult['cuser'] = $USER->GetById($USER->GetId())->Fetch();
        else
            $this->arResult['cuser'] = $USER->GetById(1)->Fetch();
        //Блок с инфой которую можно подставить автоматически
        $order = Order::create($siteId, $this->arResult['cuser']['ID']);
        $order->setBasket($basket);
        // ShowRes($order->getAvailableFields());
        $this->arResult['basePrice'] = $basket->getBasePrice();
        $this->arResult['price'] = $basket->getPrice();
        $openTime = 1030;
        $closeTime = 2330;
        date_default_timezone_set('Asia/Yekaterinburg');
        $curTime = intval(date('Hi'));
        $this->arResult['open'] = ($curTime >= $openTime && $curTime <= $closeTime) ? true : false;
        if(!empty($_POST['addCoupon']))
        {
            $coupon = $_POST['promocode'];
            DiscountCouponsManager::init(DiscountCouponsManager::MODE_ORDER, ["userId" => $order->getUserId(), "orderId" => $order->getId()]);
            DiscountCouponsManager::add($coupon);
            $discounts = $basket->getDiscount();
            $discounts->calculate();
            $result = $basket->save();
        }        
        if (!empty($_POST['addOrder']))
        {
            $arProps = ['CITY', 'STREET', 'HOUSE', 'FLAT','FRONT_DOOR', 'DATE', 'FAST', 'PAYSUM'];
            foreach ($arProps as $key => $value)
                $this->arResult['props'][$value] = $_POST[$value];
            $currencyCode = CurrencyManager::getBaseCurrency();
            $order->setPersonTypeId(1);
            $order->setField('CURRENCY', $currencyCode);
            $order->setField('USER_DESCRIPTION', $_POST['COMMENT']);
            $order->doFinalAction(true);
            //Оплата
            $paymentCollection = $order->getPaymentCollection();
            $payment = $paymentCollection->createItem();
            $paySystemService = PaySystem\Manager::getObjectById((int)$_POST['paymentType']); //обычно 1 - это оплата наличными
            $payment->setFields(['PAY_SYSTEM_ID' => $paySystemService->getField("PAY_SYSTEM_ID"), 'PAY_SYSTEM_NAME' => $paySystemService->getField("NAME")]);
            // Свойcтва
            $propertyCollection = $order->getPropertyCollection();
            
            foreach ($propertyCollection->getGroups() as $group)
            {
                foreach ($propertyCollection->getGroupProperties($group['ID']) as $property)
                {
                    $p = $property->getProperty();
                    if (in_array($p['CODE'], $arProps))
                        $property->setValue($this->arResult['props'][$p['CODE']]);
                }
            }
            //Сохраняем
            $result = $order->save();
        }
        $this->includeComponentTemplate();
    }
}
#endregion a1SamuraiOrder