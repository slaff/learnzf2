<?php
/**
 * Specify here the cipher settings for your current application environment.
 * If possible choose different encryption keys for your development and production environment.
 */
return array(
    'cipher' => array(
        'adapter' => 'mcrypt',
        'options' => array(
                'algo' => 'aes'
        ),
        'encryption_key' => '<ENTER-HERE-VERY-LONG-ENCRYPTION-KEY>',
    ),
    'bcrypt' => array(
        'salt' => '1234567890123456',
        'cost' => 16
    )
);
