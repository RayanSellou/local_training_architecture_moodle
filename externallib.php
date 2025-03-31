<?php

// Ce fichier est pour l'implémentation de fonctions externes dans Moodle.
require_once("$CFG->libdir/externallib.php");
require_once($CFG->dirroot . '/local/training_architecture/classes/local/functions/lu_lu_functions.php');
require_once($CFG->dirroot . '/local/training_architecture/classes/local/functions/common_functions.php');
require_once($CFG->dirroot . "/local/training_architecture/classes/local/functions/training_links_functions.php");

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

    /**
     * Define parameters for delete multiple LU-to-LU links.
     *
     * @return external_function_parameters
     */
    public static function multiple_delete_lu_to_lu_parameters() {
        return new external_function_parameters([
            'selectedIds' => new external_multiple_structure(new external_value(PARAM_INT, 'ID of LU-to-LU link'))
        ]);
    }

    /**
     * Delete multiple LU-to-LU links.
     *
     * @param array $selectedIds Array of LU-to-LU link IDs.
     * @return array Status and message.
     */
    public static function multiple_delete_lu_to_lu($selectedIds) {
        global $DB;

        // Validate parameters
        $params = self::validate_parameters(self::multiple_delete_lu_to_lu_parameters(), ['selectedIds' => $selectedIds]);

        if (empty($params['selectedIds'])) {
            throw new invalid_parameter_exception('No IDs provided.');
        }

        $luFunctions = new lu_lu_functions();

        foreach ($params['selectedIds'] as $id) {
            if (!$DB->record_exists('local_training_architecture_lu_to_lu', ['id' => $id])) {
                throw new invalid_parameter_exception("Invalid ID: $id");
            }
            $luFunctions->deleteLink($id);
        }

        return ['status' => 'success', 'message' => count($params['selectedIds']) . ' LU-to-LU links deleted.'];
    }

    /**
     * Define return structure for delete multiple LU-to-LU links.
     *
     * @return external_single_structure
     */
    public static function multiple_delete_lu_to_lu_returns() {
        return new external_single_structure([
            'status' => new external_value(PARAM_TEXT, 'Status of the operation'),
            'message' => new external_value(PARAM_TEXT, 'Message about the operation result')
        ]);
    }

    public static function multiple_delete_training_links_parameters() {
        return new external_function_parameters([
            'selectedIds' => new external_multiple_structure(new external_value(PARAM_INT, 'ID du training link'))
        ]);
    }

    public static function multiple_delete_training_links($selectedIds) {
        global $DB;

        $params = self::validate_parameters(self::multiple_delete_training_links_parameters(), ['selectedIds' => $selectedIds]);

        if (empty($params['selectedIds'])) {
            throw new moodle_exception('invalid_parameter', 'error', '', 'Aucun ID fourni.');
        }

        $trainingLinksFunctions = new training_links_functions();

        foreach ($params['selectedIds'] as $id) {
            if (!$DB->record_exists('local_training_architecture_training_links', ['id' => $id])) {
                throw new moodle_exception('invalid_parameter', 'error', '', "L'ID $id n'existe pas.");
            }
            $trainingLinksFunctions->deleteLink($id);
        }

        return ['status' => 'success', 'message' => count($params['selectedIds']) . ' training links supprimés.'];
    }

    public static function multiple_delete_training_links_returns() {
        return new external_single_structure([
            'status'  => new external_value(PARAM_TEXT, 'Succès ou échec'),
            'message' => new external_value(PARAM_TEXT, 'Message de confirmation'),
        ]);
    }

    // /**
    //  * Définition des paramètres pour la méthode move_lu_sort_order.
    //  * @return external_function_parameters
    //  */
    // public static function move_lu_sort_order_parameters() {
    //     return new external_function_parameters([
    //         'luId' => new external_value(PARAM_INT, 'ID de la LU à déplacer'),
    //         'luToMove' => new external_value(PARAM_INT, 'ID de la LU cible vers laquelle déplacer'),
    //         'trainingId' => new external_value(PARAM_INT, 'ID de la formation'),
    //         'granularityLevel' => new external_value(PARAM_INT, 'Niveau de granularité'),
    //         'level' => new external_value(PARAM_ALPHA, 'Niveau (ex : level1)')
    //     ]);
    // }

    // /**
    //  * Fonction qui effectue le déplacement de l’ordre de LU.
    //  * @param int $luId ID de la LU à déplacer.
    //  * @param int $luToMove ID de la LU cible vers laquelle déplacer.
    //  * @param int $trainingId ID de la formation.
    //  * @param int $granularityLevel Niveau de granularité.
    //  * @param string $level Niveau (par exemple level1)
    //  * @return array Le statut de la fonction et un message.
    //  */
    // public static function move_lu_sort_order($luId, $luToMove, $trainingId, $granularityLevel, $level) {
    //     global $DB;

    //     // Validation des paramètres
    //     $params = self::validate_parameters(self::move_lu_sort_order_parameters(), [
    //         'luId' => $luId,
    //         'luToMove' => $luToMove,
    //         'trainingId' => $trainingId,
    //         'granularityLevel' => $granularityLevel,
    //         'level' => $level
    //     ]);

    //     // Récupère les enregistrements LU actuels
    //     $actualLu = $DB->get_record('local_training_architecture_order', ['trainingid' => $trainingId, 'luid' => $luId]);
    //     $luToMoveRecord = $DB->get_record('local_training_architecture_order', ['trainingid' => $trainingId, 'luid' => $luToMove]);

    //     if (!$actualLu || !$luToMoveRecord) {
    //         throw new invalid_parameter_exception('Une ou plusieurs LU n\'existent pas.');
    //     }

    //     // Effectue l'échange des ordres de tri
    //     $old_lu_order = $actualLu->sortorder;
    //     $record1 = (object)[
    //         'id' => $actualLu->id,
    //         'trainingid' => $trainingId,
    //         'luid' => $luId,
    //         'sortorder' => $luToMoveRecord->sortorder
    //     ];

    //     $record2 = (object)[
    //         'id' => $luToMoveRecord->id,
    //         'trainingid' => $trainingId,
    //         'luid' => $luToMove,
    //         'sortorder' => $old_lu_order
    //     ];

    //     // Mise à jour des enregistrements dans la base de données
    //     $DB->update_record('local_training_architecture_order', $record1);
    //     $DB->update_record('local_training_architecture_order', $record2);

    //     // Logique de granularité et niveau
    //     $newOrder = [];
    //     if ($level == "level1") {
    //         if ($granularityLevel == '1') {
    //             $newOrder = $DB->get_records_sql('SELECT DISTINCT luid1 FROM {local_training_architecture_lu_to_lu} WHERE trainingid = ?', [$trainingId]);
    //         } else {
    //             $newOrder = $DB->get_records_sql('SELECT DISTINCT luid1 FROM {local_training_architecture_lu_to_lu} WHERE trainingid = ? AND isluid2course = ?', [$trainingId, 'false']);
    //         }
    //     } else {
    //         if ($granularityLevel == '1') {
    //             $newOrder = $DB->get_records_sql('SELECT DISTINCT luid1 FROM {local_training_architecture_lu_to_lu} WHERE trainingid = ?', [$trainingId]);
    //         } else {
    //             $newOrder = $DB->get_records_sql('SELECT DISTINCT luid1 FROM {local_training_architecture_lu_to_lu} WHERE trainingid = ? AND isluid2course = ?', [$trainingId, 'true']);
    //         }
    //     }

    //     // Retourne le résultat sous forme de tableau
    //     return ['status' => 'success', 'message' => 'Ordre de tri des LU mis à jour.'];
    // }

    // /**
    //  * Définit la structure de données renvoyées pour la fonction move_lu_sort_order.
    //  * @return external_single_structure
    //  */
    // public static function move_lu_sort_order_returns() {
    //     return new external_single_structure([
    //         'status' => new external_value(PARAM_TEXT, 'Statut de l\'opération'),
    //         'message' => new external_value(PARAM_TEXT, 'Message relatif à l\'opération')
    //     ]);
    // }

    public static function get_training_level_parameters() {
        return new external_function_parameters([
            'trainingId' => new external_value(PARAM_INT, 'ID of the training')
        ]);
    }

    public static function get_training_level($trainingId) {
        global $DB;

        // Validation de l'ID de formation
        if (!is_int($trainingId)) {
            throw new moodle_exception('invalid_training_id');
        }

        // Obtenir le niveau de granularité
        $granularitylevel = $DB->get_field('local_training_architecture_training', 'granularitylevel', ['id' => $trainingId]);

        // Vérifier si la formation existe
        if ($granularitylevel === false) {
            throw new moodle_exception('training_not_found');
        }

        // Retourner le résultat
        return $granularitylevel;
    }

    public static function get_training_level_returns() {
        return new external_value(PARAM_INT, 'Granularity level of the training');
    }


}