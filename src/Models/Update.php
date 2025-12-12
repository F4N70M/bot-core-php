<?php

/* Namespace */
namespace TgBotCore\Models;

/* Interfaces */
use TgBotCore\Contracts\iUpdate;
use TgBotCore\Contracts\iUser;
use TgBotCore\Contracts\iChat;

/* Classes */
use TgBotCore\Models\User;
use TgBotCore\Models\Chat;


/**
 * 
 */
class Update implements iUpdate
{
	protected $data;

	protected $Chat;
	
	public function __construct(array $standartData) {
		$this->data = $standartData;
	}

	public function getRawData() : array {
		return $this->data["meta"]["raw_data"];
	}

	public function getChat() : iChat {
		if (!($this->Chat instanceof iChat)) {
			$this->Chat = new Chat($this->data["chat"]);
		}
		return $this->Chat;
	}
}