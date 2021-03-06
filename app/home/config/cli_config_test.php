<?php
// 模块名称
define('MODULE_NAME', 'home');
// 模块命名空间
define('MODULE_NAMESPACE', APP_NAMESPACE . '\\Home');

return [ 
    // 应用配置
    'application' => [ 
        'debug' => [ 
            'state' => true,
            'path' => '' // BASE_PATH . 'runtime/' . MODULE_NAME . '/debug/{YmdH}.log'
        ],
        'error' => [ 
            'path' => BASE_PATH . 'runtime/' . MODULE_NAME . '/error/{YmdH}.log'
        ],
        'loader' => [ 
            'namespaces' => [ 
                MODULE_NAMESPACE . '\\Models' => APP_PATH . MODULE_NAME . '/models' . DS
            ],
            'directories' => [
                APP_PATH . MODULE_NAME . '/tasks/'
            ]
        ]
    ],
    // 服务配置
    'services' => [ 
        // 文件日志,formatter常用line，adapter常用file
        'logger' => [ 
            'line' => [ 
                'format' => '[%date%][%type%] %message%',
                'dateFormat' => 'Y-m-d H:i:s'
            ],
            'file' => [ 
                'alert' => BASE_PATH . 'runtime/' . MODULE_NAME . '/logs/alert/{Y/m/d}/{YmdH}.log',
                'critical' => BASE_PATH . 'runtime/' . MODULE_NAME . '/logs/critical/{Y/m/d}/{YmdH}.log',
                'debug' => BASE_PATH . 'runtime/' . MODULE_NAME . '/logs/debug/{Y/m/d}/{YmdH}.log',
                'error' => BASE_PATH . 'runtime/' . MODULE_NAME . '/logs/error/{Y/m/d}/{YmdH}.log',
                'emergency' => BASE_PATH . 'runtime/' . MODULE_NAME . '/logs/emergency/{Y/m/d}/{YmdH}.log',
                'info' => BASE_PATH . 'runtime/' . MODULE_NAME . '/logs/info/{Y/m/d}/{YmdH}.log',
                'notice' => BASE_PATH . 'runtime/' . MODULE_NAME . '/logs/notice/{Y/m/d}/{YmdH}.log',
                'warning' => BASE_PATH . 'runtime/' . MODULE_NAME . '/logs/warning/{Y/m/d}/{YmdH}.log'
            ]
        ],
        // 加密配置
        'crypt' => [ 
            // 加密秘钥
            'key' => MODULE_NAME,
            // 填充方式，默认是0（PADDING_DEFAULT），1（PADDING_ANSI_X_923）、2（PADDING_PKCS7）、3（PADDING_ISO_10126）、4（PADDING_ISO_IEC_7816_4）、5（PADDING_ZERO）、6（PADDING_SPACE）
            'padding' => '',
            // 加密方法，默认是"aes-256-cfb"
            'cipher' => ''
        ],
        // 缓存配置
        'cache' => [ 
            'backend' => [ 
                // 数据缓存方式，支持memcache、file、redis、mongo、apc、apcu、libmemcached、memory、xcache
                'file' => [ 
                    'cache_dir' => BASE_PATH . 'runtime/' . MODULE_NAME . '/cache/'
                ]
            ]
        ],
        // 模型元数据缓存配置
        'models_metadata' => [ 
            'options' => [ 
                // 适配器，默认使用memory(内存),还支持apc、apcu、files、libmemcached、memcache、redis、session、xcache
                'adapter' => 'files',
                'meta_data_dir' => BASE_PATH . 'runtime/' . MODULE_NAME . '/models_metadata/'
            ]
        ],
        // 模型缓存配置
        'models_cache' => [ 
            'frontend' => [ 
                'adapter' => 'data',
                'lifetime' => 86400
            ],
            'backend' => [ 
                'adapter' => 'file',
                'cache_dir' => BASE_PATH . 'runtime/' . MODULE_NAME . '/models_cache/'
            ]
        ],
        // 安全配置
        'security' => [ 
            // 设置由openssl伪随机生成器生成的字节数
            'random_bytes' => 16,
            // 设置默认hash,0=7(CRYPT_BLOWFISH_Y),1(CRYPT_STD_DES),2(CRYPT_EXT_DES),3(CRYPT_MD5),4(CRYPT_BLOWFISH),5(CRYPT_BLOWFISH_A),6(CRYPT_BLOWFISH_X),8(CRYPT_SHA256),9(CRYPT_SHA512)
            'default_hash' => 7,
            'work_factor' => 8
        ]
    ]
];