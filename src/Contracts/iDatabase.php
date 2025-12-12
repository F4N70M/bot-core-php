<?php

namespace TgBotCore\Contracts;

use PDO;
use TgBotCore\Contracts\iUser;
use TgBotCore\Contracts\iChat;

interface iDatabase {
	public function __construct();

	public function setCredentials(string $host, string $user, string $password, string $base);

	public function getUserData($unique, $platform = null) : array|false;
	public function setUserData(iUser $User) : bool;

	public function getChatData($unique, $platform) : array|false;
	public function setChatData(iChat $Chat) : bool;
}