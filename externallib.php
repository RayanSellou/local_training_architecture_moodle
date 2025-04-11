<?php
/**
 * External functions for the training architecture local plugin.
 *
 * This class contains AJAX-exposed services used to handle training links,
 * LU operations, and UI helper calls.
 *
 * @package    local_training_architecture
 * @copyright  2025 IFRASS
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once("$CFG->libdir/externallib.php");
require_once($CFG->dirroot . '/local/training_architecture/classes/local/functions/lu_lu_functions.php');
require_once($CFG->dirroot . '/local/training_architecture/classes/local/functions/common_functions.php');
require_once($CFG->dirroot . "/local/training_architecture/classes/local/functions/training_links_functions.php");

class local_training_architecture_external extends external_api {

    /**
     * Returns the list of LU (Learning Units) linked to a specific training.
     *
     * @param int $trainingId ID of the training.
     * @return array List of LUs with id and fullname.
     * @throws invalid_parameter_exception If the training does not exist.
     */
    public static function get_lu_list_parameters() {
        return new external_function_parameters([
            'trainingId' => new external_value(PARAM_INT, 'ID de la formation')
        ]);
    }

    public static function get_lu_list($trainingId) {
        global $DB;

        // Check if the formation exists
        if (!$DB->record_exists('local_training_architecture_training_links', ['trainingid' => $trainingId])) {
            throw new invalid_parameter_exception('Formation introuvable.');
        }

        // Get linked LUs
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



    /**
     * Returns localized strings for use in JS (e.g., expand/collapse).
     *
     * @return array Associative array with 'expand' and 'collapse' labels.
     */
    public static function get_lang_strings_parameters() {
        return new external_function_parameters([]);
    }


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


    public static function get_lang_strings_returns() {
        return new external_single_structure([
            'expand' => new external_value(PARAM_TEXT, 'Label de l\'expand'),
            'collapse' => new external_value(PARAM_TEXT, 'Label du collapse'),
        ]);
    }


    /**
     * Deletes course-to-architecture links from the custom table.
     *
     * @param int[] $selectedIds List of link IDs to delete.
     * @return array Redirect URL.
     * @throws invalid_parameter_exception If no IDs are provided.
     */
    public static function delete_courses_not_in_architecture_parameters() {
        return new external_function_parameters([
            'selectedIds' => new external_multiple_structure(
                new external_value(PARAM_INT, 'ID du lien à supprimer'),
                'Liste des IDs des liens à supprimer (dans la table local_training_architecture_courses_not_architecture)'
            ),
        ]);
    }

    public static function delete_courses_not_in_architecture($selectedIds) {
        global $DB, $CFG;

        if (empty($selectedIds)) {
            throw new invalid_parameter_exception('Aucun ID de lien fourni.');
        }

        error_log('Selected IDs: ' . implode(',', $selectedIds));

        // Deletion of the links in the table'local_training_architecture_courses_not_architecture'
        foreach ($selectedIds as $id) {
            // On supprime uniquement les enregistrements de la table local_training_architecture_courses_not_architecture
            // où l'ID correspond au lien entre le cours et l'architecture
            $DB->delete_records('local_training_architecture_courses_not_architecture', ['id' => $id]);
        }

        // Return the redirection URL after the links'deletion 
        return [
            'redirectUrl' => $CFG->wwwroot . '/local/training_architecture/index.php',
        ];
    }

    public static function delete_courses_not_in_architecture_returns() {
        return new external_single_structure([
            'redirectUrl' => new external_value(PARAM_URL, 'L\'URL de redirection après suppression'),
        ]);
    }

    /**
     * Deletes multiple LU-to-LU links.
     *
     * @param int[] $selectedIds Array of LU-to-LU link IDs.
     * @return array Operation result.
     * @throws invalid_parameter_exception If an invalid ID is found.
     */
    public static function multiple_delete_lu_to_lu_parameters() {
        return new external_function_parameters([
            'selectedIds' => new external_multiple_structure(new external_value(PARAM_INT, 'ID of LU-to-LU link'))
        ]);
    }


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


    /**
     * Deletes multiple training links.
     *
     * @param int[] $selectedIds IDs of the training links to delete.
     * @return array Operation status and message.
     * @throws moodle_exception If an invalid ID is provided.
     */
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


    /**
     * Returns the granularity level of a given training.
     *
     * @param int $trainingId ID of the training.
     * @return int Granularity level.
     * @throws moodle_exception If the training does not exist.
     */
    public static function get_training_level_parameters() {
        return new external_function_parameters([
            'trainingId' => new external_value(PARAM_INT, 'ID of the training')
        ]);
    }

    public static function get_training_level($trainingId) {
        global $DB;

        // Validation of the formation's ID
        if (!is_int($trainingId)) {
            throw new moodle_exception('invalid_training_id');
        }

        // Get the granularity level 
        $granularitylevel = $DB->get_field('local_training_architecture_training', 'granularitylevel', ['id' => $trainingId]);

        if ($granularitylevel === false) {
            throw new moodle_exception('training_not_found');
        }

        return $granularitylevel;
    }

    public static function get_training_level_returns() {
        return new external_value(PARAM_INT, 'Granularity level of the training');
    }


    public static function get_training_links_parameters() {
        return new external_function_parameters([
            'trainingId' => new external_value(PARAM_INT, 'ID of the training'),
            'level' => new external_value(PARAM_INT, 'The level of the training')
        ]);
    }

    public static function get_training_links($trainingId, $level) {
        global $DB;

        if (!is_int($trainingId) || !is_int($level)) {
            throw new moodle_exception('invalid_parameters');
        }

        $granularityLevel = (int) $DB->get_field('local_training_architecture_training', 'granularitylevel', ['id' => $trainingId]);

        // If the asked level is higher than the granularity
        $course = false;
        $semester = false;

        if ($granularityLevel + 1 === (int) $level) {
            $course = true;

            $isSemester = (int) $DB->get_field('local_training_architecture_training', 'issemester', ['id' => $trainingId]);

            if ($isSemester === 1) {
                $semester = true;
            }
        }

        return [
            'course' => $course,
            'semester' => $semester
        ];
    }

    public static function get_training_links_returns() {
        return new external_single_structure( 
            [
                'course' => new external_value(PARAM_BOOL, 'Whether this is a course'),
                'semester' => new external_value(PARAM_BOOL, 'Whether this is a semester')
            ]
        );
    }

    /**
     * Moves LU sort order between two items.
     *
     * @param int $luId LU to move.
     * @param int $luToMove LU target.
     * @param int $trainingId ID of the training.
     * @param int $granularityLevel Granularity level of the training.
     * @param string $level Level identifier (e.g., 'level1').
     * @return array Status and message after reorder.
     * @throws invalid_parameter_exception If LU records are not found.
     */
    public static function move_lu_sort_order_parameters() {
        return new external_function_parameters([
            'luId' => new external_value(PARAM_INT, 'ID de la LU à déplacer'),
            'luToMove' => new external_value(PARAM_INT, 'ID de la LU cible vers laquelle déplacer'),
            'trainingId' => new external_value(PARAM_INT, 'ID de la formation'),
            'granularityLevel' => new external_value(PARAM_INT, 'Niveau de granularité'),
            'level' => new external_value(PARAM_ALPHANUM, 'Niveau (ex : level1)')

        ]);
    }

    
    public static function move_lu_sort_order($luId, $luToMove, $trainingId, $granularityLevel, $level) {
        global $DB;

        $params = self::validate_parameters(self::move_lu_sort_order_parameters(), [
            'luId' => $luId,
            'luToMove' => $luToMove,
            'trainingId' => $trainingId,
            'granularityLevel' => $granularityLevel,
            'level' => $level
        ]);

        $actualLu = $DB->get_record('local_training_architecture_order', ['trainingid' => $trainingId, 'luid' => $luId]);
        $luToMoveRecord = $DB->get_record('local_training_architecture_order', ['trainingid' => $trainingId, 'luid' => $luToMove]);

        if (!$actualLu || !$luToMoveRecord) {
            throw new invalid_parameter_exception('Une ou plusieurs LU n\'existent pas.');
        }

        $old_lu_order = $actualLu->sortorder;
        $record1 = (object)[
            'id' => $actualLu->id,
            'trainingid' => $trainingId,
            'luid' => $luId,
            'sortorder' => $luToMoveRecord->sortorder
        ];

        $record2 = (object)[
            'id' => $luToMoveRecord->id,
            'trainingid' => $trainingId,
            'luid' => $luToMove,
            'sortorder' => $old_lu_order
        ];

        $DB->update_record('local_training_architecture_order', $record1);
        $DB->update_record('local_training_architecture_order', $record2);

        // Granularity and level logic 
        $newOrder = [];
        if ($level == "level1") {
            if ($granularityLevel == '1') {
                $newOrder = $DB->get_records_sql('SELECT DISTINCT luid1 FROM {local_training_architecture_lu_to_lu} WHERE trainingid = ?', [$trainingId]);
            } else {
                $newOrder = $DB->get_records_sql('SELECT DISTINCT luid1 FROM {local_training_architecture_lu_to_lu} WHERE trainingid = ? AND isluid2course = ?', [$trainingId, 'false']);
            }
        } else {
            if ($granularityLevel == '1') {
                $newOrder = $DB->get_records_sql('SELECT DISTINCT luid1 FROM {local_training_architecture_lu_to_lu} WHERE trainingid = ?', [$trainingId]);
            } else {
                $newOrder = $DB->get_records_sql('SELECT DISTINCT luid1 FROM {local_training_architecture_lu_to_lu} WHERE trainingid = ? AND isluid2course = ?', [$trainingId, 'true']);
            }
        }

        return ['status' => 'success', 'message' => 'Ordre de tri des LU mis à jour.'];
    }


    public static function move_lu_sort_order_returns() {
        return new external_single_structure([
            'status' => new external_value(PARAM_TEXT, 'Statut de l\'opération'),
            'message' => new external_value(PARAM_TEXT, 'Message relatif à l\'opération')
        ]);
    }


}