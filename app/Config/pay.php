<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-31
 * Time: 下午4:44
 */
return [
    'local'=>[
        //微信小程序支付url
        'PAY_URL'=>'https://api.mch.weixin.qq.com/pay/unifiedorder',
        //商户号
        'MCH_ID'=>'1504528021',
        //支付回调地址
        'NOTIFY_URL'=>'https://www.ebikea.com/wechat/point/pay_callback',
        //支付秘钥
        'PAY_KEY'=>'fb9e16006856eacc2500856f1c39a05f'

    ],
    'qa'=>[
        //微信小程序支付url
        'PAY_URL'=>'https://api.mch.weixin.qq.com/pay/unifiedorder',
        //商户号
        'MCH_ID'=>'1504528021',
        //支付回调地址
        'NOTIFY_URL'=>'https://www.ebikea.com/wechat/point/pay_callback',
        //支付秘钥
        'PAY_KEY'=>'fb9e16006856eacc2500856f1c39a05f'
    ],
    'production'=>[
        //微信小程序支付url
        'PAY_URL'=>'https://api.mch.weixin.qq.com/pay/unifiedorder',
        //商户号
        'MCH_ID'=>'1504528021',
        //支付回调地址
        'NOTIFY_URL'=>'https://www.ebikea.com/wechat/point/pay_callback',
        //支付秘钥
        'PAY_KEY'=>'fb9e16006856eacc2500856f1c39a05f'
    ]

];