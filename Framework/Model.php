<?php
/**
 *
 * @author Bruce.cheng@carbit.com.cn
 * @date 16-3-21
 */
namespace Framework;

class Model{

	private $link;

	public function __construct()
	{
		$this->link = new PDO("mysql:host=localhost;dbname=db_demo","root","");
		var_dump(1);exit;
		$this->link->exec('set names utf8');

	}

	public function query($sql)
	{
		$res = $this->link->exec($sql);
		return $res;
	}
}