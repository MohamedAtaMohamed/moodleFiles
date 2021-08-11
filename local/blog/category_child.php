<?php

require_once (__DIR__ . '/../../config.php');


require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/local/blog/classes/form/blogcategory/addnew.php');
require_once($CFG->dirroot . '/local/blog/classes/form/blogcategory/edit.php');
require_once($CFG->dirroot . '/local/blog/classes/form/blogcategory/addchild.php');




$systemcontext = context_system::instance();

global $DB , $USER;

if (!has_capability('local/blog:categoryedit', $systemcontext)) {
    print_error('accessdenied', 'admin');
}


$PAGE->set_url(new moodle_url('/local/blog/category.php'));

$PAGE->set_context(context_system::instance());


$systemcontext = context_system::instance();



global $DB,$USER;
$PAGE->set_title('Manage Blog Categories Child');


if (!has_capability('local/blog:category', $systemcontext)) {
    print_error('accessdenied', 'admin');
}


echo $OUTPUT->header();


$blog_categories = $DB->get_records('blog_categories',['parent'=>0],'id');

echo "<h2 class='text-center'>Blog Categories Child </h2>";
echo "<hr>";
echo "<br>";
echo "<br>";

echo "<table class ='table table-responsive table-fluid'>
        <tr>
            <td>Blog Category </td>
            <td>Category Number </td>
            <td>Category Description </td>
            <td>Operation</td>    
        </tr>
    ";

foreach ($blog_categories as $category)
{
    echo
    "<tr>
            <td>$category->name</td>
            <td>$category->idnumber</td>
            <td>$category->description</td>
            ";

            echo "<td>";
            // get the records of parent
            if (has_capability('local/blog:categoryedit', $systemcontext)) {
                echo "<a href =/moodle/local/blog/categoryedit.php?id=$category->id><i class = 'fa fa-edit'></i> </a>";
                echo "<a onClick=\"alert('Ara U sure')\" href =/moodle/local/blog/categorydelete.php?id=$category->id><i class = 'fa fa-remove'></i> </a>";
            }
            echo "</td>";
       echo"</tr>";

}


echo "</table>";

echo "<br>";



echo $OUTPUT->footer();





