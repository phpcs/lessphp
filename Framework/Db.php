<?php
/**
 *
 * @author Bruce.cheng@carbit.com.cn
 * @date 16-3-21
 */
namespace Framework;

class Db
{

    static $instance;

    public $link;


    private function __construct()
    {
        $this->link = new \PDO('mysql:host='.C('DB_HOST').';dbname=' . C('DB_NAME'), C('DB_USER'), C('DB_PASS'));
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
        $statment = $this->link->prepare($sql);
        $statment->execute();

        return $statment->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function save($sql, $arr)
    {
        $statment = $this->link->prepare($sql);
        $statment->execute($arr);

        return $statment->rowCount();
    }
}