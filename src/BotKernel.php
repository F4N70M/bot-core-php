<?php

namespace TgBotCore;

use TgBotCore\Contracts\iBotKernel;
use TgBotCore\Contracts\iInputAdapter;
use TgBotCore\Contracts\iOutputAdapter;
use TgBotCore\Contracts\iUpdate;
use TgBotCore\Contracts\iMessage;
use TgBotCore\Contracts\iDatabase;

use TgBotCore\Models\Message;
use TgBotCore\Services\Database\Database;
use TgBotCore\Exception;


/**
 * 
 */
class BotKernel implements iBotKernel
{
	protected $config;
	protected $InputAdapter;
	protected $OutputAdapter;

	protected $Database;
	
	function __construct(iInputAdapter $InputAdapter, iOutputAdapter $OutputAdapter, array $config) {
		$lvl = BotKernelDebug();

		$this->config = $config;
		
		$this->InputAdapter = $InputAdapter;
		$this->OutputAdapter = $OutputAdapter;
	}

	public function returnRawUpdateData() {
		$lvl = BotKernelDebug();
		$Update = $this->getUpdate();
		$rawData = $Update->getRawData();
		$Chat = $Update->getChat();
		$chatPID = $Chat->getPID();
		$Response = new Message();
		$Response->setText(print_r($rawData, true));
		$Response->setChatPID($chatPID);
		$result = $this->sendMessage($Response);
		return $result;
	}

	public function sendMessage(iMessage $Message) {	// Отправить сообщение
		$lvl = BotKernelDebug();
		
		return $this->OutputAdapter->sendMessage($Message);
	}

	public function getUpdate() : iUpdate {	// Получить объект Update из объекта iInputAdapter
		$lvl = BotKernelDebug();
		$rawData = json_decode(file_get_contents('php://input'), true);
		if (!is_array($rawData)) {
			$rawData = $this->getTestRawData();
			// throw new Exception("Нет данных обновления");
		}
		$Update = $this->InputAdapter->convertToStandartUpdate($rawData);
		$Update->setDatabase($this->getDatabase());
		return $Update;
	}

	public function getTestRawData() {
		$lvl = BotKernelDebug();
		return [
			"update_id" => 123456789,
			"message" => [
				"from" => [
					"id" => 440955330,
					"is_bot" => false,
					"first_name" => "Эд",
					"username" => "konard",
					"language_code" => "ru",
					"is_premium" => 1
				],
				"chat" => [
					"id" => 440955330,
					"first_name" => "Эд",
					"username" => "konard",
					"type" => "private"
				],
				"date" => 1764184940,
				"text" => "/start"
			]
		];
	}
	public function getDatabase() : iDatabase {	// Получить объект Database
		$lvl = BotKernelDebug();

		if ($this->Database === null) {
			$this->initDatabase();
		}

		return $this->Database;
	}

	public function setDatabase(iDatabase $Database) : void {
		$this->Database = $Database;
	}

	protected function initDatabase() : void {
		$lvl = BotKernelDebug();

		$credentials = $this->config["database"];
		if (
			!(
				isset($credentials["host"]) &&
				isset($credentials["user"]) &&
				isset($credentials["pass"]) &&
				isset($credentials["base"])
			)
		) {
			throw new Exception("Нет данных для подключения к базе данных");
		}

		$db = new Database();
		$db->setCredentials(
			$credentials["host"],
			$credentials["user"],
			$credentials["pass"],
			$credentials["base"]
		);

		$this->Database = $db;
	}
}