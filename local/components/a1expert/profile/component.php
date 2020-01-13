<?
/**
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @global CUserTypeManager $USER_FIELD_MANAGER
 * @var array $arParams
 * @var CBitrixComponent $this
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)die();
global $USER_FIELD_MANAGER;
$arResult["ID"] = intval($USER->GetID());
$strError = '';
if($_SERVER["REQUEST_METHOD"] == "POST" && ($_REQUEST["save"] != '' || $_REQUEST["apply"] != ''))
{
	if(COption::GetOptionString('main', 'use_encrypted_auth', 'N') == 'Y')
	{
		//possible encrypted user password
		$sec = new CRsaSecurity();
		if(($arKeys = $sec->LoadKeys()))
		{
			$sec->SetKeys($arKeys);
			$errno = $sec->AcceptFromForm(array('NEW_PASSWORD', 'NEW_PASSWORD_CONFIRM'));
			if($errno == CRsaSecurity::ERROR_SESS_CHECK)
				$strError .= GetMessage("main_profile_sess_expired").'<br />';
			elseif($errno < 0)
				$strError .= GetMessage("main_profile_decode_err", array("#ERRCODE#"=>$errno)).'<br />';
		}
	}
	if($strError == '')
	{
		$bOk = false;
		$obUser = new CUser;
		$rsUser = CUser::GetByID($arResult["ID"]);
		$arUser = $rsUser->Fetch();
		$arEditFields = array(
			"NAME",
			"LAST_NAME",
			"PERSONAL_PHONE",
		);
		$arFields = array();
		foreach($arEditFields as $field)
			if(isset($_REQUEST[$field]))
				$arFields[$field] = $_REQUEST[$field];
		if($USER->IsAdmin() && isset($_REQUEST["ADMIN_NOTES"]))
			$arFields["ADMIN_NOTES"] = $_REQUEST["ADMIN_NOTES"];
		if($_REQUEST["NEW_PASSWORD"] != '')
		{
			$passRE = "/(?=.*[0-9])(?=.*[a-z])[0-9a-z]{6,}/i";
			if(preg_match($passRE, $_REQUEST['NEW_PASSWORD']) == false)
				$arResult['passValidError'] = true;
			else
			{
				$arFields["PASSWORD"] = $_REQUEST["NEW_PASSWORD"];
				$arFields["CONFIRM_PASSWORD"] = $_REQUEST["NEW_PASSWORD_CONFIRM"];
			}
		}
		if($arUser)
		{
			if($arUser['EXTERNAL_AUTH_ID'] != '')
				$arFields['EXTERNAL_AUTH_ID'] = $arUser['EXTERNAL_AUTH_ID'];
		}
		$USER_FIELD_MANAGER->EditFormAddFields("USER", $arFields);
		if($obUser->Update($arResult["ID"], $arFields))
		{
			if($arResult["PHONE_REGISTRATION"] == true && $arFields["PHONE_NUMBER"] != '')
			{
				if(!($phone = \Bitrix\Main\UserPhoneAuthTable::getRowById($arResult["ID"])))
					$phone = ["PHONE_NUMBER" => "", "CONFIRMED" => "N"];
				$arFields["PHONE_NUMBER"] = \Bitrix\Main\UserPhoneAuthTable::normalizePhoneNumber($arFields["PHONE_NUMBER"]);
				if($arFields["PHONE_NUMBER"] != $phone["PHONE_NUMBER"] || $phone["CONFIRMED"] != 'Y')
				{
					//added or updated the phone number for the user, now sending a confirmation SMS
					list($code, $phoneNumber) = CUser::GeneratePhoneCode($arResult["ID"]);
					$sms = new \Bitrix\Main\Sms\Event(
						"SMS_USER_CONFIRM_NUMBER",
						[
							"USER_PHONE" => $phoneNumber,
							"CODE" => $code,
						]
					);
					$smsResult = $sms->send(true);
					if(!$smsResult->isSuccess())
						$strError .= implode("<br />", $smsResult->getErrorMessages());
					$arResult["SHOW_SMS_FIELD"] = true;
					$arResult["SIGNED_DATA"] = \Bitrix\Main\Controller\PhoneAuth::signData(['phoneNumber' => $phoneNumber]);
				}
			}
		}
		else
		{
			$strError .= $obUser->LAST_ERROR;
		}
	}
	
	if($strError == '')
	{
		if($arParams['SEND_INFO'] == 'Y')
			$obUser->SendUserInfo($arResult["ID"], SITE_ID, GetMessage("main_profile_update"), true);
		$bOk = true;
	}
}
// verify phone code
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_REQUEST["code_submit_button"] != '')
{
	if($_REQUEST["SIGNED_DATA"] != '')
	{
		if(($params = \Bitrix\Main\Controller\PhoneAuth::extractData($_REQUEST["SIGNED_DATA"])) !== false)
		{
			if(($userId = CUser::VerifyPhoneCode($params['phoneNumber'], $_REQUEST["SMS_CODE"])))
				$bOk = true;
			else
			{
				$strError .= GetMessage("main_profile_sms_error")."<br />";
				$arResult["SHOW_SMS_FIELD"] = true;
				$arResult["SMS_CODE"] = $_REQUEST["SMS_CODE"];
				$arResult["SIGNED_DATA"] = $_REQUEST["SIGNED_DATA"];
			}
		}
	}
}
$rsUser = CUser::GetByID($arResult["ID"]);
if(!$arResult["arUser"] = $rsUser->GetNext(false))
	$arResult["ID"] = 0;
$arResult["arUser"]["PHONE_NUMBER"] = "";
if($arResult["PHONE_REGISTRATION"])
{
	if($phone = \Bitrix\Main\UserPhoneAuthTable::getRowById($arResult["ID"]))
		$arResult["arUser"]["PHONE_NUMBER"] = htmlspecialcharsbx($phone["PHONE_NUMBER"]);
}
$arResult["FORM_TARGET"] = $APPLICATION->GetCurPage();
$arResult["IS_ADMIN"] = $USER->IsAdmin();
$arResult['CAN_EDIT_PASSWORD'] = $arUser['EXTERNAL_AUTH_ID'] == '' || in_array($arUser['EXTERNAL_AUTH_ID'], $arParams['EDITABLE_EXTERNAL_AUTH_ID'], true);
$arResult["strProfileError"] = $strError;
$arResult["DATE_FORMAT"] = CLang::GetDateFormat("SHORT");
$arResult["COOKIE_PREFIX"] = COption::GetOptionString("main", "cookie_name", "BITRIX_SM");
if (strlen($arResult["COOKIE_PREFIX"]) <= 0) 
	$arResult["COOKIE_PREFIX"] = "BX";
// ********************* User properties ***************************************************
$arResult["USER_PROPERTIES"] = array("SHOW" => "N");
if (!empty($arParams["USER_PROPERTY"]))
{
	$arUserFields = $USER_FIELD_MANAGER->GetUserFields("USER", $arResult["ID"], LANGUAGE_ID);
	if (count($arParams["USER_PROPERTY"]) > 0)
	{
		foreach ($arUserFields as $FIELD_NAME => $arUserField)
		{
			if (!in_array($FIELD_NAME, $arParams["USER_PROPERTY"]))
				continue;
			$arUserField["EDIT_FORM_LABEL"] = strLen($arUserField["EDIT_FORM_LABEL"]) > 0 ? $arUserField["EDIT_FORM_LABEL"] : $arUserField["FIELD_NAME"];
			$arUserField["EDIT_FORM_LABEL"] = htmlspecialcharsEx($arUserField["EDIT_FORM_LABEL"]);
			$arUserField["~EDIT_FORM_LABEL"] = $arUserField["EDIT_FORM_LABEL"];
			$arResult["USER_PROPERTIES"]["DATA"][$FIELD_NAME] = $arUserField;
		}
	}
	if (!empty($arResult["USER_PROPERTIES"]["DATA"]))
		$arResult["USER_PROPERTIES"]["SHOW"] = "Y";
	$arResult["bVarsFromForm"] = ($strError == ''? false : true);
}
// ******************** /User properties ***************************************************
if($bOk) 
	$arResult['DATA_SAVED'] = 'Y';
$arResult["TIME_ZONE_ENABLED"] = CTimeZone::Enabled();
if($arResult["TIME_ZONE_ENABLED"])
	$arResult["TIME_ZONE_LIST"] = CTimeZone::GetZones();
//secure authorization
$arResult["SECURE_AUTH"] = false;
if(!CMain::IsHTTPS() && COption::GetOptionString('main', 'use_encrypted_auth', 'N') == 'Y')
{
	$sec = new CRsaSecurity();
	if(($arKeys = $sec->LoadKeys()))
	{
		$sec->SetKeys($arKeys);
		$sec->AddToForm('form1', array('NEW_PASSWORD', 'NEW_PASSWORD_CONFIRM'));
		$arResult["SECURE_AUTH"] = true;
	}
}
$this->IncludeComponentTemplate();