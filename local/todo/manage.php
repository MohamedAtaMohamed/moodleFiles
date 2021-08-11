<?php
/**
 * @package   plugintype_pluginname
 * @copyright 2020, You Name <your@email.address>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require (__DIR__ . '/../../config.php');

$PAGE->set_url(new moodle_url('/local/todo/manage.php'));

$PAGE->set_context(context_system::instance());

$systemcontext = context_system::instance();

global $DB,$USER;
$PAGE->set_title('Manage Todo');


if (!has_capability('local/todo:manage', $systemcontext)) {
    print_error('accessdenied', 'admin');
}



echo $OUTPUT->header();

$todos = $DB->get_records('todo', ['user_id'=>$USER->id]);

echo $OUTPUT->render_from_template('local_todo/manage',$todos);

echo "<table class ='table table-responsive table-fluid'>
        <tr>
            <td>Todo text </td>
            <td>Todo type</td>
            <td>todo user</td>
            <td>Operation</td>    
        </tr>
    ";

    foreach ($todos as $todo)
    {
        echo 
        "<tr>
            <td>$todo->todo_text</td>
            <td>$todo->todo_type</td>
            <td>$USER->username</td>
            <td>
                <a href =/moodle/local/todo/edit.php?id=$todo->id><i class = 'fa fa-eye'></i> </a>
            </td>
        </tr>";
    }

    echo "</table>";

    echo "<br>";
    echo "<a href='/moodle/local/todo/edit.php' class='btn btn-success btn-block'>Add new Todo</a>";


echo $OUTPUT->footer();