<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Plugin strings are defined here.
 *
 * @copyright 2024 IFRASS
 * @author    2024 Esteban BIRET-TOSCANO <esteban.biret@gmail.com>
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @category  string
 * @package   local_training_architecture
 */

defined('MOODLE_INTERNAL') || die();

// Common.
$string['pluginname'] = 'Training Architecture';
$string['training_architecture:manage'] = 'Edit and manage trainings architecture';
$string['heading'] = 'Manage training architecture';
$string['title'] = 'Training\'s architecture';
$string['fullname'] = 'Fullname';
$string['shortname'] = 'Shortname';
$string['idnumber'] = 'Identification number';
$string['description'] = 'Description';
$string['numberoflevel'] = 'Number of granularity\'s level';
$string['level'] = 'Granularity\'s level';
$string['level1'] = 'Granularity of level 1\'s name';
$string['level2'] = 'Granularity of level 2\'s name';
$string['confirmyes'] = 'Confirm';
$string['confirmno'] = ' Go back';
$string['actions'] = 'Actions';
$string['selection'] = 'Selection';
$string['deleteselection'] = 'Delete the selected elements';
$string['yes'] = 'Yes';
$string['no'] = 'No';
$string['back'] = 'Back';
$string['order'] = 'Order';
$string['up'] = 'Up';
$string['down'] = 'Down';
$string['lu1'] = 'Learning Unit 1';
$string['lu2'] = 'Learning Unit 2';
$string['chooseoption'] = 'Choose an option';
$string['course'] = 'Course';
$string['lu'] = 'Learning Unit';
$string['allforms'] = 'All forms : ';
$string['deletemultipletitle1'] = 'Delete ';
$string['expand'] = 'Expand all';
$string['collapse'] = 'Collapse all';

// Training.
$string['createtraining'] = 'New Training';
$string['traininglevel'] = 'Granularity of level ';
$string['edittrainingtitle'] = 'Edit the training';
$string['deletetrainingtitle'] = 'Delete the training';
$string['selectnumberoflevel'] = 'Number of granularity\s level';
$string['semesterchoice'] = 'Semester architecture';

// Level name.
$string['createleveltitle'] = 'New granularity\'s level';
$string['editleveltitle'] = 'Edit the level name';
$string['deleteleveltitle'] = 'Delete the level name';

// Training to level name.
$string['trainingtolevel'] = 'Association Traininig - Granularities levels names';
$string['deletetrainingleveltitle'] = 'Delete this Training - Granularity level name association';

// Cohort to training.
$string['cohorttotraining'] = 'Association Training - Cohort';
$string['cohort'] = 'Cohort';
$string['training'] = 'Training';
$string['deletecohorttrainingtitle'] = 'Delete this Cohort Training - Cohort association';

// LU.
$string['createlutitle'] = 'New Learning Unit';
$string['editlutitle'] = 'Edit the Learning Unit';
$string['deletelutitle'] = 'Delete the Learning Unit';

// Not in architecture. 
$string['coursesnotinarchitecturetitle'] = 'Association of courses outside architecture';
$string['deletenotarchitecture'] = 'Delete course - training association';
$string['deletemultiplecoursesnotinarchitecturetitle2'] = ' course - training association(s)';

// Training links.
$string['traininglinks'] = 'Association of training characteristics';
$string['semester'] = 'Semester';
$string['selectsemester'] = 'Select a semester';
$string['deletetraininglinks'] = 'Delete training characteristics';
$string['deletemultipletraininglinkstitle2'] = ' link(s) of training characteristics';

// LU to LU.
$string['lutolu'] = 'Association of Learning Units';
$string['lulevel'] = 'Learning Unit of level ';
$string['deletelulutitle'] = 'Delete Association of Learning Units';
$string['deletemultiplelulutitle2'] = ' association(s) of Learning Units';

// Sort order LU.
$string['sortlutitle'] = 'Manage Learning Units order';
$string['sortlu'] = 'Manage the Learning Units order of ';
$string['nolus'] = 'This training has no Learning Units yet.';
$string['orderinformations'] = 'This page is used to order the Learning Units (LU) of a training. 
Click on a level 1 LU to order its level 2 LU. 
(This will only have an impact on the display order of the LU of a training linked to the associated block plugin (block_training_architecture)).';

// Help.
$string['traininglevel'] = 'Level of granularity ';
$string['traininglevel_help'] = 'The level of granularity corresponds to a level of segmentation of the training. 
Trainings generally offer 2 or 3 levels of granularity. 
The last level of the Learning Units here corresponds to the Moodle course.

Possible examples: 

Teaching Unit / Module / Course 
Competency Block / Module / Course
Training Unit / Module / Course
Module / Chapter / Course 
...

It is not possible to have two levels of granularity with the same name.';

$string['fullname_help'] = 'Correspond to the name of the chosen level of granularity.
This may refer to a segmentation corresponding to a content-subject approach or a competency-based approach.
This name may be displayed in certain areas of the site depending on associated dependent plugins.

This name must be unique.';

$string['shortname_help'] = 'This name is an abbreviation of the granularity level name.
This abbreviated name may be displayed in certain areas of the site depending on associated dependent plugins.

This name must be unique.';

$string['idnumber_help'] = 'Reference of the entity created within the information system.
This allows referencing and linking the entity with the rest of the information system.

This number must be unique.';

$string['granularitylevel_help'] = 'Select here the granularity level to which you want to associate the Learning Unit for a given training.
You must also associate each course in your training plan with the correct granularity level.
Courses correspond to the last granularity level of your Learning Unit (excluding activities/resources) of your training plan.

Example:
If your training has 1 level of granularity, the course will be at level 2,
If your training has 2 levels of granularity, the course will be at level 3.';

$string['createtraininggranularitylevel_help'] = 'Choose the number of granularity levels above the course (do not count the course).

Example:
A training plan with 1 level : Module > Course.
A training plan with 2 levels : Block > Module > Course.';

$string['createtraininggranularitylevel'] = 'Create a granularity level for training';

// Errors.
$string['namealreadyexists'] = 'This name is already taken.';
$string['shortnamealreadyexists'] = 'This shortname is already taken.';
$string['idnumberalreadyexists'] = 'This identification number is already taken.';
$string['selectdifferentlevel'] = 'This level has already been selected.';
$string['associationalreadyexists'] = 'This association already exists.';
$string['traininglevelalreadyexists'] = 'This training is already linked wiht granularity\'s levels.';
$string['associationalreadyexistscohorts'] = 'These cohorts are already associated with this training';
$string['coursealreadyinarchitecture'] = 'This course is already in the architecture for this training.';
$string['coursealreadynotinarchitecture'] = 'This course has already been associated outside of the architecture for this training.';
$string['luduplicate'] = 'This Learning Unit has already been chosen.';
$string['lunotrelated'] = 'This Learning Unit is not linked to this training.';
$string['coursenotrelated'] = 'This course is not linked to this training.';
$string['leveltoohigh'] = 'Granularity level is higher than the maximum granularity level for this training.';
$string['erroreditsemester'] = 'You cannot edit this field because there are references to the semesters in other tables.';
$string['erroreditlevel'] = 'You cannot edit this field because there are references to the levels in other tables.';
$string['lu1alreadyaslu2'] = 'This level 1 Learning Unit is already involved in another relationship as level 2, for this training';
$string['lu2alreadyaslu1'] = 'This level 2 Learning Unit is already involved in another relationship as level 1, for this training';

// Warnings.
$string['deletelinkwarning'] = 'Are you sure you want to remove this association ?';
$string['deletemultiplewarning'] = 'Are you sure you want to remove this/these association(s) ?';
$string['deleteluwarning'] = 'Are you sure you want to remove this Learning Unit ?';
$string['deletelevelnamewarning'] = 'Are you sure you want to remove this level name ?';
$string['deletetrainingwarning'] = 'Are you sure you want to remove this training ? This will result in the deletion of all data related to this training.';

// Notify errors.
$string['notifyerrorlutolu'] = 'You cannot delete this association, one of the Learning Units is used in one or more other relationships.';
$string['notifyerrormultiplelutolu'] = 'You cannot delete this/these association(s), one of the Learning Units is used in one or more other relationships.';
$string['notifyerrorlevel'] = 'You cannot delete this level name, it is associated with one or more training.';
$string['notifyerrorlu'] = 'You cannot delete this Learning Unit, it is used in one or more other relationships.';
$string['notifyerrormultipletraininglinks'] = 'You cannot delete this/these association(s), one of the Learning Units is involved in one or more relationships for this training in the "Learning Unit Associations" form .';

// Tasks.
$string['cohorttask'] = 'Synchronize cohort_to_training data based on existing cohorts';
$string['coursetask'] = 'Synchronize lu_to_course data based on existing courses';

//Privacy.
$string['privacy:metadata'] = 'The Training Architecture plugin does not store any personal data.';