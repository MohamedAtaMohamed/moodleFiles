<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 06/07/21
 * Time: 10:37 ص
 */


function local_message_before_footer() {

    \core\notification::add('a test message',\core\notification::SUCCESS);

}