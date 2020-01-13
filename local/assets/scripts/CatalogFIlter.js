class CatalogFIlter
{
    constructor()
    {
        //кнопки
        this.filtersBtns = document.querySelectorAll('.jsFiltersBtn');
        // кнопка "Все"
        this.btnAll = document.querySelector('#all');
        //плитка / товары
        this.catalogItems = [...document.querySelectorAll('.jsCatalogItem')];
        //лейблы
		this.filterLabels = document.querySelectorAll('.jsFiltersLabel');
		//Конпки сортировки
		this.sortBtns = document.querySelectorAll('.filters__toggler');
        //значения текущего фильтра
		this.filterArray = [];
    }
    /**
     * @function Сравнеие двух масивов
     * @array array1 - массив для проверки
     * @array array2 - фильтруемый массив
     * @return возвращает true если все элементы фильтруемого массива есть в массиве для проверки, иначе false.
     */
    ArrayCompare = (array1, array2) =>
    {
        for (let i = 0; i < array2.length; i++)
            if(!array1.includes(array2[i]))
                return false;
        return true;
    }
    OnFilterChangeHandler = () =>
    {
        let tmpArray = [];
        this.catalogItems.forEach(item =>
        {
            const itemIds = item.dataset.sectionsid.split(',');
            if(this.ArrayCompare(itemIds, this.filterArray))
            {
                item.style.display = 'list-item';
                tmpArray = tmpArray.concat(itemIds);
            }
            else
                item.style.display = 'none';
        });
        this.filterLabels.forEach(label =>
        {
            if(tmpArray.indexOf(label.dataset.sectionid) < 0 && label.id !== 'labelAll')
                label.classList.add('disabledBtn');
            else
                label.classList.remove('disabledBtn');
        });
        
    }
    AllBtnHandler = () =>
    {
        this.catalogItems.forEach(item => item.style.display = 'list-item');
        this.filtersBtns.forEach(btn =>
        {
            btn.checked = (btn.dataset.sectionid == 'all') ? true : false;
        });
        this.filterLabels.forEach(label => label.classList.remove('disabledBtn'));
        this.filterArray = [];
    }
    /**
     * @EventHandler обработчик нажатия на кнопку фильтра
     * изменяет фильтруемый массив и запускает обработку изменение состояния фильтра onFilterChangeHandler.
     * Если нажата кнопка "Все" запускается свой обработчик
     */
    OnBtnChangeHandler = (e) =>
    {
        const id = e.target.dataset.sectionid;
        if(id == 'all')
            this.AllBtnHandler();
        else
        {
            this.btnAll.checked = false;
            if(e.target.checked)
                this.filterArray.push(id);
            else
                this.filterArray.splice(this.filterArray.indexOf(id), 1);
            this.OnFilterChangeHandler();
        }
	}
	SortNChangeClass = (btn, sortType) =>
	{
		btn.classList.add('filters__toggler--active');
		if(btn.classList.contains('filters__toggler--up'))
		{
			btn.classList.remove('filters__toggler--up');
			btn.classList.add('filters__toggler--down');
			this.catalogItems.sort((a, b) => parseInt(b.dataset[sortType]) - parseInt(a.dataset[sortType]));
		}
		else if(btn.classList.contains('filters__toggler--down'))
		{
			btn.classList.remove('filters__toggler--down');
			btn.classList.add('filters__toggler--up');
			this.catalogItems.sort((a, b) => parseInt(a.dataset[sortType]) - parseInt(b.dataset[sortType]));
		}
		else
		{
			btn.classList.add('filters__toggler--up');
			this.catalogItems.sort((a, b) => parseInt(a.dataset[sortType]) - parseInt(b.dataset[sortType]));
		}
	}

	OnSortBtnHandler = (e) =>
	{
		this.sortBtns.forEach(btn=>btn.classList.remove('filters__toggler--active'));
		this.SortNChangeClass(e.target, e.target.id);
		this.catalogItems.forEach((item, i) => {item.style.order = i;});
	}
    Execute = () =>
    {
		this.filtersBtns.forEach(btn => btn.addEventListener('change', this.OnBtnChangeHandler));
		this.sortBtns.forEach(btn => btn.addEventListener('click', this.OnSortBtnHandler));
    }
}


//dsffs
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