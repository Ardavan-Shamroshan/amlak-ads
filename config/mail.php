<?php
return [
    /*
       |--------------------------------------------------------------------------
       | Mailer Configurations
       |--------------------------------------------------------------------------
       |
       | Here you may configure all of the mailers used by your application plus
       | their respective settings. Several examples have been configured for
       | you and you are free to add your own as your application requires.
       |
       | Laravel supports a variety of mail "transport" drivers to be used while
       | sending an e-mail. You will specify which one you are using for your
       | mailers below. You are free to add additional mailers as required.
       |
       | Supported: "smtp", "sendmail", "mailtrap", "ses",
       |            "postmark", "log", "array"
       |
       */

    'SMTP' => [
        'Host' => 'smtp.gmail.com',
        'SMTPAuth' => true,
        'Username' => 'raphael2000.r@gmail.com',
        'Password' => '13801380',
        'Port' => 587,
        'setFrom' => [
            'mail' => 'raphael2000.r@gmail.com',
            'name' => 'AmlakAds Email service',
        ]
    ]
];

