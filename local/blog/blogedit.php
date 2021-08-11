<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 11/07/21
 * Time: 11:35 ص
 */



require_once(__DIR__ . '/../../config.php');
require_once $CFG->libdir . '/filelib.php';
require_once($CFG->dirroot . '/local/blog/classes/form//blog/addnew.php');
require_once($CFG->dirroot . '/local/blog/classes/form/blog/edit.php');


$systemcontext = context_system::instance();


global $DB , $USER;

if (!has_capability('local/blog:blogedit', $systemcontext)) {
    print_error('accessdenied', 'admin');
}

if(isset($_GET['id'])) {

    $id = $_GET['id'];


    $PAGE->set_url(new moodle_url("/local/blog/blogedit.php?id=$id"));

    $PAGE->set_context(context_system::instance());

    $PAGE->set_title('Update Blog');

    $blog_id = $_GET['id'];

    $blog = $DB->get_record('blog', ['id'=>$blog_id]);


    $to_form = array('blog' => array($blog));


    echo $OUTPUT->header();

    if($blog){
        // call back to update

        echo " <h2 class='text-center'>Edit Blog </h2>";
        $mform = new blog_edit(null,$to_form);

        $mform->moodleform('/moodle/local/blog/blogedit.php?id='.$blog->id,$to_form);

        if ($mform->is_cancelled()) {
            //Handle form cancel operation, if cancel button is present on form
            \core\notification::add('Canceled ',\core\notification::INFO);
            $mform->display();

        } else if ($fromform = $mform->get_data()) {
            //In this case you process validated data. $mform->get_data() returns data posted in form.


            $dataobject = [
                'id'             => $fromform->id,
                'title'             => $fromform->title,
                'picture'             => $draftitemid,
                'description'       =>($fromform->description['text']),
                'blogcategoryid'          => $fromform->blogcategoryid,
            ];



            // $query
            global $DB;

            $data = $DB->update_record('blog', $dataobject);


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



}else{


    // add new

    $PAGE->set_url(new moodle_url('/local/blog/blogedit.php'));

    $PAGE->set_context(context_system::instance());


    $PAGE->set_title('Add Blog');

    echo $OUTPUT->header();


    $mform = new add_new_blog();





    //Form processing and displaying is done here
    if ($mform->is_cancelled()) {
        //Handle form cancel operation, if cancel button is present on form
        \core\notification::add('Canceled ',\core\notification::INFO);
        $mform->display();

    } else if ($fromform = $mform->get_data()) {
        //In this case you process validated data. $mform->get_data() returns data posted in form.


        $content = $mform->get_file_content('blog_file');

        $name = $mform->get_new_filename('blog_file');

        $storedfile = $mform->save_stored_file('blog_file',1,
            'blog',
            'preview',
            $fromform->blog_file,
            '/blog/',$name);



        $dataobject = [
            'title'             => $fromform->title,
            'picture'             => $fromform->blog_picturefile,
            'description'       =>($fromform->description['text']),
            'blogcategoryid'          => $fromform->blogcategoryid,
        ];





        // $query
        global $DB;
        $data = $DB->insert_record('blog', $dataobject, true, false);


        $formitemname = 'picture';
        $filearea = 'imagearea';
        $filepath = '/';
        $filename = null;  // This means 'get from the uploaded file'

        $mform->save_stored_file('image', $systemcontext->id,
            'mod_assignment',
            $filearea, $data, $filepath, $filename);

        $fs = get_file_storage();

        $files = $fs->get_area_files(5, 'user', 'draft',  $fromform->picture, 'id', false);



        foreach ($files as $file) {
            $url = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(),
                $file->get_filearea(), $file->get_itemid(), $file->get_filepath(),
                $file->get_filename());
            echo html_writer::empty_tag('img', array('src' => $url));
        }




        \core\notification::add('Successfully added',\core\notification::SUCCESS);;


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