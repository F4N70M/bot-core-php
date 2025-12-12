<?php

namespace TgBotCore\Contracts;

use TgBotCore\Contracts\iMessage;

interface iOutputAdapter {
	public function __construct(string $token);
	
	public function getRequestUrl($method) : string;

	public function sendMessage(iMessage $Message);
}