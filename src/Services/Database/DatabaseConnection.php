<?php

namespace TgBotCore\Services\Database;


use PDO;
use PDOException;
use Exception;

class DatabaseConnection
{
	private $_link;

	private $Exception = false;

	public $microtime = [];

	public function __construct($host, $user, $password, $base)
	{
		$dsn = "mysql:host=".$host.";dbname=".$base.";charset=utf8mb4";

		try
		{
			$this->_link = new PDO($dsn, $user, $password);
			$this->_link->query('SET NAMES utf8mb4');
		}
		catch (PDOException $e)
		{
        	$this->Exception = $e;
		}
	}




	/**
	 * @return PDOException | false
	 */
	public function getException()
	{
		return $this->Exception;
	}




	/**
	 * @return PDO
	 */
	public function get()
	{
		return $this->check() ? $this->_link : false;
	}




	/**
	 * @return bool
	 */
	private function check()
	{
		return !empty($this->_link);
	}
}