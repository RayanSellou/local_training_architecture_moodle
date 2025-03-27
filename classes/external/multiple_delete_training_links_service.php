<?php

namespace local_training_architecture\external;

require_once($CFG->libdir . '/externallib.php');

class multiple_delete_training_links_service extends \external_api {

    /**
     * Définit les paramètres d'entrée de la fonction du Web Service.
     */
    public static function delete_training_links_parameters() {
        return new \external_function_parameters([
            'selectedIds' => new \external_value(\PARAM_INT, 'Array of training link IDs to delete', VALUE_DEFAULT, []),
        ]);
    }

    /**
     * La fonction qui va effectuer la suppression des liens de formation.
     *
     * @param array $selectedIds - Les IDs des liens de formation à supprimer.
     * @return array - URL de redirection après la suppression.
     */
    public static function delete_training_links($selectedIds) {
        global $DB, $CFG;

        // Vérification de la sécurité des paramètres
        if (empty($selectedIds)) {
            throw new \invalid_parameter_exception('No selected IDs provided');
        }

        // Suppression des enregistrements dans la table 'training_links' (ou autre table concernée)
        foreach ($selectedIds as $linkId) {
            // Exemple de suppression dans la table 'training_links', remplace avec ta table
            $DB->delete_records('training_links', ['id' => $linkId]);
        }

        // Créer une URL de redirection après la suppression
        $redirectUrl = $CFG->wwwroot . '/local/training_architecture/classes/multiple_delete/training_links.php?' . http_build_query(['id' => $selectedIds]);

        // Retourner l'URL de redirection
        return [
            'redirectUrl' => $redirectUrl,
        ];
    }

    /**
     * Définit le format de retour du Web Service.
     */
    public static function delete_training_links_returns() {
        return new \external_single_structure([
            'redirectUrl' => new \external_value(\PARAM_URL, 'The redirect URL after deletion'),
        ]);
    }
}
