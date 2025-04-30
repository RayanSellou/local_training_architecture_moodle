<?php
namespace local_training_architecture\output;

defined('MOODLE_INTERNAL') || die();

use plugin_renderer_base;
use moodle_url;
use local_training_architecture\local\functions\common_functions;


class renderer extends plugin_renderer_base {

    public function render_cohort_to_training($tableid, $collapsetext, $searchtext) {
        global $DB;
        $commonFunctions = new common_functions();
    
        $cohortsTrainings = $DB->get_records('local_training_architecture_cohort_to_training');
        $rows = [];
    
        foreach ($cohortsTrainings as $record) {
            $rows[] = [
                'training' => $commonFunctions->getTrainingFullName($record->trainingid),
                'cohort' => $commonFunctions->getCohortName($record->cohortid),
                'delete_url' => (new \moodle_url('/local/training_architecture/classes/edit_delete/cohort_to_training.php', [
                    'id' => $record->id
                ]))->out(false)
            ];
        }
    
        usort($rows, function($a, $b) {
            return strcmp($a['training'] . $a['cohort'], $b['training'] . $b['cohort']);
        });
    
        $context = [
            'tableid' => $tableid,
            'collapsetext' => $collapsetext,
            'searchtext' => $searchtext,
            'training_label' => get_string('training', 'local_training_architecture'),
            'cohort_label' => get_string('cohort', 'local_training_architecture'),
            'actions_label' => get_string('actions', 'local_training_architecture'),
            'rows' => $rows
        ];
    
        return $this->render_from_template('local_training_architecture/cohort_to_training', $context);
    }

    public function render_courses_not_in_architecture($tableid, $collapsetext, $searchtext) {
        global $DB;
        $commonFunctions = new common_functions();
    
        $records = $DB->get_records('local_training_architecture_courses_not_architecture');
        $rows = [];
    
        foreach ($records as $record) {
            $rows[] = [
                'training' => $commonFunctions->getTrainingFullName($record->trainingid),
                'course' => $commonFunctions->getCourseFullName($record->courseid),
                'delete_url' => (new \moodle_url('/local/training_architecture/classes/edit_delete/courses_not_in_architecture.php', [
                    'id' => $record->id,
                    'delete' => 1
                ]))->out(false),
                'checkbox_value' => $record->id
            ];
        }
    
        usort($rows, function($a, $b) {
            return strcmp($a['training'] . $a['course'], $b['training'] . $b['course']);
        });
    
        $context = [
            'tableid' => $tableid,
            'collapsetext' => $collapsetext,
            'searchtext' => $searchtext,
            'training_label' => get_string('training', 'local_training_architecture'),
            'course_label' => get_string('course', 'local_training_architecture'),
            'actions_label' => get_string('actions', 'local_training_architecture'),
            'selection_label' => get_string('selection', 'local_training_architecture'),
            'rows' => $rows
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
                'edit_url' => $editurl->out(false),   
                'delete_url' => $deleteurl->out(false) 
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
        global $DB;
    
        $lus = $DB->get_records('local_training_architecture_lu', [], 'fullname');
    
        $lurows = [];
        foreach ($lus as $lu) {
            $editurl = new \moodle_url('/local/training_architecture/classes/edit_delete/lu.php', ['id' => $lu->id]);
            $deleteurl = new \moodle_url('/local/training_architecture/classes/edit_delete/lu.php', ['id' => $lu->id, 'delete' => 1]);
    
            $lurows[] = [
                'fullname' => $lu->fullname,
                'shortname' => $lu->shortname,
                'idnumber' => $lu->idnumber,
                'edit_url' => $editurl->out(false),
                'delete_url' => $deleteurl->out(false)
            ];
        }
    
        $context = [
            'tableid' => $tableid,
            'collapsetext' => $collapsetext,
            'searchtext' => $searchtext,
            'fullname_label' => get_string('fullname', 'local_training_architecture'),
            'shortname_label' => get_string('shortname', 'local_training_architecture'),
            'idnumber_label' => get_string('idnumber', 'local_training_architecture'),
            'actions_label' => get_string('actions', 'local_training_architecture'),
            'lus' => $lurows
        ];
    
        return $this->render_from_template('local_training_architecture/create_lu', $context);
    }

    public function render_create_training($tableid, $collapsetext, $searchtext) {
        global $DB;
    
        $trainings = $DB->get_records('local_training_architecture_training', [], 'fullname');
    
        $trainingrows = [];
        foreach ($trainings as $training) {
            $editurl = new \moodle_url('/local/training_architecture/classes/edit_delete/training.php', ['id' => $training->id]);
            $deleteurl = new \moodle_url('/local/training_architecture/classes/edit_delete/training.php', ['id' => $training->id, 'delete' => 1]);
            $sorturl = new \moodle_url('/local/training_architecture/sort.php', ['trainingid' => $training->id]);
    
            $trainingrows[] = [
                'fullname' => $training->fullname,
                'shortname' => $training->shortname,
                'idnumber' => $training->idnumber,
                'granularitylevel' => $training->granularitylevel,
                'issemester' => ($training->issemester == 0) ? get_string('no', 'local_training_architecture') : get_string('yes', 'local_training_architecture'),
                'edit_url' => $editurl->out(false),
                'delete_url' => $deleteurl->out(false),
                'sort_url' => $sorturl->out(false)
            ];
        }
    
        $context = [
            'tableid' => $tableid,
            'collapsetext' => $collapsetext,
            'searchtext' => $searchtext,
            'fullname_label' => get_string('fullname', 'local_training_architecture'),
            'shortname_label' => get_string('shortname', 'local_training_architecture'),
            'idnumber_label' => get_string('idnumber', 'local_training_architecture'),
            'level_label' => get_string('selectnumberoflevel', 'local_training_architecture'),
            'semester_label' => get_string('semesterchoice', 'local_training_architecture'),
            'actions_label' => get_string('actions', 'local_training_architecture'),
            'trainings' => $trainingrows
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
        global $DB;
        $commonFunctions = new common_functions();
    
        $records = $DB->get_records('local_training_architecture_training_links');
        $rows = [];
    
        foreach ($records as $record) {
            $target = '';
            if (!$record->luid) {
                $target = $commonFunctions->getCourseFullName($record->courseid) . ' (' . get_string('course', 'local_training_architecture') . ')';
            } else {
                $target = $commonFunctions->getluFullName($record->luid);
            }
    
            $semester = $record->semester ? get_string('semester', 'local_training_architecture') . ' ' . $record->semester : '';
    
            $rows[] = [
                'training' => $commonFunctions->getTrainingFullName($record->trainingid),
                'target' => $target,
                'level' => $record->level,
                'semester' => $semester,
                'delete_url' => (new \moodle_url('/local/training_architecture/classes/edit_delete/training_links.php', [
                    'id' => $record->id,
                    'delete' => 1
                ]))->out(false),
                'checkbox_value' => $record->id
            ];
        }
    
        usort($rows, function($a, $b) {
            return strcmp($a['training'] . $a['target'], $b['training'] . $b['target']);
        });
    
        $context = [
            'tableid' => $tableid,
            'collapsetext' => $collapsetext,
            'searchtext' => $searchtext,
            'training_label' => get_string('training', 'local_training_architecture'),
            'target_label' => get_string('lu', 'local_training_architecture'),
            'level_label' => get_string('level', 'local_training_architecture'),
            'semester_label' => get_string('semester', 'local_training_architecture'),
            'actions_label' => get_string('actions', 'local_training_architecture'),
            'selection_label' => get_string('selection', 'local_training_architecture'),
            'rows' => $rows
        ];
    
        return $this->render_from_template('local_training_architecture/training_links', $context);
    }

    public function render_training_to_level($tableid, $collapsetext, $searchtext) {
        global $DB;
        $commonFunctions = new common_functions();
    
        $levelsTrainings = $DB->get_records('local_training_architecture_level_names_to_training');
        $encounteredIds = [];
        $trainingrows = [];
    
        foreach ($levelsTrainings as $record) {
            $trainingid = $record->trainingid;
    
            if (in_array($trainingid, $encounteredIds)) {
                continue;
            }
            $encounteredIds[] = $trainingid;
    
            $trainingname = $commonFunctions->getTrainingFullName($trainingid);
            $levels = $commonFunctions->getLevelNamesByTrainingId($trainingid);
    
            $deleteurl = new \moodle_url('/local/training_architecture/classes/edit_delete/training_to_level.php', ['trainingid' => $trainingid]);
    
            $trainingrows[] = [
                'training_name' => $trainingname,
                'level1_name' => !empty($levels[1]) ? $levels[1] : '',
                'level2_name' => !empty($levels[2]) ? $levels[2] : '',
                'delete_url' => $deleteurl->out(false)
            ];
        }
    
        usort($trainingrows, fn($a, $b) => strcmp($a['training_name'], $b['training_name']));
    
        $context = [
            'tableid' => $tableid,
            'collapsetext' => $collapsetext,
            'searchtext' => $searchtext,
            'training_label' => get_string('training', 'local_training_architecture'),
            'level1_label' => get_string('level1', 'local_training_architecture'),
            'level2_label' => get_string('level2', 'local_training_architecture'),
            'actions_label' => get_string('actions', 'local_training_architecture'),
            'rows' => $trainingrows
        ];
    
        return $this->render_from_template('local_training_architecture/training_to_level', $context);
    }
    
}
