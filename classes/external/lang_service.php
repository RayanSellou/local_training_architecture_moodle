<?php

namespace local_training_architecture\external;

defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/externallib.php");

use external_api;
use external_function_parameters;
use external_single_structure;
use external_value;

/**
 * External service to retrieve localized strings.
 */
class lang_service extends external_api {

    /**
     * Defines the parameters for the get_lang_strings function.
     * @return external_function_parameters
     */
    public static function get_lang_strings_parameters() {
        return new external_function_parameters([]);
    }

    /**
     * Retrieves localized strings for 'expand' and 'collapse'.
     * @return array
     */
    public static function get_lang_strings() {
        global $CFG;

        // Retrieve the strings from the language files
        $expand = get_string('expand', 'local_training_architecture');
        $collapse = get_string('collapse', 'local_training_architecture');

        return [
            'expand' => $expand,
            'collapse' => $collapse
        ];
    }

    /**
     * Defines the structure of the returned data.
     * @return external_single_structure
     */
    public static function get_lang_strings_returns() {
        return new external_single_structure([
            'expand' => new external_value(PARAM_TEXT, 'Expand label'),
            'collapse' => new external_value(PARAM_TEXT, 'Collapse label'),
        ]);
    }
}
