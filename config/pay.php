<?php

return [
    'alipay' => [
        // 支付宝分配的 APPID
        'app_id' => env('ALI_APP_ID', '2016102700771468'),

        // 支付宝异步通知地址
        'notify_url' => 'https://www.mypic.life/api/callback/ali/sync',

        // 支付成功后同步通知地址
        'return_url' => 'https://www.mypic.life/api/callback/ali/notice',

        // 阿里公共密钥，验证签名时使用
        'ali_public_key' => env('ALI_PUBLIC_KEY', base_path('cert2/alipayCertPublicKey_RSA2.crt')),

        // 自己的私钥，签名时使用
        'private_key' => env('ALI_PRIVATE_KEY', 'MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQCSeAibpigGsiILPNBplvtI4UyimCsh5bEouIchQVnnsVXQg8e4P2MRfikmLClWk2gsJX0o5hYq95R6gK7kwhJ+SKiVbwB1vmcGaix557tzXp2VXE54DCQv56hzzVUnE3lZISBW0sU4xmRAC/pn0IN+HilLnDZuWG35RzrBPKh1MUKxZyg/UMcvD+w98ujMLWqSuZzgCl7HXOD+Cp2UUkiHx748FIlA+F3SQGs8Asj62YYNxCawLQbhN33SEcPpPJGGLtCoXvq0Xk8YCagt7NnepjD3Q6QWlr34DS+Rfym2R21JtAH/r9bfQBf3hGmMjBmLywqH4ypsVNn4qZd43n03AgMBAAECggEBAIfSYYEcun9DDojHMyjHRmxV6H/ahhzf58GwJDb1aA6PhtleaoTz2sVs7XGlgAv1k6NkfETB4IqlnX1f+U7OnOGYNSSlk5KcJuNu76F3/37DnXPU7jsqXyBBPRdtsGoVB/Fb46Y/u32jk3FE6kb8uALqqzafPGZlAE4p/FUXD8vjo7/dN6NcbNRQ0gwC7sud9nKVbJIkM1NeekJkb1jm9BVGOpcTs/CsoeiZQQhRR16scAhUovK2UJ4qmmuFR/3t609JVCLXahhqDleK+G1gkxrOSu8VTpIR+tL8bme36z63XcLJaTYi5/PhjGmBaOpP78/i/kOIK+4zPoBWVE5p01kCgYEAyxbs7WaK3e9/9ItzJeUfz4MJDE4t+CVNYea1EsV5SVaUGGesyB7jkEp8QyHSuhdKIqW0yADZ4/taK6bhiPvcPf4N7Fq5AJFZnX9UDBVcrf+FlDJPFXESjbx7unOyPKBB7dXl9hxnaaOZoU0ERPAQ90kVUM6qArX71gvSOWUI9T0CgYEAuKDJq1puLtV+5bx+w4lLbTPs33psk5+OE4pwblj973djLC/hZmNZlaogRl/XtWr0rkui3I7oxIeeoS4b3YQ20yMULVDqM4tHWx81vhjR8zv72hVbNvwnlWGDK+35zQol+1rr6Hr2YJNd+bJVCBT0x2ZhmnCnixKfrfbsGSNy64MCgYEAr1k+/gbgdZkZSIKyzBBVc+z2ffpudGd4tcPlqax4+RpYye2R4EPTRb0aJzhn4qbDKsEaIumhN9fI1hHDf2u+kIPvb5gxTc0xq+vJHJnBKLaLlhYN9DxpwZjw116XkQLpibl6URHbM/m+ZufBfOguLeSbE+csISURqJESVN3oax0CgYAlXp4TKdWdcychNvrtdw+mRdlPDoeFhckLGX1SSH71hlOzcOmNgNR0H6Ayvll55fEqijKns+FXTiAEfcG0H3u9Vp9R4MvWrP0/a1zEYl+0fNKoPKRex8D3UmprbNqf7srrSmbvglv2Bj4COV9OqHc3GPjuepje5GEfpBf7qporIwKBgGT0/LcbUw61yATGN+XyFsBBg8HG1tlyRfvzhRYYRBZ64uFm6GVjHeF19xcvQ28CX2TCLbLWDbzZa3ml9doz3AqRNRCOCIycAWFjaVhlDNplEijVZMKh239OpULnFJfRsAqZYMBXfdICWA2L+QBQfY0yRfIQ3WTZASgVRmnQcep9'),

        // 使用公钥证书模式，请配置下面两个参数，同时修改 ali_public_key 为以 .crt 结尾的支付宝公钥证书路径，如（./cert/alipayCertPublicKey_RSA2.crt）
        // 应用公钥证书路径
         'app_cert_public_key' => env('ALI_CERT_PUBLIC_KEY_PATH',base_path('cert2/appCertPublicKey_2016102700771468.crt')),

        // 支付宝根证书路径
         'alipay_root_cert' => env('ALIPAY_ROOT_CERT_PATH',base_path('cert2/alipayRootCert.crt')),

        // optional，默认 warning；日志路径为：sys_get_temp_dir().'/logs/yansongda.pay.log'
        'log' => [
            'file' => storage_path('logs/alipay.log'),
        //  'level' => 'debug'
        //  'type' => 'single', // optional, 可选 daily.
        //  'max_file' => 30,
        ],

        // optional，设置此参数，将进入沙箱模式
        'mode' => env('ALIPAY_MODE','dev'),
    ],

    'wechat' => [
        // 公众号 APPID
        'app_id' => env('WECHAT_APP_ID', ''),

        // 小程序 APPID
        'miniapp_id' => env('WECHAT_MINIAPP_ID', ''),

        // APP 引用的 appid
        'appid' => env('WECHAT_APPID', ''),

        // 微信支付分配的微信商户号
        'mch_id' => env('WECHAT_MCH_ID', ''),

        // 微信支付异步通知地址
        'notify_url' => '',

        // 微信支付签名秘钥
        'key' => env('WECHAT_KEY', ''),

        // 客户端证书路径，退款、红包等需要用到。请填写绝对路径，linux 请确保权限问题。pem 格式。
        'cert_client' => '',

        // 客户端秘钥路径，退款、红包等需要用到。请填写绝对路径，linux 请确保权限问题。pem 格式。
        'cert_key' => '',

        // optional，默认 warning；日志路径为：sys_get_temp_dir().'/logs/yansongda.pay.log'
        'log' => [
            'file' => storage_path('logs/wechat.log'),
        //  'level' => 'debug'
        //  'type' => 'single', // optional, 可选 daily.
        //  'max_file' => 30,
        ],

        // optional
        // 'dev' 时为沙箱模式
        // 'hk' 时为东南亚节点
        // 'mode' => 'dev',
    ],
];
