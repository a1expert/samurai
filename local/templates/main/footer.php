<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$curCity = $cities->curCity;?>
			</main>
			<footer class="footer">
				<div class="container">
					<div class="footer__inner">
						<div class="footer__top">
							<a href="/" class="footer__logo">
								<img src="/local/assets/images/logo_white.png" alt="сытый самурай" width="103" height="90" class="footer__logo-picture" />
							</a>
							<ul class="info footer__info">
								<li class="info__item info__item--address">
									<svg xmlns:xlink="http://www.w3.org/1999/xlink">
										<use xlink:href="/local/assets/images/icon.svg#icon_pin"></use>
									</svg><?=$curCity['props']['ADDRESS']['VALUE'];?>
								</li>
								<li class="info__item info__item--phone">
									<svg xmlns:xlink="http://www.w3.org/1999/xlink">
										<use xlink:href="/local/assets/images/icon.svg#icon_phone"></use>
									</svg><?=$curCity['props']['ABOUT_PHONE']['VALUE'];?>
								</li>
								<li class="info__item info__item--work-time">
									<svg xmlns:xlink="http://www.w3.org/1999/xlink">
										<use xlink:href="/local/assets/images/icon.svg#icon_timer"></use>
									</svg>Работаем с <?=$curCity['props']['WORK_TIME']['VALUE'];?>
								</li>
							</ul>
							<ul class="socials socials--footer">
								<li class="socials__item">
									<a href="<?=$curCity['props']['VK_LINK']['VALUE'];?>" class="socials__link socials__link--vk">
										<svg xmlns:xlink="http://www.w3.org/1999/xlink">
											<use xlink:href="/local/assets/images/icon.svg#icon_vk"></use>
										</svg>
									</a>
								</li>
								<li class="socials__item">
									<a href="<?=$curCity['props']['FB_LINK']['VALUE'];?>" class="socials__link socials__link--fb">
										<svg xmlns:xlink="http://www.w3.org/1999/xlink">
											<use xlink:href="/local/assets/images/icon.svg#icon_facebook"></use>
										</svg>
									</a>
								</li>
								<li class="socials__item">
									<a href="<?=$curCity['props']['INSTA_LINK']['VALUE'];?>" class="socials__link socials__link--inst">
										<svg xmlns:xlink="http://www.w3.org/1999/xlink">
											<use xlink:href="/local/assets/images/icon.svg#icon_instagram"></use>
										</svg>
									</a>
								</li>
								<li class="socials__item">
									<a href="<?=$curCity['props']['OK_LINK']['VALUE'];?>" class="socials__link socials__link--ok">
										<svg xmlns:xlink="http://www.w3.org/1999/xlink">
											<use xlink:href="/local/assets/images/icon.svg#icon_odnoklassniki"></use>
										</svg>
									</a>
								</li>
							</ul>
						</div>
						<div class="footer__bottom">
							<div class="footer__copyrights">&copy; 2011-<?=date('Y');?> ООО «СМАЙЛ»,</div>
							<div class="footer__requisites">ИНН 860238152024, ОГРН 318861700002247. </div>
							<div class="footer__policy"><a href="#">Политика конфиденциальности</a></div>
							<div class="footer__madeby">Разработка и продвижение:<a href="//a1-reklama.ru" target="_blank"><img src="/local/assets/images/logo_dev.png" alt="Логотип А1-Эксперт" width="114" height="42" /></a></div>
						</div>
					</div>
				</div>
				<template id="city">
					<h2 class="city-choose__title">Выберите город</h2>
					<?=$cities->MakeCitiesList();?>
				</template>
			</footer>
		</div>
		<div class="glob hide" title="title">
			<svg xmlns:xlink="http://www.w3.org/1999/xlink" class="glob__img">
				<use xlink:href="/local/assets/images/icon.svg#icon_cart"></use>
			</svg>
		</div>
		<div class="myPopup" style="display:none;" id="myPopup">
			<div class="popup__content">
				<div class="popup__closeBtn" onclick="this.parentNode.parentNode.style.display = 'none'">&#x2715;</div>
			</div>
		</div>
	</body>
</html>