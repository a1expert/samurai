<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Контакты");

?>
<script 
        src="https://api-maps.yandex.ru/2.1/?apikey=f97f3f38-06e5-48cf-bdef-00aaeb283bd4&lang=ru_RU" type="text/javascript">  
    </script>
    <script>
        ymaps.ready(init);
        function init() {
            var myMap = new ymaps.Map("map", {
                center: [61.24244775, 73.4440395],
                controls: ['zoomControl'],
                zoom: 16
            });
            myMap.geoObjects.add(new ymaps.Placemark([61.24244775, 73.4440395], {
                balloonContent: 'Сытый самурай'
            }, {
                preset: 'islands#icon',
                iconColor: '#309515'
            }))
            myMap.behaviors.disable('scrollZoom');
        }
    </script>    
<section class="contacts">
    <div class="container">
        <div class="section__layout contacts__layout">
        <div class="contacts__inner">
            <div class="contacts__col contacts__col--address">
                <div class="address">
                    <small class="notice">Адрес:</small>
                    <p class="address__text">Пролетарский, 10/3 просп, Сургут, Ханты-Мансийский автономный округ, Россия</p>
                </div>
            </div>
            <div class="contacts__col contacts__col--phones">
                <div class="phones">
                    <small class="notice">Каналы связи:</small>
                    <div class="phones__block">
                        <div class="phones__row">
                            <p class="phones__text phones__text_phone">+7 (3462) 46-99-46</p>
                            <p class="phones__text phones__text_subscriber"><span class="phones__divider"> - </span>Прием заказов</p>
                        </div>
                        <div class="phones__row">
                            <p class="phones__text phones__text_phone">+7 (3462) 46-99-00</p>
                            <p class="phones__text phones__text_subscriber"><span class="phones__divider"> - </span>Прием заказов</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="contacts__col contacts__col--timeline">
                <div class="timeline">
                    <small class="notice">Время работы:</small>
                    <div class="timeline__area">
                    <ul class="timeline__list timeline__list_open">
                        <li class="timeline__item">Пн</li>
                        <li class="timeline__item">Вт</li>
                        <li class="timeline__item">Ср</li>
                        <li class="timeline__item">Чт</li>
                        <li class="timeline__item">Пт</li>
                        <li class="timeline__item">Сб</li>
                        <li class="timeline__item">Вс</li>
                    </ul>
                    <p class="timeline__work-time">10:30&nbsp;-&nbsp;23:30</p>
                    </div>
                </div>
            </div>
            <div class="contacts__col contacts__col--requisites">
                <div class="requisites">
                    <small class="notice">Реквизиты компании:</small>
                    <a href="#" class="requisites__link" download="Реквизиты А1 - Интернет Эксперт">Скачать реквизиты, <br>16.5 КБ 
                        <span class="iconBlock iconBlock_rounded requisites__icon">
                            <svg xmlns:xlink="http://www.w3.org/1999/xlink">
                                <use xlink:href="/local/assets/images/icon.svg#icon_download"></use>
                            </svg>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div id="map" style=" height: 400px;"></div>
</section>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>