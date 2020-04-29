<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $APPLICATION;
if(empty($arResult))
	return "";
$strReturn = '';
$strReturn .= '<ul class="breadcrumbs page-intro__breadcrumbs" itemprop="http://schema.org/breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">';
$itemSize = count($arResult);
for($index = 0; $index < $itemSize; $index++)
{
	$link = ($index != $itemSize - 1) ? "href=\"{$arResult[$index]['LINK']}\"" : '';
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
	$strReturn .= '
			<li class="breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a '.$link.' title="'.$title.'" itemprop="url" class="breadcrumbs__link">'.$title.'</a>
				<meta itemprop="position" content="'.($index + 1).'" />
			</li>';
}
$strReturn .= '</ul>';
return $strReturn;
?>