<?php

namespace TgBotCore\Contracts;

interface iMessage {
	public function __construct();

	public function setText($data);
	public function setChatPID($chatID);

	public function getText();
	public function getChatPID();
}