
class CatalogFIlter
{
    constructor()
    {
        //кнопки
        this.filtersBtns = document.querySelectorAll('.jsFiltersBtn');
        // кнопка "Все"
        this.btnAll = document.querySelector('#all');
        //плитка / товары
        this.catalogItems = document.querySelectorAll('.jsCatalogItem');
        //лейблы
        this.filterLabels = document.querySelectorAll('.jsFiltersLabel');
        //значения текущего фильтра
        this.filterArray = [];
    }
    /**
     * @function Сравнеие двух масивов
     * @array array1 - массив для проверки
     * @array array2 - фильтруемый массив
     * @return возвращает true если все элементы фильтруемого массива есть в массиве для проверки, иначе false.
     */
    arrayCompare = (array1, array2) =>
    {
        for (let i = 0; i < array2.length; i++)
            if(!array1.includes(array2[i]))
                return false;
        return true;
    }
    onFilterChangeHandler = () =>
    {
        let tmpArray = [];
        this.catalogItems.forEach(item =>
        {
            const itemIds = item.dataset.sectionsid.split(',');
            if(this.arrayCompare(itemIds, this.filterArray))
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
    onBtnChangeHandler = (e) =>
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
            this.onFilterChangeHandler();
        }
    }
    
    Execute = () =>
    {
        this.filtersBtns.forEach(btn => btn.addEventListener('change', this.onBtnChangeHandler));
    }
}
document.addEventListener('DOMContentLoaded', ()=>
{
    if(window.location.href.indexOf('catalog') > -1)
    {
        const catalogFilter = new CatalogFIlter();
        catalogFilter.Execute();
    }
});
