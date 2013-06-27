<?php
return array (
    'db' => array(
            'driver' => 'pdo_sqlite', //The database driver. Mysqli, Sqlsrv, Pdo_Sqlite, Pdo_Mysql, Pdo=OtherPdoDriver
            'database' => 'data/db/tc.sqlite',
            'path'   => 'data/db/tc.sqlite',
    		'options' => array (
    			'buffer_results' => 1
    		)
    )
);
