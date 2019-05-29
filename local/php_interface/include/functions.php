<?
/**
 * @var принтуемый массив
 * @mode по умолчанию тру = испольщуется print_r. false = используется var_dump
 * @show режим показа на странице по умолчанию true = показывать. false = скроет результат работы со страницы но оставинт просмотр в инструментах разработчика во вкладке Элементы (Elements)
 */
function ShowRes($var, $mode = true, $show = true)
{
    echo '<style>pre{background-color:#000000;color:#1ace38;font-size:14px;width:100%;max-width:1200px;margin:0 auto;padding:30px;height:900px;overflow:scroll;}</style>';
    echo (($show) ? '<pre>' : '<pre style="display:none;">');
    if ($mode)
    {
        print_r($var);
    }else
    {
        var_dump($var);
    }
    echo '</pre>';
}

/**
* Проверяет есть ли меню.
* @param string $strSectionMenuType название типа меню.
* @param bool $useExtFiles учитывать файлы menu_ext.php.
* @return bool Возвращает false при отсутствии файла меню или отсутствии в нем пунктов.
*/
function isSectionMenu($strSectionMenuType = 'left', $useExtFiles = true)
{
    global $APPLICATION;
    $strSectionDir = (isset($_SERVER['REAL_FILE_PATH'])) ? dirname($_SERVER['REAL_FILE_PATH']) : dirname($_SERVER['SCRIPT_NAME']);
    $arPath = explode('/', $strSectionDir);
    $arPath = array_diff($arPath, array(''));
    $rootPath = realpath($_SERVER['DOCUMENT_ROOT']);
    $currentPath = '/';
    $lastPath = '';
 
    
    $arLastMenu = array();
    foreach ($arPath as $key => $crumb)
    {
        $currentPath .= $crumb . '/';
        $menuFile = $rootPath . $currentPath . '.' . $strSectionMenuType . '.' . 'menu.php';
        $extMenuFile = $rootPath . $currentPath . '.' . $strSectionMenuType . '.' . 'menu_ext.php';
        
        if(file_exists($menuFile))
        {
            $lastPath = $currentPath;
            require($menuFile);
            $arLastMenu = $aMenuLinks;
        }
        if(file_exists($extMenuFile))
        {
            $lastPath = $currentPath;
            require($extMenuFile);
            if($aMenuLinksExt)
                $aMenuLinks = array_merge($aMenuLinksExt, $aMenuLinks);
            $arLastMenu = $aMenuLinks;
        }
    }

    return (count($arLastMenu) > 0) ? true : false;

 }
