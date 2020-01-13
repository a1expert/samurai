document.addEventListener('DOMContentLoaded', function () {

	// slider bonuses

	const slider = document.querySelector('.range-slider');

	if(slider) {
		noUiSlider.create(slider, {
			start: [80],
			connect: 'lower',
			range: {
				'min': [0],
				'max': [100]
			}
		});
	}
	//tabs
	const tabsBtns = document.querySelectorAll(`.tabs__button`);
	if (tabsBtns.length > 0) {
		const tabsMobInner = document.querySelector(`.tabs__mobile-controls-inner`);
		const tabsMobToggler = document.querySelector(`.tabs__mobile-controls-toggler`);
		const tabs = document.querySelectorAll(`.js-tab`);

		const changeIcon = (icon) => {
			const use = tabsMobInner.querySelector(`use`);
			use.setAttributeNS(`http://www.w3.org/1999/xlink`, `xlink:href`, `${icon}` )
		};

		const setActiveSelectOption = (prop) => {
			const optionToSelect = [...tabsMobToggler.options].find((option) => {
				return option.value === prop;
			});
			optionToSelect.selected = true;
			changeIcon(optionToSelect.dataset.icon);
		};

		const setActiveBtn = (btn) => {
			[...tabsBtns].forEach((it) => {
				it.classList.remove(`tabs__button--active`);
			});
			btn.classList.add(`tabs__button--active`);
		};

		const setActiveTab = (pointer) => {
			[...tabs].forEach((tab) => {
				tab.classList.remove(`js-tab--active`);
			});
			document.querySelector(`#${pointer}`).classList.add(`js-tab--active`);
		};

		const onTabBtnClick = (evt) => {
			setActiveBtn(evt.target);
			setActiveTab(evt.target.dataset.tab);
			setActiveSelectOption(evt.target.dataset.tab);
		};

		[...tabsBtns].forEach((btn) => {
			btn.addEventListener(`click`, onTabBtnClick)
		});

		const onTabsMobTogglerChange = (evt) => {
			setActiveBtn(document.querySelector(`[data-tab=${evt.target.value}]`));
			setActiveTab(evt.target.value);
			const iconPath =  evt.target.options[evt.target.selectedIndex].dataset.icon;
			changeIcon(iconPath);
		};

		tabsMobToggler.addEventListener(`change`, onTabsMobTogglerChange);
	}

	const initMainCarousels = (el) => {
		el.owlCarousel({
			loop: true,
			margin: 30,
			nav: true,
			navText: ['<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 284 284"><path d="M282.082 195.285L149.028 62.24c-1.901-1.903-4.088-2.856-6.562-2.856s-4.665.953-6.567 2.856L2.856 195.285C.95 197.191 0 199.378 0 201.853c0 2.474.953 4.664 2.856 6.566l14.272 14.271c1.903 1.903 4.093 2.854 6.567 2.854s4.664-.951 6.567-2.854l112.204-112.202 112.208 112.209c1.902 1.903 4.093 2.848 6.563 2.848 2.478 0 4.668-.951 6.57-2.848l14.274-14.277c1.902-1.902 2.847-4.093 2.847-6.566.001-2.476-.944-4.666-2.846-6.569z"/></svg>', '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 284 284"><path d="M282.082 195.285L149.028 62.24c-1.901-1.903-4.088-2.856-6.562-2.856s-4.665.953-6.567 2.856L2.856 195.285C.95 197.191 0 199.378 0 201.853c0 2.474.953 4.664 2.856 6.566l14.272 14.271c1.903 1.903 4.093 2.854 6.567 2.854s4.664-.951 6.567-2.854l112.204-112.202 112.208 112.209c1.902 1.903 4.093 2.848 6.563 2.848 2.478 0 4.668-.951 6.57-2.848l14.274-14.277c1.902-1.902 2.847-4.093 2.847-6.566.001-2.476-.944-4.666-2.846-6.569z"/></svg>'],
			responsive: {
				0: {
					items: 1
				},
				600: {
					items: 3
				},
				1000: {
					items: 4
				}
			}
		})
	};
	initMainCarousels($(".main-items"))


	//popup

	const removeElement = (element) => {
		element.remove()
	};

	const documentOnKeyDown = (evt, layout) => {
		if (evt.key === "Escape" || evt.key === "Esc") {
			removeElement(layout);
		}
	};

	const onLayoutClick = (evt, layout) => {
		if(!evt.target.closest(`.popup`)) {
			removeElement(layout);
		}
	};

	const onCloseClick = (layout) => {
		removeElement(layout);
	};

	const bindPopupListenters = (layout, close) => {
		layout.addEventListener(`click`, (evt) => {
			onLayoutClick(evt, layout);
		});
		close.addEventListener(`click`, () => {
			onCloseClick(layout);
		});
		document.addEventListener(`keydown`, (evt) => {
			documentOnKeyDown(evt, layout);
		})
	};

	const createPopup = () => {
		const layout = document.createElement(`div`);
		const popup = document.createElement(`div`);
		const close = document.createElement(`button`);

		layout.classList.add(`popup-layout`);
		popup.classList.add(`popup`);
		close.classList.add(`popup__close`);

		popup.appendChild(close);
		layout.appendChild(popup);
		document.body.appendChild(layout);

		bindPopupListenters(layout, close);
	};

	// fetch

	const getdata = url => fetch(url)
			.then(response => response.json());

	// stocks

	const stocks = document.querySelectorAll(`.stock`);

	const createFullStock = (data) => {
		return (`
			<div class="stock-popup">
				<div class="stock-popup__header" style="background-image: url(${data.img})"></div>
				<div class="stock-popup__body">
					<h3 class="stock-popup__title">${data.description.title}</h3>
					${data.description.text.map((paragraph) => {
						return (`<p class="stock-popup__text">${paragraph}</p>`)
					}).join(``)}
					<p class="stock-popup__note">${data.description.note}</p>
				</div>
				<div class="stock-popup__footer">
					<p class="stock-popup__footer-note">Поделиться с друзьями:</p>
					<ul class="socials socials--invert socials--small">
					<li class="socials__item">
						<a class="socials__link socials__link--vk" href="#">
							<svg xmlns:xlink="http://www.w3.org/1999/xlink">
								<use xlink:href="./assets/images/icon.svg#icon_vk" />
							</svg>	
						</a>		
					</li>			
					<li class="socials__item">
						<a class="socials__link socials__link--fb" href="#">
							<svg xmlns:xlink="http://www.w3.org/1999/xlink">
								<use xlink:href="./assets/images/icon.svg#icon_facebook" />
							</svg>
						</a>		
					</li>			
					<li class="socials__item">
						<a class="socials__link socials__link--inst" href="#"> 
							<svg xmlns:xlink="http://www.w3.org/1999/xlink">
								<use xlink:href="./assets/images/icon.svg#icon_instagram" />
							</svg>
						</a>		
					</li>			
					<li class="socials__item">
						<a class="socials__link socials__link--ok" href="#">
							<svg xmlns:xlink="http://www.w3.org/1999/xlink">
								<use xlink:href="./assets/images/icon.svg#icon_odnoklassniki" />
							</svg>
						</a>		
					</li>			
					</ul>			
				</div>
			</div>
		`)
	};

	const showfullStockPopup = (data) => {
		document.querySelector(`.popup`).insertAdjacentHTML(`beforeend`, createFullStock(data))
	};

	const loadStockDescription = (id) => {
		const URL = `https://samurai-df366.firebaseio.com/stocks/${id}.json`;
		getdata(URL)
			.then((response) => showfullStockPopup(response))

	};

	const onStockClick = (evt) => {
		const self = evt.target;
		createPopup();
		loadStockDescription(self.id);
	};

	if (stocks) {
		[...stocks].forEach((stock) => {
			stock.addEventListener(`click`, onStockClick);
		});
	}

	// city toggler
	const cityToggler = document.querySelector(`.info__city-name`);

	const showCityChoosePopup = () => {
		const template = document.querySelector(`#city`).content;
		const chooseCity = template.cloneNode(true);
		const popup = document.querySelector(`.popup`);

		popup.appendChild(chooseCity);
	};

	const onCityTogglerClick = () => {
		createPopup();
		showCityChoosePopup();
	};
	cityToggler.addEventListener(`click`, onCityTogglerClick)

	// input date
	const dateInput = document.querySelector(`#date`);
	const timeInput = document.querySelector(`#time`);

	flatpickr(dateInput, {
		"locale": "ru",
		dateFormat: "d-m-Y",
	});

	flatpickr(timeInput, {
		"locale": "ru",
		enableTime: true,
		noCalendar: true,
		dateFormat: "H:i",
		minDate: "09:00",
		maxDate: "18:00",
		time_24hr: true
	});

});
