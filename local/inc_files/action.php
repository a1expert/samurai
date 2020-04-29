<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
// throw new Exception("Error Processing Request", 1);

use A1expert\Basket;
$id = $_GET['id'];
if($_GET['action'] == 'add')
{
    $res = Basket::Add($id);
    ShowRes($res);
    return $res;
}
if($_GET['action'] == 'update')
{
    if(!is_numeric($_GET['quant']))
        return http_response_code(406);
    $res = Basket::Update($id, $_GET['quant']);
}
if($_GET['action'] == 'remove')
    Basket::Remove($id);
if($_GET['action'] == 'wok')
    Basket::Wok($_GET['result']);
