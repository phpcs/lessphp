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
        halt('文件：' . basename($file) . '不存在');
    }
}

function halt($str, $display = false)
{
    header("Content-Type:text/html; charset=utf-8");
    echo "<div style='margin: 0 auto;padding:10px 10px;background-color: #00ab00;border: 1px solid #ff0000;font-size: 18px;color:#ffffff;height:50px;line-height: 30px'>";
    echo "$str</div>";
    if ($display) {
        debug_print_backtrace();
    }

    return;
}

function p($data)
{
    echo '<pre>';
    print_r($data);
}

