<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.


/**
 * Delete multiple courses not in architecture links
 *
 * @copyright 2024 IFRASS
 * @author    2024 Esteban BIRET-TOSCANO <esteban.biret@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package   training_architecture
 */

 namespace local_training_architecture\local\multiple_delete;

use moodle_url;
use context_system;
use core\notification;
use single_button;
use core_exception;
use local_training_architecture\local\functions\common_functions;
use local_training_architecture\local\functions\courses_not_in_architecture_functions;

require_once(dirname(__FILE__) . '/../../../../config.php');

global $DB;
$commonFunctions = new common_functions();
$coursesNotInArchitectureFunctions = new courses_not_in_architecture_functions();

// MODIFICATION PRINCIPALE ICI - Nouvelle méthode de récupération des IDs
$ids_string = optional_param('ids', '', PARAM_TEXT);
$ids = !empty($ids_string) ? explode(',', $ids_string) : [];
$ids = array_map('intval', $ids); // Conversion en entiers
$ids = array_filter($ids); // Supprime les valeurs vides

$confirm = optional_param('confirm', 0, PARAM_BOOL);
$returnUrl = $CFG->wwwroot . '/local/training_architecture/index.php';

// Validation des paramètres
if (!empty($ids)) {
    // Vérification de l'existence de chaque ID dans la base de données
    foreach ($ids as $id) {
        if (!$courseNotInArchitecture = $DB->get_record('local_training_architecture_courses_not_architecture', ['id' => $id])) {
            throw new \moodle_exception('invalid_parameter_exception', 'Course ID not found');
        }
    }

    // Construction de la nouvelle URL
    $url = new moodle_url('/local/training_architecture/classes/multiple_delete/courses_not_in_architecture.php', [
        'ids' => implode(',', $ids),
        'sesskey' => sesskey()
    ]);
} else {
    redirect($returnUrl);
}

$PAGE->set_url($url);
require_login();
$context = \context_system::instance();
require_capability('local/training_architecture:manage', $context);
$PAGE->set_context($context);
$PAGE->set_title(get_string('deletenotarchitecture', 'local_training_architecture'));
$PAGE->set_heading(get_string('deletenotarchitecture', 'local_training_architecture'));
$PAGE->set_pagelayout('admin');

// Traitement de la suppression
if ($ids) {
    if (!$confirm) {
        $PAGE->set_title(get_string('deletemultipletitle1', 'local_training_architecture') .
        count($ids) . get_string('deletemultiplecoursesnotinarchitecturetitle2', 'local_training_architecture'));

        $PAGE->set_heading(get_string('deletemultipletitle1', 'local_training_architecture') .
        count($ids) . get_string('deletemultiplecoursesnotinarchitecturetitle2', 'local_training_architecture'));

        echo $OUTPUT->header();

        // Préparer le formulaire de confirmation (modifié pour utiliser la nouvelle URL)
        $formcontinue = new single_button(new moodle_url($url, ['confirm' => 1]), 
            get_string('confirmyes', 'local_training_architecture'), 'get');

        $formcancel = new \single_button(new moodle_url('/local/training_architecture/index.php'), 
            get_string('confirmno', 'local_training_architecture'), 'get');
        
        echo $OUTPUT->confirm(get_string('deletemultiplewarning', 'local_training_architecture'), $formcontinue, $formcancel);
        echo $OUTPUT->footer();
        die;
    } else {
        // Suppression des liens
        foreach ($ids as $id) {
            $coursesNotInArchitectureFunctions->deleteLink($id);
        }
        
        redirect($returnUrl, get_string('deletesuccess', 'local_training_architecture'), null, \core\output\notification::NOTIFY_SUCCESS);
    }
}

echo $OUTPUT->header();
echo $OUTPUT->footer();