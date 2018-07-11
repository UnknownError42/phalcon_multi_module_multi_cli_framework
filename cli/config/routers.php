<?php
/**
 * @desc cli路由规则
 * @author: ZhaoYang
 * @date: 2018年6月17日 下午5:45:54
 */
$defaultRouters = [
    '#^([a-zA-Z0-9\\_\\-]+)$#' => [
        'module' => DEFAULT_MODULE,
        'task' => 1,
        'action' => 'main'
    ],
    '#^([a-zA-Z0-9\\_\\-]+):delimiter([a-zA-Z0-9\\_\\-]+)$#' => [
        'module' => DEFAULT_MODULE,
        'task' => 1,
        'action' => 2
    ],
    '#^([a-zA-Z0-9\\_\\-]+):delimiter([a-zA-Z0-9\\_\\-]+)(:delimiter.+)$#' => [
        'module' => DEFAULT_MODULE,
        'task' => 1,
        'action' => 2,
        'params' => 3
    ]
];

$routers = [ ];
foreach (MODULE_ALLOW_LIST as $v) {
    $vUcfirst = ucfirst($v);
    $routers['#^' . $v . '$#'] = [
        'module' => $v,
        'task' => 'Main',
        'action' => 'main'
    ];
    $routers[$v . ':delimiter:task'] = [
        'module' => $v,
        'task' => 1,
        'action' => 'main'
    ];
    $routers[$v . ':delimiter:task:delimiter:action'] = [
        'module' => $v,
        'task' => 1,
        'action' => 2
    ];
    $routers[$v . ':delimiter:task:delimiter:action:delimiter:params'] = [
        'module' => $v,
        'task' => 1,
        'action' => 2,
        'params' => 3
    ];
}
return array_merge($defaultRouters, $routers);