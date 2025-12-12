<?php

namespace TgBotCore\Adapters\Telegram;

use TgBotCore\Contracts\iInputAdapter;
use TgBotCore\Contracts\iUpdate;

use TgBotCore\Models\Update;
use TgBotCore\Models\User;

/**
 * 
 */
class InputAdapter implements iInputAdapter
{
	protected $platform = "telegram";
	
	public function __construct() {
	}

	public function convertToStandartUpdate(array $rawData) : iUpdate {
		// echo "<pre>";
		// 	print_r('InputAdapter::convertToStandartUpdate()' . "\n");
		// 	print_r($rawData);
		// echo "</pre>";

		$standartData = $this->convertToStandartData($rawData);
		$Update = new Update($standartData);
		return $Update;
	}

	public function convertToStandartData($rawData) : array {
		$standartData = [];
		$standartData["timestamp"] = time();
		$standartData["platform"] = $this->platform;
		$standartData["id"] = $rawData["update_id"];
		$standartData["type"] = $this->getUpdateType($rawData);
		$standartData["chat"] = $this->getUpdateChat($rawData);
		$standartData["from"] = $this->getUpdateFrom($rawData);
		$standartData["content"] = $this->getUpdateContent($rawData);
		$standartData["meta"] = $this->getUpdateMeta($rawData);
		echo "<pre>";
			print_r("InputAdapter::convertToStandartData()" . "\n");
			print_r($rawData);
			print_r($standartData);
		echo "</pre>";
		return $standartData;
	}

	protected function getUpdateType($rawData) : string {
		if (isset($rawData['message'])) {
			return "message";
		} elseif (isset($rawData['callback_query'])) {
			return "callback";
		}
		throw new Exception("Тип обновления не определен");
	}

	protected function getUpdateChat($rawData) : array {

		if (isset($rawData['message'])) {
			$rawChat = $rawData['message']['chat'];
		} elseif (isset($rawData['callback_query'])) {
			$rawChat = $rawData['callback_query']['chat'];
		}

		$chat = [];
		$chat["id"] = $rawChat["id"];
		$chat["type"] = $rawChat["type"];
		$chat["username"] = array_key_exists("username", $rawChat) ? $rawChat["username"] : null;
		$chat["first_name"] = array_key_exists("first_name", $rawChat) ? $rawChat["first_name"] : null;
		$chat["last_name"] = array_key_exists("last_name", $rawChat) ? $rawChat["last_name"] : null;


		return $chat;
	}

	protected function getUpdateFrom($rawData) : array {

		if (isset($rawData['message'])) {
			$rawFrom = $rawData['message']['from'];
		} elseif (isset($rawData['callback_query'])) {
			$rawFrom = $rawData['callback_query']['from'];
		}

		$from = [];
		$from["id"] = $rawFrom["id"];
		$from["is_bot"] = array_key_exists("is_bot", $rawFrom) ? $rawFrom["is_bot"] : null;
		$from["username"] = array_key_exists("username", $rawFrom) ? $rawFrom["username"] : null;
		$from["first_name"] = array_key_exists("first_name", $rawFrom) ? $rawFrom["first_name"] : null;
		$from["last_name"] = array_key_exists("last_name", $rawFrom) ? $rawFrom["last_name"] : null;
		$from["is_premium"] = array_key_exists("is_premium", $rawFrom) ? $rawFrom["is_premium"] : null;
		$from["language"] = array_key_exists("language_code", $rawFrom) ? $rawFrom["language_code"] : null;

		return $from;
	}

	protected function getUpdateContent($rawData) : array {
		$content = [];
		return $content;
	}

	protected function getUpdateMeta($rawData) : array {
		$meta = [];
		$meta["raw_data"] = $rawData;
		return $meta;
	}

}