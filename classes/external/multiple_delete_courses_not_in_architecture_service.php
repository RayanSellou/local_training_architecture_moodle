<?php

namespace local_training_architecture\external;

require_once($CFG->libdir . '/externallib.php');
require_once($CFG->dirroot . '/local/training_architecture/classes/functions.php');

class multiple_delete_courses_not_in_architecture_service extends \external_api {

    public static function delete_courses_not_in_architecture_parameters() {
        return new \external_function_parameters([
            'selectedIds' => new \external_value(\PARAM_INT, 'Array of course IDs to delete', VALUE_DEFAULT, []),
        ]);
    }

    public static function delete_courses_not_in_architecture($selectedIds) {
        global $DB;

        // Vérification de sécurité
        if (empty($selectedIds)) {
            throw new \invalid_parameter_exception('No course IDs provided');
        }

        // Suppression des cours
        foreach ($selectedIds as $courseId) {
            // Suppression des enregistrements dans la table 'course' (par exemple)
            $DB->delete_records('course', ['id' => $courseId]);
        }

        // Retourne l'URL de redirection après la suppression
        return [
            'redirectUrl' => $CFG->wwwroot . '/local/training_architecture/index.php',
        ];
    }

    public static function delete_courses_not_in_architecture_returns() {
        return new \external_single_structure([
            'redirectUrl' => new \external_value(\PARAM_URL, 'The redirect URL after deletion'),
        ]);
    }
}
