<?php
/**
 * External services declaration for the Local Training Architecture plugin.
 *
 * This file defines the list of external functions (web services)
 * that are exposed by the local_training_architecture plugin.
 *
 * Each function is mapped with:
 *  - Its external class and method.
 *  - The description of what the function does.
 *  - Whether it is a read or write operation.
 *  - Its availability via AJAX.
 *
 * @package    local_training_architecture
 * @category   external
 * @copyright  2025 IFRASS
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$functions = [
    'local_training_architecture_get_lang_strings' => [
        'classname'   => 'local_training_architecture_external',
        'methodname'  => 'get_lang_strings',
        'classpath'   => 'local/training_architecture/externallib.php',
        'description' => 'Retrieve localized strings for expand and collapse.',
        'type'        => 'read',
        'ajax'        => true, 
    ],
    'local_training_architecture_get_lu_list' => [
        'classname'   => 'local_training_architecture_external', 
        'methodname'  => 'get_lu_list',  
        'classpath'   => 'local/training_architecture/externallib.php',  
        'description' => 'Retrieve a list of LU for a given training ID.',
        'type'        => 'read', 
        'ajax'        => true,  
    ],
    'local_training_architecture_delete_courses_not_in_architecture' => [
        'classname'   => 'local_training_architecture_external',
        'methodname'  => 'delete_courses_not_in_architecture',
        'classpath'   => 'local/training_architecture/externallib.php',
        'description' => 'Delete courses that are not in the architecture.',
        'type'        => 'write',
        'ajax'        => true,
    ],
    'local_training_architecture_multiple_delete_lu_to_lu' => [
        'classname'   => 'local_training_architecture_external',
        'methodname'  => 'multiple_delete_lu_to_lu',
        'classpath'   => 'local/training_architecture/externallib.php',
        'description' => 'Delete multiple LU to LU links',
        'type'        => 'write',
        'ajax'        => true, 
    ],
    'local_training_architecture_multiple_delete_training_links' => [
        'classname'   => 'local_training_architecture_external',
        'methodname'  => 'multiple_delete_training_links',
        'classpath'   => 'local/training_architecture/externallib.php',
        'description' => 'Delete multiple training links',
        'type'        => 'write',
        // 'ajax'        => true,
    ],
    'local_training_architecture_get_training_level' => [
    'classname'   => 'local_training_architecture_external',
    'methodname'  => 'get_training_level',
    'classpath'   => 'local/training_architecture/externallib.php',
    'description' => 'Retrieve granularity level of a training',
    'type'        => 'read',
    'ajax'        => true,
    ],
    'local_training_architecture_get_training_links' => [
        'classname'   => 'local_training_architecture_external',
        'methodname'  => 'get_training_links',
        'classpath'   => 'local/training_architecture/externallib.php',
        'description' => 'Retrieve whether the training is a course or a semester based on the given level.',
        'type'        => 'read',
        'ajax'        => true,
    ],
    'local_training_architecture_move_lu_sort_order' => [
        'classname'   => 'local_training_architecture_external',
        'methodname'  => 'move_lu_sort_order',
        'classpath'   => 'local/training_architecture/externallib.php',
        'description' => 'Move LU sort order within a training architecture.',
        'type'        => 'write',
        'ajax'        => true, 
    ],
];

$services = [
    'Local Training Architecture Service' => [
        'functions' => [
            'local_training_architecture_get_lang_strings',
            'local_training_architecture_get_lu_list',
            'local_training_architecture_delete_courses_not_in_architecture',
            'local_training_architecture_multiple_delete_lu_to_lu',
            'local_training_architecture_multiple_delete_training_links',
            'local_training_architecture_get_training_level',
            'local_training_architecture_get_training_links',
            'local_training_architecture_move_lu_sort_order', 
    ],
        'restrictedusers' => 0,
        'enabled' => 1,
        'shortname' => 'local_training_architecture_service',
    ],

];
