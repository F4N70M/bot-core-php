<?php

/* Namespace */
namespace TgBotCore\Models;

/* Interfaces */
use TgBotCore\Contracts\iChat;
use TgBotCore\Contracts\iDatabase;

/* Classes */


/**
 * 
 */
class Chat implements iChat
{
	protected $Database;

	protected $uid;
	protected $platform;

	protected $data;

	public function __construct(iDatabase $Database, string $platform, array $data) {
		$lvl = BotKernelDebug();

		$this->Database = $Database;
		$this->platform = $platform;

		$this->initData($data);
	}

	protected function initData($data) {
		$lvl = BotKernelDebug();

		$this->updateDataFromDatabase($data["pid"]);
		$this->updateData($data);

		$this->Database->setChatData($this);
	}

	protected function updateDataFromDatabase($pid) {
		$lvl = BotKernelDebug();

		$dbData = $this->Database->getChatData($pid, $this->platform);
		if (isset($dbData["uid"])) {
			$this->setUID($dbData["uid"]);
		}
		$this->updateData($dbData);
	}

	protected function updateData(array $data) : void {
		$lvl = BotKernelDebug();

		$keys = ["pid", "type", "title", "username", "first_name", "last_name", "is_forum", "pending"];
		foreach ($keys as $key) {
			$chat[$key] = (
				array_key_exists($key, $data)
					? $data[$key]
					: (
						is_array($this->data) && array_key_exists($key, $this->data)
							? $this->data[$key]
							: null
					)
			);
		}
		$this->data = $chat;
	}

	public function getData() : array {
		$lvl = BotKernelDebug();
		return $this->data;
	}

	public function getPlatform() : string {
		$lvl = BotKernelDebug();
		return $this->platform;
	}

	public function setUID($uid) {
		$lvl = BotKernelDebug();
		$this->uid = $uid;
	}

	public function getUID() {
		$lvl = BotKernelDebug();
		return $this->uid;
	}

	public function getPID() {
		$lvl = BotKernelDebug();
		return $this->data["pid"];
	}
}