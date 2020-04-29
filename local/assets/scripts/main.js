"use strict";
document.addEventListener('DOMContentLoaded', () =>
{
	//tabs
	const tabsBtns = document.querySelectorAll('.jsTabBtn');

	if (tabsBtns.length > 0)
	{
		const tabsMobInner = document.querySelector('.tabs__mobile-controls-inner');
		const tabsMobToggler = document.querySelector('.tabs__mobile-controls-toggler');
		const tabs = document.querySelectorAll('.jsOrderTab');
		const ChangeIcon = icon =>
		{
			const use = tabsMobInner.querySelector('use');
			use.setAttributeNS('http://www.w3.org/1999/xlink', 'xlink:href', `${icon}`)
		}
		const SetActiveSelectOption = prop =>
		{
			const optionToSelect = [...tabsMobToggler.options].find(option=>
			{
				return option.value === prop;
			});
			optionToSelect.selected = true;
			ChangeIcon(optionToSelect.dataset.icon);
		}
		const SetActiveBtn = btn =>
		{
			tabsBtns.forEach(it =>
			{
				it.classList.remove('tabs__button--active');
			});
			btn.classList.add('tabs__button--active');
		}
		const SetActiveTab = pointer =>
		{
			tabs.forEach(tab =>
			{
				tab.classList.remove('tabActive');
			});
			document.querySelector(`#${pointer}`).classList.add('tabActive');
		}
		const onTabBtnClick = evt =>
		{
			SetActiveBtn(evt.target);
			SetActiveTab(evt.target.dataset.tab);
			SetActiveSelectOption(evt.target.dataset.tab);
		}
		const OnTabsMobTogglerChange = evt =>
		{
			SetActiveBtn(document.querySelector(`[data-tab=${evt.target.value}]`));
			SetActiveTab(evt.target.value);
			const iconPath =  evt.target.options[evt.target.selectedIndex].dataset.icon;
			ChangeIcon(iconPath);
		};

		tabsBtns.forEach(btn =>btn.addEventListener('click', onTabBtnClick));
		tabsMobToggler.addEventListener('change', OnTabsMobTogglerChange);
	}

	const initMainCarousels = el =>
	{
		el.owlCarousel(
		{
			loop: true,
			margin: 30,
			nav: true,
			navText: ['<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 284 284"><path d="M282.082 195.285L149.028 62.24c-1.901-1.903-4.088-2.856-6.562-2.856s-4.665.953-6.567 2.856L2.856 195.285C.95 197.191 0 199.378 0 201.853c0 2.474.953 4.664 2.856 6.566l14.272 14.271c1.903 1.903 4.093 2.854 6.567 2.854s4.664-.951 6.567-2.854l112.204-112.202 112.208 112.209c1.902 1.903 4.093 2.848 6.563 2.848 2.478 0 4.668-.951 6.57-2.848l14.274-14.277c1.902-1.902 2.847-4.093 2.847-6.566.001-2.476-.944-4.666-2.846-6.569z"/></svg>', '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 284 284"><path d="M282.082 195.285L149.028 62.24c-1.901-1.903-4.088-2.856-6.562-2.856s-4.665.953-6.567 2.856L2.856 195.285C.95 197.191 0 199.378 0 201.853c0 2.474.953 4.664 2.856 6.566l14.272 14.271c1.903 1.903 4.093 2.854 6.567 2.854s4.664-.951 6.567-2.854l112.204-112.202 112.208 112.209c1.902 1.903 4.093 2.848 6.563 2.848 2.478 0 4.668-.951 6.57-2.848l14.274-14.277c1.902-1.902 2.847-4.093 2.847-6.566.001-2.476-.944-4.666-2.846-6.569z"/></svg>'],
			responsive:
			{
				0: {
					items: 1
				},
				600: {
					items: 2
				},
				1000: {
					items: 3
				},
				1366: {
					items: 4
				}
			}
		});
	}
	initMainCarousels($(".main-items"));

	//popup
	const removeElement = (element) =>element.remove();
	const documentOnKeyDown = (evt, layout) =>
	{
		if (evt.key === "Escape" || evt.key === "Esc")
			removeElement(layout);
	}
	const onLayoutClick = (evt, layout)=>
	{
		if(!evt.target.closest('.popup'))
			removeElement(layout);
	}
	const onCloseClick = (layout)=>removeElement(layout);
	const bindPopupListenters = (layout, close)=>
	{
		layout.addEventListener('click', evt=>onLayoutClick(evt, layout));
		close.addEventListener('click', ()=>onCloseClick(layout));
		document.addEventListener('keydown', evt=>documentOnKeyDown(evt, layout));
	}
	const createPopup = (evt = false) =>
	{
		const layout = document.createElement('div');
		const popup = document.createElement('div');
		const close = document.createElement('button');

		layout.classList.add('popup-layout');
		popup.classList.add('popup');
		close.classList.add('popup__close');

		popup.appendChild(close);
		layout.appendChild(popup);
		document.body.appendChild(layout);

		bindPopupListenters(layout, close);
		if(evt != false)
			createFullStock(evt.target);
	}
	// fetch
	const getdata = url => fetch(url).then(response => response.json());
	// stocks
	const stocks = document.querySelectorAll('.stock');

	const createFullStock = data =>
	{
		fetch(data.dataset.url, {method: 'POST'})
		.then(response =>
		{
			if(response.status == 200)
				return response.text();
		})
		.then(text=>
		{
			const n1 = '#anchor#';
			const n2 = '#endanchor#'
			let start = text.search(n1) + n1.length;
			let end = text.search(n2) - text.search(n1) - n1.length;
			const stock = text.substr(start, end);
			console.log(stock);
			document.querySelector('.popup').insertAdjacentHTML('beforeend', stock);
		});
	};

	const onStockClick = evt =>
	{
		createPopup(evt);
	};
	if (stocks)
	{
		[...stocks].forEach((stock)=>stock.addEventListener('click', onStockClick));
	}

	//#region submenu
	// let subMenuList = document.querySelector('.submenu__list');
	// let menuItemsNodeList = document.querySelectorAll('.submenu__item');
	// let menuItems = [...menuItemsNodeList];
	// let subMenuResponsiveList = document.querySelector('.submenu__responsive-list');
	// let subMenuToggler = document.querySelector('.submenu__toggler');
	// let menuWidth = 0; let copyItem;
	//
	// let GetWidth = () =>
	// {
	// 	menuWidth = subMenuList.clientWidth;
	// 	let itemsWidth = 0;
	// 	menuItems.forEach(item=>{itemsWidth += item.clientWidth});
	// 	return itemsWidth > menuWidth;
	// }
	// let ChangeMenu = () =>
	// {
	// 	if(GetWidth())
	// 	{
	// 		if(copyItem)
	// 		{
	// 			let prevItem = copyItem;
	// 			copyItem = menuItems.pop();
	// 			subMenuResponsiveList.insertBefore(copyItem, prevItem);
	// 			return ChangeMenu();
	// 		}
	// 		else
	// 		{
	// 			copyItem = menuItems.pop();
	// 			subMenuResponsiveList.appendChild(copyItem);
	// 			return ChangeMenu();
	// 		}
	// 	}
	// }
	//
	// if(subMenuList)
	// {
	// 	ChangeMenu();
	// 	subMenuToggler.addEventListener('click',()=>subMenuResponsiveList.classList.toggle('hide'));
	// 	window.addEventListener('resize', ChangeMenu);
	// }
	const headerInner = document.querySelector(`.submenu__inner`);

	const headerMenu = document.querySelector(`.submenu`);
	const headerMenuList = headerMenu.querySelector(`.submenu__list`);
	const headerMenuItems = headerMenu.querySelectorAll(`.submenu__item`);

	const hiddenMenu = document.querySelector(`.hidden-menu`);
	const hiddenMenuList = hiddenMenu.querySelector(`.hidden-menu__list`);
	const hiddenMenuToggler = hiddenMenu.querySelector(`.hidden-menu__toggler`);
	const menuItemsData = [...headerMenuItems].map((item) => {
		return {
			item,
			width: item.offsetWidth
		}
	});
	const hiddenMenuListData = [];

	const calculateWidth = () => {
		return Number([...headerInner.children]
			.map(child => child.offsetWidth)
			.reduce((prev, current) => prev + current));
	};

	const hideItem = () => {
		if (menuItemsData.length > 0) {
			const lastItem = menuItemsData[menuItemsData.length - 1];
			hiddenMenuListData.push(lastItem);
			menuItemsData.pop();
			hiddenMenuList.appendChild(lastItem.item);
		}
	};

	const returnItem = () => {
		if (hiddenMenuListData.length > 0) {
			const lastItem = hiddenMenuListData[hiddenMenuListData.length - 1];
			if(calculateWidth() + lastItem.width + 2 <= Number(headerInner.offsetWidth)) {
				menuItemsData.push(lastItem);
				hiddenMenuListData.pop();
				headerMenuList.appendChild(lastItem.item);
				if (hiddenMenuListData.length === 0) {
					hiddenMenuList.classList.remove(`hidden-menu__list--open`);
				}
				returnItem();
			}

		}
	};

	const compareWidths = () => calculateWidth() > Number(headerInner.offsetWidth);

	const rebuildMenu = () => {
		if(!compareWidths()) {
			returnItem();
		}  else {
			hideItem();
			rebuildMenu();
		}
	};

	const onWindowResize = () => {
		rebuildMenu();
	};

	window.addEventListener(`resize`, onWindowResize);

	rebuildMenu();

	const toggleHiddenMenuList = () => {
		hiddenMenuList.classList.toggle(`hidden-menu__list--open`);
	};

	const onHiddenMenuToggler = () => {
		if(hiddenMenuList.children.length > 0) {
			toggleHiddenMenuList();

		}
	};

	hiddenMenuToggler.addEventListener(`click`, onHiddenMenuToggler);
	//#endregion submenu

	//#region stickyHeader
	const headerCart = document.querySelector('.header__cart');
	const headerCartParent = headerCart.parentNode;
	const headerLogo = document.querySelector('.header__logo');
	const headerLogoImage = headerLogo.querySelector('img');
	const headerLogoParent = headerLogo.parentNode;
	const header = document.querySelector('.header');
	const sticky = document.querySelector('.submenu');
	const headerHeight = sticky.offsetTop;
	const stickyHeight = sticky.offsetHeight;
	const stickyContainer = sticky.querySelector('.submenu__inner');
	const changeLogoURL = URL=>
	{
		if (headerLogoImage.src !== URL)
			headerLogoImage.src = `${URL}`;
		else
			return false;
	}
	const replaceNode = (container, position, node) =>
	{
		if(!container.contains(node))
			container.insertAdjacentElement(position, node);
		else
			return false;
	}
	const onWindowScroll = () =>
	{
		if (window.pageYOffset > headerHeight)
		{
			changeLogoURL('/local/assets/images/logo-colored-small.png');
			header.classList.add("sticky");
			header.style.paddingBottom = `${stickyHeight}px`;
			replaceNode(stickyContainer, 'afterbegin', headerLogo);
			replaceNode(stickyContainer, 'beforeend', headerCart);
			rebuildMenu();
		}
		else if (window.pageYOffset < headerHeight && header.classList.contains("sticky"))
		{
			changeLogoURL('/local/assets/styles/images/logo_colored.png');
			header.classList.remove("sticky");
			header.style.paddingBottom = `${0}px`;
			replaceNode(headerLogoParent, 'afterbegin', headerLogo);
			replaceNode(headerCartParent, 'beforeend', headerCart);
			rebuildMenu();
		}
	}
	if(window.innerWidth > 992)
	{
		window.addEventListener('scroll', onWindowScroll);
	}
	const menuOpenBtn = document.querySelector('.header__menu-toggler');
	const mobile_menu = document.querySelector('.mobile-menu');
	const openMobileMenu = () =>
	{
		mobile_menu.classList.add('mobile-menu--open');
	}
	menuOpenBtn.addEventListener('click', openMobileMenu);
	const closeMobileMenu = () =>
	{
		mobile_menu.classList.remove('mobile-menu--open');
	}
	const toggleAccordeonMenu = self=>
	{
		const parent = self.parentNode;
		const allMenuItems = mobile_menu.querySelectorAll('.mobile-menu__item--dropdown');
		if (parent.classList.contains('mobile-menu__item--open'))
			parent.classList.remove('mobile-menu__item--open');
		else
		{
			[...allMenuItems].forEach(item=>item.classList.remove('mobile-menu__item--open'));
			parent.classList.add('mobile-menu__item--open');
		}
	}
	const onMobileMenuClick = evt =>
	{
		if (evt.target === evt.target.closest('.mobile-menu__close'))
			closeMobileMenu();
		if (evt.target === evt.target.closest('.mobile-menu__item--dropdown > a'))
			toggleAccordeonMenu(evt.target);
	}
	mobile_menu.addEventListener('click', onMobileMenuClick);
	//#endregion stickyHeader

	const saleControls = document.querySelector('.sale__controls');



	if(window.matchMedia("(max-width: 767px)").matches) {
		const createWokGrid = $(`.create-wok__grid`);
		createWokGrid.owlCarousel({
				loop: false,
				nav: false,
				dots: true,
				items: 1,
				margin: 15,
				autoHeight:true
		})
		$('.js-wok-next').click(function() {
			createWokGrid.trigger('next.owl.carousel');
		})
		$('.js-wok-prev').click(function() {
			createWokGrid.trigger('prev.owl.carousel');
		})
		$('.js-wok-reset').click(function() {
			createWokGrid.trigger('to.owl.carousel', [0, 100]);
		})
	}

});
