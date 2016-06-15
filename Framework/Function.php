<?php
/**
 *
 * @author Bruce.cheng@carbit.com.cn
 * @date 16-3-7
 */
$less_default_config = returnConfig(DEFAULT_CONFIG_FILE);
$less_user_config = returnConfig(USER_CONFIG_FILE);
if (is_array($less_user_config)) {
    $less_global_config = array_merge($less_default_config, $less_user_config);
} else {
    $less_global_config = $less_default_config;
}

function C($data)
{
    global $less_global_config;
    if (empty($data)) {
        return $less_global_config;
    } elseif (is_string($data)) {
        return isset($less_global_config[$data]) ? $less_global_config[$data] : null;
    } elseif (is_array($data)) {
        foreach ($data as $k => $v) {
            $less_global_config[$k] = $v;
        }
    } else {
        halt('参数错误');
    }

    return;
}

function returnConfig($file)
{
    if (file_exists($file)) {
        return include $file;
    } else {
        halt('文件：' . $file . '不存在');
    }
}

function includeFile($file)
{
    if (file_exists($file)) {
        include $file;
    } else {
        echo $file . '不存在';
    }
}

function halt()
{
    include ROOT_PATH . '/App/View/error.html';
    if (C('DEBUG')) {
        if (func_num_args() > 0) {
            echo "<div style='background-color: #127fff;color:white;padding: 20px 20px'>";
            echo func_get_arg(0);
            echo "</div>";
            echo '<hr/>';
        }
        debug_print_backtrace();
    }
    exit;
}

function odd($num)
{
    return 1 & $num;
}

function even($num)
{
    return !(1 & $num);
}

function p($data)
{
    echo '<pre>';
    print_r($data);
}

function closed()
{
    echo "<div style='width: 80%;height: 400px; margin:100px auto; background: #CCCCCC;border: 1px solid blue; text-align: center'>
            <div style='padding-top: 180px'>网站正在升级中........</div>
            </div>";
    exit;
}

function DB($sql)
{
    $obj = \Framework\Db::getInstance();
    if (func_num_args() == 2) {
        $res = $obj->insert(func_get_arg(0), func_get_arg(1));
    } elseif (func_num_args() == 1) {
        preg_match('/([a-zA-Z]+)\s+/', $sql, $arr);
        switch ($do = strtolower($arr[1])) {
            case 'select':
                $res = $obj->select($sql);
                break;
            case 'delete':
                $res = $obj->delete($sql);
                break;
        }
    }

    return $res;

}

function calcTime($time)
{
    list($usec, $sec) = explode(" ", $time);
    return ((float)$usec + (float)$sec);
}
