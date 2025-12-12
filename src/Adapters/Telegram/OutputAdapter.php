<?php

namespace TgBotCore\Adapters\Telegram;

use TgBotCore\Contracts\iOutputAdapter;	// OutputAdapter interface
use TgBotCore\Contracts\iMessage;

/**
 * 
 */
class OutputAdapter implements iOutputAdapter
{
	protected $token;
	
	public function __construct(string $token) {
		$this->token = $token;
	}

	public function getRequestUrl($method) : string {
		return 'https://api.telegram.org/bot' . $this->token . '/' . $method;
	}

	public function sendMessage(iMessage $Message) {
		$url = $this->getRequestUrl('sendMessage');
		$data = $this->convertMessageToData($Message);

		return $this->curl($url, $data);
	}

	public function convertMessageToData($Message) : array {
		$result = [
			"chat_id"	=> $Message->getChatID(),
			"text"		=> $Message->getText()
		];
		echo "<pre>";
		print_r('BotKernel::convertMessageToData()' . "\n");
		print_r($result);
		echo "</pre>";
		return $result;
	}

	public function curl(string $url, array $data) {

		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_POST => 1,
			CURLOPT_HEADER => 0,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $url,
			CURLOPT_POSTFIELDS => json_encode($data, JSON_UNESCAPED_UNICODE),
			// CURLOPT_POSTFIELDS => json_encode($data),
			CURLOPT_HTTPHEADER => array_merge(array("Content-Type: application/json"))
		]);
		$result = curl_exec($curl);
		curl_close($curl);
		echo "<pre>";
		print_r('BotKernel::curl()' . "\n");
		print_r(json_decode($result, true));
		echo "</pre>";
		return (($return = json_decode($result, true)) ? $return : $result);
	}
}