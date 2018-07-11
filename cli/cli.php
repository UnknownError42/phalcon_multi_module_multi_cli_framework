<?php
/**
 * @desc 命令行入口文件
 * @author: ZhaoYang
 * @date: 2018年6月17日 下午5:42:16
 */
use Phalcon\Cli\Console;

// 检查版本，搭建用到php7一些新特性
version_compare(PHP_VERSION, '7.0.0', '>') || exit('Require PHP > 7.0.0 !');
extension_loaded('phalcon') || exit('Please open the Phalcon extension !');

// 引入自定义常量文件
require '../config/define.php';

version_compare(PHALCON_VERSION, '3.0.0', '>') || exit('Require Phalcon > 3.0.0 !');

// 设置时区
date_default_timezone_set('Asia/Shanghai');

NOW_ENV != 'dev' && error_reporting(E_ALL & ~E_NOTICE);

try {
    
    // 引入注册服务
    $di = require BASE_PATH . 'cli/config/services.php';
    
    $arguments = $argv;
    
    // 处理请求
    $console = new Console($di);
    
    // 组装应用程序模块
    $modules = [ ];
    foreach (MODULE_ALLOW_LIST as $v) {
        $modules[$v] = [ 
            'className' => APP_NAMESPACE . '\\' . ucfirst($v) . '\CliModule',
            'path' => APP_PATH . $v . '/CliModule.php'
        ];
    }
    // 加入模块分组配置
    $console->registerModules($modules);
    
    // 设置选项
    $console->setArgument($arguments);
    
    unset($arguments[0]);
    
    $arguments = array_map('urlencode', $arguments);
    
    $arguments = implode(' ', $arguments);
    
    // 解析路由
    $console->router->handle($arguments);
    if (!$console->router->wasMatched()) {
        echo '未匹配到合适的路由，请校验参数',PHP_EOL;
        exit();
    }
    $arguments = [
        'module' => $console->router->getModuleName(),
        'task' => $console->router->getTaskName(),
        'action' => $console->router->getActionName(),
        'params' => array_map('urldecode', $console->router->getParams())
    ];
    
    // 处理请求
    $console->handle($arguments);
} catch (\Throwable $e) {
    $previous = $e->getPrevious();
    $consoleConfig = $console->config->application;
    if ($consoleConfig->debug->state ?? false) {
        if (empty($consoleConfig->debug->path)) {
            echo 'Exception： ', PHP_EOL, '所在文件：', $e->getFile(), PHP_EOL, '所在行：', $e->getLine(), PHP_EOL, '错误码：', $e->getCode(), PHP_EOL, '错误消息：', $e->getMessage(), PHP_EOL, PHP_EOL;
            if (!is_null($previous)) {
                echo '前一个Exception： ', PHP_EOL, '所在文件：', $previous->getFile(), PHP_EOL, '所在行：', $previous->getLine(), PHP_EOL, '错误码：', $previous->getCode(), PHP_EOL, '错误消息：', $previous->getMessage(), PHP_EOL, PHP_EOL;
            }
            exit();
        }
        $errorType = 'debug';
    } else {
        $errorType = 'error';
    }
    $errorFile = $consoleConfig->$errorType->path;
    $errorMessage = 'Exception： [所在文件：' . $e->getFile() . '] [所在行：' . $e->getLine() . '] [错误码：' . $e->getCode() . '] [错误消息：' . $e->getMessage() . '] '/* . PHP_EOL . '[异常追踪信息：' . $e->getTraceAsString() . ']' */;
    if (!is_null($previous)) {
        $errorMessage .= ' 前一个Exception： [所在文件：' . $previous->getFile() . '] [所在行：' . $previous->getLine() . '] [错误码：' . $previous->getCode() . '] [错误消息：' . $previous->getMessage() . '] '/* . PHP_EOL . '[异常追踪信息：' . $previous->getTraceAsString() . ']' */;
    }
    $console->di->get('logger', [ 
        $errorFile
    ])->$errorType($errorMessage);
}