<?
// function OnAfterIBlockElementAddHandler(&$arFields)
// {
	
// 	if(in_array($arFields['IBLOCK_ID'], array(17, 20)) && !empty($arFields['ID']))
// 	{
// 		$arFilter = Array('IBLOCK_ID'=>$arFields['IBLOCK_ID'], 'ID'=>$arFields['ID']);
// 		$arSelect = Array('ID', 'IBLOCK_ID', 'NAME', 'PROPERTY_PHONE');
// 		$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
// 		while($ob = $res->GetNextElement())
// 		{
// 			$arItem = $ob->GetFields();
// 			$arEventFields  = array('NAME'=>$arItem['NAME'], 'ELEMENT_NAME'=>$arItem['NAME'], 'PHONE' => $arItem['PROPERTY_PHONE_VALUE']);
// 		}
// 		if(!empty($arEventFields))
// 		{
// 			switch ($arFields['IBLOCK_ID'])
// 			{
// 				case 17:
// 					$event = 'CALLBACK';
// 					break;
// 				case 20:
// 					$event = 'SELECTABLE_FORM';
// 					break;
// 				default:
// 					break;
// 			}
			
// 			CEvent::Send($event, SITE_ID, $arEventFields);
// 		}
// 	}
// }
?>