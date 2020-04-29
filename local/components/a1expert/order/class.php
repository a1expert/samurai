<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();
use Bitrix\Main\Context,
    Bitrix\Main\Loader,
    Bitrix\Main\CUser,
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
    public $errors = '';
    
    private function RegisterUser ($fields)
    {
        global $USER;
        if(!empty($fields['NAME']) && preg_match('/[а-я\s\-]*/ui',$fields['NAME']) == false)
            $this->errors = "Имя ";
        if(preg_match('/^(?:[\(\)\-\+\s]*+\d){11}[\(\)\-\+\s]*+$/ui', $fields['PHONE']) == false)
            $this->errors = "$this->errors Телефон ";
        if(!empty($this->errors))
        {
            $this->errors = "Неверно заполнены поля: $this->errors";
            return false;
        }
        $pass = (string)time();
        $arFields = [
            "NAME" => $fields['NAME'],
            "EMAIL" => $fields['EMAIL'],
            "LOGIN" => $fields['EMAIL'],
            'PERSONAL_PHONE' => $fields['PHONE'],
            "GROUP_ID" => [3],
        ];
        $res = $USER->Register($fields['EMAIL'], $fields['NAME'], '', $pass, $pass, $fields['EMAIL']);
        if($res['TYPE'] == 'ERROR')
            $this->errors = $res['MESSAGE'];
        if($res['TYPE'] == 'OK')
        {
            $USER->Update($res['ID'], $arFields);
            $this->arResult['newUser'] = 1;
        }
        return $res;
    }
    public function executeComponent()
    {
        Bitrix\Main\Loader::includeModule("sale");
        Bitrix\Main\Loader::includeModule("catalog");
        global $USER;
        global $USER_FIELD_MANAGER;
        $siteId = Context::getCurrent()->getSite();
        $basket = Basket::loadItemsForFUser(\Bitrix\Sale\Fuser::getId(), $siteId);
        $cities = new Cities();
        $this->arResult['cities'] = $cities->cities;
        $this->arResult['curCity'] = $cities->curCity;
        $this->arResult['errors'] = [];
        //Блок с инфой которую можно подставить автоматически
        if($USER->IsAuthorized())
        {
            $this->arResult['cuser'] = $USER->GetById($USER->GetId())->Fetch();
            $userId = $this->arResult['cuser']['ID'];
        }
        else
        {
            $userId = 1;
            if($_POST['addOrder'] == 'order')
            {
                $regResult = $this->RegisterUser($_POST);
                $this->arResult['errors'] = $this->errors;
                if($regResult['ID'] > 0)$userId = $regResult['ID'];
            }
            if($_POST['addOrder'] == 'fast order')
            {
                if(preg_match('/^(?:[\(\)\-\+\s]*+\d){11}[\(\)\-\+\s]*+$/ui', $_POST['PHONE']) == false)
                    $this->arResult['errors'] = $this->errors = "Неверно заполнен телефон";
            }
        }
        $order = Order::create($siteId, $userId);
        $order->setBasket($basket);
        $this->arResult['basePrice'] = $basket->getBasePrice();
        $this->arResult['price'] = $basket->getPrice();
        $openTime = 1030;
        $closeTime = 2330;
        date_default_timezone_set('Asia/Yekaterinburg');
        $curTime = intval(date('Hi'));
        $this->arResult['open'] = ($curTime >= $openTime && $curTime <= $closeTime) ? true : false;
        if($userId == 1)
            $this->arResult['addBonuses'] = 0;
        else
        {
            $orderList = Bitrix\Sale\Order::getList(['filter' => ['USER_ID'=>$userId], 'order'=>['ID'=>'DESC']]);
            while($rsOrder = $orderList->fetch())
                $orders[] = $rsOrder;
            foreach ($orders as $key => $arOrder)
            {
                if($key == 0)
                    continue;
                else
                    $allOrderPrice += $arOrder['PRICE'];
            }
            $multiply = ($allOrderPrice > 10000) ? 10 : 5;
            $this->arResult['addBonuses'] = round($this->arResult['basePrice'] / 100 * $multiply);
        }

        if(!empty($_POST['addCoupon']))
        {
            $coupon = $_POST['promocode'];
            DiscountCouponsManager::init(DiscountCouponsManager::MODE_ORDER, ["userId" => $order->getUserId(), "orderId" => $order->getId()]);
            DiscountCouponsManager::add($coupon);
            $discounts = $basket->getDiscount();
            $discounts->calculate();
            $result = $basket->save();
        }        
        if (!empty($_POST['addOrder']) && empty($this->$errors))
        {
            $arProps = ['CITY', 'STREET', 'HOUSE', 'FLAT','FRONT_DOOR', 'DATE', 'FAST', 'PAYSUM'];
            foreach ($arProps as $value)
                $this->arResult['props'][$value] = $_POST[$value];
            $currencyCode = CurrencyManager::getBaseCurrency();
            $order->setPersonTypeId(1);
            $order->setField('CURRENCY', $currencyCode);
            $order->setField('USER_DESCRIPTION', $_POST['COMMENT']);
            $order->doFinalAction(true);
            //Оплата
            if($_POST['addOrder'] == 'order')
            {
                $paymentCollection = $order->getPaymentCollection();
                $payment = $paymentCollection->createItem();
                $paySystemService = PaySystem\Manager::getObjectById((int)$_POST['paymentType']); //обычно 1 - это оплата наличными
                $payment->setFields(['PAY_SYSTEM_ID' => $paySystemService->getField("PAY_SYSTEM_ID"), 'PAY_SYSTEM_NAME' => $paySystemService->getField("NAME")]);
            }
            if($USER->IsAuthorized() && isset($_POST['bonuses'])) {
                $bonuses = $USER_FIELD_MANAGER->GetUserFields('USER', $USER->GetID(), LANGUAGE_ID)['UF_BONUSES']['VALUE'] ?: 0;
                if (isset($_POST['bonuses'])) {
                    $action_bonuses = intval(trim($_POST['bonuses']));
                    if (($action_bonuses < 0) || ($action_bonuses > $bonuses) || ($action_bonuses > $basket->getPrice()))
                       throw new Exception("Error Bonuses", 1);
                    else
                    {
                        $USER->Update($USER->GetID(), array('UF_BONUSES' => $bonuses - $action_bonuses));
                        $order->setFieldNoDemand('PRICE', $order->getPrice() - $action_bonuses);
                        //$order->setFieldNoDemand('SUM_PAID', $action_bonuses);
                    }
                }
            }

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
            ShowRes($result);
        }
        $this->includeComponentTemplate();
    }
}
#endregion a1SamuraiOrder