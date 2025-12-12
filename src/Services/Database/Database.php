<?php

namespace TgBotCore\Services\Database;

use TgBotCore\Contracts\iDatabase;
use TgBotCore\Contracts\iUser;
use TgBotCore\Contracts\iChat;

use TgBotCore\Services\Database\DatabaseConnection;
use TgBotCore\Services\Database\DatabaseQueryBuilder;
use TgBotCore\Exception;

/**
 * 
 */
class Database implements iDatabase
{
	protected $credentials;

	protected $QueryBuilder;

	public function __construct() {}

	public function setCredentials(string $host, string $user, string $password, string $base) {
		$lvl = BotKernelDebug();
		$this->credentials = [
			"host" => $host,
			"user" => $user,
			"password" => $password,
			"base" => $base
		];
	}

	public function getUserData($unique, $platform = null) : array {}
	public function setUserData(iUser $User) : bool {}

	public function getChatData($pid, $platform) : array|false {
		$lvl = BotKernelDebug();
		$db = $this->getQueryBuilder();
		$response = $db
			->select()
			->from("chats")
			->where(["platform"=>$platform, "pid"=>$pid])
			->result();
		$result = (!empty($response)) ? $response[0] : ["pid"=>$pid];

		return $result;
	}

	public function setChatData(iChat $Chat) : bool {
		$lvl = BotKernelDebug();

			$data = $Chat->getData();
			$data["platform"] = $Chat->getPlatform();
			$db = $this->getQueryBuilder();
			if (($uid = $Chat->getUID()) !== null) {
				$rowCount = $db
					->update("chats")
					->set($data)
					->where(["uid"=>$uid])
					->result();
				$result = (bool) $rowCount;
			} else {
				$lastInsertId = $db
					->insert()
					->into("chats")
					->values($data)
					->result();
				if ($lastInsertId) {
					$Chat->setUID($lastInsertId);
				}
				$result = (bool) $lastInsertId;
			}
		// echo "<pre>";
		// 	echo str_repeat("    ", $lvl);
		// 	var_dump($result);
		// echo "</pre>";
		return $result;
	}

	protected function getQueryBuilder() : DatabaseQueryBuilder {
		$lvl = BotKernelDebug();
		if (!($this->QueryBuilder instanceof DatabaseQueryBuilder)) {
			$credentials = $this->credentials;
			$connection = new DatabaseConnection(
				$credentials["host"],
				$credentials["user"],
				$credentials["password"],
				$credentials["base"]
			);
			$exception = $connection->getException();
			if(!$exception) {
				$link = $connection->get();
				$this->QueryBuilder = new DatabaseQueryBuilder($link);
			}
			else {
				throw new Exception(print_r($exception->errorInfo[2], true));
			}
		}
		return $this->QueryBuilder;
	}
}