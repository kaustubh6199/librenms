<?php

// https://www.iana.org/assignments/bgp-parameters/bgp-parameters.xhtml#bgp-parameters-3
return [
    'error_codes' => [
         0 => '保留',
        1 => '消息头错误',
        2 => '打开消息错误',
        3 => '更新消息错误',
        4 => '保持计时器过期',
        5 => '有限状态机错误',
        6 => '终止',
        7 => '路由刷新消息错误',
    ],
    'error_subcodes' => [
        1 => [
            0 => '未指定',
            1 => '连接不同步',
            2 => '消息长度错误',
            3 => '消息类型错误',
        ],
        2 => [
            0 => '未指定',
            1 => '不支持的版本号',
            2 => '错误的对等AS',
            3 => '错误的BGP标识符',
            4 => '不支持的可选参数',
            5 => '[已弃用]',
            6 => '不可接受的保持时间',
            7 => '角色不匹配（临时BGP草案）',
        ],
        3 => [
            0 => '未指定',
            1 => '属性列表格式错误',
            2 => '未识别的熟知属性',
            3 => '缺少熟知属性',
            4 => '属性标志错误',
            5 => '属性长度错误',
            6 => '无效的ORIGIN属性',
            7 => '[已弃用]',
            8 => '无效的NEXT_HOP属性',
            9 => '可选属性错误',
            10 => '无效的网络字段',
            11 => 'AS_PATH格式错误',
        ],
        5 => [
            0 => '未指定错误',
            1 => '在OpenSent状态下收到意外消息',
            2 => '在OpenConfirm状态下收到意外消息',
            3 => '在Established状态下收到意外消息',
        ],
        6 => [
            0 => '保留',
            1 => '达到前缀最大数量',
            2 => '管理关闭',
            3 => '对等配置取消',
            4 => '管理重置',
            5 => '连接被拒绝',
            6 => '其他配置变更',
            7 => '连接冲突解决',
            8 => '资源不足',
            9 => '硬重置', 
        ],
    ],
];
