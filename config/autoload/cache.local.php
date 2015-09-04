<?php
return array(
    // Cache that is used only for storing and fetching data without any form of convertion.
    'cache' => array (
        'adapter' => array(
            'name' => 'filesystem',
            'options' => array (
                'cache_dir' => 'data/cache/text',
            )
        ),
        'plugins' => array(
            // Don't throw exceptions on cache errors
            'exception_handler' => array(
                'throw_exceptions' => false
            ),
        )
    ),

    // This cache allows us to store variables in a serialized form
    'var-cache' => array (
        'adapter' => array(
            'name' => 'filesystem',
            'options' => array (
                'cache_dir' => 'data/cache/var',
            )
        ),
        'plugins' => array(
            // Don't throw exceptions on cache errors
            'exception_handler' => array(
                'throw_exceptions' => false
            ),
            'serializer' => array (
                'serializer' => 'Zend\Serializer\Adapter\PhpSerialize',
            )
        )
    ),

        'cache-enabled-services' => array(
                'translator',
        )
);
