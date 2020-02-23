<?php
return[
    'wechat' => [
        'appid' => 'wxc0cfad497b4c1fcd', // APP APPID
        'app_id' => 'wxc0cfad497b4c1fcd', // 公众号 APPID
        'miniapp_id' => '', // 小程序 APPID
        'mch_id' => '1520313301',
        'key' => '97f0943a2a00abad875ee0a8777d7ca2',
        'notify_url' => 'http://bufan.leagokj.com/api/payments/wechat/notify',
        'cert_client' => '', // optional, 退款，红包等情况时需要用到
        'cert_key' => '',// optional, 退款，红包等情况时需要用到
        'log' => [ // optional
            'file' => './logs/wechat.log',
            'level' => 'debug', // 建议生产环境等级调整为 info，开发环境为 debug
            'type' => 'daily', // optional, 可选 daily.
            'max_file' => 3, // optional, 当 type 为 daily 时有效，默认 30 天
        ],
        'http' => [ // optional
            'timeout' => 5.0,
            'connect_timeout' => 5.0,
            // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
        ],
        // 'mode' => 'dev',
    ],

    'alipay' => [
        'app_id' => '',
        'notify_url' => '',
        'return_url' => '',
        'ali_public_key' => '',
        'private_key' => '',
        'log' => [ // optional
            'file' => './logs/alipay.log',
            'level' => 'debug', // 建议生产环境等级调整为 info，开发环境为 debug
            'type' => 'daily', // optional, 可选 daily.
            'max_file' => 3, // optional, 当 type 为 daily 时有效，默认 30 天
        ],
        'http' => [ // optional
            'timeout' => 5.0,
            'connect_timeout' => 5.0,
            // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
        ],
        // 'mode' => 'dev', // optional,设置此参数，将进入沙箱模式
    ]
];