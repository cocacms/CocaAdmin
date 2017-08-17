<?php
/**
 * Author:     Rojer
 * Mail:       rojerchen@qq.com
 */

return [
    'use_sandbox'               => false,// 是否使用沙盒模式
    'partner'                   => '2088721712984700',
    'app_id'                    => '2017081708239340',
    'sign_type'                 => 'RSA2',// RSA  RSA2
    // 可以填写文件路径，或者密钥字符串  当前字符串是 rsa2 的支付宝公钥(开放平台获取)
    'ali_public_key'            => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAufTmfkL0Xh7AC4MyIE6Wzuh+x3yyshiQ45jQ7Au9X/gOeGGFV3jy7c/vFi49sKFCDdvJ1WngqkuYP+EuyMXO0+9Af1VRzxXK7cA4w3JzgXvglAkY19gIO+EMOkFsYYamzxNeQR3oHYxAQFrnmejQ3LmhMiEroS/yaD0V/IpYoF7tYfO/z2fEw+gWUNmS+7GXzc9hs8kw+hfnQedApJPVix8YRjYyvx5zd248Gy1ysWike9+wQXSq4nwzItlWo69+ia2yi4VK9ns8VKBsIwVlI981zEjqVgfTaoCBFcQmYYK9gN/7gHla4QrZyWteFdiPfNoKdBj9Z8cpn/F08+uALQIDAQAB',
    // 可以填写文件路径，或者密钥字符串  我的沙箱模式，rsa与rsa2的私钥相同，为了方便测试
    'rsa_private_key'           => 'MIIEowIBAAKCAQEAuBOO/K7mAtcvOBcDPSFf7HVMA+Fck/Ck8ozF92OwNnQQyvzp9d7TgRbB0XT1oJmBgnyvhyv7ifXyRuEsog40FcS/+rxYXtyBGG6JajwARLsCvGKHLkDNkPVwcdo+7TUnA0vIVPxYxsdDYW9HE+ba762JyTUjjW13K7GIRoYXc4CHj4PMvUibM066HMlQWLBa+OVBcuPAsggn67idu1XJwUOLxUjLDpfOOtt5klOljGoty5I/mmIA/FMD3780ntBuLfIWtMjk4EhL/LMvSHAk9gBgKuypcIFw4LQG2n1H1mjaXVSIQXfFvdXneRk5TkUjogLo1fCcrNwwKyferUV84QIDAQABAoIBAFRuRCuKXV34LWRgyc+EO2dN9evhtoD04/OMtlDenLidTAaPMxDff8u6EHRuXSuovUqIvkoV1m5VLSdtqPc75JAHircLJM19/oiiSs07cDQWQw79clu4xZEzwru2Cx7qPla4r86rYFzskO9kBwoN3WYKByUPBpucFgkoiQUwBBmpl14kSfJQ8+KKcLALc+rCVE/Qm6PaILljOHUNBd9D60G1K4/P6dXw1t4bqumF4waxtrktGBqnZ5rhXkd13xCadiAsOzZF819V4r64PDJTtYRDSsU9kD8LE/mftzhYDxzuMBe1rHd3Gqi8lVL4BZr+C5ADwUrgxSI1jpKWbKR5IEECgYEA2yHDa7EdYaIMvSbtbuIOPW88PGSxnMt+C19sWMLtTrGGI93pCYPZblnUPtIrsuHwl/oor3cgvmZTruJ7WCBGKJMd6QAb4PU5+Ml7Xto9/lsx5BUsDFTq+Sr38KjqlF2HfFF+6ULZRVQoa6cJ2gokiYspngfGwtDCTnx+ZgfjsDUCgYEA1wvrTO1H9QhUdUHs4SwLn4vd3Al61JnTO9oFqVLwLMzDmE1V7mPaO6SBwNrsq3b2SS5GkTIlRfkVs/S/XDe9WLFk29Nki2sqGr+2K9bye/jr/k/L8dtYtzxLfnd7Ie/tWX/Ycm14kaax5QSIgMtv87s4HlykAjxYsO8JZ8sLB30CgYASS99lPoSVglJN+NIaUAWgW4lMAZxS2yrLCEyjnKLzzx7EH+M1SCz/acCu/h1n8jWEev6qp+ez/hc+ouppkUhKWv5EVh39ynvsqeYDJXXHpxWjVaE35l84Lr5E+dWcTbLiTmuqTkqV31EArBHGgtJKKbRv3XZbDdMrenmTS1VXgQKBgAQ5773rS+a86ywCx60FOJVCInIYnZlgDI64kjPptV6sB4wOuQmeXMOfUA2CP/R+ughmKGziF2lwo8SNotUlI0uC8QCA/xDeYk10RxhFeS6GjdzJpLB0JyIyxSkPIBRiqr9/i7lz/VKffA+ML0KYvPKFU20FVRPWK8gOapjnnKfhAoGBAI9usEVzvKt1lQ6/srkDEBuNNBm82fMgJH7ljYaUiom1W4zm8vEEwviBkWZ6BVtPnv5VPiTuBxm6oqjCYJ18IxGAXIk7275hvuuDsCkcffxRpYqGhLNPC2DoS/QuOPfFIAke98mxCAFgr6dlJWgXLeuLyfSM+jjP+jzr9p5i3XOv',
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
    'return_url'                => env('APP_URL', 'http://www.zhongshang.shop').'/order/result/ali' ,
    'return_raw'                => false,// 在处理回调时，是否直接返回原始数据，默认为 true
];