<?php

/* Namespace */
namespace TgBotCore\Models;

/* Interfaces */
use TgBotCore\Contracts\iChat;

/* Classes */


/**
 * 
 */
class Chat implements iChat
{
	protected $data;

	public function __construct($data) {
		$this->data = $data;
	}

	public function getId() {
		return $this->data["id"];
	}
}