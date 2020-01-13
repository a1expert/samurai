<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !==true)die();
$order = current($arResult);
if($order['STATUS'] == 'N')
    $status = 'выполняется';
elseif ($order['STATUS'] == 'F')
    $status = 'выполнен';
?>
<section class="orders__block">
    <h3 class="section__title orders__title">Текущий заказ <span class="orders__status orders__status--active">статус: <?=$status?></span></h3>
    <ul class="orders__list">
    <?foreach ($order['ITEMS'] as $key => $item)
    {?>
        <li class="orders__item">
            <article class="order">
                <img src="<?=$item['img'];?>" alt="order-img" class="order__picture">
                <div class="order__info">
                    <h4 class="order__title"><?=$item['NAME']?></h4>
                    <p class="order__description"></p>
                </div>
                <p class="order__price"><strong><?=round($item['PRICE']);?> ₽</strong></p>
            </article>
        </li>
        <?
    }?>
    </ul>
</section>