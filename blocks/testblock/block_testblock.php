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
 * Form for editing HTML block instances.
 *
 * @package   block_testblock
 * @copyright 1999 onwards Martin Dougiamas (http://dougiamas.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_testblock extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_testblock');
    }

    function has_config() {
        return true;
    }

    function applicable_formats() {
        return array('all' => true);
    }

    function specialization() {
        if (isset($this->config->title)) {
            $this->title = $this->title = format_string($this->config->title, true, ['context' => $this->context]);
        } else {
            $this->title = get_string('newhtmlblock', 'block_html');
        }
    }

    function instance_allow_multiple() {
        return true;
    }

    function get_content() {
        global $CFG;

        if ($this->content !== NULL) {
            return $this->content;
        }


        $this->content = new stdClass;


        $this->content->text = 'this is the text';

        global  $DB;

        $blog_lists = $DB->get_records_sql('SELECT * FROM mdl_blog ORDER BY id DESC LIMIT 5');


        $this->content->text = "<ul class='list-group'></ul>";

        foreach ($blog_lists as $index => $blog_list)
        {

            $this->content->text .= "<li class='list-group-item'><span style='width: 30px; display: inline-block'>$blog_list->id</span>
                                    <span class='' style='display: inline-block; margin-left: 10px; margin-right: 15px'> | 
                                    </span> $blog_list->title </li>";
        }



        $this->content->footer = "<br><a class='btn btn-success' href='/moodle/local/blog/blog.php'>All Blog</a>";

        return $this->content;
    }
}
