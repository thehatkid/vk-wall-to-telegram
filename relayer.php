<?php

// VK Wall to Telegram channel Relayer
// by hat_kid (GitHub: @thehatkid), 2020

$request = file_get_contents("php://input");

if(!$request) {
	http_response_code(400);
	die();
}

$request = json_decode($request, true);

// Проверка секретного ключа
if(!isset($request["secret"]) || $request["secret"] !== "YourSecretCode") {
	http_response_code(400);
	die();
}

// Код подтверждения Callback API
define("CONFIRM_CODE", "1a2b3c4d");

// Токен Телеграм бота
define("BOT_TOKEN", "1234567890:AaBbCcDdEeFf1234567890-AaBbCcDdEeFf");

// Имя канала или Чат ID для отправки сообщение
define("CHAT_ID", "@yourchannelname");

function tgApiCall($method, $params = array()) {
	$ch = curl_init("https://api.telegram.org/bot" . BOT_TOKEN . "/" . $method);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	curl_close($ch);
	return json_decode($response, true);
}
function tgSendMessage($text, $url) {
	return tgApiCall("sendMessage", array(
		"chat_id" => CHAT_ID,
		"text" => $text,
		"reply_markup" => json_encode(array(
			"inline_keyboard" => [[
				[
					"text" => "Перейти к посту",
					"url" => $url
				]
			]]
		))
	));
}
function tgSendPhoto($photo, $caption = "", $url) {
	return tgApiCall("sendPhoto", array(
		"chat_id" => CHAT_ID,
		"photo" => $photo,
		"caption" => $caption,
		"reply_markup" => json_encode(array(
			"inline_keyboard" => [[
				[
					"text" => "Перейти к посту",
					"url" => $url
				]
			]]
		))
	));
}

switch($request["type"]) {
	case "confirmation":
		die(CONFIRM_CODE);
		break;
	case "wall_post_new":
		if($request["object"]["post_type"] == "post") { // Если тип поста был постинг
			$group_id = $request["group_id"];
			$wall_id = $request["object"]["id"];
			$wall_text = $request["object"]["text"];
			$wall_url = "https://vk.com/club{$group_id}?w=wall-{$group_id}_{$wall_id}";
			if(!empty($response["object"]["attachments"])) {
				if($response["object"]["attachments"][0]["type"] == "photo") {
					$lastsize = array_pop($response["object"]["attachments"][0]["photo"]["sizes"]);
					$wall_photourl = $lastsize["url"];
				} else {
					$wall_photourl = false;
				}
			} else {
				$wall_photourl = false;
			}
			if(!$wall_photourl) {
				tgSendMessage($wall_text, $wall_url); // Отправка сообщение
			} else {
				tgSendPhoto($wall_photourl, $wall_text, $wall_url); // Отправка картинки
			}
			die("ok");
		} else {
			die("ok");
		}
		break;
}

?>