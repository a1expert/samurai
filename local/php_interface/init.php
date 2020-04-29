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
        'A1expert\Basket' => '/local/php_interface/include/a1expert/Basket.php',
        'A1expert\CCatalogProductProviderCustom' => '/local/php_interface/include/a1expert/CCatalogProductProviderCustom.php'
    )
);

//Подгрузка всех обработчиков
//require_once('include/eventHandlers.php');

function DontDeleteWokHandler($ID)
{
    if($ID==WOK_ID)
        return false;
}

class ReviewHandler {
    // public function OnBeforeAdd(&$arFields)
    // {
    //     mail('klimin@a1-reklama.ru', 'Новый json', $arFields);
    //     return false;
    // }
    public function OnAfterAdd(&$arFields)
    {
        mail('klimin@a1-reklama.ru', 'Новый json', $arFields);
        if($arFields['IBLOCK_ID'] == 10 && !empty($arFields['ID']))
        {
            $arEventFields  = array(
                'NAME' => $arFields['NAME'],
                'PHONE' => $arFields['PHONE'],
                'EMAIL' => $arFields['EMAIL'],
                'TEXT' => $arFields['PREVIEW_TEXT'],
                'CITY' => (new Cities())->curCity['NAME'],
            );
            CEvent::Send('FEEDBACK', SITE_ID, $arEventFields);
        }
    }
}

// Запрет на удаление WOK
AddEventHandler('iblock', 'OnBeforeIBlockElementDelete', 'DontDeleteWokHandler');
AddEventHandler('iblock', 'OnAfterIBlockElementAdd', array('ReviewHandler', 'OnAfterAdd'));
// AddEventHandler('iblock', 'OnBeforeIBlockElementAdd', array('ReviewHandler', 'OnBeforeAdd'));

global $CML2_CURRENCY;
$CML2_CURRENCY['руб'] = 'RUB'; 
$CML2_CURRENCY['643'] = 'RUB'; 
$CML2_CURRENCY['590b5fc4-735a-11e6-ab45-d43d7e2c0d96'] = 'RUB'; 
$CML2_CURRENCY['Розничная цена'] = 'RUB'; 

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
// AddEventHandler("iblock", "OnAfterIBlockElementAdd", "OnAfterIBlockElementAddHandler");

// AddEventHandler("main", "OnAfterEpilog", "Prefix_FunctionName");
// AddEventHandler("iblock", "OnAfterIBlockElementAdd", "OnAfterIBlockElementAddHandler");


function custom_mail($to, $subject, $message, $additional_headers, $additional_parameters)
{
	$result = true;
	$tos = array(
		'administrator@barvikhaspa86.ru',
		'83593@mail.ru',
		'Imperil@yandex.ru',
	);
	foreach ($tos as $to) {
		$arHeaders = [];
		if (!empty($additional_headers)) {
			$explode = explode("\n", $additional_headers);
			foreach ($explode as $strHeader) {
				if (preg_match('/^([^\:]+)\:(.*)$/', $strHeader, $matches)) {
					$key = trim($matches[1]);
					$value = trim($matches[2]);
					$arHeaders[$key] = $value;
				}
			}
		}
		$mail = new PHPMailer\PHPMailer\PHPMailer();
		try {
			// Настройки SMTP
			$mail->isSMTP();
			$mail->SMTPAuth = true;
			$mail->SMTPDebug = 0;
			$mail->CharSet = "UTF-8";  
	
			$mail->Host = 'ssl://smtp.mail.ru';
			$mail->Port = 465;
			$mail->Username = 'remont-avto86@mail.ru';
			$mail->Password = 'NKhPt7nu3ettWVm';
	
			//Recipients
			$mail->setFrom('remont-avto86@mail.ru', 'Сытый Самурай');
			$mail->addAddress($to);
	
			//Content
			$mail->isHTML(true);
			$mail->Subject = $subject;
			//$mail->Body    = $message; 
			$mail->msgHTML(str_replace(PHP_EOL, '<br>', $message));

			if (!$mail->send()) {
				throw new Exception();
			}

		} catch (Exception $e) {
			$result = $result &&  @mail(
				$to, 
				$subject, 
				$message, 
				"MIME-Version: 1.0\nContent-Type: text/plain; charset=utf-8\nFrom: ".mb_encode_mimeheader('Сытый Самурай')." <remont-avto86@mail.ru>"
			);
		}
	}
	return $result;
}