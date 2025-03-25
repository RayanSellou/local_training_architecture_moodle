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

defined('MOODLE_INTERNAL') || die();

use core_privacy\local\metadata\provider;
use core_privacy\local\request\plugin\provider as pluginprovider;

class local_training_architecture_provider implements provider, pluginprovider {

    /**
     * Declares that this plugin does not store any personal data.
     *
     * @param \core_privacy\local\metadata\collection $collection The collection to add metadata to.
     * @return void
     */
    public static function get_metadata(\core_privacy\local\metadata\collection $collection) {
        // Since this plugin does not store any personal data, we do not add anything to the collection.
    }

    /**
     * States that this plugin does not store any user data.
     *
     * @param \core_privacy\local\request\approved_contextlist $contextlist The list of approved contexts.
     * @return void
     */
    public static function delete_data_for_user(\core_privacy\local\request\approved_contextlist $contextlist) {
        // Since this plugin does not store any personal data, no action is necessary here.
    }

    /**
     * Function to retrieve the list of contexts where data can be deleted.
     *
     * @param int $userid The user ID for which to retrieve contexts.
     * @return array The list of contexts. It may be empty if no contexts are associated.
     */
    public static function get_contexts_for_userid($userid) {
        // This plugin does not store data, so there are no contexts to return.
        return [];
    }
}
