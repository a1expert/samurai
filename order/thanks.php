<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заказ оформлен");
?>
<main>
	<section class="thanks">
			<div class="container">
				<div class="section__layout">
					<h2 class="thanks__title">Спасибо! ваш заказ принят.</h2>
					<div class="thanks__order-data">
						<p class="thanks__text">
							Если в течении 20 минут оператор не смог до вас дозвониться, позвоните, пожалуйста <br>по номеру <span class="thanks__important thanks__phone">+7 (3462) 254-15-77</span> самостоятельно.</p>
						<p class="thanks__text">Номер вашего заказа: <span class="thanks__important thanks__order-number">23553</span></p>
						<p class="thanks__text">Начислено бонусов: <span class="thanks__important thanks__bonuses">178</span></p>
						<p class="thanks__text">Статус вашего заказа вы всегда можете посмотреть в личном кабинете. Регистрационные данные высланы были высланы вам на почтовый ящик.</p>
					</div>
			</div>
		</div>
	</section>
</main>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>