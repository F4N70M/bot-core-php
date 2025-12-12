<?php

namespace TgBotCore\Contracts;

use TgBotCore\Contracts\iUser;
use TgBotCore\Contracts\iChat;

interface iUpdate {
	public function __construct(array $standartData);
	public function getRawData() : array;
	public function getChat() : iChat;
}