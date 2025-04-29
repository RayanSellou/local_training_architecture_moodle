<?php
namespace local_training_architecture\output;

defined('MOODLE_INTERNAL') || die();

use plugin_renderer_base;
use moodle_url;

class renderer extends plugin_renderer_base {

    public function render_cohort_to_training($tableid, $collapsetext, $searchtext) {
        $context = [
            'tableid' => $tableid,
            'collapsetext' => $collapsetext,
            'searchtext' => $searchtext
        ];

        return $this->render_from_template('local_training_architecture/cohort_to_training', $context);
    }

    public function render_courses_not_in_architecture($tableid, $collapsetext, $searchtext) {
        $context = [
            'tableid' => $tableid,
            'collapsetext' => $collapsetext,
            'searchtext' => $searchtext
        ];
    
        return $this->render_from_template('local_training_architecture/courses_not_in_architecture', $context);
    }

    // public function render_create_level($tableid, $collapsetext, $searchtext) {
    //     $context = [
    //         'tableid' => $tableid,
    //         'collapsetext' => $collapsetext,
    //         'searchtext' => $searchtext
    //     ];
    
    //     return $this->render_from_template('local_training_architecture/create_level', $context);
    // }

    public function render_create_level($tableid, $collapsetext, $searchtext) {
        global $DB;
    
        $levels = $DB->get_records('local_training_architecture_level_names', [], 'fullname');
    
        $levelrows = [];
        foreach ($levels as $level) {
            $editurl = new \moodle_url('/local/training_architecture/classes/edit_delete/level.php', ['id' => $level->id]);
            $deleteurl = new \moodle_url('/local/training_architecture/classes/edit_delete/level.php', ['id' => $level->id, 'delete' => 1]);
    
            $levelrows[] = [
                'fullname' => $level->fullname,
                'shortname' => $level->shortname,
                'edit_url' => $editurl->out(false),   // Important ici !
                'delete_url' => $deleteurl->out(false) // Important ici aussi !
            ];
        }
    
        $context = [
            'tableid' => $tableid,
            'collapsetext' => $collapsetext,
            'searchtext' => $searchtext,
            'fullname_label' => get_string('fullname', 'local_training_architecture'),
            'shortname_label' => get_string('shortname', 'local_training_architecture'),
            'actions_label' => get_string('actions', 'local_training_architecture'),
            'levels' => $levelrows
        ];
    
        return $this->render_from_template('local_training_architecture/create_level', $context);
    }

    public function render_create_lu($tableid, $collapsetext, $searchtext) {
        $context = [
            'tableid' => $tableid,
            'collapsetext' => $collapsetext,
            'searchtext' => $searchtext
        ];
    
        return $this->render_from_template('local_training_architecture/create_lu', $context);
    }

    public function render_create_training($tableid, $collapsetext, $searchtext) {
        $context = [
            'tableid' => $tableid,
            'collapsetext' => $collapsetext,
            'searchtext' => $searchtext
        ];
    
        return $this->render_from_template('local_training_architecture/create_training', $context);
    }

    public function render_lu_to_lu($tableid, $collapsetext, $searchtext) {
        $context = [
            'tableid' => $tableid,
            'collapsetext' => $collapsetext,
            'searchtext' => $searchtext
        ];
    
        return $this->render_from_template('local_training_architecture/lu_to_lu', $context);
    }

    public function render_training_links($tableid, $collapsetext, $searchtext) {
        $context = [
            'tableid' => $tableid,
            'collapsetext' => $collapsetext,
            'searchtext' => $searchtext
        ];
    
        return $this->render_from_template('local_training_architecture/training_links', $context);
    }

    public function render_training_to_level($tableid, $collapsetext, $searchtext) {
        $context = [
            'tableid' => $tableid,
            'collapsetext' => $collapsetext,
            'searchtext' => $searchtext
        ];
    
        return $this->render_from_template('local_training_architecture/training_to_level', $context);
    }
}
