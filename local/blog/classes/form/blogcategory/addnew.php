<?php

/**formslib
 * @package   plugintype_pluginname
 * @copyright 2020, You Name <your@email.address>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once ("$CFG->libdir/formslib.php");


class blog_add_category extends moodleform {

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

        $selectArray[0] = 'Top';




        if (count($categories) > 0){

            foreach($categories as $category) {
                $key = $category->id;
                $value = $this->getValue($key);
                $selectArray[$key] = $value;
            }
        }



        $select = $mform->addElement('select', 'parent', 'Parent', $selectArray);
        $select->setMultiple(false);
        $select->setSelected(0);
        $mform->addElement('text','name','Category Title');
        $mform->setType('name',PARAM_RAW);
        $mform->addElement('text','idnumber','Add ID Number');
        $mform->setType('idnumber',PARAM_INT);
        $mform->addElement('textarea', 'description', 'Description', 'wrap="virtual" rows="5" cols="50"');
        $mform->setType('description',PARAM_RAW);
        /*
        $mform->addElement('filepicker', 'userfile', get_string('file'), null,
        array('maxbytes' => '10000', 'accepted_types' => '*')); */
        $this->add_action_buttons();

    }

    public function validation($data, $files)
    {
        return array();
    }
}