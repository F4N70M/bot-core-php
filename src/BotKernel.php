<?php

namespace TgBotCore;

use TgBotCore\Contracts\iBotKernel;
use TgBotCore\Contracts\iInputAdapter;
use TgBotCore\Contracts\iOutputAdapter;
use TgBotCore\Contracts\iUpdate;
use TgBotCore\Contracts\iMessage;
use TgBotCore\Contracts\iDataBase;

use TgBotCore\Models\Message;

/**
 * 
 */
class BotKernel implements iBotKernel
{
	protected $InputAdapter;
	protected $OutputAdapter;
	
	function __construct(iInputAdapter $InputAdapter, iOutputAdapter $OutputAdapter) {
		$this->InputAdapter = $InputAdapter;
		$this->OutputAdapter = $OutputAdapter;
		echo "<pre>";
			print_r('BotKernel::__construct()' . "\n");
			print_r($this->InputAdapter);
			print_r($this->OutputAdapter);
		echo "</pre>";
	}

	public function returnRawUpdateData() {
		$Update = $this->getUpdate();
		$rawData = $Update->getRawData();
		$Chat = $Update->getChat();
		$chatID = $Chat->getID();
		$Response = new Message();
		$Response->setText(print_r($rawData, true));
		$Response->setChatID($chatID);
		$result = $this->sendMessage($Response);
		return $result;
	}

	public function sendMessage(iMessage $Message)		// Отправить сообщение
	{
		return $this->OutputAdapter->sendMessage($Message);
	}

	public function getUpdate() : iUpdate		// Получить объект Update из объекта iInputAdapter
	{

		// $rawData = json_decode(file_get_contents('php://input'), true);
		$rawData = $this->getTestRawData();
		$Update = $this->InputAdapter->convertToStandartUpdate($rawData);
		return $Update;
	}

	public function getTestRawData() {
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
				"text" => "test"
			]
		];
	}
	public function getDataBase() : iDataBase	// Получить объект DataBase
	{
	}
}