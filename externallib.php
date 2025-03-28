<?php

// Ce fichier est pour l'implémentation de fonctions externes dans Moodle.
require_once("$CFG->libdir/externallib.php");

class local_training_architecture_external extends external_api {

    // Définition des paramètres pour la méthode get_lu_list
    public static function get_lu_list_parameters() {
        return new external_function_parameters([
            'trainingId' => new external_value(PARAM_INT, 'ID de la formation')
        ]);
    }

    // Fonction qui récupère la liste des LU pour une formation donnée
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

    // Retourne les résultats de la fonction
    public static function get_lu_list_returns() {
        return new external_multiple_structure(
            new external_single_structure([
                'id' => new external_value(PARAM_INT, 'ID de la LU'),
                'fullname' => new external_value(PARAM_TEXT, 'Nom de la LU')
            ])
        );
    }



    /**
     * Définition des paramètres pour la méthode get_lang_strings.
     * @return external_function_parameters
     */
    public static function get_lang_strings_parameters() {
        return new external_function_parameters([]);
    }

    /**
     * Fonction qui récupère les chaînes localisées pour 'expand' et 'collapse'.
     * @return array
     */
    public static function get_lang_strings() {
        global $CFG;

        // Récupère les chaînes à partir des fichiers de langue
        $expand = get_string('expand', 'local_training_architecture');
        $collapse = get_string('collapse', 'local_training_architecture');

        return [
            'expand' => $expand,
            'collapse' => $collapse
        ];
    }

    /**
     * Définit la structure des données renvoyées par la fonction.
     * @return external_single_structure
     */
    public static function get_lang_strings_returns() {
        return new external_single_structure([
            'expand' => new external_value(PARAM_TEXT, 'Label de l\'expand'),
            'collapse' => new external_value(PARAM_TEXT, 'Label du collapse'),
        ]);
    }


    // Définition des paramètres pour delete_courses_not_in_architecture
    public static function delete_courses_not_in_architecture_parameters() {
        return new external_function_parameters([
            'selectedIds' => new external_multiple_structure(
                new external_value(PARAM_INT, 'ID du lien à supprimer'),
                'Liste des IDs des liens à supprimer (dans la table local_training_architecture_courses_not_architecture)'
            ),
        ]);
    }

    // Fonction pour supprimer les liens des cours qui ne sont pas dans l'architecture
    public static function delete_courses_not_in_architecture($selectedIds) {
        global $DB, $CFG;

        // Vérification de sécurité
        if (empty($selectedIds)) {
            throw new invalid_parameter_exception('Aucun ID de lien fourni.');
        }

        error_log('Selected IDs: ' . implode(',', $selectedIds));

        // Suppression des liens dans la table 'local_training_architecture_courses_not_architecture'
        foreach ($selectedIds as $id) {
            // On supprime uniquement les enregistrements de la table local_training_architecture_courses_not_architecture
            // où l'ID correspond au lien entre le cours et l'architecture
            $DB->delete_records('local_training_architecture_courses_not_architecture', ['id' => $id]);
        }

        // Retourne l'URL de redirection après la suppression des liens
        return [
            'redirectUrl' => $CFG->wwwroot . '/local/training_architecture/index.php',
        ];
    }

    // Retourne les résultats de la fonction
    public static function delete_courses_not_in_architecture_returns() {
        return new external_single_structure([
            'redirectUrl' => new external_value(PARAM_URL, 'L\'URL de redirection après suppression'),
        ]);
    }

}