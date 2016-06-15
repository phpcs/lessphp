<?php

namespace Framework;

class Db
{
    //一般设置
    protected $database_type;

    protected $charset;

    protected $database_name;

    protected $server;

    protected $username;

    protected $password;

    protected $port;

    protected $prefix;

    protected $option = array();

    static $instance;

    private function __construct()
    {
            $commands = array();

            $this->server = C('DB_HOST');

            $this->database_type = C('DB_TYPE');

            $this->port = C('DB_PORT');

            $this->username = C('DB_USER');

            $this->password = C('DB_PASS');

            $this->database_name = C('DB_NAME');

            $this->charset = C('DB_CHART');

            $this->prefix = C('TABLE_PRE') ?:'';

            $dsn = $this->database_type . ':host=' . $this->server . ($this->port ? ';port=' . $this->port : '') . ';dbname=' . $this->database_name;

            $commands[] = "SET NAMES '" . $this->charset . "'";

            $this->pdo = new \PDO(
                $dsn,
                $this->username,
                $this->password
            );

            foreach ($commands as $value) {
                $this->pdo->exec($value);
            }
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)){
            self::$instance = new Db();
        }

        return self::$instance;
    }

    public function query($query)
    {
        if ($this->debug_mode) {
            echo $query;

            $this->debug_mode = false;

            return false;
        }

        array_push($this->logs, $query);

        return $this->pdo->query($query);
    }

    public function select($sql)
    {
        $query = $this->query($sql);
        return $query ? $query->fetchAll(\PDO::FETCH_ASSOC) : false;
    }

    public function insert($table, $datas)
    {
        $lastId = 0;

        $values = array();
        $columns = array();
        foreach ($datas as $key => $value) {
            array_push($columns, $key);
            array_push($values, "'". $value. "'");
        }
        $sql = 'INSERT INTO '. $this->prefix . $table . '(' . implode(', ', $columns) . ') VALUES (' . implode($values, ', ') . ')';
        $res = $this->pdo->exec($sql);
        $lastId = $this->pdo->lastInsertId();

        return $lastId;
    }

    public function info()
    {
        $output = array(
            'server' => 'SERVER_INFO',
            'driver' => 'DRIVER_NAME',
            'client' => 'CLIENT_VERSION',
            'version' => 'SERVER_VERSION',
            'connection' => 'CONNECTION_STATUS'
        );

        foreach ($output as $key => $value) {
            $output[$key] = $this->pdo->getAttribute(constant('PDO::ATTR_' . $value));
        }

        return $output;
    }
}
