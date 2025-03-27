<?php

namespace local_training_architecture\external;

require_once($CFG->libdir . '/externallib.php');

class multiple_delete_lu_to_lu_service extends \external_api {

    // Paramètres de la fonction
    public static function delete_lu_to_lu_parameters() {
        return new \external_function_parameters([
            'selectedIds' => new \external_value(\PARAM_INT, 'Array of LU IDs to delete', VALUE_DEFAULT, []),
        ]);
    }

    // Fonction de suppression des liens LU à LU
    public static function delete_lu_to_lu($selectedIds) {
        global $DB;

        // Vérification de sécurité
        if (empty($selectedIds)) {
            throw new \invalid_parameter_exception('No LU IDs provided');
        }

        // Suppression des liens LU à LU dans la base de données
        foreach ($selectedIds as $luId) {
            // Suppression des enregistrements dans la table 'local_training_lu_to_lu' ou toute autre table concernée
            $DB->delete_records('local_training_lu_to_lu', ['id' => $luId]);
        }

        // Retourne l'URL de redirection après la suppression
        return [
            'redirectUrl' => $CFG->wwwroot . '/local/training_architecture/index.php',
        ];
    }

    // Définir le retour de la fonction
    public static function delete_lu_to_lu_returns() {
        return new \external_single_structure([
            'redirectUrl' => new \external_value(\PARAM_URL, 'The redirect URL after deletion'),
        ]);
    }
}
