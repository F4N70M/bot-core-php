<?php

namespace TgBotCore\Contracts;

interface iOutputAdapter {
	public function __construct(string $token);
	public function getRequestUrl($method) : string;
}