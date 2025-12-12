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
	}

	public function setText($data) {
		$this->data = $data;
	}
	public function setChatID($chatID) {
		$this->chatID = $chatID;
	}

	public function getText() {
		return $this->data;
	}
	public function getChatID() {
		return $this->chatID;
	}
}