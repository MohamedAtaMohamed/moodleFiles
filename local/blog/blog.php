<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 14/07/21
 * Time: 11:39 ص
 */



require_once (__DIR__ . '/../../config.php');



$PAGE->set_url(new moodle_url('/local/blog/blog.php'));



$systemcontext = context_system::instance();


global $DB,$USER;
$PAGE->set_title('Manage Blog');



if (!has_capability('local/blog:view', $systemcontext)) {
    print_error('accessdenied', 'admin');
}



echo $OUTPUT->header();

global  $DB;

$blog_lists = $DB->get_records('blog');


echo "<h2 class='text-center'>Blog List</h2>";
echo "<hr>";
echo "<br>";

if (has_capability('local/blog:blogedit', $systemcontext)) {
    echo "<a href='/moodle/local/blog/blogedit.php' class='btn btn-success' style='margin:20px 0px'>Add New Blog</a>";
}




$table = new html_table();
$table->head   = array('id','Title','Description', 'Category','created_at','options');

function getCategory($id){

    global  $DB;
    $categry= $DB->get_record('blog_categories',['id'=>$id]);

    return $categry->name;


}
foreach ($blog_lists as $blog_list)
{
    $table->data[] = array(
        $blog_list->id,
        $blog_list->title,
        html_entity_decode(substr($blog_list->description,0,200)),
        getCategory($blog_list->blogcategoryid),
        $blog_list->created_at,
        "<a href='/moodle/local/blog/blogedit.php?id=$blog_list->id'><i class = 'fa fa-edit'></i></a>" . ' ' .
        "<a onClick=\"alert('Ara U sure')\" href =/moodle/local/blog/blogdelete.php?id=$blog_list->id><i class = 'fa fa-remove'></i> </a>"
    );
}

echo html_writer::table($table);

echo $OUTPUT->footer();


