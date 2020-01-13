<?require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
use Bitrix\Main\Loader;
Loader::includeModule('iblock');
$el = new CIBlockElement;
$id = $el->Add(
[
    'IBLOCK_ID' => 10,
    'IBLOCK_SECTION_ID' => false,
    'ACTIVE' => 'Y',
    'NAME' => $_POST['name'],
    'PREVIEW_TEXT' => $_POST['comment'],
    'PROPERTY_VALUES' => [
        'PHONE'=>$_POST['phone'],
        'EMAIL'=>$_POST['email']
    ]
]);
return $id;