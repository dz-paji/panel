<?php

return [
    'email' => [
        'title' => '更改邮箱地址',
        'updated' => '您的邮箱地址已更新.',
    ],
    'password' => [
        'title' => '更改密码',
        'requirements' => '您的新密码应当至少包含 8 个字符.',
        'updated' => '您的密码已更新.',
    ],
    'two_factor' => [
        'button' => '两步验证设置',
        'disabled' => '您的账号已禁用两步验证. 日后登陆时, 不会有窗口弹出并索取 token.',
        'enabled' => '您的账号已启用两步验证. 日后登陆时, 您需要提供由验证器生成的代码.',
        'invalid' => '您提供的 token 不合法.',
        'setup' => [
            'title' => '设置两步验证',
            'help' => '无法识别二维码? 输入下方代码至两部验证程序:',
            'field' => '获取 token',
        ],
        'disable' => [
            'title' => '关闭两步验证',
            'field' => '输入 token',
        ],
    ],
];
