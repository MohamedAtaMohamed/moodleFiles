<?php

/**formslib
 * @package   plugintype_pluginname
 * @copyright 2020, You Name <your@email.address>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once ("$CFG->libdir/formslib.php");


class blog_add_child_category extends moodleform {

    public function definition()
    {
        // TODO: Implement definition() method.

        global  $CFG, $DB;
        global $USER;
        $mform = $this->_form;



        $blog_category = $this->_customdata['blog_category'];
        $mform->addElement('hidden','parent',$blog_category[0]->id);

        $mform->addElement('text','name','Category Title');

        $mform->setType('name',PARAM_RAW);

        $mform->setDefault('name','');

        $mform->addElement('text','idnumber','Add ID Number');

        $mform->setType('idnumber',PARAM_INT);

        $mform->setDefault('idnumber','');

        $mform->addElement('textarea', 'description', 'Description', 'wrap="virtual" rows="5" cols="50"');

        $mform->setType('description',PARAM_RAW);

        $mform->setDefault('description','');


        $this->add_action_buttons();
    }


    public function validation($data, $files)
    {
        return array();
    }
}