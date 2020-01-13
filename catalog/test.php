<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
if(!empty($_POST))
    ShowRes($_POST);
?>

<form action="/catalog/test.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="name1" value="fgh">
    <input type="text" name="name">
    <input type="text" name="name">
    <input type="text" name="name">
    <input type="text" name="name">
    <input type="text" name="name">
    <button type="submit">go!</button>
</form>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>