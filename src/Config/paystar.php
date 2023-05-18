<?php 


return [
    'urls' => [
        'create' => 'https://core.paystar.ir/api/pardakht/create',
        'pay' => "https://core.paystar.ir/api/pardakht/payment/?token=",
        'verify' => 'https://core.paystar.ir/api/pardakht/verify',
    ],
    'terminal_id' => '0yovdk2l6e143',
    'secret_key' => "9A3EC03483556C73714510C507529DF70A1228C83477D1455E0511BD72C5AAB8A6715A414AA48B7C905FCEF45868BD26DA58196EF29C77C194C9F14A4B47456CC6454E9D50B388D6FC5AC91BB08B234A8060FDC85B1CEC32CA036DC907F8A4A635D9CBB9CAA31B42549B8D70B2CE5EDE8274FFB55DABFE92D76BC42D91696FAF",
    'transaction_status' => [
        'ok',
        'cancel',
        'pending',
        'not-verified'
    ],
    'status' =>  [
        '1' => [ 'en' => 'Ok', 'fa' => 'موفق' ],
        '-1' => [ 'en' => 'invalidRequest', 'fa' => 'درخواست نامعتبر (خطا در پارامترهای ورودی)' ],
        '-2' => [ 'en' => 'inactiveGateway', 'fa' => 'درگاه فعال نیست' ],
        '-3' => [ 'en' => 'retryToken', 'fa' => 'توکن تکراری است' ],
        '-4' => [ 'en' => 'amountLimitExceed', 'fa' => 'مبلغ بیشتر از سقف مجاز درگاه است' ],
        '-5' => [ 'en' => 'invalidRefNum', 'fa' => 'شناسه ref_num معتبر نیست' ],
        '-6' => [ 'en' => 'retryVerification', 'fa' => 'تراکنش قبلا وریفای شده است' ],
        '-7' => [ 'en' => 'badData', 'fa' => 'پارامترهای ارسال شده نامعتبر است' ],
        '-8' => [ 'en' => 'trNotVerifiable', 'fa' => 'تراکنش را نمیتوان وریفای کرد' ],
        '-9' => [ 'en' => 'trNotVerified', 'fa' => 'تراکنش وریفای نشد' ],
        '-98' => [ 'en' => 'paymentFailed', 'fa' => 'تراکنش ناموفق'],
        '-99' => [ 'en' => 'error', 'fa' => 'خطای سامانه'],
    ]
];