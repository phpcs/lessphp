<?php
/**
 *
 * @author Bruce.cheng@carbit.com.cn
 * @date 16-3-7
 */

function C($key)
{
    static $_config = array();
    $args = func_num_args();
    if ($args == 1) {
        if (is_string($key)) {
            return isset($_config[$key]) ?: null;
        } elseif (is_array($key)) {
            foreach ($key as $k => $v) {
                $_config[$k] = $v;
            }
        }
    } elseif ($args == 2) {
        return $_config[$key] = func_get_arg(1);
    } else{
        halt('传入参数有误');
    }
}

function halt($str, $display = true)
{
    //Log::fatal($str . ' debug_backtrace:' . var_export(debug_backtrace(), true));
    header("Content-Type:text/html; charset=utf-8");
    if ($display) {
        echo "<pre>";
        debug_print_backtrace();
        echo "</pre>";
    }
    echo $str;
    exit;
}

