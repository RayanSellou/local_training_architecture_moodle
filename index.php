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
 * Create architecture main file.
 *
 * @copyright 2024 IFRASS
 * @author    2024 Esteban BIRET-TOSCANO <esteban.biret@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package   training_architecture
 */

use local_training_architecture\local\form\create_level;
use local_training_architecture\local\form\create_training;
use local_training_architecture\local\form\training_level;
use local_training_architecture\local\form\cohort_to_training;
use local_training_architecture\local\form\courses_not_in_architecture;
use local_training_architecture\local\form\create_lu;
use local_training_architecture\local\form\training_links;
use local_training_architecture\local\form\lu_to_lu;

use local_training_architecture\local\functions\common_functions;

require_once(dirname(__FILE__) . '/../../config.php');

// This section handles user authentication, page setup, and permission checks.
require_login();
$context = context_system::instance();
require_capability('local/training_architecture:manage',$context);
$PAGE->set_context($context);
$PAGE->set_url('/local/training_architecture/index.php');
$PAGE->set_title(get_string('title', 'local_training_architecture'));
$PAGE->requires->css('/local/training_architecture/styles.css');


$PAGE->requires->js_call_amd('local_training_architecture/multiple_delete', 'init');
$PAGE->requires->js_call_amd('local_training_architecture/functions', 'init');

$PAGE->set_heading(get_string('heading', 'local_training_architecture'));
$PAGE->set_pagelayout('admin');
echo $OUTPUT->header();

// Initialize common objects and variables.
$returnurl = new moodle_url('/local/training_architecture/index.php');
$commonFunctions = new common_functions();

global $PAGE;

$renderer = $PAGE->get_renderer('local_training_architecture');

echo $renderer->render_form_links();

//-----------------------------------

// Create level section

$create_level_form = new create_level();

// Check if the create level form is submitted.
if ($create_level_form->is_submitted()) {
    $data = $create_level_form->get_data();
    if($data) {
        redirect('index.php');
    }
}

// Check if the create level form is cancelled.
if($create_level_form->is_cancelled()) {
    redirect('index.php');
}

$create_level_form->display();

//--------------

// Create Training Section

$create_training_form = new create_training();


// Check if the create training form is submitted.
if ($create_training_form->is_submitted()) {
    $data = $create_training_form->get_data();
    if($data) {
        redirect('index.php');
    }
}

// Check if the create training form is cancelled.
if($create_training_form->is_cancelled()) {
    redirect('index.php');
}

$create_training_form->display();


//----------------------------------------------------------------------

// Create LU section

$create_lu_form = new create_lu();

// Check if the lu form is submitted.
if ($create_lu_form->is_submitted()) {
    $data = $create_lu_form->get_data();
    if($data) {
        redirect('index.php');
    }
}

// Check if the lu form is cancelled.
if($create_lu_form->is_cancelled()) {
    redirect('index.php');
}

$create_lu_form->display();

//--------------------------------------------------------------

// Training to level names Section
require_once(__DIR__ . '/classes/local/form/training_to_level.php');

$training_to_level_form = new training_level();

// Check if the training to level form is submitted.
if ($training_to_level_form->is_submitted()) {
    $data = $training_to_level_form->get_data();
    if($data) {
        redirect('index.php');
    }
}

// Check if the training to level form is cancelled.
if($training_to_level_form->is_cancelled()) {
    redirect('index.php');
}

$training_to_level_form->display();


//----------

// Cohort to training section

$cohort_to_training_form = new cohort_to_training();

// Check if the cohort to training form is submitted.
if ($cohort_to_training_form->is_submitted()) {
    $data = $cohort_to_training_form->get_data();
    if($data) {
        redirect('index.php');
    }
}

// Check if the cohort to training form is cancelled.
if($cohort_to_training_form->is_cancelled()) {
    redirect('index.php');
}

$cohort_to_training_form->display();

//---------------------------------------------------------

// Courses not in architecture section

$courses_not_in_architecture_form = new courses_not_in_architecture();

// Check if the form is submitted.
if ($courses_not_in_architecture_form->is_submitted()) {
    $data = $courses_not_in_architecture_form->get_data();
    if($data) {
        redirect('index.php');
    }
}

// Check if the form is cancelled.
if($courses_not_in_architecture_form->is_cancelled()) {
    redirect('index.php');
}

$courses_not_in_architecture_form->display();


//--------------------------------------------------------------

// Training links section

$training_links_form = new training_links();

// Check if the training lniks form is submitted.
if ($training_links_form->is_submitted()) {
    $data = $training_links_form->get_data();
    if($data) {
        redirect('index.php');
    }
}
// Check if the training lniks form is cancelled.
if($training_links_form->is_cancelled()) {
    redirect('index.php');
}

$training_links_form->display();

//-----------------

// LU to LU section

$lu_to_lu_form = new lu_to_lu();

// Check if the lu to lu form is submitted.
if ($lu_to_lu_form->is_submitted()) {
    $data = $lu_to_lu_form->get_data();
    if($data) {
        redirect('index.php');
    }
}

// Check if the LU to LU form is cancelled.
if($lu_to_lu_form->is_cancelled()) {
    redirect('index.php');
}

$lu_to_lu_form->display();

echo $OUTPUT->footer();