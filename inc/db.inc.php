<?php
require_once 'config.inc.php';

class DB
{
	private $link;

	function __construct()
	{
		$this->link = new mysqli(HOST, USER, PASS);
		if ($this->link->connect_error) {
			die('keine Verbindung möglich: ' . $this->link->connect_error);
		}
		$this->link->select_db(DB) or die("Auswahl der Datenbank fehlgeschlagen");
	}

	function query($string)
	{
		$result = $this->link->query($string);
		return $result;
	}
}
