<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 26/07/21
 * Time: 11:40 ص
 */

defined('MOODLE_INTERNAL') || die();

$functions = array(
    'local_blog_get_blog_data' => array(
        'classname'     => 'local_get_blog_data',
        'methodname'    => 'get_blog_data',
        'classpath'     => '/local/blog/externallib.php',
        'description'   => 'Return the launch data for blog',
        'type'          => 'read',
        'capabilities'  => 'local/blog:view',
    ),
);

$services = array(
    'Custom Web Services'   => array(
        'functions' => array(
            'local_blog_get_blog_data'
        ),
        'restrictedusers'   => 1,
        'enabled'           => 1,
        'shortname'       => 'custom_web_services'
    )
);