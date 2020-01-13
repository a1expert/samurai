<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет");
global $USER;
use Bitrix\Main\Context,
    Bitrix\Main\Loader;
// if($USER->IsAuthorized() == false)
// header('Location://'. $_SERVER['HTTP_HOST'] . '/'); ?>
<div class="container">
	<div class="tabs">
		<div class="tabs__mobile-controls">
			<div class="tabs__mobile-controls-inner">
				<svg xmlns:xlink="http://www.w3.org/1999/xlink">
					<use xlink:href="/local/assets/images/icon.svg#icon_cursor"></use>
				</svg>
				<select class="tabs__mobile-controls-toggler">
					<option value="tab-1" data-icon="/local/assets/images/icon.svg#icon_cursor" selected>Личные данные</option>
					<option value="tab-2" data-icon="/local/assets/images/icon.svg#icon_marketing"> Исторя заказов</option>
					<option value="tab-3" data-icon="/local/assets/images/icon.svg#icon_email">Рассылки</option>
				</select>
			</div>
		</div>
		<div class="tabs__controls">
			<button data-tab="tab-1" class="tabs__button tabs__button--active">
				<svg xmlns:xlink="http://www.w3.org/1999/xlink">
					<use xlink:href="/local/assets/images/icon.svg#icon_cursor"></use>
				</svg>Личные данные
			</button>
			<button data-tab="tab-2" class="tabs__button">
				<svg xmlns:xlink="http://www.w3.org/1999/xlink">
					<use xlink:href="/local/assets/images/icon.svg#icon_marketing"></use>
				</svg>История заказов</button>
			<button data-tab="tab-3" class="tabs__button">
				<svg xmlns:xlink="http://www.w3.org/1999/xlink">
					<use xlink:href="/local/assets/images/icon.svg#icon_email"></use>
				</svg>Рассылки
			</button>
		</div>
		<div class="tabs__content">
			<div id="tab-1" class="js-tab js-tab--active">
				<?$APPLICATION->IncludeComponent("a1expert:profile", "", [
					"CHECK_RIGHTS" => "N",
					"SEND_INFO" => "N",
					"SET_TITLE" => "N",
					"USER_PROPERTY" => array("UF_BONUSES"),
					"USER_PROPERTY_NAME" => ""
				]);?>
				<section class="section orders">
					<h2 class="visually-hidden">Секция с информацией о заказах</h2>
					<?$APPLICATION->IncludeComponent("a1expert:orders.history", "tab1", []);?>
				</section>
			</div>
			<div id="tab-2" class="js-tab">
				<?$APPLICATION->IncludeComponent("a1expert:orders.history", "tab2", []);?>
			</div>
			<div id="tab-3" class="js-tab">
				<section class="section subscriptions">
					<h2 class="visually-hidden">Выбор рассылок</h2>
					<p class="intro-text subscriptions__intro">Сервис в разработке</p>
					<!-- <form>
						<div class="subscriptions__inner">
							<ul class="subscriptions__list">
								<li class="subscriptions__item">
									<h3 class="subscriptions__subtitle">Получать по Email</h3>
								</li>
								<li class="subscriptions__item">
									<div class="checkbox">
										<input type="checkbox" name="11" id="1" class="visually-hidden">
										<label for="1" class="checkbox__label">Новвинки и акции</label>
									</div>
								</li>
								<li class="subscriptions__item">
									<div class="checkbox">
										<input type="checkbox" name="11" id="2" class="visually-hidden">
										<label for="2" class="checkbox__label">Товар дня (ежедневно)</label>
									</div>
								</li>
								<li class="subscriptions__item">
									<div class="checkbox">
										<input type="checkbox" name="11" id="3" class="visually-hidden">
										<label for="3" class="checkbox__label">Акции, скидки, персональные предложения</label>
									</div>
								</li>
								<li class="subscriptions__item">
									<div class="checkbox">
										<input type="checkbox" name="11" id="4" class="visually-hidden">
										<label for="4" class="checkbox__label">Новинки, акции</label>
									</div>
								</li>
							</ul>
							<ul class="subscriptions__list">
								<li class="subscriptions__item">
									<h3 class="subscriptions__subtitle">Получать по SMS</h3>
								</li>
								<li class="subscriptions__item">
									<div class="checkbox">
										<input type="checkbox" name="22" id="5" class="visually-hidden">
										<label for="5" class="checkbox__label">Акции, скидки, персональные предложения</label>
									</div>
								</li>
								<li class="subscriptions__item">
									<div class="checkbox">
										<input type="checkbox" name="22" id="6" class="visually-hidden">
										<label for="6" class="checkbox__label">Новинки, акции</label>
									</div>
								</li>
								<li class="subscriptions__item">
									<div class="checkbox">
										<input type="checkbox" name="22" id="7" class="visually-hidden">
										<label for="7" class="checkbox__label">Товар дня (ежедневно)</label>
									</div>
								</li>
								<li class="subscriptions__item">
									<div class="checkbox">
										<input type="checkbox" name="22" id="8" class="visually-hidden">
										<label for="8" class="checkbox__label">Новвинки и акции</label>
									</div>
								</li>
							</ul>
						</div>
						<button class="button">Сохранить изменения</button>
					</form> -->
				</section>
			</div>
		</div>
	</div>
</div>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>