<?php
/**
 * Author:     Rojer
 * Mail:       rojerchen@qq.com
 */

return [
    'use_sandbox'       => env('PAY_USE_SANDBOX',false),// 是否使用沙盒模式
    'app_id'            => env('WX_APP_ID',''),  // 公众账号ID
    'mch_id'            => env('WX_MCH_ID',''),// 商户id
    'md5_key'           => env('WX_MD5_KEY',''),// md5 秘钥
    'app_cert_pem'      => env('WX_CERT_PEM',base_path('wx_pay_pem'.DIRECTORY_SEPARATOR.'apiclient_cert.pem')),
    'app_key_pem'       => env('WX_KEY_PEM',base_path('wx_pay_pem'.DIRECTORY_SEPARATOR.'apiclient_key.pem')),
    'sign_type'         => env('WX_SIGN_TYPE','MD5'),// MD5  HMAC-SHA256
    'limit_pay'         => [
        //'no_credit',
    ],// 指定不能使用信用卡支付不传入，则均可使用
    'fee_type'          => env('WX_FEE_TYPE','CNY'),// 货币类型  当前仅支持该字段
    'notify_url'        => env('APP_URL', 'http://www.zhongshang.shop').'/order/notify/wx' ,
    'return_url'        => env('APP_URL', 'http://www.zhongshang.shop').'/order' ,
    'return_raw'        => true,// 在处理回调时，是否直接返回原始数据，默认为 true
];