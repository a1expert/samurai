<?



/*function OnAfterIBlockElementAddHandler(&$arFields)
{
	
	if($arFields['IBLOCK_ID'] == 1 && !empty($arFields['ID']))
	{
		$arFilter = Array('IBLOCK_ID'=>$arFields['IBLOCK_ID'], 'ID'=>$arFields['ID']);
		$arSelect = Array('ID', 'IBLOCK_ID', 'NAME');
		$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
		while($ob = $res->GetNextElement())
		{
			$arItem = $ob->GetFields();
			$arEventFields  = array('TEXT'=>$arItem['NAME']);
		}
		if(!empty($arEventFields))
		{
			switch ($arFields['IBLOCK_ID'])
			{
				case 17:
					$event = 'CALLBACK';
					break;
				case 20:
					$event = 'SELECTABLE_FORM';
					break;
				default:
					break;
			}
        }
        CEvent::Send('FEEDBACK', SITE_ID, $arEventFields);
		
	}
}
?>*/