<?php
/**formslib
 * @package   plugintype_pluginname
 * @copyright 2020, You Name <your@email.address>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once ("$CFG->libdir/formslib.php");


class todo_update_form extends moodleform {


    public function definition()
    {
        // TODO: Implement definition() method.

        global  $CFG;
        global $USER;

        $mform = $this->_form;


        $todo = $this->_customdata['todo'];

        $action = $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
        
        
        $mform->addElement('hidden', 'id', $action);



        $mform->addElement('text','todo_text','Todo text');


        $mform->setType('todo_text',PARAM_ALPHA);


        $mform->setDefault('todo_text',$todo[0]->todo_text);




        $mform->addElement('text','todo_type','TODO Type Here ');


        $mform->setType('todo_type',PARAM_ALPHA);


        $mform->setDefault('todo_type',$todo[0]->todo_type);



        $mform->addElement('hidden','user_id',$todo[0]->user_id);


        $mform->addElement('hidden','id',$todo[0]->id);

        $mform->setType('user_id',PARAM_INT);

        $mform->setDefault('user_id',$todo[0]->user_id);


        $mform->setDefault('id',$todo[0]->id);

       
        $this->add_action_buttons();

    }


    public function validation($data, $files)
    {
        return array();
    }
}