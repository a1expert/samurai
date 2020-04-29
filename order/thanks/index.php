<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заказ оформлен");
use Bitrix\Main\Context,
    Bitrix\Main\Loader,
	Bitrix\Sale\Order;
Bitrix\Main\Loader::includeModule("sale");
global $USER;
$userId = $USER->GetId();
if($_GET['fast_order'] == 'true')
	$userId = 1;
if($_GET['new_user'] == 'true')
	$newUser = true;
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
$bonuses = round($orders[0]['PRICE'] / 100 * $multiply);
?>
<main>
	<section class="thanks">
		<div class="container">
			<div class="section__layout">
				<h2 class="thanks__title">Спасибо! ваш заказ принят.</h2>
				<div class="thanks__order-data">
					<p class="thanks__text">
						Если в течении 20 минут оператор не смог до вас дозвониться, позвоните, пожалуйста <br>по номеру <span class="thanks__important thanks__phone">+7 (3462) 254-15-77</span> самостоятельно.</p>
					<p class="thanks__text">Номер вашего заказа: <span class="thanks__important thanks__order-number"><?=$orders[0]['ID'];?></span></p>
					<?if($userId > 1)
					{?>
						<p class="thanks__text">Начислено бонусов: <span class="thanks__important thanks__bonuses"><?=$bonuses?></span></p>
						<p class="thanks__text">Статус вашего заказа вы всегда можете посмотреть в личном кабинете. <?=($newUser) ? 'Регистрационные данные были высланы вам на почтовый ящик. Настоятельно рекомендуем сменить пароль!':'';?></p>
						<?
					}?>
				</div>
			</div>
		</div>
	</section>
</main>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>