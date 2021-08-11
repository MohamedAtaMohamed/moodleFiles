<?php
/**
 * @package   plugintype_pluginname
 * @copyright 2020, You Name <your@email.address>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/local/blog/classes/form/blogcategory/addnew.php');
require_once($CFG->dirroot . '/local/blog/classes/form/blogcategory/edit.php');
require_once($CFG->dirroot . '/local/blog/classes/form/blogcategory/addchild.php');

$systemcontext = context_system::instance();

global $DB , $USER;

if (!has_capability('local/blog:categoryedit', $systemcontext)) {
    print_error('accessdenied', 'admin');
}



if(isset($_GET['id'])){

    $id = $_GET['id'];

    $PAGE->set_url(new moodle_url("/local/blog/categoryedit.php?id=$id"));

    $PAGE->set_context(context_system::instance());

    $PAGE->set_title('Update Category');

    $category_id = $_GET['id'];

    $blog_category = $DB->get_record('blog_categories', ['id'=>$category_id]);


    $to_form = array('blog_category' => array($blog_category));


    echo $OUTPUT->header();

    if($blog_category){
        // call back to update

        echo " <h2 class='text-center'>Edit Category </h2>";
        $mform = new blog_edit_category(null,$to_form);

        $mform->moodleform('/moodle/local/blog/categoryedit.php?id='.$blog_category->id,$to_form);

        if ($mform->is_cancelled()) {
            //Handle form cancel operation, if cancel button is present on form
            \core\notification::add('No Data ',\core\notification::INFO);

            $mform->display();

        } else if ($fromform = $mform->get_data()) {

            //In this case you process validated data. $mform->get_data() returns data posted in form.
            $dataobject = [
                'parent'      => $fromform->parent,
                'idnumber'      => $fromform->idnumber,
                'name'        => $fromform->name,
                'description' => $fromform->description,
                'id'        => $fromform->id,
            ];

            // $query
            global $DB;
            $data = $DB->update_record('blog_categories', $dataobject);
            \core\notification::add('Done Update ',\core\notification::SUCCESS);
            $mform->display();

        }

        else {
            // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
            // or on the first display of the form.
            //displays the form
            $mform->display();
        }


        echo "</table>";

        echo "<br>";



    }
    else{
        var_dump('user not have it yet');
    }

    // display the forms to add the child category



    echo $OUTPUT->footer();
}

else{

    $PAGE->set_url(new moodle_url('/local/blog/categoryedit.php'));

    $PAGE->set_context(context_system::instance());


    $PAGE->set_title('Add Category');

    echo $OUTPUT->header();


    $mform = new blog_add_category();


    //Form processing and displaying is done here
    if ($mform->is_cancelled()) {
        //Handle form cancel operation, if cancel button is present on form
        \core\notification::add('No Data ',\core\notification::INFO);
        $mform->display();

    } else if ($fromform = $mform->get_data()) {
        //In this case you process validated data. $mform->get_data() returns data posted in form.



        $dataobject = [
            'parent'      => $fromform->parent,
            'idnumber'      => $fromform->idnumber,
            'name'        => $fromform->name,
            'description' => $fromform->description
        ];


        // $query
        global $DB;

        $data = $DB->insert_record('blog_categories', $dataobject, true, false);
        \core\notification::add('Successfully added',\core\notification::SUCCESS);;


        $get_cat = $DB->get_record('blog_categories',['id'=>$data]);


        $PAGE->set_url(new moodle_url("/local/blog/category.php"));

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

