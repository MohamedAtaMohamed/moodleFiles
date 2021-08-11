<?php
/**formslib
 * @package   plugintype_pluginname
 * @copyright 2020, You Name <your@email.address>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once ("$CFG->libdir/formslib.php");


class todo_edit_form extends moodleform {

    public function definition()
    {
        // TODO: Implement definition() method.

        global  $CFG;
        global $USER;
        $mform = $this->_form;


        
        $mform->addElement('text','todo_text','TODO Text Here ');


        $mform->setType('todo_text',PARAM_ALPHA);


        $mform->setDefault('todo_text','Please Add todo name');




        $mform->addElement('text','todo_type','TODO Type Here ');


        $mform->setType('todo_type',PARAM_ALPHA);



        $mform->addElement('hidden','user_id','user Id');

        $mform->setType('user_id',PARAM_INT);

        $mform->setDefault('user_id',$USER->id);


        $this->add_action_buttons();

    }


    public function validation($data, $files)
    {
        return array();
    }
}