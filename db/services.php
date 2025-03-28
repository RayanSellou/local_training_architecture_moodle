<?php

$functions = [
    'local_training_architecture_get_lang_strings' => [
        'classname'   => 'local_training_architecture_lang_service',
        'methodname'  => 'get_lang_strings',
        'classpath'   => 'local/training_architecture/externallib.php',
        'description' => 'Retrieve localized strings for expand and collapse.',
        'type'        => 'read',
        'ajax'        => true, // Permet l'appel AJAX sans authentification
    ],
    'local_training_architecture_get_lu_list' => [
        'classname'   => 'local_training_architecture_external', 
        'methodname'  => 'get_lu_list',  
        'classpath'   => 'local/training_architecture/externallib.php',  
        'description' => 'Retrieve a list of LU for a given training ID.',
        'type'        => 'read', 
        'ajax'        => true,  
    ],
    // 'local_training_architecture_delete_courses_not_in_architecture' => [
    //     'classname'   => 'local_training_architecture\external\multiple_delete_courses_not_in_architecture_service',
    //     'methodname'  => 'delete_courses_not_in_architecture',
    //     'classpath'   => '',
    //     'description' => 'Delete courses that are not in the architecture.',
    //     'type'        => 'write',
    //     'ajax'        => true,
    // ],
    // 'local_training_architecture_delete_lu_to_lu' => [
    //     'classname'   => 'local_training_architecture\external\multiple_delete_lu_to_lu_service',
    //     'methodname'  => 'delete_lu_to_lu',
    //     'classpath'   => '',
    //     'description' => 'Delete LU to LU links',
    //     'type'        => 'write',
    //     'ajax'        => true, // Permet l'appel AJAX sans authentification
    // ],
    // 'local_training_architecture_delete_training_links' => [
    //     'classname'   => 'local_training_architecture\external\multiple_delete_training_links_service',
    //     'methodname'  => 'delete_training_links',
    //     'classpath'   => '',
    //     'description' => 'Delete selected training links',
    //     'type'        => 'write',
    //     'ajax'        => true, // Permet l'appel AJAX sans authentification
    // ],
];

$services = [
    'Local Training Architecture Service' => [
        'functions' => [
            // 'local_training_architecture_get_lang_strings',
            'local_training_architecture_get_lu_list',
            // 'local_training_architecture_delete_courses_not_in_architecture',
            // 'local_training_architecture_delete_lu_to_lu',
            // 'local_training_architecture_delete_training_links',
    ],
        'restrictedusers' => 0,
        'enabled' => 1,
        'shortname' => 'local_training_architecture_service',
    ],

];
