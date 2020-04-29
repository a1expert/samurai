<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Условия доставки");
?>
<section class="section main__section delivery-advantages">
    <h2 class="visually-hidden">Наши преимущества доставки</h2>
    <div class="container delivery-advantages__container">
        <div class="section__layout delivery-advantages__layout">
            <ul class="delivery-advantages__info-list">
                <li class="delivery-advantages__info-item delivery-advantages__info-item--free">
                    <div>
                        <h4 class="delivery-advantages__title">Доставляем бесплатно</h4>
                        <p class="delivery-advantages__text">
                            Любой заказ мы доставим бесплатно. Вы оплачиваете только любимые блюда.
                            Минимальная сумма заказа 500 рублей.
                        </p>
                    </div>
                </li>
                <li class="delivery-advantages__info-item delivery-advantages__info-item--fast">
                    <div>
                        <h4 class="delivery-advantages__title">Быстрая доставка от 40 минут*</h4>
                        <p class="delivery-advantages__text">
                            У нас одна из самых быстрых доставок. Если Вы оформили заказ на сайте или
                            в мобильном приложении - Вы будете точно знать время получения заказа.
                        </p>
                    </div>
                </li>
                <li class="delivery-advantages__info-item delivery-advantages__info-item--time">
                    <div>
                        <h4 class="delivery-advantages__title">График работы</h4>
                        <p class="delivery-advantages__text">Принимаем и доставляем заказы с 10:30 до 23:30<sup>*</sup></p>
                    </div>
                </li>
            </ul>
            <div class="delivery-advantages__note">
                <p>
                    <sup>*</sup>
                    В некоторых районах могут быть ограничения по времени доставки. Точное время доставки
                    вы можете уточнить у оператора как при оформлении заказа, так и заранее.
                </p>
            </div>
        </div>
    </div>
</section>
<section class="section main__section payment-info">
    <div class="container">
        <h2 class="section__title">Способы оплаты</h2>
        <ul class="payment-info__list">
            <li class="payment-info__item payment-info__item--card">
                <h3 class="payment-info__title">Банковской картой</h3>
                <p class="payment-info__text">Оплата производится через терминал курьеру при доставке заказа</p>
            </li>
            <li class="payment-info__item payment-info__item--online">
                <h3 class="payment-info__title">Через сайт</h3>
                <p class="payment-info__text">Оплата производится через терминал курьеру при доставке заказа</p>
            </li>
            <li class="payment-info__item payment-info__item--cash">
                <h3 class="payment-info__title">Наличными курьеру</h3>
                <p class="payment-info__text">Оплата производится через терминал курьеру при доставке заказа</p>
            </li>
        </ul>

    </div>
</section>
<section class="section main__section delivery-price">
    <div class="container">
        <div class="section__layout delivery-price__layout">
            <p class="delivery-price__alert">
                Доставка по городу <span class="delivery-price__important">бесплатная</span> при заказе от 500 руб
            </p>
            <div class="delivery-price__column">
            		<h3 class="delivery-price__item delivery-price__item--title">150 рублей</h3>
                <ul class="delivery-price__list">
                    <li class="delivery-price__item">Нефтеюганское шоссе</li>
                    <li class="delivery-price__item">Югорский тракт</li>
                    <li class="delivery-price__item">поселок Кедровый</li>
                    <li class="delivery-price__item">поселок Юности</li>
                    <li class="delivery-price__item">поселок Финский</li>
                    <li class="delivery-price__item">поселок Лунный</li>
                    <li class="delivery-price__item">поселок Звездный</li>
                    <li class="delivery-price__item">Ж/д</li>
                    <li class="delivery-price__item">ГРЭС</li>
                    <li class="delivery-price__item">8-й промузел</li>
                </ul>
            </div>
            <div class="delivery-price__column">
            		<h3 class="delivery-price__item delivery-price__item--title">150 рублей</h3>
                <ul class="delivery-price__list">
                    <li class="delivery-price__item">поселок Таежный</li>
                    <li class="delivery-price__item">Аэропорт</li>
                    <li class="delivery-price__item">поселок Снежный</li>
                    <li class="delivery-price__item">поселок Дорожный</li>
                    <li class="delivery-price__item">поселок Белый Яр</li>
                </ul>
            </div>
            <div class="delivery-price__column">
            		<h3 class="delivery-price__item delivery-price__item--title">150 рублей</h3>
                <ul class="delivery-price__list">
                    <li class="delivery-price__item">поселок Солнечный;</li>
                    <li class="delivery-price__item">поселок Барсово;</li>
                </ul>
            </div>    
            <div class="delivery-price__column">    
                <h3 class="delivery-price__item delivery-price__item--title">150 рублей</h3>
                <ul class="delivery-price__list">
                    <li class="delivery-price__item">Дачные кооперативы</li>
                </ul>
            </div>
        </div>
    </div>
</section>
<section class="section main__section map">
    <div class="container">
        <h2 class="section__title">
            Территория обслуживания
        </h2>
    </div>
</section>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>