<?php

/* Namespace */
namespace TgBotCore\Models;

/* Interfaces */
use TgBotCore\Contracts\iUser;

/* Classes */


/**
 * 
 */
class User implements iUser
{
	public function __construct() {
		$lvl = BotKernelDebug();
	}
}