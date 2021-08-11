<?php

/**formslib
 * @package   plugintype_pluginname
 * @copyright 2020, You Name <your@email.address>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once ("$CFG->libdir/formslib.php");


class blog_edit extends moodleform {


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



        $blog = $this->_customdata['blog'];

        $categories = $DB->get_records('blog_categories');
        $selectArray = array();




        if (count($categories) > 0){
            foreach($categories as $category) {
                $key = $category->id;
                $value = $this->getValue($key);
                $selectArray[$key] = $value;
            }
        }




        $mform->addElement('hidden','id',$blog[0]->id);


        $select = $mform->addElement('select', 'blogcategoryid', 'Category', $selectArray);

        $select->setMultiple(false);

        $select->setSelected($blog[0]->blogcategoryid);


        $mform->addElement('text','title','Blog Title')->setValue('text',$blog[0]->title);

        $mform->setType('title',PARAM_RAW);

        $mform->addElement('editor', 'description', 'Description', 'wrap="virtual" rows="5" cols="50"')->setValue( array('text' => $blog[0]->description ) );;

        $mform->addElement('filepicker', 'picture', get_string('file'), null,
            array('maxbytes' => '10000',  'return_types'=> FILE_INTERNAL | FILE_EXTERNAL));


        $this->add_action_buttons();
    }


    public function validation($data, $files)
    {
        return array();
    }
}