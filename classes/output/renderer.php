<?php
namespace local_training_architecture\output;

defined('MOODLE_INTERNAL') || die();

use plugin_renderer_base;

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

    public function render_create_level($tableid, $collapsetext, $searchtext) {
        $context = [
            'tableid' => $tableid,
            'collapsetext' => $collapsetext,
            'searchtext' => $searchtext
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
