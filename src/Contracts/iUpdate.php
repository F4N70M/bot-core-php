<?php

namespace TgBotCore\Contracts;

use TgBotCore\Contracts\iDatabase;
use TgBotCore\Contracts\iUser;
use TgBotCore\Contracts\iChat;

interface iUpdate {
	public function __construct(array $standartData);
	public function getRawData() : array;
	public function getChat() : iChat;
	public function setDatabase(iDatabase $Database) : void;
}