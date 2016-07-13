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
    
    public function del($table, $key_conditon)
    {
        if (!$key_conditon){
            return false;
        }

        if (!is_array($key_conditon)) {
            $where = " WHERE id=". $key_conditon;
        } else {
            $where = " WHERE " . array_keys($key_conditon)[0] . "=" .array_pop($key_conditon);
        }

        $res = $this->pdo->exec("DELETE FROM " . $this->prefix . $table . $where );

        return $res;
    }

    public function insert($table, $datas)
    {
        $values = array();
        $columns = array();
        foreach ($datas as $key => $value) {
            array_push($columns, $key);
            array_push($values, "?");
            $bindParams[] = $value;
        }
        $sql = 'INSERT INTO '. $this->prefix . $table . '(' . implode(', ', $columns) . ') VALUES (' . implode($values, ', ') . ')';
        $statement = $this->pdo->prepare($sql);
        $statement->execute($bindParams);
        $lastId = $this->pdo->lastInsertId();

        return $lastId;
    }

    public function update($table, $data)
    {
        $set_str = '';
        foreach ($data as $key => &$value) {
            if ($key=='id') {
                $where = ' WHERE id='. $value;
                unset($data[$key]);
            } else{
                if (is_string($key)) {
                    $set_str .=$key . "=?,";
                }
            }

        }
        if ($set_str) {
            $set_str = rtrim(' SET '. $set_str, ",");
        }
        $sql = 'UPDATE '. $this->prefix . $table . $set_str . $where;
        $statement = $this->pdo->prepare($sql);
        $res = $statement->execute(array_values($data));
        
        return $res;
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
