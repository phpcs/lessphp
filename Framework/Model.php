<?php
/**
 *
 * @author Bruce.cheng@carbit.com.cn
 * @date 16-3-21
 */
namespace Framework;

class Model{

	static $link;

	public function __construct()
	{
		self::$link = new \PDO('mysql:host=localhost;dbname=lessdata', 'root', '');

	}

	public static function getModel()
	{
		if (isset(self::$link)) {
			self::$link = new Model();
		}
		return self::$link;
	}

	public function query($sql)
	{

		
	}
}