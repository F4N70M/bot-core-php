<?php

namespace TgBotCore\Contracts;

use TgBotCore\Contracts\iDatabase;

interface iChat {
	public function __construct(iDatabase $Database, string $platform, array $data);
	
	public function getData() : array;

	public function getPlatform() : string;

	public function setUID($uid);

	public function getUID();

	public function getPID();
}