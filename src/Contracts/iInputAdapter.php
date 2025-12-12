<?php

namespace TgBotCore\Contracts;

use TgBotCore\Contracts\iUpdate;

interface iInputAdapter {
	public function __construct();
	public function convertToStandartUpdate(array $rawData) : iUpdate;
	public function convertToStandartData(array $rawData) : array;
}