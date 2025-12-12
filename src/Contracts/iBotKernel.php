<?php

namespace TgBotCore\Contracts;

use TgBotCore\Contracts\iInputAdapter;
use TgBotCore\Contracts\iOutputAdapter;
use TgBotCore\Contracts\iUpdate;

interface iBotKernel {
	public function __construct(iInputAdapter $InputAdapter, iOutputAdapter $OutputAdapter);
	public function getUpdate() : iUpdate;		// Получить объект Update из объекта iInputAdapter
	public function getDataBase() : iDataBase;	// Получить объект DataBase
	public function returnRawUpdateData();	// Отправить обратно сырые данные обновления
}