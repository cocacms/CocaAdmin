<?php
/**
 * Author:     Rojer
 * Mail:       rojerchen@qq.com
 */

return [
    'use_sandbox'               => env('PAY_USE_SANDBOX',false),// 是否使用沙盒模式
    'partner'                   => env('ALI_PARTNER',''),
    'app_id'                    => env('ALI_APP_ID',''),
    'sign_type'                 => env('ALI_SIGN_TYPE',''),// RSA  RSA2
    // 可以填写文件路径，或者密钥字符串  当前字符串是 rsa2 的支付宝公钥(开放平台获取)
    'ali_public_key'            => env('ALI_PUBLIC_KEY'),
    // 可以填写文件路径，或者密钥字符串  我的沙箱模式，rsa与rsa2的私钥相同，为了方便测试
    'rsa_private_key'           => '',
    'limit_pay'                 => [
        //'balance',// 余额
        //'moneyFund',// 余额宝
        //'debitCardExpress',// 	借记卡快捷
        //'creditCard',//信用卡
        //'creditCardExpress',// 信用卡快捷
        //'creditCardCartoon',//信用卡卡通
        //'credit_group',// 信用支付类型（包含信用卡卡通、信用卡快捷、花呗、花呗分期）
    ],// 用户不可用指定渠道支付当有多个渠道时用“,”分隔
    // 与业务相关参数
    'notify_url'                => env('APP_URL', 'http://www.zhongshang.shop').'/order/notify/ali' ,
    'return_url'                => env('APP_URL', 'http://www.zhongshang.shop').'/order' ,
    'return_raw'                => true,// 在处理回调时，是否直接返回原始数据，默认为 true
];