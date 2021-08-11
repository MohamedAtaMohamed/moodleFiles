<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 11/07/21
 * Time: 11:35 ص
 */






require_once(__DIR__ . '/../../config.php');

$systemcontext = context_system::instance();


global $DB , $USER;

if (!has_capability('local/blog:blogdelete', $systemcontext)) {
    print_error('accessdenied', 'admin');
}


$id = $_GET['id'];

$category = $DB->delete_records('blog',['id'=>$id]);

\core\notification::add('Done Delete ',\core\notification::INFO);

header('Location: ' . $_SERVER['HTTP_REFERER']);

