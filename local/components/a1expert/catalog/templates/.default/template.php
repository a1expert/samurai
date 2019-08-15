<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
ShowRes($arResult);
?>
<div class="filters main__filters">
    <div class="container">
        <form class="filters__form filters__form--filtrating">
            <input class="filters__item visually-hidden jsFiltersBtn" type="checkbox" name="type" id="all" data-sectionid="all">
            <label class="filters__label" id="labelAll" for="all">Все</label>
            <?$fid = 0;
            foreach ($arResult['filters'] as $filter)
            {?>
                <input class="filters__item visually-hidden jsFiltersBtn" type="checkbox" name="type" id="filter<?=$fid?>" data-sectionid="<?=$filter?>">
                <label class="filters__label jsFiltersLabel" for="filter<?=$fid++?>" data-sectionid="<?=$filter?>"><?=$filter?></label>
                <?
            }?>
        </form>
        <form class="filters__form filters__form--sorting">
            <p class="filters__subtitile">Сортировать</p>
            <button class="filters__toggler" type="button">По популярности</button>
            <button class="filters__toggler filters__toggler--active" type="button">По цене</button>
            <button class="filters__toggler" type="button">По составляющим</button>
        </form>
    </div>
</div>

<section class="section main__section cards-grid">
    <div class="container">
        <h2 class="visually-hidden">Список товаров</h2>
        <ul class="cards-grid__list">
            <?foreach ($arResult['ITEMS'] as $key => $arItem)
            {
                $itemFilter = implode(',', $arItem['PROPERTIES']['FILTER']['VALUE']);?>
            <li class="cards-grid__item jsCatalogItem" data-sectionsid="<?=$itemFilter;?>">
                <article class="card">
                    <a href="#popup" class="card__toggle">
                        <div class="card__picture-wrapper">
                            <img src="<?=$arItem['PREVIEW_PICTURE'];?>" alt="<?=$arItem['NAME'];?>" class="card__picture" width="330" height="234">
                        </div>
                    </a>
                    <div class="card__body">
                        <a href="#popup" class="card__toggle">
                            <h3 class="card__title"><?=$arItem['NAME'];?></h3>
                        </a>
                        <ul class="card__chars">
                            <li class="card__chars-item card__chars-item--main card__chars-item--weight"><?=$arItem['DISPLAY_PROPERTIES']['WEIGHT']['DISPLAY_VALUE'];?> грамм</li>
                            <?if(!empty($arItem['DISPLAY_PROPERTIES']['ROLLS_COUNT']['DISPLAY_VALUE']) && $arResult['SECTION']['PATH'][0]['ID'] == 1)
                            {?>
                                <li class="card__chars-item card__chars-item--main card__chars-item--quantity"><?=$arItem['DISPLAY_PROPERTIES']['ROLLS_COUNT']['DISPLAY_VALUE']?> штук</li>
                                <?
                            }?>
                            <li class="card__chars-item card__chars-item--extra card__chars-item--proteins"><?=$arItem['DISPLAY_PROPERTIES']['PROTEINS']['DISPLAY_VLAUE'];?> <span>белков</span></li>
                            <li class="card__chars-item card__chars-item--extra card__chars-item--fat"><?=$arItem['DISPLAY_PROPERTIES']['FATS']['DISPLAY_VALUE'];?> <span>жиров</span></li>
                            <li class="card__chars-item card__chars-item--extra card__chars-item--carb"><?=$arItem['DISPLAY_PROPERTIES']['CARBOHYDRATES']['DISPLAY_VALUE'];?> <span>углеводов</span></li>
                            <li class="card__chars-item card__chars-item--extra card__chars-item--calories"><?=$arItem['DISPLAY_PROPERTIES']['CALORIES']['DISPLAY_VALUE'];?> <span>калорий</span></li>
                        </ul>
                        <?if(!empty($arItem['DIPLAY_PROPERTIES']['COMPOSITION']['DISPLAY_VALUE']))
                        {?>}
                        <p class="card__ingredients">
                            <strong><?=$arItem['DIPLAY_PROPERTIES']['COMPOSITION']['DISPLAY_VALUE'];?></strong>
                        </p>
                        <?
                        }?>
                    </div>
                    <div class="card__footer">
                        <p class="card__price"><?=round($arItem['CATALOG_PRICE_1']);?> <span class="currency">₽</span>
                        </p>
                        <a href="#" class="card__add-to-cart">Беру!</a>
                    </div>
                </article>
            </li>
            <?
            }?>
        </ul>
    </div>
</section>
<?if(!empty($arResult['SECTION']['PATH'][0]['~DESCRIPTION']))
{?>
    <section class="section content">
        <div class="container">
            <div class="section__layout content__layout">
                <?=$arResult['SECTION']['PATH'][0]['~DESCRIPTION'];?>
            </div>
        </div>
    </section>
<?
}?>