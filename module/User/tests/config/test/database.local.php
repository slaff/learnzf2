<?php
return array (
    'db' => array(
            'driver' => 'pdo_sqlite', // PDO_SQlite has the option to create in-memory database. Which is great for testing db's
            'database' => ':memory:',
    		'options' => array (
    			'buffer_results' => 1,
    		    
    		),
            'driver_options' => array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ) 
    )
);