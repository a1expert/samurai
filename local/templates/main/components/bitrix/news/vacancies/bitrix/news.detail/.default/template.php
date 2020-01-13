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
// ShowRes($arResult);
?>
<section class="vacancyDetail main">
	<div class="main__wrapper">
		<div class="main__container container">
			<a class="main__back-link" href="/vacancies/">Назад к списку вакансий</a>
			<h1 class="vacancy__header"><?=$arResult['NAME'];?></h1>
			<p class="vacancy__text">
				<strong class="vacancy__strong">Общие требования к соискателям:</strong> <?=$arResult['IBLOCK']['DESCRIPTION'];?>
			</p>
			<p></p>
			<h2 class="vacancy__subtitle">Требования</h2>
			<ul class="vacancy__list">
			<?foreach ($arResult['DISPLAY_PROPERTIES']['MUST_HAVE']['VALUE'] as $key => $value)
			{?>
				<li class="vacancy__item"><?=$value;?></li>
				<?
			}?>
			
			</ul>
			<h2 class="vacancy__subtitle">Обязанности</h2>
			<ul class="vacancy__list">
			<?foreach ($arResult['DISPLAY_PROPERTIES']['MUST_DO']['VALUE'] as $key => $value)
			{?>
				<li class="vacancy__item"><?=$value;?></li>
				<?
			}?>
			</ul>
			<h2 class="vacancy__subtitle">Условия</h2>
			<ul class="vacancy__list">
				<?foreach ($arResult['DISPLAY_PROPERTIES']['CONDITIONS']['VALUE'] as $key => $value)
			{?>
				<li class="vacancy__item"><?=$value;?></li>
				<?
			}?>
			</ul>
			<h2 class="vacancy__subtitle">Как к нам попасть?</h2>
			<div class="vacancy__contacts">
				<div class="vacancy__contacts-text">
					<p class="vacancy__text vacancy__text--small">
						<b class="vacancy__strong">Внимание: без резюме кандидаты не рассматриваются!</b>
					</p>
					<p class="vacancy__text vacancy__text--last"><?$APPLICATION->IncludeFile('/local/inc_areas/vacancies/bottomText.php', array(), array('MODE' => 'text', 'NAME'=>''));?></p>
				</div>
				<div class="vacancy__contacts-mail">
					<div class="vacancy__avatar  avatar" style="background-image: url('/local/assets/images/email-2.png');"></div>
					<div class="vacancy__contacts-mail-inner">
						<p class="vacancy__contacts-mail-text">Почтовый ящик для резюме:</p>
						<a class="vacancy__email-address" href="#"><?$APPLICATION->IncludeFile('/local/inc_areas/vacancies/email.php', array(), array('MODE' => 'text', 'NAME'=>''));?></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>