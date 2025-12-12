<?php

namespace TgBotCore\Contracts;

use TgBotCore\Contracts\iInputAdapter;
use TgBotCore\Contracts\iOutputAdapter;
use TgBotCore\Contracts\iUpdate;
use TgBotCore\Contracts\iDatabase;

interface iBotKernel {
	public function __construct(iInputAdapter $InputAdapter, iOutputAdapter $OutputAdapter, array $config);
	public function getUpdate() : iUpdate;		// Получить объект Update из объекта iInputAdapter
	public function setDatabase(iDatabase $Database) : void;	// Получить объект Database
	public function getDatabase() : iDatabase;	// Получить объект Database
	public function returnRawUpdateData();	// Отправить обратно сырые данные обновления
}