<?php

/* Namespace */
namespace TgBotCore\Models;

/* Interfaces */
use TgBotCore\Contracts\iUpdate;
use TgBotCore\Contracts\iDatabase;
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
	protected $Database;
	
	public function __construct(array $standartData) {
		$lvl = BotKernelDebug();

		$this->data = $standartData;
	}

	public function getPlatform() : string {
		$lvl = BotKernelDebug();
		return $this->data["platform"];
	}

	public function getRawData() : array {
		$lvl = BotKernelDebug();
		return $this->data["meta"]["raw_data"];
	}

	public function getChat() : iChat {
		$lvl = BotKernelDebug();

		if (!($this->Chat instanceof iChat)) {
			$this->Chat = new Chat($this->Database, $this->getPlatform(), $this->data["chat"]);
		}

		// echo "<pre>";
		// 	echo str_repeat("    ", $lvl);
		// 	print_r($this->Chat);
		// echo "</pre>";
		
		return $this->Chat;
	}

	public function setDatabase(iDatabase $Database) : void {
		$this->Database = $Database;
	}
}