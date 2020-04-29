"use strict";
function _instanceof(left, right) { if (right != null && typeof Symbol !== "undefined" && right[Symbol.hasInstance]) { return !!right[Symbol.hasInstance](left); } else { return left instanceof right; } }
function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread(); }
function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance"); }
function _iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter); }
function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }
function _classCallCheck(instance, Constructor) { if (!_instanceof(instance, Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
var CatalogFIlter = function CatalogFIlter() {
  var _this = this;
  _classCallCheck(this, CatalogFIlter);
  _defineProperty(this, "ArrayCompare", function (array1, array2) {
    for (var i = 0; i < array2.length; i++) {
      if (!array1.includes(array2[i])) return false;
    }
    return true;
  });
  _defineProperty(this, "OnFilterChangeHandler", function () {
    var tmpArray = [];
    _this.catalogItems.forEach(function (item) {
      var itemIds = item.dataset.sectionsid.split(',');
      if (_this.ArrayCompare(itemIds, _this.filterArray)) {
        item.style.display = 'list-item';
        tmpArray = tmpArray.concat(itemIds);
      } else item.style.display = 'none';
    });
    _this.filterLabels.forEach(function (label) {
      if (tmpArray.indexOf(label.dataset.sectionid) < 0 && label.id !== 'labelAll') label.classList.add('disabledBtn');else label.classList.remove('disabledBtn');
    });
  });
  _defineProperty(this, "AllBtnHandler", function () {
    _this.catalogItems.forEach(function (item) {
      return item.style.display = 'list-item';
    });
    _this.filtersBtns.forEach(function (btn) {
      btn.checked = btn.dataset.sectionid == 'all' ? true : false;
    });
    _this.filterLabels.forEach(function (label) {
      return label.classList.remove('disabledBtn');
    });
    _this.filterArray = [];
  });
  _defineProperty(this, "OnBtnChangeHandler", function (e) {
    var id = e.target.dataset.sectionid;
    if (id == 'all') _this.AllBtnHandler();else {
      _this.btnAll.checked = false;
      if (e.target.checked) _this.filterArray.push(id);else _this.filterArray.splice(_this.filterArray.indexOf(id), 1);

      _this.OnFilterChangeHandler();
    }
  });
  _defineProperty(this, "SortNChangeClass", function (btn, sortType) {
    btn.classList.add('filters__toggler--active');
    if (btn.classList.contains('filters__toggler--up')) {
      btn.classList.remove('filters__toggler--up');
      btn.classList.add('filters__toggler--down');
      _this.catalogItems.sort(function (a, b) {
        return parseInt(b.dataset[sortType]) - parseInt(a.dataset[sortType]);
      });
    } else if (btn.classList.contains('filters__toggler--down')) {
      btn.classList.remove('filters__toggler--down');
      btn.classList.add('filters__toggler--up');
      _this.catalogItems.sort(function (a, b) {
        return parseInt(a.dataset[sortType]) - parseInt(b.dataset[sortType]);
      });
    } else {
      btn.classList.add('filters__toggler--up');
      _this.catalogItems.sort(function (a, b) {
        return parseInt(a.dataset[sortType]) - parseInt(b.dataset[sortType]);
      });
    }
  });
  _defineProperty(this, "OnSortBtnHandler", function (e) {
    _this.sortBtns.forEach(function (btn) {
      return btn.classList.remove('filters__toggler--active');
    });
    _this.SortNChangeClass(e.target, e.target.id);
    _this.catalogItems.forEach(function (item, i) {
      item.style.order = i;
    });
  });
  _defineProperty(this, "Execute", function () {
    _this.filtersBtns.forEach(function (btn) {
      return btn.addEventListener('change', _this.OnBtnChangeHandler);
    });
    _this.sortBtns.forEach(function (btn) {
      return btn.addEventListener('click', _this.OnSortBtnHandler);
    });
  });
  //кнопки
  this.filtersBtns = document.querySelectorAll('.jsFiltersBtn'); // кнопка "Все"
  this.btnAll = document.querySelector('#all'); //плитка / товары
  this.catalogItems = _toConsumableArray(document.querySelectorAll('.jsCatalogItem')); //лейблы
  this.filterLabels = document.querySelectorAll('.jsFiltersLabel'); //Конпки сортировки
  this.sortBtns = document.querySelectorAll('.filters__toggler'); //значения текущего фильтра
  this.filterArray = [];
}
/**
 * @function Сравнеие двух масивов
 * @array array1 - массив для проверки
 * @array array2 - фильтруемый массив
 * @return возвращает true если все элементы фильтруемого массива есть в массиве для проверки, иначе false.
 */
;
document.addEventListener('DOMContentLoaded', () =>
{
    if(window.location.href.indexOf('catalog') > -1)
    {
        const catalogFilter = new CatalogFIlter();
        catalogFilter.Execute();
	}
	const removeElement = (element) =>element.remove();
	/**
	 * Всплывающая подсказка
	 * @place {object} Событие или элемент на котором нужно вызвать подсказку. Из него берутся координаты клика на документе.
	 * @text {string} Тестк подсказки
	 * @time {int} Время показа подсказки в млсекундах. По дефолту = 2 сек.
	 * @fixed {bool} Флаг для применения позицианирования fixed, по умолчания = false (position: absolute), применять true только если передается событие
	 */
	const ShowTooltip = (place, text, time = 2000, fixed = false) =>
	{
		let top = 0; let left = 0;
		if(place.target == undefined)
		{
			let rect = place.getBoundingClientRect();
			top = rect.y + pageYOffset;
			left = rect.x + pageXOffset;
		}
		else//срабатывает когда передано событие
		{
			if(fixed)
			{
				top = place.clientY;
				left = place.clientX;
			}
			else
			{
				top = place.pageY;
				left = place.pageX;
			}
		}
		let tooltip = document.querySelector('.tooltip');
		if(tooltip)
		{
			tooltip.innerHTML = text;
			tooltip.classList.remove('hide');
			if(fixed)tooltip.style.position = 'fixed';
			tooltip.style.top = `${top - tooltip.offsetHeight}px`;
			tooltip.style.left = `${left}px`;
			setTimeout(() => {
				tooltip.classList.add('hide');
				if(fixed)tooltip.style.position = 'absolute';
			}, time);
		}
	}
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
	const LoadingIcon = 
	{
		icon: undefined,
		layout: undefined,
		Constructor: () =>
		{
			LoadingIcon.icon = document.querySelector('#loading');
			LoadingIcon.layout = document.querySelector('#loadingLayout');
		},
		Show: () =>
		{
			LoadingIcon.icon.classList.remove('hide');
			LoadingIcon.layout.classList.remove('hide');
		},
		Hide: () =>
		{
			LoadingIcon.icon.classList.add('hide');
			LoadingIcon.layout.classList.add('hide');
		}
	}
	LoadingIcon.Constructor();

    //#region city toggler
	const cityTogglers = document.querySelectorAll('.jsCityToggler');

	const showCityChoosePopup = () =>
	{
		const template = document.querySelector('#city').content;
		const chooseCity = template.cloneNode(true);
		const popup = document.querySelector('.popup');
		popup.appendChild(chooseCity);
	};
	const onCityTogglerClick = () =>
	{
		createPopup();
		showCityChoosePopup();
	};
	cityTogglers.forEach(btn=>btn.addEventListener('click', onCityTogglerClick));
    //#endregion city toggler
    
    //#region catalog popup
	const cardtogglers = document.querySelectorAll('.card__toggle');
	let popup = document.querySelector('#myPopup');
	let popupContent = document.querySelector('.popup__content');
	let card;
	let CardTogglerHandler = e =>
	{
		e.preventDefault();
		for (let i = 0; i < e.path.length; i++)
		{
			if(e.path[i].classList.contains('card'))
			{
				card = e.path[i].cloneNode(true);
				popup.style.display = 'flex';
				popupContent.innerHTML = '<div class="popup__closeBtn" onclick="this.parentNode.parentNode.style.display = \'none\'">&#x2715;</div>';
				popupContent.appendChild(card);
				card.querySelectorAll('.jsBuy_link').forEach(btn=>btn.addEventListener('click', BuyBtnHandler));
				break;
			}
		}
	}
	if(cardtogglers)
	{
		cardtogglers.forEach(toggler => toggler.addEventListener('click', CardTogglerHandler));
		popup.addEventListener('click', (e)=>
		{
			if(e.target == popup)
				popup.style.display = 'none';
		});
	}
	//#endregion catalog popup

	//#region reviews
	const revForm = document.querySelector('.revForm');
	const revBtn = document.querySelector('#revSubmit');
	const revSubmitText = document.querySelector('#revSubmitText');
	const RevAddHandler = e =>
	{
		e.preventDefault();
		LoadingIcon.Show();
		revBtn.setAttribute('disabled', 'disabled');
		const formData = new FormData(revForm);
		
		fetch('/local/inc_files/reviewAdd.php', {method: 'POST', body: formData})
		.then(response =>
		{
			LoadingIcon.Hide();
			if(response.ok)
				ShowTooltip(revBtn, revSubmitText.innerHTML, 5000);
		});
	}
	if(revForm)
		revForm.addEventListener('submit', RevAddHandler);
	
	//#endregion reviews

	//#region Basket
	let stop = 0;
	// Кнопка открывающая корзину, можно ставить класс вообще на любой элемент
	const basketToggler = document.querySelector('.jsBasketToggler');
	// Основной контейнер корзины
	let basket = document.querySelector('.jsBasket');
	// Подложка корзины, по клику на которую, корзина закрывается
	let basketLO = document.querySelector('.jsBasketLayout');
	// Количество товаров в корзине и общая цена, элементы находится в шапке и не интерактивные
	let smallBasketQuant = document.querySelector('#smallBasketQuant');
	let smallBasketPrice = document.querySelector('#smallBasketPrice');
	//файл с битриксовыми функциями: добавления, обновления и удаления товаров, работает через GET параметры
	const actionUrl = '/local/inc_files/action.php';
	//файл подгружающий компонент корзины
	const getBasketUrl = '/local/inc_files/getBasket.php';
	//любая кнопка добавления товара в карзину
	let buyBtns = document.querySelectorAll('.jsBuy_link');
	//Объект c ключами = id товаров в корзине и значениями = количество; ключи и количество хранятся в виде строки
	let arrProducts = {};
	//я уже не помню зачем создовал это событие.
	let updateBasketEvent = new Event("updateBasketEvent", {bubbles: true});
	//пужырик летащий в корзину при покупке
	let glob = document.querySelector('.glob');
	//ф-ция открытия корзины
	const BasketDisplayToggle = () =>
	{
		basket.classList.toggle('hide');
		basketLO.classList.toggle('hide');
	}
	//ф-ция обновления корзины: подтягивает файл с компонентом, получая актуальную корзину вставляет в основной контейнер и перезапускает "class basket"
	const UpdateBasket = () =>
	{
		fetch(getBasketUrl)
		.then(response=>
		{
			if(response.ok)
				return response.text();
			else
			{
				LoadingIcon.Hide();
				alert('Fatal error! Everything dying!');
				return false;
			}
		})
		.then(data =>
		{
			if(data !== false)
			{
				basket.innerHTML = data;
				LoadingIcon.Hide();
				Basket();
				UpdateGifts();
			}
			else
			{
				LoadingIcon.Hide();
				alert('Fatal error! Everything dying!');
				return false;
			}
		});
	}
	//обновление корзины на бэке и вызов ф-ции обновления на фронте
	const UpdateHandler = (id, quant) =>
	{
		fetch(`${actionUrl}?action=update&id=${id}&quant=${quant}`)
		.then(response=>
		{
			if(response.ok)
				UpdateBasket();
			else
			{
				LoadingIcon.Hide();
				alert('Fatal error! Everything dying!');
				return false;
			}
		});
	}
	const IncBtnHandler = e =>
	{
		LoadingIcon.Show(); // вскрытие иконки "Загрузка"
		let quant = e.target.previousElementSibling;// получение элемента "количесвто" из текущего товара
		quant.value = parseInt(quant.value) + 1;// плюсуем
		arrProducts[e.target.dataset.id] = quant.value.toString();
		UpdateHandler(e.target.dataset.id, quant.value);//обновляем
	}
	//тут все тоже самое как тут ↑ только наоборот + защита при количестве = 1
	const DecBtnHandler = e =>
	{
		LoadingIcon.Show();
		let quant = e.target.nextElementSibling;
		if(quant.value == '1')
		{
			LoadingIcon.Hide();
			stop++;
			if(stop > 5)alert('ХВАТИТ КЛИКАТЬ НА МИНУС, ХОЧЕШЬ УДАЛИТЬ - НАЖМИ НА КРЕСТИК!!!');
			return false;
		}
		quant.value = parseInt(quant.value) - 1;
		arrProducts[e.target.dataset.id] = quant.value.toString();
		UpdateHandler(e.target.dataset.id, quant.value);
	}
	const DelHandler = el =>
	{
		LoadingIcon.Show();
		fetch(`${actionUrl}?action=remove&id=${el.dataset.id}`)
		.then(response=>
		{
			if(response.ok)
			{
				document.querySelector(`#id${el.dataset.id}`).remove();
				let buyBtns = document.querySelectorAll(`.jsBuy_link.id${el.dataset.id}`);
				if(buyBtns)
				{
					buyBtns.forEach(buyBtn =>
					{
						buyBtn.classList.remove('card__add-to-cart--more');
						buyBtn.innerText = 'беру!';
					});
				}
				delete arrProducts[el.dataset.id];
			}
			else
			{
				LoadingIcon.Hide();
				alert('Fatal error! Everything dying!');
				return false;
			}
		});
		UpdateBasket();
	}
	const BuyBtnHandler = e =>
	{
		let eId = e.target.dataset.id;
		let eQuant = parseInt(arrProducts[eId]);
		LoadingIcon.Show();
		if(arrProducts[e.target.dataset.id] != undefined)
		{
			arrProducts[eId] = (eQuant + 1).toString();
			UpdateHandler(eId, (eQuant + 1).toString());
			GlobAimation(e.target);
		}
		else
		{
			fetch(`${actionUrl}?action=add&id=${eId}`)
			.then(response=>
			{
				if(response.status == 200)
				{
					let buyBtns = document.querySelectorAll(`.jsBuy_link.id${eId}`);
					if(buyBtns)
					{
						buyBtns.forEach(buyBtn =>
						{
							buyBtn.classList.add('card__add-to-cart--more');
							buyBtn.innerText = 'беру еще!';
						});
					}
					arrProducts[eId] = '1';
					UpdateBasket();
					GlobAimation(e.target);
				}
				else
				{
					LoadingIcon.Hide();
					alert('Fatal error! Everything dying!');
					return false;
				}
			});
		}
	}
	const CurQuantHandler = e =>
	{
		if(e.target.validationMessage != "")
		{
			alert(e.target.validationMessage);
			e.target.value = e.target.defaultValue;
			return false;
		}
		if(e.target.valueAsNumber <= 0)
		{
			alert('Значения 0 и меньше — не допустимы');
			e.target.value = e.target.defaultValue;
			return false;
		}
		arrProducts[e.target.dataset.id] = e.target.value;
		UpdateHandler(e.target.dataset.id, e.target.valueAsNumber);
	}
	const WokDeleteHandler = e =>
	{
		fetch(`${actionUrl}?action=update&id=${e.target.dataset.id}&quant=0`);
		UpdateBasket();
	}

	const GlobAimation = (element) =>
	{
		let rect = element.getBoundingClientRect();
		let curPos = [rect.x, rect.y];
		rect = basketToggler.getBoundingClientRect();
		let endPos = [rect.x, rect.y];
		glob.style.left = curPos[0];
		glob.style.top = curPos[1];
		glob.classList.remove('hide');
		let difX = endPos[0] - curPos[0];
		let difY = endPos[1] - curPos[1];
		let speedX = difX / 0.4;
		let speedY = difY / 0.4;
		let fps = 240;
		// console.log(curPos)
		// console.log(endPos)
		// console.log(difX)
		// console.log(difY)
		// console.log(speedX)
		// console.log(speedY)
		let frame;
		frame = window.setInterval(() => 
		{
			if(curPos[0] >= endPos[0] && curPos[1] <= endPos[1])
			{
				clearInterval(frame);
				glob.classList.add('hide');
			}
			glob.style.left = `${curPos[0]}px`;
			glob.style.top = `${curPos[1]}px`;
			curPos[0] += speedX / fps;
			curPos[1] += speedY / fps;
		}, 1000 / fps);
	}

	/**
	 * Основная функция для работы корзины типо class, сделано так для того, чтобы при каждом изменении подгружать компонент снова, да это не оптимально, зато упрощается процесс разработки и избавляет от ошибок З.Ы. ф-нкция была изменена и уже не полностью соответствует описанию
	 *
	 */
	function Basket()
	{
		const basketClose = document.querySelectorAll('.jsBasketClose');
		// если есть эта нода значит в корзине есть товар
		const basketFlag = document.querySelector('#basketFlag');
		//скрытый див в который компонент вставляет текущее количество товаров в корзине
		let basketItemsQuant = document.querySelector('#basketItemsQuant').dataset.value;
		//скрытый див в который компонент вставляет общую цену корзины
		let basketAllSum = document.querySelector('.jsBasketPrice').dataset.value;
		// "Перенаходим" кнопки добавления товара в корзину, что бы найти новые кнопки товаров в самой корзине, да и так прост на всякий случай
		buyBtns = document.querySelectorAll('.jsBuy_link');
		if(basketFlag)// если в корзине есть товар, то получаем элементы управления товаров
		{
			const incBtns = document.querySelectorAll('.jsIncrement');
			const decBtns = document.querySelectorAll('.jsDecrement');
			const deleteBtns = document.querySelectorAll('.jsDelBtn');
			const curQuant = document.querySelectorAll('.jsCurQuant');
			const wokDelBtns = document.querySelectorAll('.jsWokDelBtn');
			
			//товары в корзине
			const products = document.querySelectorAll('.jsProduct');

			products.forEach(p=>arrProducts[p.dataset.id] = p.dataset.quant);
			incBtns.forEach(btn=>btn.addEventListener('click', IncBtnHandler));
			decBtns.forEach(btn=>btn.addEventListener('click', DecBtnHandler));
			deleteBtns.forEach(btn=>btn.addEventListener('click', e => DelHandler(e.target)));
			curQuant.forEach(el=>el.addEventListener('change', CurQuantHandler));
			if(wokDelBtns)wokDelBtns.forEach(btn=>btn.addEventListener('click', WokDeleteHandler));
		}
		//обновляем элементы в шапке
		smallBasketQuant.innerText = basketItemsQuant;
		smallBasketPrice.innerText = basketAllSum;
		basketClose.forEach(btn => btn.addEventListener('click', BasketDisplayToggle));
		buyBtns.forEach(btn => btn.addEventListener('click', BuyBtnHandler));
		return arrProducts;
	}
	basketToggler.addEventListener('click', BasketDisplayToggle);
	// инициализация корзины
	var promise1 = new Promise(resolve=>resolve(Basket()));
	promise1.then(arrProducts=>
	{
		if(Object.entries(arrProducts) != 0)
		{
			for(var product in arrProducts)
			{
				buyBtns.forEach(btn=>
				{
					if(btn.dataset.id == product)
					{
						btn.classList.add('card__add-to-cart--more');
						btn.innerText = 'беру еще!';
					}
				});
			}
		}
	});
	//#endregion Basket

	//#region wok
	const huita = document.querySelector('#huita');
	if(huita)
	{
		const wokConsistBtn = document.querySelectorAll('.wokConsistBtn');
		let groups = {};
		let wokPicture = document.querySelector('#wokPicture');
		const simpleTemplate = document.querySelector('#simpleTemplate .create-wok__output-item');
		const controlsTemplate = document.querySelector('#controlsTemplate .create-wok__output-item');
		const wokResetBtn = document.querySelector('.js-wok-reset');
		const wokSumPriceView = document.querySelector('#jsWokSumPriceValue');
		const basePrice = document.querySelector('#basePrice');
		let sumPrice = basePrice.dataset.value;
		let wokFormSubmit = document.querySelector('#wokFormSubmit');
		let wokFormItemsList = document.querySelector('#wokFormItemsList');
		let baseName = document.querySelector('#baseName');
		let baseDescription = document.querySelector('#baseDescription');
		let newOutputItem = undefined;
		let wokImg = undefined;
		let sauceItem = undefined;
		let wokIncrBtns = undefined;
		let wokDecrBtns = undefined;
		let ItemPrices = undefined;
		let check = 0;
		let itemsIds = {
			base: '',
			sauce: '',
			filling: [],
			extra: []
		};
		
		const wokIncBtnHandler = (e) =>
		{
			if(groups[e.target.dataset.section] == 2)
			{
				ShowTooltip(e, 'Нельзя добавить больше двух');
				return;
			}
			itemsIds[e.target.dataset.section].push(e.target.dataset.id);
			groups[e.target.dataset.section]++;
			e.target.previousElementSibling.value = '2';
			let localItemPrice = document.querySelector(`#oiid${e.target.dataset.id} .jsItemPrice`);
			if(localItemPrice)localItemPrice.innerText = `${parseInt(localItemPrice.innerText) * 2} ₽`;
			WokRecalcSumPrice();
		}
		const wokDecBtnHandler = (e) =>
		{
			check = 0;
			itemsIds[e.target.dataset.section].forEach(id => {
				if(e.target.dataset.id == id)
				check++;
			});
			if(check <= 1)
				return;
			itemsIds[e.target.dataset.section].splice(itemsIds[e.target.dataset.section].indexOf(e.target.dataset.id), 1);
			groups[e.target.dataset.section]--;
			e.target.nextElementSibling.value = '1';
			let localItemPrice = document.querySelector(`#oiid${e.target.dataset.id} .jsItemPrice`);
			if(localItemPrice)localItemPrice.innerText = `${parseInt(localItemPrice.innerText) / 2} ₽`;
			WokRecalcSumPrice();
		}
		const wokControlsChange = () =>
		{
			wokIncrBtns = document.querySelectorAll('.jsWokIncr');
			wokDecrBtns = document.querySelectorAll('.jsWokDecr');
			wokIncrBtns.forEach(btn => btn.addEventListener('click', wokIncBtnHandler));
			wokDecrBtns.forEach(btn => btn.addEventListener('click', wokDecBtnHandler));
		}
		const WokReset = () =>
		{
			if(wokConsistBtn)
			{
				wokConsistBtn[0].click();
				wokConsistBtn.forEach(btn =>
				{
					if(btn.checked == true || btn.dataset.price == '0')
						btn.click();
				});
			}
			else
				throw 'variable wokConsistBtn undefined or null or something else wrong!';
		}
		const WokRecalcSumPrice = () =>
		{
			sumPrice = 0;
			ItemPrices = document.querySelectorAll('.jsItemPrice');
			
			ItemPrices.forEach(item => 
			{
				sumPrice += parseInt(item.innerText);
			});
			wokSumPriceView.innerText = `${sumPrice} ₽`;
		}
		const WokConsistHandler = (e) =>
		{
			if(e.target.checked)
			{
				if(groups[e.target.name] == 2)
				{
					e.preventDefault();
					ShowTooltip(e, 'Нельзя добавить больше двух');
					return;
				}
				else if(e.target.type != 'radio')
					groups[e.target.name]++;
				switch (e.target.name)
				{
					case 'base':
						baseName.innerText = e.target.dataset.name;
						baseDescription.innerText = e.target.dataset.description;
						wokPicture.querySelector('.wok__img-base').src =  e.target.previousElementSibling.src;
						itemsIds['base'] = e.target.dataset.id;
						break;
					case 'filling':
					case 'extra':
						newOutputItem = controlsTemplate.cloneNode(true);
						newOutputItem.querySelector('.jsItemName').innerText = e.target.dataset.name;
						newOutputItem.querySelector('.jsItemPrice').innerText = `${e.target.dataset.price} ₽`;
						newOutputItem.id = `oi${e.target.id}`;
						newOutputItem.querySelector('.jsWokIncr').dataset.id = newOutputItem.querySelector('.jsWokDecr').dataset.id = e.target.dataset.id;
						newOutputItem.querySelector('.jsWokIncr').dataset.section = newOutputItem.querySelector('.jsWokDecr').dataset.section = e.target.name;
						wokFormItemsList.appendChild(newOutputItem);
						newOutputItem = undefined;
						wokImg = e.target.previousElementSibling.cloneNode();
						wokPicture.appendChild(wokImg);
						wokControlsChange();
						itemsIds[e.target.name].push(e.target.dataset.id);
						break;
					case 'sauce':
						if(sauceItem == undefined)
						{
							newOutputItem = simpleTemplate.cloneNode(true);
							newOutputItem.classList.add('sauceItem');
							wokFormItemsList.appendChild(newOutputItem);
							newOutputItem = undefined;
							sauceItem = wokFormItemsList.querySelector('.sauceItem');
						}
						sauceItem.querySelector('.jsItemName').innerText = e.target.dataset.name;
						sauceItem.querySelector('.jsItemPrice').innerText = `${e.target.dataset.price} ₽`;
						itemsIds['sauce'] = (e.target.id == 'huita2') ? '' : e.target.dataset.id;
						break;
				}
			}
			else
			{
				groups[e.target.name]--;
				let img = wokPicture.querySelector(`[data-imgid="${e.target.previousElementSibling.dataset.imgid}"]`);
				if(img)
					img.remove();
				wokFormItemsList.querySelector(`#oi${e.target.id}`).remove();
				let ebaaat = [];
				itemsIds[e.target.name].map(i => {
					if(i != e.target.dataset.id)
						ebaaat.push(i);
				});
				itemsIds[e.target.name] = ebaaat;
				if(ebaaat.length == 0)
					groups[e.target.name] = 0;
			}
			WokRecalcSumPrice();
		}

		wokConsistBtn.forEach(el =>
		{
			groups[el.name] = 0;
			el.addEventListener('click', WokConsistHandler);
		});
		itemsIds['base'] = baseName.dataset.id;

		const WokFormHandler = (e =>
		{
			e.preventDefault();
			LoadingIcon.Show();
			let arResult = [];
			for (const key in itemsIds)
			{
				if (Array.isArray(itemsIds[key]))
					itemsIds[key].forEach(id =>arResult.push(id));
				else
					arResult.push(itemsIds[key]);
			}
			fetch(`/local/inc_files/action.php?action=wok&result=${JSON.stringify(arResult)}`)
			.then(response =>
			{
				if(response.ok)
				{
					WokReset();
					UpdateBasket();
				}
				else
					alert('Server error!');
				LoadingIcon.Hide();
			});
		});
		wokFormSubmit.addEventListener('click', WokFormHandler);
		wokResetBtn.addEventListener('click', WokReset);
		wokPicture.addEventListener('click', (e)=>
		{
			// let t1 = performance.now();
			// let elById = document.querySelector('#wokFormSubmit');
			// let t2 = performance.now();
			// let t3 = performance.now();
			// let elByClass = document.querySelector('.wokForm__submit');
			// let t4 = performance.now();
			// console.log(t2-t1);
			// console.log(t4-t3);
		});
	}
	//#endregion wok

	//#region gifts
	const giftsPopup = document.querySelector('#giftsPopup');
	const giftsCloseBtn = document.querySelector('#jsGiftsClose');
	const giftsCancelBtn = document.querySelector('#jsGiftsCancel');
	const freeGoods = document.querySelector('#freeGoods');
	const slyshKupi = document.querySelector('#slyshKupi');
	let leftToGift = document.querySelector('#leftToGift');
	const addGiftBtns = document.querySelectorAll('.jsGift_link');
	const UpdateGifts = () =>
	{
		const basketOrderBtn = document.querySelector('#basketOrderBtn');
		const BasketOrderBtnHandler = e =>
		{
			e.preventDefault();
			const giftsInBasket = document.querySelector('.basketGift');
			let canceled = document.cookie.match(/gifts_canceled=(true)/);
			canceled = canceled != null ? canceled[1] : false;
			if(canceled || giftsInBasket != null)
				document.location.href = '/order/';
			else
			{
				let basketAllSum = document.querySelector('.jsBasketPrice').dataset.value;
				if(typeof basketAllSum !== 'undefined' && parseInt(basketAllSum) >= 1000)
				{
					giftsPopup.classList.remove('hide');
					freeGoods.classList.remove('hide');
				}
				else if(typeof basketAllSum !== 'undefined' && parseInt(basketAllSum) < 1000)
				{
					giftsPopup.classList.remove('hide');
					slyshKupi.classList.remove('hide');
					leftToGift.innerText = 1000 - basketAllSum;
				}
			}
		}
		const GiftBtnHandler = e =>
		{
			e.preventDefault();
			LoadingIcon.Show();
			fetch(`${actionUrl}?action=add&id=${e.target.dataset.id}`)
			.then(response=>
			{
				if(response.status == 200)
					return true;
				else
					return !true;
			})
			.then(flag =>
			{
				if(flag)
				{
					UpdateBasket();
					document.location.href = '/order/';
				}
				else
				{
					LoadingIcon.Hide();
					alert('Error! Error! Error!\nTry again later.');
				}
			});
		}
		addGiftBtns.forEach(btn=>btn.addEventListener('click', GiftBtnHandler));
		if(basketOrderBtn)basketOrderBtn.addEventListener('click', BasketOrderBtnHandler);
	}

	const CancelBtnHandler = () =>
	{
		document.cookie = 'gifts_canceled=true; path=/;';
		giftsPopup.classList.add('hide');
		freeGoods.classList.add('hide');// Это на всякий случай
		slyshKupi.classList.add('hide');// И это тоже
	}

	giftsCancelBtn.addEventListener('click', CancelBtnHandler);
	giftsCloseBtn.addEventListener('click', ()=>
	{
		giftsPopup.classList.add('hide');
		freeGoods.classList.add('hide');
		slyshKupi.classList.add('hide');
	});
	UpdateGifts();
    //#endregion gifts
    
    //#region slider bonuses
	const SliderBonuses = () =>
	{
		const slider = document.querySelector('.range-slider');
		if(slider)
		{
			const maxRange = Number(document.querySelector('.bonuses__data').dataset.bonuses_exist);
			const onSliderOutputInput = evt=>slider.noUiSlider.set(evt.target.value);
			const sliderOutput = document.querySelector('.bonuses__data--small input');
			sliderOutput.addEventListener('input', onSliderOutputInput);
			noUiSlider.create(slider,
			{
				start: [0],
				connect: 'lower',
				range:
				{
					'min': [0],
					'max': [maxRange]
				}
			});
			slider.noUiSlider.on('update', function (values, handle)
			{
				if (handle === 0)
					sliderOutput.value = Math.round(values[handle]);
			});

			const bonusesApplyBtn = document.querySelector('.bonuses__spend-button');
			const bonusesApply = evt =>
			{
				evt.preventDefault();
				renderPrice();
			}
			bonusesApplyBtn.addEventListener('click', bonusesApply);

			const priceContainer = document.querySelector('.order-form__total');
			const actualPrice = document.querySelector('.order-form__total-price--important');
			const priceBleat = document.querySelector('.jsPriceBleat');
			const newPrice = document.querySelector('.order-form__total-price--new');
			const renderPrice = () =>
			{
				const bonuses = Number(document.querySelector('.bonuses__data--small input').value);
				const price = Number(priceContainer.dataset.price) - bonuses;
				if(bonuses > 0)
				{
					priceBleat.classList.add('order-form__total-price--old');
					newPrice.classList.remove('hide');
					actualPrice.innerHTML = price.toLocaleString() + ' руб.';
				}
				else
				{
					priceBleat.classList.remove('order-form__total-price--old');
					actualPrice.innerHTML = price.toLocaleString() + ' руб.';
					newPrice.classList.add('hide');
				}
			}
		}
	}
	SliderBonuses();
    //#endregion slider bonuses

    //#region input date
	const InputDate = () =>
	{
		const dateInput = document.querySelector('#date');
		const timeInput = document.querySelector('#time');
		if(dateInput && timeInput)
		{
			flatpickr(dateInput, {
				"locale": "ru",
				dateFormat: "d.m.Y",
				minDate: 'today',
				maxDate: new Date().fp_incr(14) // 14 days from now
			});
			flatpickr(timeInput, {
				"locale": "ru",
				enableTime: true,
				noCalendar: true,
				dateFormat: "H:i",
				minDate: "10:30",
				maxDate: "23:30",
				time_24hr: true
			});
		}
	}
	InputDate();
	//#endregion input date

    //#region Order
	// const orderTabs = document.querySelector('.orderTabs');
	// const addPromo = document.querySelector('#addPromo');
	const orderFrom = document.querySelector('#orderForm');
	const orderFormFast = document.querySelector('#orderFormFast');
	let parser = new DOMParser();
	const UpdateOrder = () =>
	{
		fetch('/order/', {method: 'POST'})
		.then(response =>
		{
			if(response.ok)
				return response.text();
			else
				document.location.reload(true);
		})
		.then(text =>
		{
			let resp = parser.parseFromString(text, "text/html");
			let newOrderForm = resp.querySelector('#orderForm');
			orderForm.innerHTML = newOrderForm.innerHTML;
			SliderBonuses();
			InputDate();
			LoadingIcon.Hide();
		});
	}
	if(orderFrom)
	{		
		const OrderFormHandler = (e) =>
		{
			e.preventDefault();
			LoadingIcon.Show();
			const form = e.target;
			const formData = new FormData(form);
			let promocode = formData.get('promocode');
			if(promocode && promocode.length > 0)
			{
				formData.append('addCoupon', 'true');
				formData.set('addOrder', '');
			}
			fetch('/local/inc_files/order.php', {method: form.method, body: formData})
			.then(response=>
			{
				if(response.ok)
				{
					if(promocode && promocode.length > 0)
						UpdateOrder();
					else
						return response.text();
				}
				else
				{
					alert('Server response with error? Please Try again.\nОшибка сервера, пожалуйста попробуйте еще раз.');
					document.location.reload();
				}
			})
			.then(text =>
			{
				LoadingIcon.Hide();
				let parser = new DOMParser();
				let resp = parser.parseFromString(text, "text/html");
				let orderErrors = resp.querySelector('#orderErrors');
				let newUser = resp.querySelector('#newUser');
				let btn = form.querySelector('.jsFormSubmit');
				let thanksHref = '/order/thanks/';
				if(form.name == 'fastOrder')
					thanksHref += '?fast_order=true';
				if(newUser)
					thanksHref += '?new_user=true';
				if(orderErrors)
					ShowTooltip(btn, orderErrors.innerHTML, 5000);
				else
					window.location.href = thanksHref;
			});
		}
		orderFrom.addEventListener('submit', OrderFormHandler);
		orderFormFast.addEventListener('submit', OrderFormHandler);
		document.addEventListener('updateBasketEvent', UpdateOrder);
	}
	
	//#endregion Order
	// document.addEventListener('mouseover', (e)=>
	// {
	// 	console.log(e);
	// });
	//#region account
	let accEditable = document.querySelectorAll('.accEditable');
	let editAccDataBtn = document.querySelector('#editAccData');
	let accEditSaveBtn = document.querySelector('#accEditSave');
	let accEditInputs = document.querySelectorAll('.accEditInput');
	let passEditInputs = document.querySelectorAll('.passEditInput');
	let editAccPassSaveBtn = document.querySelector('#editAccPassSave');
	let editAccPassBtn = document.querySelector('#editAccPass');

	const AccEditSaveHandler = () =>
	{
		LoadingIcon.Show();
		let formData = new FormData();
		formData.append('save', 'true');
		accEditInputs.forEach(el => formData.append(el.name, el.value));
		fetch('/profile/', {method: 'POST', body: formData})
		.then(response =>
		{
			if(response.ok)
				document.location.reload(true);
		});
		LoadingIcon.Hide();
	}
	const EditAccDataHandler = () =>
	{
		accEditable.forEach(el => el.classList.add('hide'));
		editAccDataBtn.classList.add('hide');
		accEditSaveBtn.classList.remove('hide');
		accEditInputs.forEach(el => el.classList.remove('hide'));
		accEditSaveBtn.addEventListener('click', AccEditSaveHandler);
	}
	const EditAccPassHandler = () =>
	{
		LoadingIcon.Show();
		if(passEditInputs[0].value !== passEditInputs[1].value)
		{
			alert('Пароли не совпадают');
			passEditInputs[0].value = '';
			passEditInputs[1].value = '';
			LoadingIcon.Hide();
			return;
		}
		let formData = new FormData();
		formData.append('save', 'true');
		passEditInputs.forEach(el => formData.append(el.name, el.value));
		fetch('/profile/', {method: 'POST', body: formData})
		.then(response =>
		{
			if(response.ok)
				return response.text();
		})
		.then(text=>
		{
			let parser = new DOMParser();
			let resp = parser.parseFromString(text, "text/html");
			let passValidError = resp.querySelector('#passValidError');
			if(passValidError)
			{
				LoadingIcon.Hide();
				alert('Пароль не соответствует требованиям. Пароль должен быть не менее 6 символов и должен содержать, как минимум одну букву и одну цифру, буквы допускаются только английские.');
				passEditInputs[0].value = '';
				passEditInputs[1].value = '';
			}
			else
			{
				LoadingIcon.Hide();
				alert('Новый пароль успешно сохранён.');
				document.location.reload(true);
			}
		});
	}
	const EditAccPassBtnHandler = () =>
	{
		passEditInputs.forEach(el => el.classList.remove('hide'));
		editAccPassSaveBtn.classList.remove('hide');
		editAccPassBtn.classList.add('hide');
		editAccPassSaveBtn.addEventListener('click', EditAccPassHandler);
	}
	if(editAccDataBtn)
	{
		editAccDataBtn.addEventListener('click', EditAccDataHandler);
		editAccPassBtn.addEventListener('click', EditAccPassBtnHandler);
	}
	//#endregion account

	/**
	 * Находит первого родителя у которого есть переданый класс. Возвращает елемент как ноду или undefined 
	 * @node {node} Элемент
	 * @className {string} Класс искомого родителя
	 */
	const FindParentWithClass = (node, className)=>
	{
		if(node.parentNode === null)
			return undefined;
		if(node.parentNode.classList.contains(className))
			return node.parentNode;
		return FindParentWithClass(node.parentNode, className);
	}

	//#region pizza
	const pizza_exist = document.querySelector('.pizza_exist');
	if(pizza_exist)
	{
		const pizzaSizeBtns = document.querySelectorAll('.jsPizzaSizeBtn');
		const PizzaChange = (nodeList, id) =>
		{
			nodeList.forEach(node=>
			{
				if (node.classList.contains(`id${id}`)) node.classList.remove('hide');
				else node.classList.add('hide');
			});
		}
		const PizzaBtnHandlers = (event) =>
		{
			let btn = event.currentTarget;
			let pizzaId = btn.dataset.id;
			if(btn.classList.contains('activeSize'))
				return;
			btn.classList.add('activeSize');
			if(btn.previousElementSibling === null)
				btn.nextElementSibling.classList.remove('activeSize');
			else
				btn.previousElementSibling.classList.remove('activeSize');
			let pizzaCatalogItem = FindParentWithClass(btn, 'jsCatalogItem');
			let pizzaPrices = pizzaCatalogItem.querySelectorAll('.jsPizzaPrice');
			pizzaCatalogItem.querySelector('.jsItemWeight').innerText = btn.dataset.weight;
			let pizzaBuyBtns = pizzaCatalogItem.querySelectorAll('.jsPizzaBuyBtn');
			PizzaChange(pizzaPrices, pizzaId);
			PizzaChange(pizzaBuyBtns, pizzaId);
		}
		pizzaSizeBtns.forEach(btn=>btn.addEventListener('click', PizzaBtnHandlers));
	}
	//#endregion pizza

	// let vkShareBtns = document.querySelectorAll('.vkShareBtn');
	// if(vkShareBtns)
	// {
	// 	vkShareBtns.forEach(btn=>
	// 	{
	// 		btn.innerHTML = btn.innerHTML + VK.Share.button(window.location.href, {type: 'link'});
	// 	});
	// }
});