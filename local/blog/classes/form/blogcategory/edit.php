<?php

/**formslib
 * @package   plugintype_pluginname
 * @copyright 2020, You Name <your@email.address>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once ("$CFG->libdir/formslib.php");


class blog_edit_category extends moodleform {


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



        $blog_category = $this->_customdata['blog_category'];

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



        $mform->addElement('hidden','id',$blog_category[0]->id);


        $select = $mform->addElement('select', 'parent', 'Parent', $selectArray);

        $select->setMultiple(false);

        $select->setSelected($blog_category[0]->parent);


        $mform->addElement('text','name','Category Title');

        $mform->setType('name',PARAM_RAW);

        $mform->setDefault('name',$blog_category[0]->name);

        $mform->addElement('text','idnumber','Add ID Number');

        $mform->setType('idnumber',PARAM_INT);

        $mform->setDefault('idnumber',$blog_category[0]->idnumber);

        $mform->addElement('textarea', 'description', 'Description', 'wrap="virtual" rows="5" cols="50"');

        $mform->setType('description',PARAM_RAW);

        $mform->setDefault('description',$blog_category[0]->description);

        $this->add_action_buttons();
    }


    public function validation($data, $files)
    {
        return array();
    }
}