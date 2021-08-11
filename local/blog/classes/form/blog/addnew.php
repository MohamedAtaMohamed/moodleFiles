<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 11/07/21
 * Time: 11:34 ص
 */


require_once ("$CFG->libdir/formslib.php");
require_once($CFG->dirroot.'/user/lib.php');

class add_new_blog extends moodleform {


    function getValue($id){

        //
        global  $DB;

        $string = "";


        $i = 0;

        do{
            $categry= $DB->get_record('blog_categories',['id'=>$id]);
            if ($categry->parent !== 0){
                $string = $string . "/$categry->name";
            }


            $i = $categry->parent;
            $id = $categry->parent;

        }while ($i !=0 );


        return $string;
    }


    public function definition()
    {
        // TODO: Implement definition() method.

        global  $CFG, $DB;
        global $USER;

        $mform = $this->_form;



        $categories = $DB->get_records('blog_categories');


        $selectArray = array();




        if (count($categories) > 0){

            foreach($categories as $category) {
                $key = $category->id;
                $value = $this->getValue($key);
                $selectArray[$key] = $value;
            }
        }



        $select = $mform->addElement('select', 'blogcategoryid', 'Parent', $selectArray);
        $select->setMultiple(false);
        $select->setSelected(0);
        $mform->addElement('text','title','Blog Title');
        $mform->setType('title',PARAM_RAW);

        $mform->addElement('editor', 'description', 'Blog Description', 'wrap="virtual" rows="5" cols="50"');

        $mform->setType('description',PARAM_RAW);

        $mform->addElement('filepicker', 'blog_file',    get_string('file'), null,
            array('maxbytes' => 2000, 'accepted_types' => '*'));


        $this->add_action_buttons();

    }


    public function validation($data, $files)
    {
        return array();
    }


}