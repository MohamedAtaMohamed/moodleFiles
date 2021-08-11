<?php
/**
 * @package   plugintype_pluginname
 * @copyright 2020, You Name <your@email.address>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/local/todo/classes/form/edit.php');
require_once($CFG->dirroot . '/local/todo/classes/form/update.php');
$systemcontext = context_system::instance();

global $DB , $USER;

if (!has_capability('local/todo:edit', $systemcontext)) {
    print_error('accessdenied', 'admin');
}


if(isset($_GET['id'])){

    $id = $_GET['id'];
    $PAGE->set_url(new moodle_url("/local/todo/update.php?id=$id"));

    $PAGE->set_context(context_system::instance());

    $PAGE->set_title('Update Todo');

    $todo_id = $_GET['id'];
    
    $todo = $DB->get_record('todo', ['id'=>$todo_id]);


    $to_form = array('todo' => array($todo));
     

    echo $OUTPUT->header();

    if($todo && $todo->user_id == $USER->id){
        // call back to update


        $mform = new todo_update_form(null,$to_form);

        $mform->moodleform('/moodle/local/todo/edit.php?id='.$todo->id,$to_form);

        if ($mform->is_cancelled()) {
            //Handle form cancel operation, if cancel button is present on form
            \core\notification::add('No Data ',\core\notification::INFO);
    
        $mform->display();
        } else if ($fromform = $mform->get_data()) {
        //In this case you process validated data. $mform->get_data() returns data posted in form.

        $todo_text = html_entity_decode($fromform->todo_text);
    
        $todo_type = $fromform->todo_type;
    
    
        $user_id = ($fromform->user_id);

        $id = ($fromform->id);
    
        $dataobject = [
            'todo_text'   => $todo_text,
            'todo_type'   => $todo_type,
            'user_id'     => $user_id,  
            'id'          => $id,     
        ];
        // $query 
        global $DB;
    
        $data = $DB->update_record('todo', $dataobject);

        \core\notification::add('Done Update ',\core\notification::SUCCESS);
        $mform->display();
    
        } 
        else {
        // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
        // or on the first display of the form.
        
        //displays the form
        $mform->display();
        }


    
    }
    else{
        var_dump('user not have it yet');
    }

    echo $OUTPUT->footer();
}
else{

    $PAGE->set_url(new moodle_url('/local/todo/edit.php'));

    $PAGE->set_context(context_system::instance());


    $PAGE->set_title('Add Todo');




    echo $OUTPUT->header();


    $mform = new todo_edit_form();


    //Form processing and displaying is done here
    if ($mform->is_cancelled()) {
        //Handle form cancel operation, if cancel button is present on form
        \core\notification::add('No Data ',\core\notification::INFO);

    $mform->display();
    } else if ($fromform = $mform->get_data()) {
    //In this case you process validated data. $mform->get_data() returns data posted in form.

    $todo_text = ($fromform->todo_text);

    $todo_type = ($fromform->todo_type);


    $user_id = ($fromform->user_id);

    $dataobject = [
        'todo_text'   => $todo_text,
        'todo_type'   => $todo_type,
        'user_id'     => $user_id
    ];
    // $query 
    global $DB;

        $data = $DB->insert_record('todo', $dataobject, true, false);
        \core\notification::add('Successfully added',\core\notification::SUCCESS);

        $mform->display();

    } 
    else {
    // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
    // or on the first display of the form.
    
    //displays the form
    $mform->display();
    }

    echo $OUTPUT->footer();
}