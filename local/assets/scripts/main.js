"use strict";
document.addEventListener('DOMContentLoaded', () =>
{
	//tabs
	const tabsBtns = document.querySelectorAll('.tabs__button');
	if (tabsBtns.length > 0)
	{
		const tabsMobInner = document.querySelector('.tabs__mobile-controls-inner');
		const tabsMobToggler = document.querySelector('.tabs__mobile-controls-toggler');
		const tabs = document.querySelectorAll('.js-tab');

		const changeIcon = icon =>
		{
			const use = tabsMobInner.querySelector('use');
			use.setAttributeNS('http://www.w3.org/1999/xlink', 'xlink:href', `${icon}`)
		}
		const setActiveSelectOption = prop =>
		{
			const optionToSelect = [...tabsMobToggler.options].find(option=>
			{
				return option.value === prop;
			});
			optionToSelect.selected = true;
			changeIcon(optionToSelect.dataset.icon);
		}
		const setActiveBtn = btn =>
		{
			[...tabsBtns].forEach(it =>
			{
				it.classList.remove('tabs__button--active');
			});
			btn.classList.add('tabs__button--active');
		}
		const setActiveTab = pointer =>
		{
			[...tabs].forEach(tab =>
			{
				tab.classList.remove('js-tab--active');
			});
			document.querySelector(`#${pointer}`).classList.add('js-tab--active');
		}
		const onTabBtnClick = evt =>
		{
			setActiveBtn(evt.target);
			setActiveTab(evt.target.dataset.tab);
			setActiveSelectOption(evt.target.dataset.tab);
		}
		[...tabsBtns].forEach(btn =>btn.addEventListener('click', onTabBtnClick));

		const onTabsMobTogglerChange = evt =>
		{
			setActiveBtn(document.querySelector(`[data-tab=${evt.target.value}]`));
			setActiveTab(evt.target.value);
			const iconPath =  evt.target.options[evt.target.selectedIndex].dataset.icon;
			changeIcon(iconPath);
		};
		tabsMobToggler.addEventListener('change', onTabsMobTogglerChange);
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
	let subMenuList = document.querySelector('.submenu__list');
	let menuItemsNodeList = document.querySelectorAll('.submenu__item');
	let menuItems = [...menuItemsNodeList];
	let subMenuResponsiveList = document.querySelector('.submenu__responsive-list');
	let subMenuToggler = document.querySelector('.submenu__toggler');
	let menuWidth = 0; let copyItem;

	let GetWidth = () =>
	{
		menuWidth = subMenuList.clientWidth;
		let itemsWidth = 0;
		menuItems.forEach(item=>{itemsWidth += item.clientWidth});
		return itemsWidth > menuWidth;
	}
	let ChangeMenu = () =>
	{
		if(GetWidth())
		{
			if(copyItem)
			{
				let prevItem = copyItem;
				copyItem = menuItems.pop();
				subMenuResponsiveList.insertBefore(copyItem, prevItem);
				return ChangeMenu();
			}
			else
			{
				copyItem = menuItems.pop();
				subMenuResponsiveList.appendChild(copyItem);
				return ChangeMenu();
			}
		}
	}

	if(subMenuList)
	{
		ChangeMenu();
		subMenuToggler.addEventListener('click',()=>subMenuResponsiveList.classList.toggle('hide'));
		window.addEventListener('resize', ChangeMenu);
	}
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
	const stickyContainer = sticky.querySelector('.container');
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
			ChangeMenu();
		}
		else if (window.pageYOffset < headerHeight && header.classList.contains("sticky"))
		{
			changeLogoURL('/local/assets/styles/images/logo_colored.png');
			header.classList.remove("sticky");
			header.style.paddingBottom = `${0}px`;
			replaceNode(headerLogoParent, 'afterbegin', headerLogo);
			replaceNode(headerCartParent, 'beforeend', headerCart);
			ChangeMenu();
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

	//counter
	/*const counter = document.querySelector(`.js-counter`);
	if(counter) {
		const hoursDictionary = new Map ([
			'1': 'час',
			'2': 'часа',
			'3': 'часа',
			'4': 'часа'
		]);
		const minutesDictionary = new Map([
			'1': 'минута',
			'2': 'минуты',
			'3': 'минуты',
			'4': 'минуты'
		]);
		const secondsDictionary = new Map([
			'1': 'секунда',
			'2': 'секунды',
			'3': 'секунды',
			'4': 'секунды'
		]);
		const hoursOutput = counter.querySelector(`.counter__hours .counter__num`);
		const minutesOutput = counter.querySelector(`.counter__minutes .counter__num`);
		const secondsOutput = counter.querySelector(`.counter__seconds .counter__num`);
		const countDownDate = new Date("Jan 5, 2021 15:37:25").getTime();

		const x = setInterval(function() {
			const now = new Date().getTime();
			const distance = countDownDate - now;
			// const days = Math.floor(distance / (1000 * 60 * 60 * 24));
			const hours = Math.floor((distance / (1000 * 60 * 60 * 24)) * 24);
			const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			const seconds = Math.floor((distance % (1000 * 60)) / 1000);
			hoursOutput.innerHTML = hours < 10 ? `0${hours}` : hours;
			minutesOutput.innerHTML = minutes < 10 ? `0${minutes}` : minutes;
			secondsOutput.innerHTML = seconds < 10 ? `0${seconds}` : seconds;
			if (distance < 0) {
				clearInterval(x);
				hoursOutput.innerHTML = '00';
				minutesOutput.innerHTML = '00';
				secondsOutput.innerHTML = '00';
			}
		}, 1000);
	}*/

	const saleControls = document.querySelector('.sale__controls');
	
});
