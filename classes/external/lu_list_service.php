<?php
require_once("$CFG->libdir/externallib.php");

class local_training_architecture_external extends external_api {

    public static function get_lu_list_parameters() {
        return new external_function_parameters([
            'trainingId' => new external_value(PARAM_INT, 'ID de la formation')
        ]);
    }

    public static function get_lu_list($trainingId) {
        global $DB;

        // Vérifie si la formation existe
        if (!$DB->record_exists('local_training_architecture_training_links', ['trainingid' => $trainingId])) {
            throw new invalid_parameter_exception('Formation introuvable.');
        }

        // Récupère les LU liées
        $links = $DB->get_records('local_training_architecture_training_links', ['trainingid' => $trainingId]);
        $result = [];

        foreach ($links as $link) {
            $lu_info = $DB->get_record('local_training_architecture_lu', ['id' => $link->luid]);
            
            if ($lu_info) {
                $result[] = [
                    'id' => $link->luid,
                    'fullname' => $lu_info->fullname
                ];
            }
        }

        return $result;
    }

    public static function get_lu_list_returns() {
        return new external_multiple_structure(
            new external_single_structure([
                'id' => new external_value(PARAM_INT, 'ID de la LU'),
                'fullname' => new external_value(PARAM_TEXT, 'Nom de la LU')
            ])
        );
    }
}
