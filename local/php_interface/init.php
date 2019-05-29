<?
require_once("include/constants.php");
require_once('include/functions.php');

\Bitrix\Main\Loader::registerAutoLoadClasses(
    null,
    array(
        "A1expert\Fixer" => "/local/php_interface/include/a1expert/fixer.php",
        'PHPMailer\PHPMailer\PHPMailer' => '/local/php_interface/include/PHPMailer/src/PHPMailer.php',
        'PHPMailer\PHPMailer\Exception' => '/local/php_interface/include/PHPMailer/src/Exception.php',
        'PHPMailer\PHPMailer\SMTP' => '/local/php_interface/include/PHPMailer/src/SMTP.php',
        "A1expert\Cities" => "/local/php_interface/include/a1expert/cities.php",
    )
);

// function custom_mail($to, $subject, $message, $additional_headers, $additional_parameters)
// {
//     //парсим дополнительные заголовки в массив (опционально)
//     /*Ключи заголовков Array([From],[CC],[Reply-To],[X-EVENT_NAME],[X-Priority],[Date],[X-MID])*/
//     $arHeaders = [];
//     if (!empty($additional_headers)) {
//         $explode = explode("\n", $additional_headers);
//         foreach ($explode as $strHeader) {
//             if (preg_match('/^([^\:]+)\:(.*)$/', $strHeader, $matches)) {
//                 $key = trim($matches[1]);
//                 $value = trim($matches[2]);
//                 $arHeaders[$key] = $value;
//             }
//         }
//     }
//     $mail = new PHPMailer\PHPMailer\PHPMailer();
//     try {
//         //Server settings
//         //$mail->SMTPDebug = 4; 
//         $mail->isSMTP();                                  // Set mailer to use SMTP
//         $mail->Host = 'smtp.mail.ru';                     // Specify main and backup SMTP servers
//         $mail->SMTPAuth = true;                           // Enable SMTP authentication
//         $mail->Username = 'remont-avto86@mail.ru';        // SMTP username
//         $mail->Password = 'NKhPt7nu3ettWVm';                  // SMTP password
//         $mail->Port = 465;                                // SSL port to connect to
//         $mail->SMTPSecure = 'ssl';
//         $mail->CharSet = 'UTF-8';

//         //Recipients
//         $mail->setFrom('remont-avto86@mail.ru');
//         // $mail->addReplyTo('manager@koreamarket.su'); //адрес ответа на письмо
//         foreach (explode(',', $to) as $email) {
//             $email = trim($email);
//             if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
//                 $mail->addAddress($email);
//             }
//         }


//         //Content
//         $mail->isHTML(true);
//         $mail->Subject = $subject;
//         $mail->Body    = $message; 

//         $mail->send();
//     } catch (Exception $e) {
//         // если все пошло по п..., то отправяем обычным способом 
//         if($additional_parameters!="")
//             return @mail($to, $subject, $message, $additional_headers, $additional_parameters);

//         return @mail($to, $subject, $message, $additional_headers);
//     }
// }

// AddEventHandler("main", "OnAfterEpilog", "Prefix_FunctionName");
// AddEventHandler("iblock", "OnAfterIBlockElementAdd", "OnAfterIBlockElementAddHandler");
require_once('include/eventHandlers.php');
?>