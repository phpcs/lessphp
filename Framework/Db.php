<?php
/**
 *
 * @author Bruce.cheng@carbit.com.cn
 * @date 16-3-21
 */
namespace Framework;

class Db{

	static $instance;

    public $link;

	private function __construct()
	{
		$this->link = new \PDO('mysql:host=localhost;dbname=lessdata', 'root', 'cs123');
	}

	public static function getInstance()
	{
		if (!isset(self::$instance)) {
			self::$instance = new Db();
		}
		return self::$instance;
	}

	public function query($sql)
	{

		
	}
}