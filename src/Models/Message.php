<?php

/* Namespace */
namespace TgBotCore\Models;

/* Interfaces */
use TgBotCore\Contracts\iMessage;

/* Classes */


/**
 * 
 */
class Message implements iMessage
{
	protected $data;
	protected $chatID;

	public function __construct() {
		$lvl = BotKernelDebug();
	}

	public function setText($data) {
		$lvl = BotKernelDebug();
		$this->data = $data;
	}
	public function setChatPID($chatID) {
		$lvl = BotKernelDebug();
		$this->chatID = $chatID;
	}

	public function getText() {
		$lvl = BotKernelDebug();
		return $this->data;
	}
	public function getChatPID() {
		$lvl = BotKernelDebug();
		return $this->chatID;
	}
}